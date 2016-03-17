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
		$fabricante['action'] = "adiciona.php?tipo=fabricante";
		$fabricante['titulo'] = "Inserir fabricante";
		break;
	
	case 'atualizar' :
		$fabricante['action'] = "atualiza.php?tipo=fabricante&id=$id";
		$fabricante['titulo'] = "Atualizar fabricante";
		$sql = "SELECT fab_nome, fab_telefone, fab_website
		FROM {$tabela['fabricantes']}
		WHERE fab_cod = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$fabricante['nome']      = $dados['fab_nome'];
		$fabricante['telefone']  = $dados['fab_telefone'];
		$fabricante['website']   = $dados['fab_website'];
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'formFabricantes.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_fabricantes");

	/* Botões */
		$template->setVariable("btnEnviar",  "Enviar");
		$template->setVariable("btnVoltar", "Voltar");

	/* Formulario */
		$template->setVariable("formFabricante", "form_fabricante");
		$template->setVariable("actionFabricante", $fabricante['action']);
	
	/* Titulos */
		$template->setVariable("tituloFabricante", $fabricante['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoNome", "nome");
		$template->setVariable("campoTelefone", "telefone");
		$template->setVariable("campoWebSite", "website");
	
	/* Valores dos Campos */
		$template->setVariable("valorNome", $fabricante['nome']);
		$template->setVariable("valorTelefone", $fabricante['telefone']);
		$template->setVariable("valorWebSite", $fabricante['website']);
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "kValFabricante(document.form_fabricante.nome, document.form_fabricante)");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
$template->parseCurrentBlock("bloco_fabricantes");

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