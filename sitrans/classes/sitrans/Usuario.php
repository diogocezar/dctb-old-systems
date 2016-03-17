<?php

class Usuario extends Body{

	/**
	* Atributos
	*/
	protected
		$idusuario,
		$idnivel,
		$nome,
		$login,
		$senha,
		$datacadastro,
		$databaixa,
		$situacao;
		
	/** 
	* M�todo que ser� implementado nas classes herdeiras, esse m�todo deve preencher os atributos da classe pai (Generic).
	* @access public
	* Obs. Par�metro true (no m�todo set) faz com que o m�todo __toFillGeneric n�o seja chamado novamente
	*/  
    public function __toFillGeneric(){
		Body::__toFillGeneric($this);
    }//__toFillGeneric
	
	/** 
	* M�todo que extrai do banco de dados um registro com determinado �ndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
		Body::__get_db($key, $this);
	}//__get_db
	
	/** 
	* M�todo que retorna um array com os atributos privados da classe
	* @access public
	*/ 
	public function __getClassVars(){
		return get_class_vars(get_class($this));
	}//__getClassVars
	
	/** 
	* M�todo que verifica se o usu�rio j� existe no banco
	* @access public
	*/  	
	function exists($nome, $login){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT ".$this->campos[2].", ".$this->campos[3]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[2]." = '".$nome."'";
		$sql .= " OR ".$this->campos[3]." = '".$login."'";
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			if(empty($dados[$this->campos[2]])){
				return false;
			}
			else{
				return true;
			}
		}
	}//exists	
	
	/** 
	* M�todo que permite o acesso de um usu�rio no sistema
	* @parm String $login
	* @parm String $senha
	* @access public
	*/  	
	function allowLogin($login, $senha){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[1].",".$this->campos[2].",".$this->campos[3].",".$this->campos[4]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[7]." = 'TRUE'";
		
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
	* M�todo retorna uma lista de usuarios e a indexa��o por seu id
	* @access public
	*/  	
	function _list(){
		global $tabelaMap;
		global $camposMap;
		
		$sql .= "SELECT ".$this->campos[2].", ".$this->campos[0]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[7]." = 'TRUE'";
		$sql .= " ORDER BY ".$this->campos[2]." ASC";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		return $resultado;
	}//list

	
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
}//Usuario
?>