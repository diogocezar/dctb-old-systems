<?php
/**
* Arquivo de configuraзгo da pбgina.
*
* Definindo constantes de configuraзгo
*/

/**#@+
* Constantes
*/

/**
* T Н T U L O
*/
define(TITULO, 'Luthieria Caverna');

/**
* E M A I L   D O   A D M I N I S T R A D O R
*/
define(EMAIL, 'contato@luthieriacaverna.com.br');


/**
* L I N K S 
*/
define(HOME, 'http://www.luthieriacaverna.com.br');

/**
* A D M I N
*/
define(LOGIN_ADMIN, "admin");

define(SENHA_ADMIN, "admin");

/**
* M E N U S   D A S   P Б G I N A S 
*/

$menu['principal']['menu1'] = array("Inicial"            => "index.php");
$menu['principal']['menu2'] = array("Sobre a Empresa"    => "empresa.php");
$menu['principal']['menu3'] = array("Arte da Luthieria"  => "arte.php");
$menu['principal']['menu4'] = array("Serviзos"           => "servicos.php");
$menu['principal']['menu5'] = array("Dicas"              => "dicas.php");
$menu['principal']['menu6'] = array("Noticias"           => "noticias.php");
$menu['principal']['menu7'] = array("Links"              => "links.php");
$menu['principal']['menu8'] = array("Depoimentos"        => "depoimentos.php");
$menu['principal']['menu9'] = array("Contato"            => "contato.php");
						   
/**
* D I R E T У R I O S
*/

$diretorio['log'] = "../log/log.txt";

$diretorio['trb'] = "../trabalhos";

/**
* C O N F I G U R A З Х E S   D O  G E R E N C I A M E N T O 
*/

define(QTD_PAGINAS_SHOW, 10);

define(LIMITE_GENRENCIAR, 65);

define(PP_GERENCIAR, 10);

?>