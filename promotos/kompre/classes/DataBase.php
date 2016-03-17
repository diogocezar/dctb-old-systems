<?php
/**
* A seguir são colocados os arquivos incluidos e suas respectivas descrições.
*/

/**
* Incluindo classe de conexão com o banco de dados.
*/
require_once("Connection.php");

	 /** 
	 * Esta classe é responsavel por fazer a manipulação do banco de dados.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright © 2005, Kakitus.com LTDA. 
	 * @access public
	 * @package Connection
	 */
	  
class DataBase{
      /** 
	  * Método que executa um query.
	  * @access public
	  * @param String $sql
	  * @return void
	  */  
	function Query($sql){ 
		global $erro; // Reconhecendo variavel global para os erros.
		global $dataBase; // Objeto que receberá a conexão.
		$resultado = $dataBase->query($sql);
		if(DB::isError($resultado)){
			$erroQuery = new Errors($erro['QUERY_GERA_ERRO'].$resultado->getMessage());
			exit();
		}
	}
	  /** 
	  * Método que fecha uma conexão com o banco de dados.
	  * @access public
	  * @return void
	  */  	
	function Close(){
		$dataBase->disconect();
	}
	
	  /** 
	  * Método que faz uma inserção no banco de dados.
	  * @access public
	  * @param String $tabela
	  * @param Array  $campos
	  * @param Array  $valores
	  * @return void
	  */  
	function Insert($tabela, $campos, $valores){
		global $erro; // Reconhecendo variavel global para os erros.
		
		if(empty($campos) || empty($tabela) || count($campos) != count($valores) || empty($tabela)){
			$erroIns = new Errors($erro['INSERT_ERRO_CAM']);	
		}
		
		foreach($campos  as $campo){
			$x++;
			$virgula = ",";
			if($x == count($campos)){
				$virgula="";
			}
			$fields .= $campo.$virgula;			
		}
		foreach($valores as $valor){
			$y++;
			$virgula = ",";
			if($y == count($valores)){
				$virgula="";
			}			
			$values .= "\"".$valor."\"".$virgula;
		}
		$sql = "INSERT INTO $tabela ($fields) VALUES ($values)";
		$this->Query($sql);					
	}// Insert
	
      /** 
	  * Método que faz uma exclusão no banco de dados.
	  * @access public
	  * @param String $tabela
	  * @param String $condicao
	  * @return void
	  */  
	function Delete($tabela, $condicao){
		global $erro; // Reconhecendo variavel global para os erros.
		if(empty($tabela) || empty($condicao)){
			$erroDel = new Errors($erro['DELETE_ERRO_CAM']);	
		}
		$sql = "DELETE FROM $tabela WHERE $condicao";
		$this->Query($sql);
	}// Deletar
	
	
	  /** 
	  * Método que faz uma atualização no banco de dados.
	  * Se a condição estiver vazia, todos registros serão alterados.
	  * @access public
	  * @param String $tabela
	  * @param String $condicao
	  * @param Array  $campos
	  * @param Array  $valores
	  * @return void
	  */  
	function Update($tabela, $condicao, $campos, $valores){
		global $erro; // Reconhecendo variavel global para os erros.
			
		if(empty($tabela) || count($campos) != count($valores)){
			$erroUpd = new Errors($erro['DELETE_UPDA_CAM']);	
		}
		
		$limite = count($campos);
		$sql = "UPDATE $tabela SET ";
		$igual = " = ";
		$virgula = ", ";
		for($i=0; $i<$limite; $i++){
			$sql.= $campos[$i].$igual."'".$valores[$i]."'";
			if($i<($limite-1)){
				$sql.= $virgula;
			}		
		}
		if(!empty($condicao)){
			$sql.= " WHERE $condicao";
		}
		$this->Query($sql);		
	}//Update
}//DataBase
?>