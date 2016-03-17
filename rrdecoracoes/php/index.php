<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Recuperando a página a ser aberta */
$pagina = $_GET['page'];

if(empty($pagina)){
	$pagina = $paginas['principal'];
}
else{
	$pagina = $paginas[$pagina];
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'moldura.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Título */
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