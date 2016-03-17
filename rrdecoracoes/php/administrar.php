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

$templateHtmlName = 'menuAdmin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco Admin */
$template->setCurrentBlock("bloco_admin");
	$template->setVariable("titulo", "Bem vindo <b>$nome</b>, seu IP &eacute; <b>$ip</b>");
$template->parseCurrentBlock("bloco_admin");

$template->show();
?>