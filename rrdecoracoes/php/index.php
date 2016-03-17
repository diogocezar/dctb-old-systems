<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Recuperando a p�gina a ser aberta */
$pagina = $_GET['page'];

if(empty($pagina)){
	$pagina = $paginas['principal'];
}
else{
	$pagina = $paginas[$pagina];
}

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'moldura.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco T�tulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

/* Bloco iFrame */
$template->setCurrentBlock("bloco_iframe");
	$template->setVariable("conteudo", $pagina);
	$template->setVariable("nome_conteudo", $nPaginas);
$template->parseCurrentBlock("bloco_iframe");


$template->show();
?>