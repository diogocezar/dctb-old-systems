<?php
/** 
 * SpeceBrain
 *
 * Essa classe organiza o corpo das classes din�micas do sistema
 * This class organizes the body of dinamic classes of system
 *
 * @author Diogo Cezar <diogo@diogocezar.com>
 * @version 2.0.1
 * @copyright Copyright � 2007-2009
 * @abstract
 * @package body
 */

class Body extends Generic{
	
	/** 
	 * M�todo que recupera o nome original de uma classe, tranforma TestandoUmaString para testando_uma_string
	 * @access private
	 */  
	private function changeNameClass($name){
		preg_match_all('/[A-Z][a-z]*/', $name, $newName);
		$arrayPalavras = $newName[0];
		if(empty($arrayPalavras)){
			$retorno = strtolower($name);
		}
		else{
			$retorno = "";
			$i=0;
			foreach($arrayPalavras as $palavra){
				if($i+1 == count($arrayPalavras)){
					$sep = "";
				}
				else{
					$sep = "_";
				}
				$i++;
				$retorno .= strtolower($palavra).$sep;
			}
		}
		return $retorno;
	}
	
	/** 
	 * M�todo que ser� implementado nas classes herdeiras, esse m�todo deve preencher os atributos da classe pai (Generic)
	 * Obs. Par�metro true (no m�todo set) faz com que o m�todo __toFillGeneric n�o seja chamado novamente
	 * @access public
	 */  
    public function __toFillGeneric($object){
	
		/* Identificando as variaveis globais */	
		global $table_mapping;
		
		$object->setNameclass(get_class($object),         true);
		$object->setClassvars($object->__getClassVars(),  true);

		$i = 0;
		$arrayClassVars = $object->getClassvars();
		foreach($arrayClassVars as $name => $value){
			$nomeVar = $this->convertGet($name);
			$valores[$i++] = $object->$nomeVar();
		}
			
		$cod = $object->getId();
		$condicao = $camposMap[$object->getNameclass()][0]." = ".$cod;
		
		$nameChanged = $this->changeNameClass($object->getNameclass());
		
		$object->setTabela   ($nameChanged,                             true);
		$object->setCampos   (array_keys($table_mapping[$nameChanged]), true);        
		$object->setCondicao ($condicao,                                true);
		$object->setValores  ($valores,                                 true);

    }//__toFillGeneric
	
	/** 
	 * M�todo que extrai do banco de dados um registro com determinado �ndice.
	 * @param String $key
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
	 * Fun��es para mascarar o nome do id
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