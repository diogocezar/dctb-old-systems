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
		$categoria['action'] = "adiciona.php?tipo=categoria";
		$categoria['titulo'] = "Inserir categoria";
		break;
	
	case 'atualizar' :
		$categoria['action'] = "atualiza.php?tipo=categoria&id=$id";
		$categoria['titulo'] = "Atualizar categoria";
		$sql = "SELECT cat_nome, cat_descricao
		FROM {$tabela['categorias']}
		WHERE cat_cod = $id";	
		$resultado = $dataBase->query($sql);
		if(!DB::isError($resultado)){	
			$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
			$categoria['nome']      = $dados['cat_nome'];
			$categoria['descricao'] = $dados['cat_descricao'];
		}
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'formCategorias.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_categorias");

	/* Botões */
		$template->setVariable("btnEnviar",  "Enviar");
		$template->setVariable("btnVoltar", "Voltar");

	/* Formulario */
		$template->setVariable("formCategoria", "form_categoria");
		$template->setVariable("actionCategoria", $categoria['action']);
	
	/* Titulos */
		$template->setVariable("tituloCategoria", $categoria['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoNome", "nome");
		$template->setVariable("campoDescricao", "descricao");
	
	/* Valores dos Campos */
		$template->setVariable("valorNome", $categoria['nome']);
		$template->setVariable("valorDescricao", $categoria['descricao']);
		
	/* BB Code */
		$template->setVariable("onClickNegrito",    "wrapSelection(form_categoria.descricao,'[b]','[/b]')");
		$template->setVariable("onClickItalico",    "wrapSelection(form_categoria.descricao,'[i]','[/i]')");
		$template->setVariable("onClickSublinhado", "wrapSelection(form_categoria.descricao,'[u]','[/u]')");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "kValCategoria(document.form_categoria.nome, document.form_categoria.descricao, document.form_categoria)");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
$template->parseCurrentBlock("bloco_categorias");

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