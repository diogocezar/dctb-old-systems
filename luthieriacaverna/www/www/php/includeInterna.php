<?php
/* diretório dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'interna.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* conversão das variáveis dos blocos */

/* bloco do título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

/* bloco login */
$template->setCurrentBlock("bloco_login");
	$template->setVariable("actionLogin", "login.php");
	$template->setVariable("formLogin", "form_login");
	$template->setVariable("login", "login");
	$template->setVariable("senha", "senha");
	$template->setVariable("onKpLogin", "pulaCampoNoEnter(senha)");
	$template->setVariable("onKpSenha", "enviaLoginOnEnter(form_login.login, form_login.senha, form_login)");
	$template->setVariable("onClickLogin", "serValLogin(form_login.login, form_login.senha, form_login)");
$template->parseCurrentBlock("bloco_login");


/* bloco menu */
$template->setCurrentBlock("bloco_menu");
	foreach($menu as $link){
		$template->setVariable($menu, $link);
	}
$template->parseCurrentBlock("bloco_menu");	

/* bloco conteudo */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", $conteudo);
$template->setCurrentBlock("bloco_conteudo");

/* bloco kreea */
$template->setCurrentBlock("bloco_kreea");	
	$template->setVariable("linkKreea", "http://www.kreea.com.br");
$template->parseCurrentBlock("bloco_kreea");

/* bloco principal */
$template->setCurrentBlock("bloco_principal");
	$onLoad .= 	"setaFoco(document.form_login.login);";
	$template->setVariable("onLoad", $onLoad);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>