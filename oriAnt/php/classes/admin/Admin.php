<?php

class Admin extends Generic{

	/**
	* Atributos
	*/
	protected
		$id     = '',
		$nome   = '',
		$login  = '',
		$senha  = '',
		$email  = '';
	
	/**
	* Construtor
	* __construct_Admin()
	*/
	public function __construct_Admin(){
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
		
		$id = $this->getId();
		
		/* Parтmetro true, faz com que o mщtodo __toFillGeneric nуo seja chamado novamente */
		
		$condicao = $camposMap['admin'][0]." = ".$id;
		
		$valores = array($this->getId(),
						 $this->getNome(),
		                 $this->getLogin(),
						 $this->getSenha(),
						 $this->getEmail()
						 );
						 		
		$this->setTabela($tabelaMap['admin'], true);
		$this->setCampos($camposMap['admin'], true);        
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
			
			$this->setId    ($dados[$this->campos[0]]);
			$this->setNome  ($dados[$this->campos[1]]);
			$this->setLogin ($dados[$this->campos[2]]);
			$this->setSenha ($dados[$this->campos[3]]);
			$this->setEmail ($dados[$this->campos[4]]);
		}
	}//__get
	
	/** 
	* Mщtodo que faz a autenticaчуo do adminsitrador no banco de dados
	* @parm String $key
	* @access public
	*/  	
	public function allowAdmin($login, $senha, $session){
	
		$sql .= "SELECT *";
		$sql .= " FROM ".$this->tabela;
		
		$allowed = false;
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				if($login == $dados[$this->campos[2]] && $senha == $dados[$this->campos[3]]){
					$session->salvaSession(SESSION_PERMITIDO, "sim");
					$session->salvaSession(SESSION_LOGIN, $login);
					$session->salvaSession(SESSION_ID, $dados[$this->campos[0]]);
					$session->salvaSession(SESSION_NOME, $dados[$this->campos[1]]);
					$allowed = true;
				}
			}
		}
		return $allowed;
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
}//Comentarios
?>