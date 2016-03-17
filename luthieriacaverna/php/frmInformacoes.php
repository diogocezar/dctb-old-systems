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
* incluindo controle de sess�o
*/
include("../php/controlaSession.php");

/* defini��es para p�gina interna */
$pagina = getPaginaAtual();
$escopo = "Adminsitra��o";
$caminho = "P�gina Inicial";

$contexto      = "informacoes";
$contextoArray = array();
$nome          = $nomeTab[$contexto];

$objRec = $controlador[$contexto];
$objRec->__toFillGeneric();

$contextoArray['action'] = "registra.php?tipo=$contexto&acao=atualizar&id=-1";
$contextoArray['titulo'] = "Atualizar ".ucfirst($nome);

/* recuperando dados */
$objRec->__get_db();

/* diret�rio dos templates */
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
		$template->setVariable("campoArte",       "arte");
	
	/* valores dos campos */
		$template->setVariable("valorHistorico", desconverteQuebra($objRec->getHistorico()));
		$template->setVariable("valorArte",      desconverteQuebra($objRec->getArte()));
	
	/* java script ao enviar */
		$form = "form_".$contexto;
		$template->setVariable("onClickEnviar", "enviaForm($form)");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

/* incluindo conteudo na p�gina interna */
include("../php/includeInterna.php");	
?>