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
		$admin['action'] = "adiciona.php?tipo=admin";
		$admin['titulo'] = "Inserir Administrador";
		break;
	
	case 'atualizar' :
		$admin['action'] = "atualiza.php?tipo=admin&id=$id";
		$admin['titulo'] = "Atualizar Administrador";
		$sql = "SELECT nomeAdministrador, loginAdministrador, senhaAdministrador
		FROM {$tabela['administradores']}
		WHERE idAdministrador = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$admin['nome'] = $dados['nomeAdministrador'];
		$admin['login'] = $dados['loginAdministrador'];
		$admin['senha'] = $dados['senhaAdministrador'];
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formAdministrador.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("bloco_admin");

	/* Formulario */
		$template->setVariable("formAdmin", "form_admin");
		$template->setVariable("actionAdmin", $admin['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $admin['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoNome", "adm_nome");
		$template->setVariable("campoLogin", "adm_login");
		$template->setVariable("campoSenha", "adm_senha");
		$template->setVariable("campoConfirma", "adm_confirma");
			
	/* Valores dos Campos */
		$template->setVariable("valorNome", $admin['nome']);
		$template->setVariable("valorLogin", $admin['login']);
		$template->setVariable("valorSenha", $admin['senha']);
		$template->setVariable("valorConfirma", $admin['senha']);
		
	/* Botão */
		$template->setVariable("btnVoltar", "voltar");
		$template->setVariable("labelVoltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "rValAdmin(document.form_admin.adm_nome, document.form_admin.adm_login, document.form_admin.adm_senha, document.form_admin.adm_confirma, document.form_admin)");
		
$template->parseCurrentBlock("bloco_admin");

$template->show();
?>