<?php
// write your methods here

	/** 
	* Método que permite o acesso de um usuário no sistema
	* @parm String $login
	* @parm String $senha
	* @access public
	*/  	
	function allowLogin($login, $senha){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[1].",".$this->campos[2].",".$this->campos[3]." FROM ";
		$sql .= $this->getTabela();

		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		$retorno = false;
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				if($login == $dados[$this->campos[2]] && $senha == $dados[$this->campos[3]]){
					$retorno['iduser']   = $dados[$this->campos[0]];
					$retorno['name']     = $dados[$this->campos[1]];
					$retorno['login']    = $dados[$this->campos[2]];
					$retorno['password'] = $dados[$this->campos[3]];
				}
			}
		}	
		return $retorno;
	}//allowLogin

?>