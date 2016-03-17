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

/* Arquivo de controle da Session */
include('./controlaSession.php');

/* Extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_GET['id'];

switch($acao){
	case 'adicionar' :
		$administrador['action'] = "adiciona.php?tipo=administrador";
		$administrador['titulo'] = "Inserir administrador";
		break;
	
	case 'atualizar' :
		$administrador['action'] = "atualiza.php?tipo=administrador&id=$id";
		$administrador['titulo'] = "Atualizar administrador";
		$sql = "SELECT adm_nome, adm_email, adm_login, adm_senha
		FROM {$tabela['administradores']}
		WHERE adm_cod = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$administrador['nome']  = $dados['adm_nome'];
		$administrador['email'] = $dados['adm_email'];
		$administrador['login'] = $dados['adm_login'];
		$administrador['senha'] = $dados['adm_senha'];
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'formAdministradores.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_administradores");

	/* Botões */
		$template->setVariable("btnEnviar",  "Enviar");
		$template->setVariable("btnVoltar", "Voltar");

	/* Formulario */
		$template->setVariable("formAdministrador", "form_admin");
		$template->setVariable("actionAdministrador", $administrador['action']);
	
	/* Titulos */
		$template->setVariable("tituloAdministrador", $administrador['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoNome", "nome");
		$template->setVariable("campoEmail", "email");
		$template->setVariable("campoLogin", "loginCad");
		$template->setVariable("campoSenha", "senhaCad");
		$template->setVariable("campoConfi", "confi");
	
	/* Valores dos Campos */
		
		$template->setVariable("valorNome", $administrador['nome']);
		$template->setVariable("valorEmail", $administrador['email']);
		$template->setVariable("valorLogin", $administrador['login']);
		$template->setVariable("valorSenha", $administrador['senha']);
		$template->setVariable("valorConfi", $administrador['senha']);
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "kValAdministrador(document.form_admin.nome, document.form_admin.email, document.form_admin.loginCad, document.form_admin.senhaCad, document.form_admin.confi, document.form_admin)");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
$template->parseCurrentBlock("bloco_administradores");

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
	$template->setVariable("admin",  "Bem vindo <b>$nome</b>, seu IP &eacute; <b>$ip</b>");
	$template->setVariable("logoff", "<a href=\"logout.php\"><img src=\"../images/botLogoff.gif\" border = \"0\"></a>");
	$template->setVariable("data", getData());
	$template->setVariable("linkKompre", KOMPRE);
	$template->setVariable("altKompre", ALT_KOMPRE);
	$template->setVariable("linkCreditos", CREDITOS);
	$template->setVariable("altCreditos", ALT_CREDITOS);
	$template->setVariable("conteudo_administracao", $show);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>