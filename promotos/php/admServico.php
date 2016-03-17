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
		$servico['action'] = "adiciona.php?tipo=servico";
		$servico['titulo'] = "Inserir servico";
		break;
	
	case 'atualizar' :
		$servico['action'] = "atualiza.php?tipo=servico&id=$id";
		$servico['titulo'] = "Atualizar servico";
		$sql = "SELECT ser_titulo, ser_descricao
		FROM {$tabela['servicos']}
		WHERE ser_cod = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$servico['camTitulo'] = $dados['ser_titulo'];
		$servico['descricao'] = desconverteQuebra($dados['ser_descricao']);
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'formServicos.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_servicos");

	/* Botões */
		$template->setVariable("btnEnviar",  "Enviar");
		$template->setVariable("btnVoltar", "Voltar");

	/* Formulario */
		$template->setVariable("formServico", "form_servico");
		$template->setVariable("actionServico", $servico['action']);
	
	/* Titulos */
		$template->setVariable("tituloServicos", $servico['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoTitulo", "titulo");
		$template->setVariable("campoDescricao", "descricao");
	
	/* Valores dos Campos */
		$template->setVariable("valorTitulo", $servico['camTitulo']);
		$template->setVariable("valorDescricao", $servico['descricao']);
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "pValServico(document.form_servico.titulo, document.form_servico.descricao, document.form_servico)");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
$template->parseCurrentBlock("bloco_servicos");

$show = $template->get();

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");


/* Bloco Menu */
$template->setCurrentBlock("bloco_menu");
	$i = 0;
	foreach($menu as $replace => $link){
		$template->setVariable($replace, $link);
	}
$template->parseCurrentBlock("bloco_menu");

/* Bloco Interno */
$template->setCurrentBlock("bloco_interno");
	$template->setVariable("conteudoInterno", $show);
$template->parseCurrentBlock("bloco_interno");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	$template->setVariable("linkKreea", CREDITOS);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>