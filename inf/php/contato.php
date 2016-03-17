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

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'inInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$contato .= "Coordenação: <br> Alessandro Silveira Duarte <br> <a href=\"mailto:coinf-cp@utfpr.edu.br\" class=\"linkPaginacao\"><b>coinf-cp@utfpr.edu.br</b></a><br><br>";


$contato .= "Desenvolvimento: <br> Diogo Cezar Teixeira Batista <br> <a href=\"mailto:xgordo@gmail.com\" class=\"linkPaginacao\"><b>xgordo@gmail.com</b></a><br><br>";

$contato .= "Design: <br> Carlos Ferraz <br> <a href=\"mailto:carlosferraz@onda.com.br\" class=\"linkPaginacao\"><b>carlosferraz@onda.com.br</b></a>";

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_in_interna");
		$template->setVariable("conteudo", $contato);
$template->parseCurrentBlock("blk_in_interna");

$conteudo = $template->get();
$tituloInterna = "Contato";

include("includeInterna.php");
?>