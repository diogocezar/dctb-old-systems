<?php

class Pagina extends Generic{

	/**
	* Atributos
	*/
	protected
		$id_pagina       = '',
		$ultimo_acesso   = '',
		$url_pagina      = '',
		$cont_pagina     = '';
	
	/**
	* Construtor
	* __construct_Pagina()
	*/
	public function __construct_Pagina(){
		$this->__toFillGeneric();
	}	
	
	/** 
	* M�todo que ser� implementado nas classes herdeiras, esse m�todo deve preencher os atributos da classe pai (Generic).
	* @access public
	*/  
    public function __toFillGeneric(){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		$cod = $this->getId_pagina();
		
		/* Par�metro true, faz com que o m�todo __toFillGeneric n�o seja chamado novamente */
		
		$condicao = $camposMap['pagina'][0]." = ".$cod;
		
		$valores = array($this->getId_pagina(),
		                 $this->getUltimo_acesso(),
				         $this->getUrl_pagina(),
						 $this->getCont_pagina()
						 );
						 		
		$this->setTabela($tabelaMap['pagina'], true);
		$this->setCampos($camposMap['pagina'], true);        
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric

	/** 
	* M�todo que extrai do banco de dados um registro com determinado �ndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
	
		$this->setId_pagina($key);
		
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId_pagina     ($dados[$this->campos[0]]);
			$this->setUltimo_acesso ($dados[$this->campos[1]]);
			$this->setUrl_pagina    ($dados[$this->campos[2]]);
			$this->setCont_pagina   ($dados[$this->campos[3]]);
		}
	}//__get
	
	/** 
	* M�todo que retorna se uma p�gina est� cadastrada.
	* @parm String $page
	* @access public
	* @return boolean
	*/ 
	public function cadastredPage($page){
		$sql .= "SELECT count(*) as total FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[2];
		$sql .= " = '";
		$sql .= $page;
		$sql .= "'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			if($dados['total'] > 0){
				return true;
			}
			else{
				return false;
			}
		}
		return false;
	}//paginaCadastrada
	
	/** 
	* M�todo que retorna o id de uma p�gina cadastrada.
	* @parm String $page
	* @access public
	* @return Integer
	*/ 
	public function idPage($page){
		$sql .= "SELECT ".$this->campos[0]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[2];
		$sql .= " = '";
		$sql .= $page;
		$sql .= "'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados[$this->campos[0]];
		}
	}//codPage
	
	/** 
	* M�todo que faz a atualiza��o da taxa de ferom�nio para todas as p�ginas do website.
	* @parm Object $feromonio
	* @parm Object $parametrosAdm
	* @access public
	* @return void
	*************************************************************************************
	* Hours   difference = floor(($d2-$d1)/3600); 
	* Minutes difference = floor(($d2-$d1)/60); 
	* Seconds difference = $d2-$d1; 
	* Month   difference = floor(($d2-$d1)/2628000); 
	* Days    difference = floor(($d2-$d1)/86400); 
	* Year    difference = floor(($d2-$d1)/31536000);
	*/	
	public function deductPheromone($feromonio, $parametrosAdm){
	
		/**
		* Recuperando infoma��es dos par�metros administrativos.
		*/
	
		$parametrosAdm->__get_db();

		$txEvaporacao  = $parametrosAdm->getTx_evaporacao();
		$divDiferenca  = $parametrosAdm->getDiv_diferenca();
	
		$mes      = date("m");
		$diaNum   = date("d");
		$ano      = date("Y");
		
		$hora     = date("H");
		$minuto   = date("i");
		$segundo  = date("s");
		
		$hoje = mktime($hora, $minuto, $segundo, $mes, $diaNum, $ano);
		
		$sql .= "SELECT ";
		$sql .= $this->campos[0];
		$sql .= " , ";
		$sql .= $this->campos[1];
		$sql .= " FROM ";
		$sql .= $this->getTabela();
		
		$txEvaporacao = $txEvaporacao/10000;
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
		
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			
				$idPage    = $dados[$this->campos[0]];
				$antes     = returnMktime($dados[$this->campos[1]]);
				$diferenca = round(($hoje - $antes)/$divDiferenca, 5);
				//Debug: echo "id: {$dados['id']} <br>";
				$resultadosFeromonio = $feromonio->getDestines($idPage);
				
				while($dadosFeromonio = $resultadosFeromonio->fetchRow(DB_FETCHMODE_ASSOC)){
				
					$feromonio->__get_db($dadosFeromonio[$feromonio->campos[0]]);
					$qtdFeromonio = $feromonio->getQtd_feromonio();
					$novoFeromonio = round($qtdFeromonio*(pow((1-$txEvaporacao),$diferenca)), 5);
					//Debug: echo "Antes: $qtdFeromonio | Depois: $novoFeromonio | Diferen�a : ".($qtdFeromonio-$novoFeromonio)."<br>";
					$feromonio->setQtd_feromonio($novoFeromonio);
					$feromonio->update();
				}
			}
		}
	}//deductPheromone
	
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
}//pagina
?>