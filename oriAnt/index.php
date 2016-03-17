<?php
/**
* Arquivo de configuração
*/
include("./conf/config.php");

/**
* Framework PEAR
*/
include("./frameworks/Pear/PEAR.php");

/**
* Framework PEAR::HTML_Template_IT
*/
include("./frameworks/HTML_Template_IT/IT.php");

/**
* Configuração do skin a ser exibido
*/
$skin = "azul";

/**
* Configuração do indioma a ser exibido
*/
$language = $_GET['language'];

if(!empty($language)){
	$pageLang = $language.'.php';
	include('./lang/'.$pageLang);
	$pageLoad = "'./oriant/oriant.php?language=$language&skin=$skin'";
}
else{
	include('./lang/pt-br.php');
	$pageLoad = "'./oriant/oriant.php?skin=$skin'";
}

/* Diretório dos Templates */
$templateHtmlDir = './html';

/* Capturando Pedido */
$templateHtmlName = 'principal.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco Titulo */
	$template->setCurrentBlock("bloco_titulo");
		$template->setVariable("titulo", TITULO);
	$template->parseCurrentBlock("bloco_titulo");
	
/* Bloco Frameset */
	$template->setCurrentBlock("bloco_frameset");
		$template->setVariable("java_script", "refreshFrame('oriant', $pageLoad)");
		$template->setVariable("frameTop", "./html/blank.php?carregando=".$lang['cmp_carregando']."&skin=".$skin);
		$template->setVariable("frameCon", "./php/index.php");
	$template->parseCurrentBlock("bloco_frameset");

/* Bloco Html */
	$template->setCurrentBlock("bloco_html");
		$template->setVariable("msgNoFrames", $lang['sem_frames']);
	$template->parseCurrentBlock("bloco_html");
	
$template->show();
?>