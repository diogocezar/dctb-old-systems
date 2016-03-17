<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Pikture */
include('../classes/Files.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivo de fun��es */
include('../lib/library.php');
include('../lib/util.php');

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Carregando a Galeria */

$id     = $_GET['id'];
$getOp  = $_GET['folder'];

if(empty($id)){
	if(empty($getOp)){
		echo "<script language=javascript>location.href='index.php';</script>";
		exit();
	}
	$diretorio = $getOp;
}
else{
	$diretorio = $materiais[$id];
	switch($id){  // CRIAR CONSTANTES NO CONFIG
		case 1:
		$titulo = 'DEPOG';
			break;
		case 2:
		$titulo = 'Instrumentaliza��o para o Ensino de Matem�tica';
			break;
		case 3:
		$titulo = 'Engenharia de Seguran�a do Trabalho';
			break;
		case 4:
		$titulo = 'Cultura, Tecnologia e Ensino de L�nguas';
			break;
		case 5:
		$titulo = 'Tecnologia Java';
			break;
		case 6:
		$titulo = 'Gest�o da Produ��o';
			break;
		case 7:
		$titulo = 'Automa��o e Controle de Processos Industriais';
			break;
		case 10:
		$titulo = 'Tecnologia Java';
			break;
		case 12:
		$titulo = 'Gerontologia';
			break;	
		case 13:
		$titulo = 'Auditoria e Gest�o Ambiental';
			break;	
		case 14:
		$titulo = 'Inform�tica na Educa��o';
			break;		
	}
}

$files = new Files($diretorio);
$show = $files->showFiles();

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[$id]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infroma��es ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da P�gina Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Materiais : <b>$titulo</b>");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conte�do da p�gina interna */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", $show);
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
	foreach($menu['interno'] as $menu => $cont){
		foreach($cont as $titulo => $link){
			$link = str_replace('#', "?id=$id", $link);
			$template->setVariable($menu, "<a href = \"$link\" class = \"link_claro\">$titulo</a>");
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do T�tulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>
<link href="../css/cssPikture.css" rel="stylesheet" type="text/css">
<script src="../jscripts/validaCampos.js"></script>