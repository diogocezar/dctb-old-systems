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
		$newsletter['action'] = "adiciona.php?tipo=newsletter";
		$newsletter['titulo'] = "Inserir Newsletter";
		break;
	
	case 'atualizar' :
		$newsletter['action'] = "atualiza.php?tipo=newsletter&id=$id";
		$newsletter['titulo'] = "Atualizar Newsletter";
		$sql = "SELECT tituloNovidade, descricaoNovidade
		FROM {$tabela['novidades']}
		WHERE idNovidade = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$newsletter['cmpTitulo'] = $dados['tituloNovidade'];
		$newsletter['descricao'] = $dados['descricaoNovidade'];
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formNewsletter.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("bloco_newsletter");

	/* Formulario */
		$template->setVariable("formNewsletter", "form_newsletter");
		$template->setVariable("actionNewsletter", $newsletter['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $newsletter['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoTitulo", "titulo");
		$template->setVariable("campoDescricao", "descricao");
		$template->setVariable("checkEnviar", "enviar");
		$template->setVariable("valorEnviar", "sim");	
		
	/* Valores dos Campos */
		$template->setVariable("valorTitulo", $newsletter['cmpTitulo']);
		$template->setVariable("valorDescricao", $newsletter['descricao']);
		
	/* Botão */
		$template->setVariable("btnVoltar", "voltar");
		$template->setVariable("labelVoltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "rValNews(document.form_newsletter.titulo, document.form_newsletter)");
		
$template->parseCurrentBlock("bloco_newsletter");

$template->show();
?>