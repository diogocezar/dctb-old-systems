<?php
/**
* A seguir sуo colocados os arquivos incluidos e suas respectivas descriчѕes.
*/

/**
* Incluindo arquivo de configuraчуo com as constantes definidas
*/
require_once("Configuracao.php");

/**
* Incluindo classe de manipulaчуo do banco de dados (PEAR).
*/
require_once("DB/DB.php");

/**
* Incluindo impressуo de erros.
*/
require_once("Errors.php");

	 /** 
	 * Esta classe щ responsavel por fazer a conexуo com o banco de dados.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright Љ 2005, Kakirus.com LTDA. 
	 * @access public
	 * @package Connection
	 */
	 
$link = mysql_connect(HOST, USER, PASS) or die(mysql_error());
$db   = mysql_select_db(BASE, $link) or die(mysql_error());
?>