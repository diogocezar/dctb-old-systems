<?php
/**
* arquivo de configuração
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

/* diretório dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = "links.html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	

/* bloco ultimos artigos */
$template->setCurrentBlock("bloco_ultimosArtigos");
	$artigo = $controlador['artigo'];
	$artigo->__toFillGeneric();
	$resultado = $artigo->lastArticles(3);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_ultimosArtigosInterno");
			$link = "vejaArtigo.php?id=".$dados[$artigo->campos[0]];
			$template->setVariable("tituloArtigo", limitaStr($dados[$artigo->campos[2]], STR_LIMITE_TITULO_ARTIGO_RESUMO));
			$template->setVariable("linkArtigo", $link);
		$template->parseCurrentBlock("bloco_ultimosArtigosInterno");
	}	
$template->parseCurrentBlock("bloco_ultimosArtigos");

/* bloco escritorio */
$template->setCurrentBlock("bloco_links");
	$informacoes = $controlador['informacoes'];
	$informacoes->__toFillGeneric();
	$informacoes->__get_db($id);	
	$links = $informacoes->getClientes();
	
	$template->setVariable("campoLinks", $links);	
	
	/* bloco lista links */
	$links = $controlador['link'];
	$links->__toFillGeneric();
	$resultado = $links->rows(false, false, 1, 'ASC', false);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_links_itens");
		$template->setVariable("campoTitulo", $dados[$links->campos[1]]);	
		$template->setVariable("campoLink", $dados[$links->campos[2]]);
		$template->setVariable("linkLink", $dados[$links->campos[2]]);
		$template->setVariable("campoDescricao", $dados[$links->campos[3]]);
		$template->parseCurrentBlock("bloco_links_itens");
	}		
$template->parseCurrentBlock("bloco_links");

$conteudo = $template->get();

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>