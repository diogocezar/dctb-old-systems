<?php
/**
* arquivo de configuraзгo
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* incluindo controle de sessгo
*/
$nivelRequerido = "admin";
include("../php/controlaSession.php");

$contexto      = "informacoes";
$contextoArray = array();
$nome          = $nomeTab[$contexto];

$objRec = $controlador[$contexto];
$objRec->__toFillGeneric();

$contextoArray['action'] = "registra.php?tipo=$contexto&acao=atualizar&id=-1";
$contextoArray['titulo'] = "Atualizar ".ucfirst($nome);

/* recuperando dados */
$objRec->__get_db($id);

/* diretуrio dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = "frm".ucfirst($contexto).".html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	
	
$template->setCurrentBlock("bloco_formulario");
		
	/* formulario */
		$form = "form_".$contexto;
		$template->setVariable("form".ucfirst($contexto), $form);
		$template->setVariable("action".ucfirst($contexto), $contextoArray['action']);
	
	/* titulos */
		$template->setVariable("titulo".ucfirst($contexto), $contextoArray['titulo']);

	/* nomes dos campos */
		$template->setVariable("campoHistorico",  "historico");
		$template->setVariable("campoEquipe",     "equipe");
		$template->setVariable("campoServicos",   "servicos");
		$template->setVariable("campoLinks",      "links");
		$template->setVariable("campoDicas",      "dicas");
		$template->setVariable("campoTrabalhos",  "trabalhos");
	
	/* valores dos campos */
		$template->setVariable("valorHistorico", $objRec->getHistorico());
		$template->setVariable("valorEquipe",    $objRec->getEquipe());
		$template->setVariable("valorServicos",  $objRec->getServicos());
		$template->setVariable("valorLinks",     $objRec->getLinks());
		$template->setVariable("valorDicas",     $objRec->getDicas());
		$template->setVariable("valorTrabalhos", $objRec->getTrabalhos());
	
	/* java script ao enviar */
		$form = "form_".$contexto;
		$template->setVariable("onClickEnviar", "enviaForm($form)");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

/* incluindo conteudo na pбgina interna */
include("../php/includeInterna.php");	
?>