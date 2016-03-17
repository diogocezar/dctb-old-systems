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
		$cliente['action'] = "adiciona.php?tipo=cliente";
		$cliente['titulo'] = "Inserir Cliente";
		break;
	
	case 'atualizar' :
		$cliente['action'] = "atualiza.php?tipo=cliente&id=$id";
		$cliente['titulo'] = "Atualizar Cliente";
		$sql = "SELECT nomeCliente, urlCliente
		FROM {$tabela['clientes']}
		WHERE idCliente = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$cliente['nome'] = $dados['nomeCliente'];
		$cliente['link'] = $dados['urlCliente'];
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formCliente.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("bloco_cliente");

	/* Formulario */
		$template->setVariable("formLink", "form_cliente");
		$template->setVariable("actionLink", $cliente['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $cliente['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoNomeCliente", "nome_cliente");
		$template->setVariable("campoLink", "link");
	
	/* Valores dos Campos */
		$template->setVariable("valorNomeCliente", $cliente['nome']);
		$template->setVariable("valorLink", $cliente['link']);
		
	/* Botão */
		$template->setVariable("btnVoltar", "voltar");
		$template->setVariable("labelVoltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "rValCliente(document.form_cliente.nome_cliente, document.form_cliente.link, document.form_cliente)");
		
$template->parseCurrentBlock("bloco_cliente");

$template->show();
?>