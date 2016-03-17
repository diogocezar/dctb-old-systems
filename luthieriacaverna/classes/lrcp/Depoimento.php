<?php

class Depoimento extends Generic{

	/**
	* Atributos
	*/
	protected
		$id,
		$nome,
		$email,
		$depoimento;
	/**
	* Construtor
	* __construct_Depoimento()
	*/
	public function __construct_Depoimento(){}	
	
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
		
		$condicao = $camposMap['depoimento'][0]." = ".$cod;
		
		$valores = array($this->getId(),
						 $this->getNome(),
						 $this->getEmail(),
				         $this->getDepoimento()
						 );
					 		
		$this->setTabela($tabelaMap['depoimento'], true);
		$this->setCampos($camposMap['depoimento'], true);        
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
		
		$this->__toFillGeneric();
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId          ($dados[$this->campos[0]]);
			$this->setNome        ($dados[$this->campos[1]]);
			$this->setEmail       ($dados[$this->campos[2]]);
			$this->setDepoimento  ($dados[$this->campos[3]]);
		}
	}//__get
	
	public function retornaRand(){
		$sql .= "SELECT * FROM ";
		$sql .= $this->getTabela();
		$sql .= " ORDER BY rand() LIMIT 1 ";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId          ($dados[$this->campos[0]]);
			$this->setNome        ($dados[$this->campos[1]]);
			$this->setEmail       ($dados[$this->campos[2]]);
			$this->setDepoimento  ($dados[$this->campos[3]]);
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
}//Artigo
?>