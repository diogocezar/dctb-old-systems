<?php
/**
* arquivo de configura��o
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* biblioteca de funcoes
*/
include("../lib/library.php");
include("../lib/util.php");

/* defini��es para p�gina interna */
$pagina = getPaginaAtual();
$escopo = "Detalhes da not�cia";
$caminho = "P�gina Inicial";

/* resgatando qual processo */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>alert('Uma identifica��o � necess�ria para consultar os detalhes de uma not�cia.');location.href='noticias.php'</script>";
	exit();
}

/* diret�rio dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = "vejaNoticia.html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	

/* bloco noticia */
$template->setCurrentBlock("bloco_noticia_detalhes");
	$noticia = $controlador['noticia'];
	$noticia->__toFillGeneric();
	$noticia->__get_db($id);
	$template->setVariable("titulo", $noticia->getTitulo());
	$template->setVariable("data", desconverteData($noticia->getData()));	
	$template->setVariable("autor", $noticia->getAutor());
	$template->setVariable("descricao", $noticia->getDescricao());

	$template->setVariable("linkVoltar", "javascript:history.go(-1);");	
$template->parseCurrentBlock("bloco_noticia_detalhes");

$conteudo = $template->get();

/* incluindo conteudo na p�gina interna */
include("../php/includeInterna.php");	
?>