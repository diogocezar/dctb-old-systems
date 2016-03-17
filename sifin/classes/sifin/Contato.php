<?php

class Contato extends Generic{

	/**
	* Atributos
	*/
	protected
		$idcontato,
		$idpessoa,
		$nome,
		$email,
		$msn,
		$skype,
		$fone,
		$fax,
		$celular,
		$ramal,
		$departamento,
		$situacao,
		$dataBaixa;		

	/**
	* Construtor
	* __construct_Contato()
	*/
	public function __construct_Contato(){}	
	
	/** 
	* M�todo que ser� implementado nas classes herdeiras, esse m�todo deve preencher os atributos da classe pai (Generic).
	* @access public
	*/  
    public function __toFillGeneric(){
	
		/* Identificando as variaveis globais */	
		global $tabelaMap;
		global $camposMap;
		
		$cod = $this->getId();
		
		/* Par�metro true, faz com que o m�todo __toFillGeneric n�o seja chamado novamente */
		
		$condicao = $camposMap['contato'][0]." = ".$cod;
		
		$valores = array($this->getId(),
						 $this->getIdpessoa(),
						 $this->getNome(),
				         $this->getEmail(),
						 $this->getMsn(),
						 $this->getSkype(),
						 $this->getFone(),
						 $this->getFax(),
						 $this->getCelular(),
						 $this->getRamal(),
						 $this->getDepartamento(),
						 $this->getSituacao(),
						 $this->getDatabaixa()
						 );
					 		
		$this->setTabela($tabelaMap['contato'], true);
		$this->setCampos($camposMap['contato'], true);        
		$this->setCondicao($condicao, true);
		$this->setValores($valores, true);

    }//__toFillGeneric
	
	/** 
	* M�todo que extrai do banco de dados um registro com determinado �ndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
	
		$this->setIdcontato($key);
		
		$this->__toFillGeneric();
		$resultado = Generic::uniqueKey($key);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			
			$this->setId           ($dados[$this->campos[0]]);
			$this->setIdpessoa     ($dados[$this->campos[1]]);
			$this->setNome         ($dados[$this->campos[2]]);
			$this->setEmail        ($dados[$this->campos[3]]);
			$this->setMsn          ($dados[$this->campos[4]]);
			$this->setSkype        ($dados[$this->campos[5]]);
			$this->setFone         ($dados[$this->campos[6]]);
			$this->setFax          ($dados[$this->campos[7]]);
			$this->setCelular      ($dados[$this->campos[8]]);
			$this->setRamal        ($dados[$this->campos[9]]);
			$this->setDepartamento ($dados[$this->campos[10]]);
			$this->setSituacao     ($dados[$this->campos[11]]);
			$this->setDatabaixa    ($dados[$this->campos[12]]);
		}
	}//__get
	
	/** 
	* Fun��es para mascarar o nome do id
	* @access public
	*/
	function getId(){
		return $this->getIdcontato();
	}
	
	function setId($id){
		$this->setIdcontato($id);
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
}//Artigo
?>