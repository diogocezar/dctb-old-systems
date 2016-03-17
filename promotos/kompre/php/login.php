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

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateAdmin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO_KOMPRE);
$template->parseCurrentBlock("bloco_titulo");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	$template->setVariable("onLoad", "setaFoco(document.form_login.login)");
	$template->setVariable("admin", "<b>Área de Administração</b><br><br><div align=\"justify\">Olá, esse é um sistema para gerenciamento de mostruário de produtos (showroom), para ter acesso à area restrita, entre com o seu login e senha.</div>");
	$template->setVariable("data", getData());
	$template->setVariable("linkKompre", KOMPRE);
	$template->setVariable("altKompre", ALT_KOMPRE);
	$template->setVariable("linkCreditos", CREDITOS);
	$template->setVariable("altCreditos", ALT_CREDITOS);
	$template->setVariable("conteudo_administracao", $show);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>