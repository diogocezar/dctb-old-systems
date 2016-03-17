<?php
/**
* A seguir s�o colocados os arquivos incluidos e suas respectivas descri��es.
*/

/**
* Incluindo arquivo de configura��o com as constantes definidas
*/
require_once("Config.php");

/**
* Incluindo classe de manipula��o do banco de dados.
*/
require_once("DataBaseMy.php");

/**
* Incluindo impress�o de erros.
*/
require_once("Errors.php");

	 /** 
	 * Esta classe � responsavel por fazer a conex�o com o banco de dados.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright � 2005, Kakirus.com LTDA. 
	 * @access public
	 * @package Connection
	 */

class Connection{
	 /**
	  * Construtor
	  */
	   
	 /** 
	  * M�todo CONSTRUTOR que chama o "Conectar" da classe DataBase.
	  * As configura��es do banco de dados est�o no final desse arquivo.
	  * @access public
	  * @param integer $opBanco
	  * @param String  $banco
	  * @param String  $host
	  * @param String  $user
	  * @param String  $pass
	  * @param String  $path	  
	  * @return void
	  */  
	 function Connection($opBanco, $banco, $host, $user, $pass, $path){
	 	global $erro; // Reconhecendo variavel global para os erros.
		global $dataBase; // Objeto que receber� a conex�o.
	 	if(!empty($opBanco)){
			switch($opBanco){
				case 'mysql':
					if(!empty($banco) && !empty($host) && !empty($user) && !empty($pass)){
						if($pass == "[empty]"){ $pass = ""; }
						$dataBase = new DataBase($opBanco, $banco, $host, $user, $pass);
					}
					else{
						$erroConnection = new Errors($erro['PARMS_INSUFICIE']);	
					}
				break;
				case 'pgsql':
					if(!empty($banco) && !empty($host) && !empty($user) && !empty($pass)){
						if($pass == "[empty]"){ $pass = ""; }
						$dataBase = new DataBase($opBanco, $banco, $host, $user, $pass);
					}
					else{
						$erroConnection = new Errors($erro['PARMS_INSUFICIE']);	
					}
				break;
				case 'fbsql':
					if(!empty($banco) && !empty($host) && !empty($user) && !empty($pass) && !empty($path)){
						if($pass == "[empty]"){ $pass = ""; }
						$dataBase = new DataBase($opBanco, $banco, $host, $user, $pass, $path);
					}
					else{
						$erroConnection = new Errors($erro['PARMS_INSUFICIE']);	
					}
				break;
			}
		}
		else{
			$erroConnection = new Errors($erro['NENHUM_BANCO_SE']);	
		}	 	
	 }//Construtor
}//Connection

/* Fazendo a Conex�o com o Banco [Variavel com o Objeto = $DataBase] */

$Connection = new Connection(BASE_TYPE, BASE, HOST, USER, PASS);

?>