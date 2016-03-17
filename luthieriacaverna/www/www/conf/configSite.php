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
define(TITULO, 'Luthieria Rock Cp');

/**
* E M A I L   D O   A D M I N I S T R A D O R
*/
define(EMAIL, 'contato@luthieriarockcp.com.br');


/**
* L I N K S 
*/
define(HOME, 'http://www.luthieriarockcp.com.br');

/**
* A D M I N
*/
define(LOGIN_ADMIN, "admin");

define(SENHA_ADMIN, "admin");

/**
* M E N U S   D A S   P Б G I N A S 
*/

$menu['menu1'] = "index.php";
$menu['menu2'] = "escritorio.php";
$menu['menu3'] = "equipe.php";
$menu['menu4'] = "atuacao.php";
$menu['menu5'] = "artigos.php";
$menu['menu6'] = "clientes.php";
$menu['menu7'] = "links.php";
$menu['menu8'] = "vocabulario.php";
$menu['menu9'] = "contato.php";
						   
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

/**
* L I M I T E S   D A S   S T R I N G S
*/

define(STR_LIMITE_TITULO_ARTIGO_RESUMO, 50);

define(STR_LIMITE_TITULO_ARTIGO, 100);

define(STR_LIMITE_DESCRICAO_ARTIGO, 150);


define(STR_LIMITE_AREA_ATUACAO, 200);


define(STR_LIMITE_TITULO_LINK, 50);
						   
?>