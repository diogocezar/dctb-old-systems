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

$templateHtmlName = "equipe.html";

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

/* bloco equipe */
$template->setCurrentBlock("bloco_equipe");
	$informacoes = $controlador['informacoes'];
	$informacoes->__toFillGeneric();
	$informacoes->__get_db($id);	
	$equipe = $informacoes->getEquipe();
	
	$template->setVariable("campoEquipe", $equipe);	
	
	/* bloco equipe advogados */
	$equipe = $controlador['equipe'];
	$equipe->__toFillGeneric();
	$resultado = $equipe->rows(false, false, 1, 'ASC', false);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_equipe_advogados");
		$template->setVariable("campoNome", $dados[$equipe->campos[1]]);	
		$template->setVariable("campoEmail", $dados[$equipe->campos[2]]);
		$template->setVariable("linkEmail", "mailto:".$dados[$equipe->campos[2]]);
		$template->setVariable("campoApresentacao", $dados[$equipe->campos[3]]);
		$template->parseCurrentBlock("bloco_equipe_advogados");
	}		
$template->parseCurrentBlock("bloco_equipe");

$conteudo = $template->get();

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>