<?php
/**
* Arquivo de configura��o
*/
include("../conf/config.php");

/**
* Biblioteca de fun��es
*/
include("../lib/library.php");

/**
* Indioma do sistema
*/
include("../lang/lang.php");

/**
* Cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* Controle de sess�o
*/
//include("./controlaSession.php");

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'login.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco Titulo */
	$template->setCurrentBlock("bloco_titulo");
		$template->setVariable("titulo", TITULO);		
	$template->parseCurrentBlock("bloco_titulo");
	
/* Bloco Form */
	$template->setCurrentBlock("bloco_html");
		$template->setVariable("formLogin", "form_login");
		$template->setVariable("actionLogin", "administrar.php");
		$template->setVariable("campoLogin", "cmpLogin");
		$template->setVariable("campoSenha", "cmpSenha");
		$template->setVariable("onClickEnviar", "validaLogin(form_login.cmpLogin, form_login.cmpSenha, form_login)");
	$template->parseCurrentBlock("bloco_html");
	
$template->show();
?>