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
$acao  = $_GET['acao'];
$id    = $_GET['id'];

switch($acao){
	case 'adicionar' :
		$servico['action'] = "adiciona.php?tipo=servico";
		$servico['titulo'] = "Inserir serviчo";
		break;
	
	case 'atualizar' :
		$servico['action'] = "atualiza.php?tipo=servico&id=$id";
		$servico['titulo'] = "Atualizar serviчo";
		$sql = "SELECT nomeServico, descricaoServico
		FROM {$tabela['servicos']}
		WHERE idServico = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$servico['nome'] = $dados['nomeServico'];
		$servico['descricao'] = desconverteQuebra($dados['descricaoServico']);
		break;
}

/* Diretѓrio dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formServico.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("bloco_servico");

	/* Formulario */
		$template->setVariable("formServico", "form_servico");
		$template->setVariable("actionServico", $servico['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $servico['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoNome", "nome");
		$template->setVariable("campoDescricao", "descricao");
	
	/* Valores dos Campos */
		$template->setVariable("valorNome", $servico['nome']);
		$template->setVariable("valorDescricao", $servico['descricao']);
		
	/* Botуo */
		$template->setVariable("btnVoltar", "voltar");
		$template->setVariable("labelVoltar", "  Ћ Voltar   ");
		
	/* Java Script ao Voltar */
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "rValServico(document.form_servico.nome, document.form_servico.descricao, document.form_servico)");
		
$template->parseCurrentBlock("bloco_servico");

$template->show();
?>