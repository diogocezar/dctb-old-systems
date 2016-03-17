<?php
/** 
* SpeceBraid
*
* Esta classe é responsavel por fazer a manipulação do banco de dados.
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright © 2007
* @access public
* @package database
*/
	  
class DataBase{
	/**
	* Construtor
	* __construct_DataBase()
	*/
	public function __construct_DataBase(){}
	
	/** 
	* Método que executa um query.
	* @access public
	* @param String $sql
	* @return void
	*/
	function query($sql){ 
		global $erro; // Reconhecendo variavel global para os erros.
		global $dataBase; // Objeto que receberá a conexão.
		$resultado = $dataBase->query($sql); //Debug echo $sql.'<br>';
		
		/* Debug para armazenar SQLS em um arquivo de log */
			$file = "../log/sql.html";
			$when = date("d/m/Y-h:i:s");
			$info = $when.':'.$sql.'<br>';
			$fp = fopen($file, "a+");
			fputs($fp, $info, 1024);		
		if(DB::isError($resultado)){
            echo 'Houve um erro ao tentar executar essa operação, por favor reporte os dados abaixo:<br><br>';
            echo 'SQL: '.$sql.'<br><br>';
            echo $erro['QUERY_GERA_ERRO'].$resultado->getMessage();
            exit;
			//$this->erro($erro['QUERY_GERA_ERRO'].$resultado->getMessage());
		}
		else{
			return $resultado;
		}
	}//query
	
	/** 
	* Método que fecha uma conexão com o banco de dados.
	* @access public
	* @return void
	*/
	function close(){
		$dataBase->disconect();
	}//close
	
	/** 
	* Método que faz uma inserção no banco de dados.
	* @access public
	* @param String $tabela
	* @param Array  $campos
	* @param Array  $valores
	* @return void
	*/  
	function insert($tabela, $campos, $valores){
		global $erro; // Reconhecendo variavel global para os erros.
		
		if(empty($campos) || empty($tabela) || count($campos) != count($valores) || empty($tabela)){
			$this->erro($erro['INSERT_ERRO_CAM']);	
		}
		$campos[0]  = '[campo_id]';
		$valores[0] = '[valor_id]';
		foreach($campos  as $campo){
			$x++;
			$virgula = ",";
			if($x == count($campos)){
				$virgula="";
			}
			if($campo != '[campo_id]'){
				$fields .= $campo.$virgula;		
			}	
		}
		foreach($valores as $valor){
			$y++;
			$virgula = ",";
			if($y == count($valores)){
				$virgula="";
			}
			// para transformar '' em NULL
			if(empty($valor)){
				$valor = 'NULL';
			}
			if(is_numeric($valor) || $valor == 'NULL' || $valor == 'NOW()'){	
				if($valor != '[valor_id]'){
					$values .= $valor.$virgula;
				}
			}
			else{
				if($valor != '[valor_id]'){	
					$values .= "'".$valor."'".$virgula;
				}
			}
		}
		
		$fields = strtolower($fields);
		$sql = "INSERT INTO $tabela ($fields) VALUES ($values)";
		
		$this->query($sql);					
	}//insert
	
	/** 
	* Método que faz uma exclusão no banco de dados.
	* @access public
	* @param String $tabela
	* @param String $condicao
	* @return void
	*/
	function delete($tabela, $condicao){
		global $erro; // Reconhecendo variavel global para os erros.
		if(empty($tabela) || empty($condicao)){
			$this->erro($erro['DELETE_ERRO_CAM']);	
		}
		$sql = "DELETE FROM $tabela WHERE $condicao";
		$this->query($sql);
	}//delete
	
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
	function update($tabela, $condicao, $campos, $valores){
		global $erro; // Reconhecendo variavel global para os erros.
			
		if(empty($tabela) || count($campos) != count($valores)){
			$this->erro($erro['DELETE_UPDA_CAM']);	
		}
		
		$limite = count($campos);
		$sql = "UPDATE $tabela SET ";
		$igual = " = ";
		$virgula = ", ";
		for($i=0; $i<$limite; $i++){
			if(is_numeric($valores[$i]) or $valores[$i] == 'NULL'){
				$sql.= strtolower($campos[$i]).$igual.$valores[$i];
			}
			else{
				$sql.= strtolower($campos[$i]).$igual."'".$valores[$i]."'";
			}
			if($i<($limite-1)){
				$sql.= $virgula;
			}		
		}
		if(!empty($condicao)){
			$sql.= " WHERE $condicao";
		}
		$this->query($sql);		
	}//update
}//DataBase
?>
