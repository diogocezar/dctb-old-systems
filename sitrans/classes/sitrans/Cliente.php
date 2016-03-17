<?php

class Cliente extends Body{

	/**
	* Atributos
	*/
	
	protected
		$idcliente,
		$idpessoa,
		$idfrequenciacoleta,
		$nome,
		$cnpjcpf,
		$inscestadualrg,
		$datacadastro,
		$databaixa,
		$situacao;
		
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
	* Mщtodo que verifica se a pessoa jс existe no banco
	* @access public
	*/  	
	function exists($nome){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT ".$this->campos[3]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[3]." = '".$nome."'";
		
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
	* Mщtodo que verifica se a pessoa jс existe no banco (por cnpf)
	* @access public
	*/  	
	function existsByCnpf($cnpf){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT ".$this->campos[4]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[4]." = '".$cnpf."'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			if(empty($dados[$this->campos[4]])){
				return false;
			}
			else{
				return true;
			}
		}
	}//existsByCnpf
	
	/** 
	* Mщtodo que retorna o id de um cliente por seu cnpf
	* @access public
	*/  	
	function returnIdByCnpf($cnpf){
		global $tabelaMap;
		global $camposMap;

		$sql .= "SELECT ".$this->campos[0]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE ".$this->campos[4]." = '".$cnpf."'";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			return $dados['idcliente'];
		}
	}//existsByCnpf	
	
	/** 
	* Mщtodo retorna uma lista de clientes e a indexaчуo da tabela pessoa
	* @access public
	*/  	
	function _list($index = 'pessoa'){
		global $tabelaMap;
		global $camposMap;
		
		if($index == 'pessoa'){
			$campoIndex = $this->campos[1];
		}
		else{
			$campoIndex = $this->campos[0];
		}

		$sql .= "SELECT c.".$this->campos[3].", p.telefone, c.".$campoIndex." FROM ";
		$sql .= $this->getTabela()." c, pessoa p";
		$sql .= " WHERE c.".$this->campos[8]." = 'TRUE'";
		$sql .= " AND p.idpessoa = c.idpessoa";
		$sql .= " ORDER BY c.".$this->campos[3]." ASC";
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		return $resultado;
	}//list	
	
	/** 
	* Mщtodo retorna um id de cliente a partir de um id de seu contato
	* @access public
	*/  	
	function returnIdByContact($idContact){
		$sql .= "SELECT c.nome, c.idcliente FROM cliente c, pessoa p, contato k WHERE c.idpessoa = p.idpessoa AND k.idpessoa = p.idpessoa AND k.idcontato = $idContact";
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$retorno['nome']      = $dados['nome'];
			$retorno['idcliente'] = $dados['idcliente'];
			return $retorno;
		}
	}
	
	/** 
	* Mщtodo retorna os dados do cliente e da sua pessoa filtrados por seu cnpf
	* @access public
	*/  	
	function returnDataByCnpf($cnpf){
		$sql .= "SELECT c.*, p.* FROM cliente c, pessoa p WHERE c.idpessoa = p.idpessoa AND c.cnpjcpf = '$cnpf'";
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$retorno['cnpfcpf']        = $dados['cnpfcpf'];
			$retorno['inscestadualrg'] = $dados['inscestadualrg'];
			$retorno['nome']           = $dados['nome'];
			$retorno['cep']            = $dados['cep'];
			$retorno['rua']            = $dados['rua'];
			$retorno['numero']         = $dados['numero'];
			$retorno['complemento']    = $dados['complemento'];
			$retorno['bairro']         = $dados['bairro'];
			$retorno['cidade']         = $dados['cidade'];
			$retorno['estado']         = $dados['estado'];
			$retorno['telefone']       = $dados['telefone'];
			$retorno['fax']            = $dados['fax'];
			$retorno['email']          = $dados['email'];
			return $retorno;
		}
	}
	
	/** 
	* Mщtodo retorna o cnpf/cpf a partir de seu id
	* @access public
	*/  	
	function returnCnpfById($id){
		$sql .= "SELECT cnpjcpf FROM cliente  WHERE idcliente = '$id'";
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		if(!DB::isError($resultado)){
			$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			 return $dados['cnpjcpf'];
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
}//Cliente
?>