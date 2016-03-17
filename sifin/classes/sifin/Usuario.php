<?php

class Usuario extends Generic{

	/**
	* Atributos
	*/
	protected
		$idusuario,
		$idnivel,
		$nome,
		$login,
		$senha,
		$situacao,
		$databaixa;
		
	/**
	* Construtor
	* __construct_Usuario()
	*/
	public function __construct_Usuario(){}	
	
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
		
		$condicao = $camposMap['usuario'][0]." = ".$cod;
		
		$valores = array($this->getId(),
						 $this->getIdnivel(),
				         $this->getNome(),
						 $this->getLogin(),
						 $this->getSenha(),
						 $this->getSituacao(),
						 $this->getDatabaixa()
						 );
					 		
		$this->setTabela($tabelaMap['usuario'], true);
		$this->setCampos($camposMap['usuario'], true);        
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
			$this->setIdnivel   ($dados[$this->campos[1]]);
			$this->setNome      ($dados[$this->campos[2]]);
			$this->setLogin     ($dados[$this->campos[3]]);
			$this->setSenha     ($dados[$this->campos[4]]);
			$this->setSituacao  ($dados[$this->campos[5]]);
			$this->setDatabaixa ($dados[$this->campos[6]]);
		}
	}//__get
	
	/** 
	* Mщtodo que permite o acesso de um usuсrio no sistema
	* @parm String $login
	* @parm String $senha
	* @access public
	*/  	
	function allowLogin($login, $senha){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[1].",".$this->campos[2].",".$this->campos[3].",".$this->campos[4]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[5]." = 'TRUE'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		$retorno = false;
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				if($login == $dados[$this->campos[3]] && $senha == $dados[$this->campos[4]]){
					$retorno['id']    = $dados[$this->campos[0]];
					$retorno['nivel'] = $dados[$this->campos[1]];
					$retorno['nome']  = $dados[$this->campos[2]];
					$retorno['login'] = $dados[$this->campos[3]];
					$retorno['senha'] = $dados[$this->campos[4]];
				}
			}
		}	
		return $retorno;
	}//allowLogin
	
	/** 
	* Funчѕes para mascarar o nome do id
	* @access public
	*/
	function getId(){
		return $this->getIdusuario();
	}
	
	function setId($id){
		$this->setIdusuario($id);
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