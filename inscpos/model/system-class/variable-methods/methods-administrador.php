<?php
// write your methods here

	/** 
	* Método que permite o acesso de um usuário no sistema
	* @parm String $login
	* @parm String $senha
	* @access public
	*/  	
	function allowLogin($login, $senha){
		$sql .= "SELECT ".$this->campos[0].",".$this->campos[1].",".$this->campos[2].",".$this->campos[3].",".$this->campos[4].",".$this->campos[5]." FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE situacao = TRUE";

		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		$retorno = false;
		if(!DB::isError($resultado)){
			while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
				if(strtoupper($login) == strtoupper($dados[$this->campos[4]]) && $senha == $dados[$this->campos[5]]){
					$retorno['idadministrador']  = $dados[$this->campos[0]];
					$retorno['idcurso']			 = $dados[$this->campos[1]];
					$retorno['nome']             = $dados[$this->campos[2]];
					$retorno['email']            = $dados[$this->campos[3]];
					$retorno['login']            = $dados[$this->campos[4]];
					$retorno['senha']            = $dados[$this->campos[5]];
				}
			}
		}	
		return $retorno;
	}//allowLogin
	
	/** 
	* Método que retorna os emails dos administradores de determinado curso
	* @access public
	* @parm Integer $curso
	*/  	
	function returnEmails($curso){
		
		$separacao = "";
		$i = 0;
		$db = Generic::dataBase();
		$qtd = 0;
		
		$sqlCount = "SELECT count(*) as qtd FROM ".$this->getTabela()." WHERE idcurso = $curso AND situacao = TRUE";
		$sqlResultado = $db->query($sqlCount);
		$dados = $sqlResultado->fetchRow(DB_FETCHMODE_ASSOC);
		$qtd = $dados['qtd'];
		
		$sql = "SELECT email FROM ".$this->getTabela()." WHERE idcurso = $curso AND situacao = TRUE";
		$resultado = $db->query($sql);
		
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			if($qtd > 1){
				$separacao = ", ";
			}
			if($i+1 == $qtd){
				$separacao = "";
			}
			$retorno .= $dados['email'].$separacao;
			$i++;
		}
		return $retorno;
	}//returnEmails
?>