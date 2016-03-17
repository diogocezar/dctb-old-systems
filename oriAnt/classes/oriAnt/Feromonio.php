<?php

class Feromonio extends Generic{

	/**
	* Atributos
	*/
	protected
		$id_feromonio      = '',
		$id_pagina_origem  = '',
		$id_pagina_destino = '',
		$id_grupo          = '',
		$qtd_feromonio     = '';
	
	/**
	* Construtor
	* __construct_Feromonio()
	*/
	public function __construct_Feromonio(){
		$this->__toFillGeneric();
	}	
	
	/** 
	* Mщtodo que serс implementado nas classes herdeiras, esse mщtodo deve preencher os atributos da classe pai (Generic).
	* @access public
	*/  
    public function __toFillGeneric(){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		$cod = $this->getId_feromonio();
		
		/* Parтmetro true, faz com que o mщtodo __toFillGeneric nуo seja chamado novamente */
		
		$condicao = $camposMap['feromonio'][0]." = ".$cod;
		
		$valores = array($this->getId_feromonio(),
		                 $this->getId_pagina_origem(),
				         $this->getId_pagina_destino(),
						 $this->getId_grupo(),
						 $this->getQtd_feromonio()
						 );
						 		
		$this->setTabela($tabelaMap['feromonio'], true);
		$this->setCampos($camposMap['feromonio'], true);        
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric
	
	/** 
	* Mщtodo que extrai do banco de dados um registro com determinado эndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
	
		$this->setId_feromonio($key);
		
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId_feromonio      ($dados[$this->campos[0]]);
			$this->setId_pagina_origem  ($dados[$this->campos[1]]);
			$this->setId_pagina_destino ($dados[$this->campos[2]]);
			$this->setId_grupo          ($dados[$this->campos[3]]);
			$this->setQtd_feromonio     ($dados[$this->campos[4]]);
		}
	}//__get_db
	
	/** 
	* Mщtodo que verifica se exite uma aresta cadastrada no website.
	* @parm Integer $idPageOrigem
	* @parm Integer $idPageDestino
	* @access public
	* @return boolean
	*/  
	public function cadastredEdge($idPageOrigem, $idPageDestino, $idGrupo){
		$sql .= "SELECT count(*) as total FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[1];
		$sql .= " = '";
		$sql .= $idPageOrigem;
		$sql .= "'";
		$sql .= " AND ";
		$sql .= $this->campos[2];
		$sql .= " = '";
		$sql .= $idPageDestino;
		$sql .= "'";
		$sql .= " AND ";
		$sql .= $this->campos[3];
		$sql .= " = '";
		$sql .= $idGrupo;
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
	}//cadastredEdge
	
	/** 
	* Mщtodo que retorna o id de uma aresta a partir dos atributos passados como parтmetros.
	* @parm Integer $idPageOrigem
	* @parm Integer $idPageDestino
	* @access public
	* @return Integer
	*/ 
	public function getEdge($idPageOrigem, $idPageDestino, $idGrupo){
		$sql .= "SELECT ";
		$sql .= $this->campos[0];
		$sql .= " FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[1];
		$sql .= " = '";
		$sql .= $idPageOrigem;
		$sql .= "'";
		$sql .= " AND ";
		$sql .= $this->campos[2];
		$sql .= " = '";
		$sql .= $idPageDestino;
		$sql .= "'";
		$sql .= " AND ";
		$sql .= $this->campos[3];
		$sql .= " = '";
		$sql .= $idGrupo;
		$sql .= "'";
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados[$this->campos[0]];
		}
	}//getEdge
	
	/** 
	* Mщtodo que retorna um ResultSet com os registros que tenhan como destino o id passado como parтmetro
	* @parm Integer $idPage
	* @access public
	* @return Integer
	*/ 
	public function getDestines($idPage){
		$sql .= "SELECT ";
		$sql .=  $this->campos[0];
		$sql .= " FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[2];
		$sql .= " = '";
		$sql .= $idPage;
		$sql .= "'";
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			return $resultado;
		}
		else{
			return false;
		}
	}
	
	/** 
	* Mщtodo que retorna a quantidade de feromєnio de uma aresta, de acordo com os atributos passados como parтmetro.
	* & recebe o nome de alpha pois щ usado no cсlculo da matriz de relevтncia.
	* @parm Integer $idPageAtual
	* @parm Integer $idPageDestino
	* @parm Integer $grupo
	* @access public
	* @return Integer
	*/ 
	public function getAlfa($idPageAtual, $idPageDestino, $grupo){
		$sql .= "SELECT ";
		$sql .=  $this->campos[4];
		$sql .= " FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[1];
		$sql .= " = '";
		$sql .= $idPageAtual;
		$sql .= "'";
		$sql .= " AND ";
		$sql .= $this->campos[2];
		$sql .= " = '";
		$sql .= $idPageDestino;
		$sql .= "'";
		$sql .= " AND ";
		$sql .= $this->campos[3];
		$sql .= " = '";
		$sql .= $grupo;
		$sql .= "'";
	
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados[$this->campos[4]];
		}
		else{
			return false;
		}
	}
	
	/** 
	* Mщtodo que retorna a soma da quantidade de feromєnio das arestas com pagina de origem igual a pсgina passada como parтmetro.
	* & recebe o nome de beta pois щ usado no cсlculo da matriz de relevтncia.
	* @parm Integer $idPageAtual
	* @parm Integer $idPageDestino
	* @parm Integer $grupo
	* @access public
	* @return Integer
	*/ 
	public function getBeta($idPageAtual, $grupo){
		$sql .= "SELECT SUM(";
		$sql .=  $this->campos[4];
		$sql .= ") as soma FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[1];
		$sql .= " = '";
		$sql .= $idPageAtual;
		$sql .= "'";
		$sql .= " AND ";
		$sql .= $this->campos[3];
		$sql .= " = '";
		$sql .= $grupo;
		$sql .= "'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados['soma'];
		}
		else{
			return false;
		}
	}
	
	/** 
	* Mщtodo que retorna a quantidade de feromєnio de uma aresta, de acordo com os atributos passados como parтmetro.
	* & recebe o nome de alpha pois щ usado no cсlculo da matriz de relevтncia.
	* @parm Integer $idPageAtual
	* @parm Integer $idPageDestino
	* @parm Integer $grupo
	* @access public
	* @return Integer
	*/ 
	public function getAlfaAll($idPageDestino, $grupo){
		$sql .= "SELECT ";
		$sql .=  $this->campos[4];
		$sql .= " FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[2];
		$sql .= " = '";
		$sql .= $idPageDestino;
		$sql .= "'";
		$sql .= " AND ";
		$sql .= $this->campos[3];
		$sql .= " = '";
		$sql .= $grupo;
		$sql .= "'";
	
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados[$this->campos[4]];
		}
		else{
			return false;
		}
	}
	
	/** 
	* Mщtodo que retorna a soma da quantidade de feromєnio das arestas com pagina de origem igual a pсgina passada como parтmetro.
	* & recebe o nome de beta pois щ usado no cсlculo da matriz de relevтncia.
	* @parm Integer $idPageAtual
	* @parm Integer $idPageDestino
	* @parm Integer $grupo
	* @access public
	* @return Integer
	*/ 
	public function getBetaAll($grupo){
		$sql .= "SELECT SUM(";
		$sql .=  $this->campos[4];
		$sql .= ") as soma FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[3];
		$sql .= " = '";
		$sql .= $grupo;
		$sql .= "'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados['soma'];
		}
		else{
			return false;
		}
	}
	
	public function getPointedMostExcellent($idPagePointed){
		$sql .= "SELECT ";
		$sql .=  $this->campos[1];
		$sql .= " FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ";
		$sql .= $this->campos[2];
		$sql .= " = '";
		$sql .= $idPagePointed;
		$sql .= "'";
		$sql .= " ORDER BY ";
		$sql .= $this->campos[4];
		$sql .= " DESC";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados[$this->campos[1]];
		}
		else{
			return;
		}
	}
	
	/** 
	* GETS e SETS
	* Mщtodo __call que щ verificado a cada chamada de uma funчуo da classe, o seguinte mщtodo implementa automaticamente as funчѕes de GET e SET.
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