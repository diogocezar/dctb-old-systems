<?php
	/** 
	* Método que retorna o código da última inscrição adicionada
	* @access public
	*/
	function returnLast(){
		$sql .= "SELECT max(idinscricao) as maxIns FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE situacao = TRUE";

		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		if(!DB::isError($resultado)){			
			return $dados['maxIns'];
		}	
		return $retorno;
	}//returnLast
	
	/** 
	* Método que verifica se a pessoa já não está cadastrada
	* @access public
	*/	
	function checkUnique(){
		$email = $this->getEmail();
		$curso = $this->getIdcurso();
		$sql .= "SELECT count(*) as checkunique FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE situacao = TRUE";	
		$sql .= " AND email = '$email'";
		$sql .= " AND idcurso = $curso";	
		
		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		if(!DB::isError($resultado)){
			if(	$dados['checkunique'] > 0){
				$retorno = false;	
			}
			else{
				$retorno = true;
			}
		}	
		return $retorno;
	}//checkUnique
?>