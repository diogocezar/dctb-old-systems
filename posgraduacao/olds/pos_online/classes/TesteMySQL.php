<?php
/**
* A seguir s�o colocados os arquivos incluidos e suas respectivas descri��es.
*/

/**
* Incluindo arquivo de configura��o com as constantes definidas
*/
require_once("Configuracao.php");

/**
* Incluindo classe de manipula��o do banco de dados (PEAR).
*/
require_once("DB/DB.php");

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
	 
$link = mysql_connect(HOST, USER, PASS) or die(mysql_error());
$db   = mysql_select_db(BASE, $link) or die(mysql_error());
?>