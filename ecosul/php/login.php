<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Enviando para administrar.php caso o usuário já esteja logado */
if($_SESSION['permitidoSession'] == 'sim'){
	echo "<script language=javascript>location.href='administrar.php'</script>";
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'login.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

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