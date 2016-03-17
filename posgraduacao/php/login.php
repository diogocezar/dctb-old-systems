<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

@$session = new Session();

$acao = $_GET['acao'];
if($acao == "logout"){
	$nome = $session->retornaSession('nome');
	$session->limpaSessions();
	$msgSair = "<div align=\"center\">";
	$msgSair .= "<br><br>";
	$msgSair .= "<img src=\"../icones/decrypted.jpg\"><br><br>";
	$msgSair .= "Obrigado <b>$nome</b>, você saio de nosso sistema com segurança.<br><br>";
	$msgSair .= "<input name=\"btnLogar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"Login »\" onclick=\"javascript:location.href='login.php'\"><br><br>";
	$msgSair .= "<input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"« Voltar\" onclick=\"javascript:location.href='index.php'\">";
	$msgSair .= "</div>";
	$saio = true;
}

if($_SESSION['permitido'] == 'sim'){
	echo "<script language=javascript>location.href='administrar.php'</script>";
	break;
}

$session->limpaSessions();

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'login.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);


/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_login");

	/* Formulario */
		$template->setVariable("form_login", "formLogin");
		$template->setVariable("action", "administrar.php");
	
	/* Titulo */
		$template->setVariable("administracao", "Administração do Site");
		
	/* Titulos dos Campos */	
		$template->setVariable("login", "Login");
		$template->setVariable("senha", "Senha");
		
	/* Nomes dos Campos */
		$template->setVariable("campoLogin", "login");
		$template->setVariable("campoSenha", "senha");
		
	/* Botão */
		$template->setVariable("nomeBotao", "btnEntrar");
		$template->setVariable("enviar", "Entrar");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "validaLogin(formLogin.login, formLogin.senha, formLogin)");

$template->parseCurrentBlock("bloco_login");

$formulario .= "<br>";
$formulario .= $template->get();

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[1]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da Página Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Login");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conteúdo da página interna */
$template->setCurrentBlock("bloco_conteudo");
	if($saio == true){
		$template->setVariable("conteudo", $msgSair);
	}
	else{
		$template->setVariable("conteudo", $formulario);
	}
$template->parseCurrentBlock("bloco_conteudo");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Geral */
$template->setCurrentBlock("bloco_geral");
	/* Links Superiores */
	$template->setVariable("linkUtf", UTFPR);
	$template->setVariable("linkDepog", DEPOG);
	/* Menu */
	foreach($menu['principal'] as $menu => $cont){
		foreach($cont as $link => $titulo){
			$template->setVariable($menu, "<a href = \"$titulo\" class = \"link_claro\">$link</a>");
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>