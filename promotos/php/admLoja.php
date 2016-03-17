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
		$loja['action'] = "adiciona.php?tipo=loja";
		$loja['titulo'] = "Inserir loja";
		break;
	
	case 'atualizar' :
		$loja['action'] = "atualiza.php?tipo=loja&id=$id";
		$loja['titulo'] = "Atualizar loja";
		$sql = "SELECT loj_titulo, loj_endereco, loj_telefone, loj_email, loj_contatos, loj_descricao, loj_foto_url
		FROM {$tabela['lojas']}
		WHERE loj_cod = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$loja['camTitulo']    = $dados['loj_titulo'];
		$loja['endereco']  = desconverteQuebra($dados['loj_endereco']);
		$loja['telefone']  = desconverteQuebra($dados['loj_telefone']);
		$loja['email']     = $dados['loj_email'];
		$loja['contatos']  = desconverteQuebra($dados['loj_contatos']);
		$loja['descricao'] = desconverteQuebra($dados['loj_descricao']);
		$loja['url']       = $dados['loj_foto_url'];
		break;
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'formLojas.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

$template->setCurrentBlock("bloco_lojas");

	/* Botões */
		$template->setVariable("btnEnviar",  "Enviar");
		$template->setVariable("btnVoltar", "Voltar");

	/* Formulario */
		$template->setVariable("formLoja", "form_loja");
		$template->setVariable("actionLoja", $loja['action']);
	
	/* Titulos */
		$template->setVariable("tituloLojas", $loja['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoTitulo", "titulo");
		$template->setVariable("campoEndereco", "endereco");
		$template->setVariable("campoTelefone", "telefone");
		$template->setVariable("campoEmail", "email");
		$template->setVariable("campoContatos", "contatos");
		$template->setVariable("campoDescricao", "descricao");
		$template->setVariable("campoArquivo", "arquivo");
	
	/* Valores dos Campos */
		$template->setVariable("valorTitulo", $loja['camTitulo']);
		$template->setVariable("valorEndereco", $loja['endereco']);
		$template->setVariable("valorTelefone", $loja['telefone']);
		$template->setVariable("valorEmail", $loja['email']);
		$template->setVariable("valorContatos", $loja['contatos']);
		$template->setVariable("valorDescricao", $loja['descricao']);
		$template->setVariable("arquivoAnexo", $loja['url']);
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "pValLoja('$acao', document.form_loja.titulo, document.form_loja.endereco, document.form_loja.telefone, document.form_loja.descricao, document.form_loja.arquivo, document.form_loja.email, document.form_loja)");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
$template->parseCurrentBlock("bloco_lojas");

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