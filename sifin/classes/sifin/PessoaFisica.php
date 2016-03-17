<?php

class PessoaFisica extends Generic{

	/**
	* Atributos
	*/
	protected
		$idpessoafisica,
		$cpf,
		$rg,
		$nome,
		$sobrenome;
		
	/**
	* Construtor
	* __construct_Pessoa()
	*/
	public function __construct_PessoaJuridica(){}	
	
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
		
		$condicao = $camposMap['pessoafisica'][0]." = ".$cod;
		
		$valores = array($this->getId(),
						 $this->getCpf(),
				         $this->getRg(),
						 $this->getNome(),
						 $this->getSobrenome()
						 );
					 		
		$this->setTabela($tabelaMap['pessoafisica'], true);
		$this->setCampos($camposMap['pessoafisica'], true);        
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
			
			$this->setId        ($dados[$this->campos[0]]);
			$this->setCpf       ($dados[$this->campos[1]]);
			$this->setRg        ($dados[$this->campos[2]]);
			$this->setNome      ($dados[$this->campos[3]]);
			$this->setSobrenome ($dados[$this->campos[4]]);
		}
	}//__get
	
	/** 
	* Mщtodo retorna uma lista de pessoas fэsicas e a indexaчуo da tabela pessoa
	* @access public
	*/  	
	function listPf(){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT pf.".$this->campos[0].", pf.".$this->campos[3].", pf.".$this->campos[4].", p.".$camposMap['pessoa'][0].", p.".$camposMap['pessoa'][14]." FROM ";
		$sql .= $this->getTabela()." pf, ".$tabelaMap['pessoa']." p";
		$sql .= " WHERE pf.".$this->campos[0]." = p.".$this->campos[0];
		$sql .= " AND p.".$camposMap['pessoa'][13]." = 'TRUE'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		return $resultado;
	}//listPf
	
	/** 
	* Mщtodo que verifica se a pessoa jс existe no banco
	* @access public
	*/  	
	function exists($nome, $sobrenome){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT ".$this->campos[3].", ".$this->campos[4]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[3]." = '".$nome."'";
		$sql .= " AND ".$this->campos[4]." = '".$sobrenome."'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			if(empty($dados[$this->campos[3]])){
				return false;
			}
			else{
				return true;
			}
		}
	}//exists
	
	/** 
	* Funчѕes para mascarar o nome do id
	* @access public
	*/
	function getId(){
		return $this->getIdpessoafisica();
	}
	
	function setId($id){
		$this->setIdpessoafisica($id);
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