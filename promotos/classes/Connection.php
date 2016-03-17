<?php
/**
* A seguir são colocados os arquivos incluidos e suas respectivas descrições.
*/

/**
* Incluindo arquivo de configuração com as constantes definidas
*/
require_once("Config.php");

/**
* Incluindo classe de manipulação do banco de dados (PEAR).
*/
require_once("DB/DB.php");

/**
* Incluindo impressão de erros.
*/
require_once("Errors.php");

	 /** 
	 * Esta classe é responsavel por fazer a conexão com o banco de dados.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright © 2005, Kakirus.com LTDA. 
	 * @access public
	 * @package Connection
	 */
	 
class Connection{
	 /**
	  * Construtor
	  */
	   
	 /** 
	  * Método CONSTRUTOR que chama o "Conectar" da classe DataBase.
	  * As configurações do banco de dados estão no final desse arquivo.
	  * @access public
	  * @param integer $opBanco
	  * @param String  $banco
	  * @param String  $host
	  * @param String  $user
	  * @param String  $pass
	  * @param String  $path	  
	  * @return void
	  */  
	 function Connection($banco, $host, $user, $pass, $path){
	 	global $erro; // Reconhecendo variavel global para os erros.
		global $dataBase; // Objeto que receberá a conexão.
			if(!empty($banco) && !empty($host) && !empty($user) && !empty($pass)){
				($pass == '[empty]') ? $pass = '' : $pass = $pass;
				if(PATH == ''){
					$dns = BASE_TYPE.'://'.$user.':'.$pass.'@'.$host.'/'.$banco;
				}
				else{
					$dns = BASE_TYPE.'://'.$user.':'.$pass.'@'.$host.'/'.$path;
				}
				$dataBase = DB::connect($dns);
				if(DB::isError($dataBase)){
					$erroConnection = new Errors($dataBase->getMessage());		
				}
			}
			else{
				$erroConnection = new Errors($erro['PARMS_INSUFICIE']);	
			}
	 }
}

/* Fazendo a Conexão com o Banco [Variavel com o Objeto = $DataBase] */

$Connection = new Connection(BASE, HOST, USER, PASS, PATH);

?>
