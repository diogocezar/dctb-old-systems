<?php
/**
* arquivo de configuraзгo
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/* diretуrio dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'frmLogin.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$template->setCurrentBlock("bloco_formulario");
	$form = "form_login";
	$template->setVariable("formLogin", $form);
	$template->setVariable("actionLogin", "index.php");
	$template->setVariable("campoLogin", "login");
	$template->setVariable("campoSenha", "senha");
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();
$titulo   = 'Bem vindo ao SIDAP, informe seu login e senha:';

/* iniciando sessгo */
$session = $controlador['session'];
$session->startSession();

/* foco no campo inicial */
	$onLoad .= "onLoad = \"";
	$onLoad .= "document.$form.login.focus();";
	$onLoad .= "\"";

include('includeInterna.php');
?>