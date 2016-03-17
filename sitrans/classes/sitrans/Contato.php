<?php

class Contato extends Body{

	/**
	* Atributos
	*/
	protected
		$idcontato,
		$idpessoa,
		$nome,
		$funcao,
		$telefone,
		$celular,
		$ramal,
		$email,
		$datacadastro,
		$databaixa,
		$situacao,
		$login,
		$senha;

	/** 
	* Mщtodo que serс implementado nas classes herdeiras, esse mщtodo deve preencher os atributos da classe pai (Generic).
	* @access public
	* Obs. Parтmetro true (no mщtodo set) faz com que o mщtodo __toFillGeneric nуo seja chamado novamente
	*/  
    public function __toFillGeneric(){
		Body::__toFillGeneric($this);
    }//__toFillGeneric
	
	/** 
	* Mщtodo que extrai do banco de dados um registro com determinado эndice.
	* @parm String $key
	* @access public
	*/  
	public function __get_db($key){
		Body::__get_db($key, $this);
	}//__get_db
	
	/** 
	* Mщtodo que retorna um array com os atributos privados da classe
	* @access public
	*/ 
	public function __getClassVars(){
		return get_class_vars(get_class($this));
	}//__getClassVars
	
	/** 
	* Mщtodo que retorna os contatos de uma pessoa
	* @parm String $idPessoa
	* @access public
	*/  	
	function listPeoples($idPessoa){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[2]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[1]." = ".$idPessoa;
		$sql .= " ORDER BY ".$this->campos[2]." ASC";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
		}	
		return $resultado;
	}//listPeoples
	
	/** 
	* Mщtodo que permite o acesso de um contato no sistema
	* @parm String $login
	* @parm String $senha
	* @access public
	*/  	
	function allowLoginContato($login, $senha){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[2].",".$this->campos[11].",".$this->campos[12]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[10]." = 'TRUE'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		$retorno = false;
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				if($login == $dados[$this->campos[11]] && $senha == $dados[$this->campos[12]]){
					$retorno['nome']  = $dados[$this->campos[2]];
					$retorno['id']    = $dados[$this->campos[0]];
					$retorno['login'] = $dados[$this->campos[11]];
					$retorno['senha'] = $dados[$this->campos[12]];
				}
			}
		}	
		return $retorno;
	}//allowLoginContato
	
	/** 
	* Mщtodo retorna uma lista de contatos
	* @access public
	*/  	
	function _list(){
		global $tabelaMap;
		global $camposMap;
		
		$campoIndex = $this->campos[0];

		$sql .= "SELECT ".$this->campos[2].", ".$campoIndex." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[10]." = 'TRUE'";
		$sql .= " ORDER BY ".$this->campos[3]." ASC";
				
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		return $resultado;
	}//_list	
	
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
}//Contato
?>