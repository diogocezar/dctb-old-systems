<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuraчуo da pсgina */
include('./configSite.php');

/* Incluindo arquivos de funчѕes */
include('../lib/util.php');
include('../lib/library.php');

/* Arquivo de controle da Session */
include('./controlaSession.php');

/* Extraindo variaveis do navegador */
$acao  = anti_sql_injection($_GET['acao']);
$id    = anti_sql_injection($_GET['id']);

switch($acao){
	case 'adicionar' :
		$page['action'] = "adiciona.php?tipo=admin";
		$page['titulo'] = "Inserir Administrador";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=admin&id=$id";
		$page['titulo'] = "Atualizar Administrador";
		$sql = "SELECT nomeAd, loginAd, senhaAd, emailAd
		FROM {$tabela['administradores']}
		WHERE idAdministradores = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['nome']  = $dados['nomeAd'];
		$page['login'] = $dados['loginAd'];
		$page['senha'] = $dados['senhaAd'];
		$page['email'] = $dados['emailAd'];
		break;
}

/* Diretѓrio dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formAdministrador.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_form_administrador");

	/* Formulario */
		$template->setVariable("form_administrador", "form_administrador");
		$template->setVariable("action", $page['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $page['titulo']);
		$template->setVariable("nome", "Nome");
		$template->setVariable("login", "Login");
		$template->setVariable("senha", "Senha");
		$template->setVariable("email", "Email");

	/* Nomes dos Campos */
		$template->setVariable("campoNome", "adm_nome");
		$template->setVariable("campoLogin", "adm_login");
		$template->setVariable("campoSenha", "adm_senha");
		$template->setVariable("campoEmail", "adm_email");
			
	/* Valores dos Campos */
		$template->setVariable("valorNome", $page['nome']);
		$template->setVariable("valorLogin", $page['login']);
		$template->setVariable("valorSenha", $page['senha']);
		$template->setVariable("valorEmail", $page['email']);
		
	/* Botуo */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  Ћ Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "infValAdmin(document.form_administrador.adm_nome, document.form_administrador.adm_login, document.form_administrador.adm_senha, document.form_administrador.adm_email, document.form_administrador)");
		
$template->parseCurrentBlock("blk_form_administrador");

$conteudo = $template->get();
$tituloInterna = "Сrea Restrita";

include("includeInterna.php");
?>