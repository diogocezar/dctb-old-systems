<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/IniFile.php');

/* Pikture */
include('../classes/Pikture.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Carregando a Galeria */

$id = $_GET['id'];
$getOp  = $_GET['folder'];
$getPag = $_GET['page'];

if(empty($id)){
	if(empty($getOp)){
		echo "<script language=javascript>location.href='index.php';</script>";
		exit();
	}
}
else{
	$diretorioFotos = $galeria[$id];
	switch($id){ // CRIAR CONSTANTES NO CONFIG
		case 1:
		$titulo = 'DEPOG';
			break;
		case 2:
		$titulo = 'Instrumentalização para o Ensino de Matemática';
			break;
		case 3:
		$titulo = 'Engenharia de Segurança do Trabalho';
			break;
		case 4:
		$titulo = 'Cultura, Tecnologia e Ensino de Línguas';
			break;
		case 5:
		$titulo = 'Tecnologia Java';
			break;
		case 6:
		$titulo = 'Gestão da Produção';
			break;
		case 7:
		$titulo = 'Automação e Controle de Processos Industriais';
			break;
		case 10:
		$titulo = 'Tecnologia Java';
			break;
		case 12:
		$titulo = 'Gerontologia';
			break;	
		case 13:
		$titulo = 'Auditoria e Gestão Ambiental';
			break;	
		case 14:
		$titulo = 'Informática na Educação';
			break;	
	}
}

if(empty($getPag)){
	$getPag = 0;
}

$ini = new IniFile("../config/gerais.ini");
$gerais = $ini->getIni(false);

$diretorio     = $diretorioFotos;
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
	$show .= $pikture->setStyle('fonteGalerias');
	$show .= $pikture->printVoltar($iconeVoltar, "pagina.php?id=$id");
	$show .= $pikture->setStyle('fecha');
}
else{
	$pikture = new Pikture($diretorio, $fotosPP, $colunas);
	$show .= $pikture->showPhotos($getOp, $getPag, $scalar, $imprimeNome, $imprimeTam);
	$pikture->countDir();
	$show .= $pikture->setStyle('fonteGalerias');
	$show .= $pikture->printPaging($getPag, $paginaAtual, $iconePrimeiro, $iconeAnterior, $iconeProximo, $iconeUltimo); 
	$show .= $pikture->printVoltar($iconeVoltar, $paginaAtual."?id=$id");
	$show .= $pikture->setStyle('fecha');
}

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[$id]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da Página Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Galeria de Fotos : <b>$titulo</b>");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conteúdo da página interna */
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

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>
<link href="../css/cssPikture.css" rel="stylesheet" type="text/css">
<script src="../jscripts/validaCampos.js"></script>