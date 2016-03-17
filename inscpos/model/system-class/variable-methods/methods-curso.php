<?php
	/** 
	* Método que retorna se um curso está ativo ou não
	* @access public
	*/
	function activatedCourse(){
		$sql .= "SELECT ativo FROM ";
		$sql .= $this->getTabela();
		$sql .= " WHERE situacao = TRUE";
		$sql .= " AND idcurso = ".$this->getIdcurso();

		$db = Generic::dataBase();
		$resultado = $db->query($sql);
		$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		if(!DB::isError($resultado)){			
			return $dados['ativo'];
		}
	}//activatedCourse
?>