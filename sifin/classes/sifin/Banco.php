<?php

class Banco extends Generic{

	/**
	* Atributos
	*/
	protected
		$idbanco,
		$descricao,
		$situacao,
		$databaixa;
	
	/**
	* Construtor
	* __construct_Banco()
	*/
	public function __construct_Banco(){}	
	
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
		
		$condicao = $camposMap['banco'][0]." = ".$cod;
		
		$valores = array($this->getId(),
				         $this->getDescricao(),
						 $this->getSituacao(),
						 $this->getDatabaixa()
						 );
					 		
		$this->setTabela($tabelaMap['banco'], true);
		$this->setCampos($camposMap['banco'], true);       
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric
	
	/** 
	* Mщtodo que extrai do banco de dados um registro com determinado эndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
	
		$this->setIdbanco($key);
		
		$this->__toFillGeneric();
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId        ($dados[$this->campos[0]]);
			$this->setDescricao ($dados[$this->campos[1]]);
			$this->setSituacao  ($dados[$this->campos[2]]);
			$this->setDatabaixa ($dados[$this->campos[3]]);
		}
	}//__get
	
	/** 
	* Funчѕes para mascarar o nome do id
	* @access public
	*/
	function getId(){
		return $this->getIdbanco();
	}
	
	function setId($id){
		$this->setIdbanco($id);
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
}//Artigo
?>