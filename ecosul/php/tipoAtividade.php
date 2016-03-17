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
		$page['action'] = "adiciona.php?tipo=tipoAtividade";
		$page['titulo'] = "Inserir Tipo de Atividade";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=tipoAtividade&id=$id";
		$page['titulo'] = "Atualizar Tipo de Atividade";
		$sql = "SELECT 	nomeTipoAtividade
		FROM {$tabela['tipoatividade']}
		WHERE idTipoAtividade = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['nome']        = $dados['nomeTipoAtividade'];
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formTipoAtividade.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_tipo_atividade");

	/* Formulario */
		$template->setVariable("form_tipo_atividade", "form_tipo_atividade");
		$template->setVariable("action", $page['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $page['titulo']);
		$template->setVariable("nome", "Nome");
		
	/* Nomes dos Campos */
		$template->setVariable("campoTipoAtividade", "tat_nome");
			
	/* Valores dos Campos */
		$template->setVariable("valorTipoAtividade", $page['nome']);

	/* Botão */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "ecoValTipoAtividade(document.form_tipo_atividade.tat_nome, document.form_tipo_atividade)");
		
$template->parseCurrentBlock("blk_tipo_atividade");

$conteudo = $template->get();

include("includeInterna.php");
?>