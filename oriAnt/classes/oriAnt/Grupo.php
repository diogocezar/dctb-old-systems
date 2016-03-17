<?php

class Grupo extends Generic{

	/**
	* Atributos
	*/
	protected
		$id   = '',
		$cont = '',
		$nome = '';
	
	/**
	* Construtor
	* __construct_Grupo()
	*/
	public function __construct_Grupo(){
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
		
		$cod = $this->getId();
		
		/* Parтmetro true, faz com que o mщtodo __toFillGeneric nуo seja chamado novamente */
		
		$condicao = $camposMap['grupo'][0]." = ".$cod;
		
		$valores = array($this->getId(),
		                 $this->getCont(),
				         $this->getNome()
						 );
						 		
		$this->setTabela($tabelaMap['grupo'], true);
		$this->setCampos($camposMap['grupo'], true);        
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric
	
	/** 
	* Mщtodo que extrai do banco de dados um registro com determinado эndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
	
		$this->setId($key);
		
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId      ($dados[$this->campos[0]]);
			$this->setCont    ($dados[$this->campos[1]]);
			$this->setNome    ($dados[$this->campos[2]]);
		}
	}//__get
	
	/** 
	* Mщtodo que retorna a soma de todos os conts
	* @access public
	*/  
	public function totalConts(){
		$sql .= "SELECT SUM(".$this->campos[1].") as totalcont FROM ";
		$sql .= $this->getTabela();
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados['totalcont'];
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
}//grupo
?>