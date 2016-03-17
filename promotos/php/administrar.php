<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Arquivo de controle da Session */
include('controlaSession.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'admin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

foreach($menuAdm as $indice => $valor){
	foreach($menuAdm[$indice] as $subitem => $link){
		$template->setCurrentBlock("bloco_menu_item");
			if($link[strlen($link)-1] == "!"){
				$link[strlen($link)-1] = "";
				$template->setVariable("opItem", "target=\"_blank\"");
			}
			$template->setVariable("linkSubItem", $link);
			$template->setVariable("subitem", $subitem);
		$template->parseCurrentBlock("bloco_menu_item");
	}
	$template->setCurrentBlock("bloco_menu");
		$template->setVariable("item", $indice);
	$template->parseCurrentBlock("bloco_menu");
}

/* Bloco Admin */
$template->setCurrentBlock("bloco_admin");
	$template->setVariable("titulo", "Bem vindo <b>$nome</b>, seu IP &eacute; <b>$ip</b>");
$template->parseCurrentBlock("bloco_admin");


$show = $template->get();

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");


/* Bloco Menu */
$template->setCurrentBlock("bloco_menu");
	$i = 0;
	foreach($menu as $replace => $link){
		$template->setVariable($replace, $link);
	}
$template->parseCurrentBlock("bloco_menu");

/* Bloco Interno */
$template->setCurrentBlock("bloco_interno");
	$template->setVariable("conteudoInterno", $show);
$template->parseCurrentBlock("bloco_interno");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	$template->setVariable("linkKreea", CREDITOS);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>