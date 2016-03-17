<?php
/** 
* SpeceBrain
*
* Esta neurônio é responsavel por fazer a manipulação do banco de dados
* This neuron is responsible to make data base manipulation
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright © 2007-2009
* @access public
* @package neuron
*/

class DataBase{
	/**
	* Construtor
	* Constructor
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
	 	global $erro; // Global variable destined to report errors
		              // Variável global para reportar erros
		$resultado = Brain::$data_base->query($sql);
		echo $sql;
		if(DB::isError($resultado)){
			$this->erro($erro['QUERY_GERA_ERRO'].$resultado->getMessage());
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
		Brain::$data_base->disconect();
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
	 	global $erro; // Global variable destined to report errors
		              // Variável global para reportar erros
		
		if(empty($campos) || empty($tabela) || count($campos) != count($valores) || empty($tabela)){
			$this->erro($erro['INSERT_ERRO_CAM']);	
		}
		/* Se não for de N p N */
		if(!eregi('NPN_', $tabela)){
			$campos[0]  = '[campo_id]';
			$valores[0] = '[valor_id]';
		}
		else{
			$tabela = str_replace('NPN_', '', $tabela);	
		}
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
			if(gettype($valor) != 'string' || $valor == 'NULL' || $valor == 'NOW()'){	
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
	 	global $erro; // Global variable destined to report errors
		              // Variável global para reportar erros
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
	 	global $erro; // Global variable destined to report errors
		              // Variável global para reportar erros
			
		if(empty($tabela) || count($campos) != count($valores)){
			$this->erro($erro['DELETE_UPDA_CAM']);	
		}
		
		$limite = count($campos);
		$sql = "UPDATE $tabela SET ";
		$igual = " = ";
		$virgula = ", ";
		for($i=0; $i<$limite; $i++){
			if(gettype($valores[$i]) != 'string' || $valores[$i] == 'NULL'){
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
