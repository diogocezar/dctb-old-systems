<?php

class OriAnt{

	/**
	* Atributos
	*/
	protected
		$origem,
		$destino,
		$grupo,
		$feromonio,      // Object
		$pagina,         // Object
		$parametros_adm; // Object
			
	/**
	* Construtor
	* __construct()
	*/
	public function __construct(){
		$this->__toFillGeneric();
	}
	
	/** 
	* M�todo que retorna uma string com os grupos do sistema.
	* @access public
	* @return String
	*/		
	public function getGroups(){
		$grupo = $this->getGrupo();
		
		$camposGrupo = $grupo->getCampos();
		
		$totalConts  = $grupo->totalConts();
		
		$i = 0;
		$resultado = $grupo->rows(false, false, 0, 'ASC', false);
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				//if($i!=0){
				//	$retorno .= ' | ';
				//}
				
				$id   = $dados[$camposGrupo[0]];
				$cont = $dados[$camposGrupo[1]];
				$nome = $dados[$camposGrupo[2]];
				
				$tamanho = calculaValorTag($totalConts, $cont);
				
				$retorno .= "<a href=\"javascript:;\" onclick=\"call_saveCookieSessionGroup('$id')\">";
				$retorno .= "<span style=\"font-size:".$tamanho."%\">";
				$retorno .= $nome;
				//$retorno .= $nome."($tamanho)";
				$retorno .= "</span>";
				$retorno .= "</a>";
				$retorno .= " ";
								
				$i++;
			}
			return $retorno;
		}
		return false;
	}//getGroups
	
	/** 
	* M�todo que faz a atualiza��o da taxa de ferom�nio em uma aresta do website.
	* @access public
	* @return void
	*/	
	public function addPheromone(){
	
		global $erro; // Variavel global de erros.
	
		$origem        = $this->getOrigem();
		$destino       = $this->getDestino();
		$grupo         = $this->getGrupo();
		$pagina        = $this->getPagina();
		$feromonio     = $this->getFeromonio();
		$parametrosAdm = $this->getParametros_adm();
	
		if(empty($origem) || empty($destino) || empty($grupo) || empty($pagina) || empty($feromonio) || empty($parametrosAdm)){
			$this->erro($erro['FERO_NAO_COMPUT']);
		}
		else{
		
			/**
			* Recuperando os id das p�ginas setadas nos atributos.
			*/			
			$idPageOrigem  = $pagina->idPage($origem);
			$idPageDestino = $pagina->idPage($destino);
			
			/**
			* Se a p�gina DESTINO n�o est� cadastrada, cadastra!
			* Sen�o, atualiza os acessos e o �ltimo acesso.
			*/			
			if(!$pagina->cadastredPage($destino)){
				$pagina->setId_pagina     (1);
				$pagina->setUltimo_acesso ('now()');
				$pagina->setUrl_pagina    ($destino);
				$pagina->setCont_pagina   (1);
				$pagina->save();
			}
			else{
				$pagina->__get_db($idPageDestino);
				$pagina->setUltimo_acesso('now()');
				$pagina->setCont_pagina($pagina->getCont_pagina()+1);
				$pagina->update();
			}
			
			/**
			* Se a p�gina ORIGEM n�o est� cadastrada, cadastra!
			*/
			if(!$pagina->cadastredPage($origem)){
				$pagina->setId_pagina     ($pagina->max_r());
				$pagina->setUltimo_acesso ('now()');
				$pagina->setUrl_pagina    ($origem);
				$pagina->setCont_pagina   (1);
				$pagina->save();
			}
			
			/**
			* Recuperando os id das p�ginas setadas nos atributos.
			* Caso alguma p�gina tenha sido cadastrada
			*/			
			$idPageOrigem  = $pagina->idPage($origem);
			$idPageDestino = $pagina->idPage($destino);
			
			/**
			* Recuperando a quantidade que dever� ser adicionada de ferom�nio.
			*/		
			$parametrosAdm->__get_db();
			
			$qtdFeromonio = $parametrosAdm->getAcrescimo_feromonio();
			
			/**
			* Se n�o existe uma aresta entre p�gina de origem e p�gina de destino, insere-se uma nova aresta.
			* Sen�o, apenas se atualiza a quantidade de ferom�nio na aresta.
			*/
			if(!$feromonio->cadastredEdge($idPageOrigem, $idPageDestino, $grupo)){
				$feromonio->setId_feromonio      ($feromonio->max_r());	
				$feromonio->setId_pagina_origem  ($idPageOrigem);	
				$feromonio->setId_pagina_destino ($idPageDestino);
				$feromonio->setId_grupo          ($this->getGrupo());
				$feromonio->setQtd_feromonio     ($qtdFeromonio);
				$feromonio->save();
			}
			else{
				$idFeromonioCadastrado = $feromonio->getEdge($idPageOrigem, $idPageDestino, $grupo);
				$feromonio->__get_db($idFeromonioCadastrado);
				$feromonio->setQtd_feromonio($feromonio->getQtd_feromonio()+$qtdFeromonio);
				$feromonio->update();
			}
		}
	}
	
	/** 
	* M�todo que faz a atualiza��o da taxa de ferom�nio para todas as p�ginas do website.
	* @access public
	* @return void
	*/	
	public function deductPheromone(){
	
		global $erro; // Variavel global de erros.
	
		$pagina        = $this->getPagina();
		$parametrosAdm = $this->getParametros_adm();
		$feromonio     = $this->getFeromonio();
		
		if(empty($pagina) || empty($parametrosAdm) || empty($feromonio)){
			$this->erro($erro['FERO_NAO_SUBITR']);
		}		
		$pagina->deductPheromone($feromonio, $parametrosAdm);
	}
	
	/** 
	* M�todo que retorna uma matriz de relev�ncia para a p�gina passada como par�metro.
	* @parm String $paginaOrigem
	* @parm Integer $grupo
	* @access public
	* @return void
	*/	
	public function getMtzRelevance($paginaAtual, $grupo){
		
		$pagina    = $this->getPagina();
		$feromonio = $this->getFeromonio();
		
		$idPageAtual = $pagina->idPage($paginaAtual);
		
		if(empty($idPageAtual)){
			return;
		}
	
		$matriz = array();
		
		$alfa = '';
		$beta = $feromonio->getBeta($idPageAtual, $grupo);
		
		if(empty($beta)){
			return;
		}
		
		$resultado = $pagina->rows(false, false, 0, 'ASC', false);
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$idPageDestino = $dados[$pagina->campos[0]];
				$alfa = $feromonio->getAlfa($idPageAtual, $idPageDestino, $grupo);
				if(!empty($alfa)){
					$relevance = $alfa/$beta;
					$matriz[$idPageAtual][$idPageDestino] = $relevance;
				}
			}
		}
		return $matriz;
	}//getMtzRelevance
	
	/** 
	* M�todo que retorna uma matriz de relev�ncia para a todas as p�ginas de um grupo.
	* @parm Integer $grupo
	* @access public
	* @return void
	*/
	public function getMtzRelevanceAll($grupo){
		
		$pagina    = $this->getPagina();
		$feromonio = $this->getFeromonio();
		
		$matriz = array();
		
		$alfa = '';
		$beta = $feromonio->getBetaAll($grupo);
		
		if(empty($beta)){
			return;
		}
		
		$resultado = $pagina->rows(false, false, 0, 'ASC', false);
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				$idPageDestino = $dados[$pagina->campos[0]];
				$alfa = $feromonio->getAlfaAll($idPageDestino, $grupo);
				if(!empty($alfa)){
					$relevance = $alfa/$beta;
					$matriz[$idPageDestino] = $relevance;
				}
			}
		}
		return $matriz;
	}
		
	/**
	* M�todo que retorna a relev�ncia de acordo com o tipo solicitado
	* @parm String $tipo
	* @parm String $paginaOrigem
	* @parm Integer $grupo
	* @access public
	* @return void
	*/		
	public function getRelevance($tipo, $paginaAtual, $grupo){
	
		global $lang; // Variavel global de linguagens;
	
		$pagina    = $this->getPagina();
		$feromonio = $this->getFeromonio();
		$matriz    = $this->getMtzRelevance($paginaAtual, $grupo);
		$matrizAll = $this->getMtzRelevanceAll($grupo);
		
		if(empty($matriz) || empty($matrizAll)){
			return $lang['rtn_info_insuficientes'];
		}
		
		$idPageAtual = $pagina->idPage($paginaAtual);
		
		switch($tipo){
		
			case 'obj$this_page':
				$maiorProb = max($matriz[$idPageAtual]);
				$pagMaiorProb = array_search($maiorProb, $matriz[$idPageAtual]);
				
				$pagina->__get_db($pagMaiorProb);
				
				$nomePagina = changePageName($pagina->getUrl_pagina());
				
				$prob = round(($maiorProb*100),3);
				
				$retorno .= $lang['rtn_pagina_relevante']." <b>$nomePagina</b>";
				$retorno .= " (<span class=\"vemelho negrito\"><b>".$prob."</span>%</b>)";
				
			break;
			
			case 'obj$all_pages':
				$maiorProb = max($matrizAll);
				$pagMaiorProb = array_search($maiorProb, $matrizAll);
				
				$pagina->__get_db($pagMaiorProb);
				
				$nomePagina = changePageName($pagina->getUrl_pagina());
				
				$prob = round(($maiorProb*100),3);
				
				$retorno .= $lang['rtn_pagina_relevante']." <b>$nomePagina</b>";
				$retorno .= " (<span class=\"vemelho negrito\"><b>".$prob."</span>%</b>)";
				
			break;
			
			case 'par$this_page':
				$matrizEach = $matriz[$idPageAtual];
				$i=0;
				arsort($matrizEach);
				foreach($matrizEach as $indice => $elemento){
					$pagina->__get_db($indice);
					$url = $pagina->getUrl_pagina();
					if(!empty($url) && $paginaAtual != $url){
						$nomePagina = changePageName($url);
						$prob = round(($elemento*100),3);
						if($i != 0){
							$retorno .= " | ";
						}
						$retorno .= "<b>$nomePagina</b> (<span class=\"vemelho negrito\"><b>".$prob."</span>%</b>)";
						$i++;
					}
				}
			break;
			
			case 'par$all_pages':
				$matrizEach = $matrizAll;
				$i=0;
				arsort($matrizEach);
				foreach($matrizEach as $indice => $elemento){
					$pagina->__get_db($indice);
					$url = $pagina->getUrl_pagina();
					if(!empty($url) && $paginaAtual != $url){
						$nomePagina = changePageName($url);
						$prob = round(($elemento*100),3);
						if($i != 0){
							$retorno .= " | ";
						}
						$retorno .= "<b>$nomePagina</b> (<span class=\"vemelho negrito\"><b>".$prob."</span>%</b>)";
						$i++;
					}
				}
			break;
			
			case 'ori$null':
				$maiorProb = max($matrizAll);
				$pagiaAlvo = array_search($maiorProb, $matrizAll);
				$i=0;
				
				/* Se Atual e Alvo foram iguais */
				if($idPageAtual == $pagiaAlvo){
					$retorno = $lang['rtn_pagina_alvo'];
				}
				else{
					/* P�gina Alvo */
					$pagina->__get_db($pagiaAlvo);
					$url = $pagina->getUrl_pagina();
					$nomePagina = changePageName($url);	
							
					$retorno = " > <b>$nomePagina</b>".$retorno;
									
					$pagAnterior = $feromonio->getPointedMostExcellent($pagiaAlvo);
					
					$arrayAdicionados[0] = $pagAnterior;
					
					$trava = true;
					
					while(($pagAnterior != $idPageAtual) && ($trava == true) && !empty($pagAnterior)){
					
						$encontrou = in_array($pagAnterior, $arrayAdicionados);
	
						if(!$encontrou){ $trava = false; }
					
						$pagina->__get_db($pagAnterior);
						$url = $pagina->getUrl_pagina();
						$nomePagina = changePageName($url);
						
						if($i != 0){
							$retorno = " > ".$retorno;
						}
						$retorno = "<b>$nomePagina</b>".$retorno;
						$i++;
						
						$pagAntAnterior = $pagAnterior;
						
						$pagAnterior = $feromonio->getPointedMostExcellent($pagAnterior);
						$arrayAdicionados[$i] = $pagAnterior;
						
						if($pagAntAnterior == $pagAnterior){ $trava = false; } 
						
					}
					
					/* P�gina Atual */
					$pagina->__get_db($idPageAtual);
					$url = $pagina->getUrl_pagina();
					$nomePagina = changePageName($url);
					
					if($i>0){
						$nomePagina .= " > ";
					}		
					$retorno = "<b>$nomePagina</b>".$retorno;
				}//Else
			break;		
		}//Case
		return $retorno;
	}

	/** 
	* GETS e SETS
	* M�todo __call que � verificado a cada chamada de uma fun��o da classe, o seguinte m�todo implementa automaticamente as fun��es de GET e SET.
	* @access public 
	*/  	
	public function __call($metodo, $parametros){
		if (substr($metodo, 0, 3) == 'set') {
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			$this->$var = $parametros[0];
			if(empty($parametros[1])){
				$this->__toFillGeneric();
			}
		}
		elseif (substr($metodo, 0, 3) == 'get'){
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			return $this->$var;
		}
	}//__call
}//Pessoa
?>