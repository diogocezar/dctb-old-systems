<?php

class Body extends Generic{
	
	/** 
	* Método que será implementado nas classes herdeiras, esse método deve preencher os atributos da classe pai (Generic).
	* @access public
	* Obs. Parâmetro true (no método set) faz com que o método __toFillGeneric não seja chamado novamente
	*/  
    public function __toFillGeneric($object){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		$object->setNameclass(strtolower(get_class($object)),  true);
		$object->setClassvars($object->__getClassVars(),  true);

		$i = 0;
		$arrayClassVars = $object->getClassvars();
		foreach($arrayClassVars as $name => $value){
			$nomeVar = $this->convertGet($name);
			$valores[$i++] = $object->$nomeVar();
		}
			
		$cod = $object->getId();
		$condicao = $camposMap[$object->getNameclass()][0]." = ".$cod;
		
		$object->setTabela   ($tabelaMap[$object->getNameclass()], true);
		$object->setCampos   ($camposMap[$object->getNameclass()], true);        
		$object->setCondicao ($condicao,                           true);
		$object->setValores  ($valores,                            true);

    }//__toFillGeneric
	
	/** 
	* Método que extrai do banco de dados um registro com determinado índice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key, $object){
	
		$object->setId($key);
		
		$object->__toFillGeneric();
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$i = 0;
			$arrayClassVars = $object->getClassvars();
			foreach($arrayClassVars as $name => $value){
				$nomeVar = $this->convertSet($name);
				$object->$nomeVar($dados[$object->campos[$i++]]);
			}
		}
	}//__get
	
	/** 
	* Funções para mascarar o nome do id
	* @access public
	*/
	function getId(){
		$arrayClassVars = $this->getClassvars();
		foreach($arrayClassVars as $name => $value){
			$nomeVar = $this->convertGet($name);
			return $this->$nomeVar();
		}
	}
	
	function setId($id){
		$arrayClassVars = $this->getClassvars();
		foreach($arrayClassVars as $name => $value){
			$nomeVar = $this->convertSet($name);
			$this->$nomeVar($id);
			$this->__toFillGeneric();
			return;
		}
	}
	
	protected function convertSet($name){
		return 'set'.ucfirst($name);
	}
	
	protected function convertGet($name){
		return 'get'.ucfirst($name);
	}
}
?>