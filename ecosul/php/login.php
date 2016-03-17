<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Enviando para administrar.php caso o usu�rio j� esteja logado */
if($_SESSION['permitidoSession'] == 'sim'){
	echo "<script language=javascript>location.href='administrar.php'</script>";
}

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'login.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco Promotos */
$template->setCurrentBlock("blk_login");	
	$template->setVariable("form_login", "form_login");
	$template->setVariable("action", "administrar.php");
	$template->setVariable("campoLogin", "login");
	$template->setVariable("campoSenha", "senha");
	$template->setVariable("login", "Login");
	$template->setVariable("senha", "Senha");
	$template->setVariable("enviar", "Enviar");
	$template->setVariable("onClickEnviar", "ecoValLogin(document.form_login.login, document.form_login.senha, document.form_login)");
	$template->setVariable("onKpLogin", "pulaCampoNoEnter(document.form_login.senha)");
	$template->setVariable("onKpSenha", "enviaFormNoEnter(document.form_login)");
$template->parseCurrentBlock("blk_login");

$conteudo = $template->get();

include("includeInterna.php");
?>