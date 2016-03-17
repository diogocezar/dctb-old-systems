<?php
/**
* Verificando a opзгo para cadastro direto do cliente
*/
$opCliente = $_GET['tcliente'];

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

if(!empty($opCliente)){
	$templateHtmlDir = '../html/cliente';
}

$templateHtmlName = 'frmLogin.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$template->setCurrentBlock("bloco_formulario");
	$form = "form_login";
	$template->setVariable("formLogin", $form);
	$action = "index.php";
	if(!empty($opCliente)){
		$action .= "?tcliente=sim";
	}
	$template->setVariable("actionLogin", $action);
	$template->setVariable("campoLogin", "login");
	$template->setVariable("campoSenha", "senha");
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();
$titulo   = 'Bem vindo ao SITRANS, informe seu login e senha:';

/* iniciando sessгo */
$session = $controlador['session'];
$session->startSession();

/* foco no campo inicial */
	$onLoad .= "onLoad = \"";
	$onLoad .= "document.$form.login.focus();";
	$onLoad .= "\"";

if(!empty($opCliente)){
	/* incluindo conteudo na pбgina interna especнfica para cliente*/
	$interface = "login";
	include("../php/includeInternaCliente.php");	
}
else{
	/* incluindo conteudo na pбgina interna */
	include("../php/includeInterna.php");	
}
?>