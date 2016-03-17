<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');

/* Pikture */
include('../classes/Pikture.php');


/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

$getOp  = $_GET['folder'];
$getPag = $_GET['page'];

if(empty($getPag)){
	$getPag = 0;
}

$ini = new IniFile("../pikture/config/gerais.ini");
$gerais = $ini->getIni(false);

$diretorio     = $gerais['diretorio'];
$colunas       = $gerais['colunas'];
$fotosPP       = $gerais['fotosPorPagina'];
$iconePastinha = $gerais['iconePastinha'];
$iconePrimeiro = $gerais['iconePrimeiro'];
$iconeProximo  = $gerais['iconeProximo'];
$iconeAnterior = $gerais['iconeAnterior'];
$iconeUltimo   = $gerais['iconeUltimo'];
$iconeVoltar   = $gerais['iconeVoltar'];
$scalar        = $gerais['fotoEscalar'];
$imprimeNome   = $gerais['imprimirNome'];
$imprimeTam    = $gerais['imprimirTamanho'];
$colunasCapa   = $gerais['colunasCapa'];

$paginaAtual   = getPaginaAtual();	

if(empty($getOp)){
	$pikture = new Pikture($diretorio, $fotosPP, $colunas);
	$show .= $pikture->setStyle('fonteGalerias');
	$show .= $pikture->printFolders($paginaAtual, 'folder', $iconePastinha, $colunasCapa);
	$show .= $pikture->setStyle('fecha');
	$pikture->countDir();
	$show .= "<br>";
	$show .= "<div align=\"center\">";
	$show .= $pikture->setStyle('fonteFotos');
	$show .= $pikture->printStats();
	$show .= $pikture->setStyle('fecha');
	$show .= "</div>";
}
else{
	$pikture = new Pikture($diretorio, $fotosPP, $colunas);
	$show .= $pikture->showPhotos($getOp, $getPag, $scalar, $imprimeNome, $imprimeTam);
	$pikture->countDir();
	$show .= $pikture->setStyle('fonteGalerias');
	$show .= $pikture->printPaging($getPag, $paginaAtual, $iconePrimeiro, $iconeAnterior, $iconeProximo, $iconeUltimo); 
	$show .= $pikture->printVoltar($iconeVoltar, $paginaAtual);
	$show .= $pikture->setStyle('fecha');
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'galeria.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Texto */
$template->setCurrentBlock("bloco_galeria");
	$template->setVariable("conteudo", $show);
$template->parseCurrentBlock("bloco_galeria");

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