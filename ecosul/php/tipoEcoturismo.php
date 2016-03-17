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
		$page['action'] = "adiciona.php?tipo=tipoEcoturismo";
		$page['titulo'] = "Inserir Tipo de Ecoturismo";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=tipoEcoturismo&id=$id";
		$page['titulo'] = "Atualizar Tipo de Ecoturismo";
		$sql = "SELECT 	nomeTipoEcoturismo
		FROM {$tabela['tipoecoturismo']}
		WHERE idTipoEcoturismo = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['nome']        = $dados['nomeTipoEcoturismo'];
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formTipoEcoturismo.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_tipo_ecoturismo");

	/* Formulario */
		$template->setVariable("form_tipo_ecoturismo", "form_tipo_ecoturismo");
		$template->setVariable("action", $page['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $page['titulo']);
		$template->setVariable("nome", "Nome");
		
	/* Nomes dos Campos */
		$template->setVariable("campoTipoEcoturismo", "tec_nome");
			
	/* Valores dos Campos */
		$template->setVariable("valorTipoEcoturismo", $page['nome']);

	/* Botão */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "ecoValTipoEcoturismo(document.form_tipo_ecoturismo.tec_nome, document.form_tipo_ecoturismo)");
		
$template->parseCurrentBlock("blk_tipo_ecoturismo");

$conteudo = $template->get();

include("includeInterna.php");
?>