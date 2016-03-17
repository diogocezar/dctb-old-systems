<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Arquivo de controle da Session */
include('controlaSession.php');

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'admin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco Admin */
$template->setCurrentBlock("blk_admin");
	$template->setVariable("titulo", "Bem vindo <b>$sessNome</b>, seu IP &eacute; <b>$sessIp</b>");
$template->parseCurrentBlock("blk_admin");

$conteudo = $template->get();

include("includeInterna.php");
?>