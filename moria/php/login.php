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

$templateHtmlName = 'formLogin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco Login */
$template->setCurrentBlock("bloco_login");
	$template->setVariable("formLogin", "form_login");
	$template->setVariable("actionLogin", "administrar.php");
	$template->setVariable("btnEnviar", "enviar_form");
	$template->setVariable("campoLogin", "login");
	$template->setVariable("campoSenha", "senha");
	$template->setVariable("onClickEnviar", "kValLogin(document.form_login.login, document.form_login.senha, document.form_login)");
	$template->setVariable("onKpLogin", "pulaCampoNoEnter(document.form_login.senha)");
	$template->setVariable("onKpSenha", "enviaFormNoEnter(document.form_login)");
$template->parseCurrentBlock("bloco_login");

$show = $template->get();

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateAdmin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco do T�tulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO_KOMPRE);
$template->parseCurrentBlock("bloco_titulo");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	$template->setVariable("onLoad", "setaFoco(document.form_login.login)");
	$template->setVariable("admin", "<b>�rea de Administra��o</b><br><br><div align=\"justify\">Ol�, esse � um sistema para gerenciamento de mostru�rio de produtos (showroom), para ter acesso � area restrita, entre com o seu login e senha.</div>");
	$template->setVariable("data", getData());
	$template->setVariable("linkKompre", KOMPRE);
	$template->setVariable("altKompre", ALT_KOMPRE);
	$template->setVariable("linkCreditos", CREDITOS);
	$template->setVariable("altCreditos", ALT_CREDITOS);
	$template->setVariable("conteudo_administracao", $show);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>