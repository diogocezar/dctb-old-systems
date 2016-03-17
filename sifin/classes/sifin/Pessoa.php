<?php

class Pessoa extends Generic{

	/**
	* Atributos
	*/
	protected
		$idpessoa,
		$idpessoajuridica,
		$idpessoafisica,
		$endereco,
		$bairro,
		$cidade,
		$uf,
		$cep,
		$fone,
		$fax,
		$site,
		$obs,
		$compraminima,
		$situacao,
		$databaixa;
		
	/**
	* Construtor
	* __construct_Pessoa()
	*/
	public function __construct_Pessoa(){}	
	
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
		
		$condicao = $camposMap['pessoa'][0]." = ".$cod;
		
		$valores = array($this->getId(),
						 $this->getIdpessoajuridica(),
						 $this->getIdpessoafisica(),
				         $this->getEndereco(),
						 $this->getBairro(),
						 $this->getCidade(),
						 $this->getUf(),
						 $this->getCep(),
						 $this->getFone(),
						 $this->getFax(),
						 $this->getSite(),
						 $this->getObs(),
						 $this->getCompraminima(),
						 $this->getSituacao(),
						 $this->getDatabaixa()
						 );
					 		
		$this->setTabela($tabelaMap['pessoa'], true);
		$this->setCampos($camposMap['pessoa'], true);        
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
			
			$this->setId               ($dados[$this->campos[0]]);
			$this->setIdpessoajuridica ($dados[$this->campos[1]]);
			$this->setIdpessoafisica   ($dados[$this->campos[2]]);
			$this->setEndereco         ($dados[$this->campos[3]]);
			$this->setBairro           ($dados[$this->campos[4]]);
			$this->setCidade           ($dados[$this->campos[5]]);
			$this->setUf               ($dados[$this->campos[6]]);
			$this->setCep              ($dados[$this->campos[7]]);
			$this->setFone             ($dados[$this->campos[8]]);
			$this->setFax              ($dados[$this->campos[9]]);
			$this->setSite             ($dados[$this->campos[10]]);
			$this->setObs              ($dados[$this->campos[11]]);
			$this->setCompraminima     ($dados[$this->campos[12]]);
			$this->setSituacao         ($dados[$this->campos[13]]);
			$this->setDatabaixa        ($dados[$this->campos[14]]);
		}
	}//__get
	
	/** 
	* Funчѕes para mascarar o nome do id
	* @access public
	*/
	function getId(){
		return $this->getIdpessoa();
	}
	
	function setId($id){
		$this->setIdpessoa($id);
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