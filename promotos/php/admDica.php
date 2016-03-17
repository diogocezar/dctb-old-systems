<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Arquivo de controle da Session */
include('./controlaSession.php');

/* Extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_GET['id'];

switch($acao){
	case 'adicionar' :
		$dica['action'] = "adiciona.php?tipo=dica";
		$dica['titulo'] = "Inserir dica";
		break;
	
	case 'atualizar' :
		$dica['action'] = "atualiza.php?tipo=dica&id=$id";
		$dica['titulo'] = "Atualizar dica";
		$sql = "SELECT dic_titulo, dic_descricao
		FROM {$tabela['dicas']}
		WHERE dic_cod = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$dica['camTitulo'] = $dados['dic_titulo'];
		$dica['descricao'] = desconverteQuebra($dados['dic_descricao']);
		break;
}

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'formDicas.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

$template->setCurrentBlock("bloco_dicas");

	/* Bot�es */
		$template->setVariable("btnEnviar",  "Enviar");
		$template->setVariable("btnVoltar", "Voltar");

	/* Formulario */
		$template->setVariable("formDica", "form_dica");
		$template->setVariable("actionDica", $dica['action']);
	
	/* Titulos */
		$template->setVariable("tituloDicas", $dica['titulo']);

	/* Nomes dos Campos */
		$template->setVariable("campoTitulo", "titulo");
		$template->setVariable("campoDescricao", "descricao");
	
	/* Valores dos Campos */
		$template->setVariable("valorTitulo", $dica['camTitulo']);
		$template->setVariable("valorDescricao", $dica['descricao']);
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "pValDica(document.form_dica.titulo, document.form_dica.descricao, document.form_dica)");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
$template->parseCurrentBlock("bloco_dicas");

$show = $template->get();

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco T�tulo */
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