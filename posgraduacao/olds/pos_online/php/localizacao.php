<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivo de fun��es */
include('../lib/library.php');
include('../lib/util.php');

/* Extraindo id do curso atual */
$idCurso = sessionNum($_SESSION['curso']);

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	if(empty($idCurso)){
		$template->setVariable('contatos', $contato[1]);
	}
	else{
		$template->setVariable('contatos', $contato[$idCurso]);
	}
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infroma��es ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da P�gina Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Localiza��o da institui��o");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conte�do da p�gina interna */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", LOCALIZACAO);
$template->parseCurrentBlock("bloco_conteudo");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Geral */
$template->setCurrentBlock("bloco_geral");
	/* Links Superiores */
	$template->setVariable("linkUtf", UTFPR);
	$template->setVariable("linkDepog", DEPOG);
	/* Menu */
	if(empty($idCurso)){
		foreach($menu['principal'] as $menu => $cont){
			foreach($cont as $link => $titulo){
				$template->setVariable($menu, "<a href = \"$titulo\" class = \"link_claro\">$link</a>");
			}
		}
	}
	else{
		foreach($menu['interno'] as $menu => $cont){
			foreach($cont as $titulo => $link){
				$link = str_replace('#', "?id=$idCurso", $link);
				$template->setVariable($menu, "<a href = \"$link\" class = \"link_claro\">$titulo</a>");
			}
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do T�tulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>