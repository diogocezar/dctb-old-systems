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

$templateHtmlName = "contato.html";

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

/* bloco contato */
$template->setCurrentBlock("bloco_contato");

	$informacoes = $controlador['informacoes'];
	$informacoes->__toFillGeneric();
	$informacoes->__get_db($id);	
	$contato = $informacoes->getContato();
	
	$template->setVariable("campoContato", $contato);	
$template->parseCurrentBlock("bloco_contato");

/* bloco form */
$template->setCurrentBlock("bloco_form");

	/* formulario */
		$template->setVariable("formContato", "form_contato");
		$template->setVariable("actionContato", "enviaContato.php");
	
	/* nomes dos campos */
		$template->setVariable("campoNome",       "nome");
		$template->setVariable("campoEmail",      "email");
		$template->setVariable("campoAssunto",    "assunto");
		$template->setVariable("campoMensagem",   "mensagem");
	
	/* javascript ao enviar */
		$template->setVariable("onClickEnviar", "serValContato(form_contato.nome, form_contato.email, form_contato.assunto, form_contato.mensagem, form_contato)");
		
$template->parseCurrentBlock("bloco_form");

$conteudo = $template->get();

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>