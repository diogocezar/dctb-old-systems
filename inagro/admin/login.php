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
	$template->setVariable("campoLogin", "loginCS");
	$template->setVariable("campoSenha", "senhaCS");
	$template->setVariable("onClickEnviar", "login($form.loginCS, $form.senhaCS, $form)");
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();
$titulo   = 'Bem vindo ao Painel Inagro';

/* iniciando sessгo */
$session = $controlador['session'];
$session->startSession();

/* foco no campo inicial */
	$onLoad .= "onLoad = \"";
	$onLoad .= "setaFoco(document.$form.loginCS);";
	$onLoad .= "\"";

include('includeInterna.php');
?>