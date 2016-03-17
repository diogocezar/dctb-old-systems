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

/* Extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_GET['id'];

switch($acao){
	case 'adicionar' :
		$visitante['action'] = "adiciona.php?tipo=visitante";
		$visitante['titulo'] = "Inserir Visitante";
		break;
	
	case 'atualizar' :
		/* Arquivo de controle da Session */
		include('./controlaSession.php');
		
		$visitante['action'] = "atualiza.php?tipo=visitante&id=$id";
		$visitante['titulo'] = "Atualizar Visitante";
		$sql = "SELECT nomeVisitante, cidadeVisitante, emailVisitante
		FROM {$tabela['visitantes']}
		WHERE idVisitante = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$visitante['nome'] = $dados['nomeVisitante'];
		$visitante['cidade'] = $dados['cidadeVisitante'];
		$visitante['email'] = $dados['emailVisitante'];
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';	

$templateHtmlName = 'cadastro.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("bloco_cadastro");

	/* Formulario */
		$template->setVariable("formCadastro", "form_cadastro");
		$template->setVariable("actionCadastro", $visitante['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $visitante['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoNome", "nome");
		$template->setVariable("campoCidade", "cidade");
		$template->setVariable("campoEmail", "email");
	
	/* Valores dos Campos */
		$template->setVariable("valorNome", $visitante['nome']);
		$template->setVariable("valorCidade", $visitante['cidade']);
		$template->setVariable("valorEmail", $visitante['email']);
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "rValVisitante(document.form_cadastro.nome, document.form_cadastro.cidade, document.form_cadastro.email, document.form_cadastro)");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
$template->parseCurrentBlock("bloco_cadastro");

$template->show();
?>