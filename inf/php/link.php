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
$acao  = anti_sql_injection($_GET['acao']);
$id    = anti_sql_injection($_GET['id']);

switch($acao){
	case 'adicionar' :
		$page['action'] = "adiciona.php?tipo=link";
		$page['titulo'] = "Inserir Link";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=link&id=$id";
		$page['titulo'] = "Atualizar Link";
		$sql = "SELECT nomeLi, urlLi, descricaoLi
		FROM {$tabela['links']}
		WHERE idLinks = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['nome']       = $dados['nomeLi'];
		$page['url']        = $dados['urlLi'];
		$page['descricao']  = desconverteQuebra($dados['descricaoLi']);
		break;
}

/* Diretѓrio dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formLink.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_form_link");

	/* Formulario */
		$template->setVariable("form_link", "form_link");
		$template->setVariable("action", $page['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $page['titulo']);
		$template->setVariable("nome", "Nome");
		$template->setVariable("url", "Url");
		$template->setVariable("descricao", "Descriчуo");
		
	/* Nomes dos Campos */
		$template->setVariable("campoNome", "lnk_nome");
		$template->setVariable("campoUrl", "lnk_url");
		$template->setVariable("campoDescricao", "lnk_descricao");
			
	/* Valores dos Campos */
		$template->setVariable("valorNome", $page['nome']);
		$template->setVariable("valorUrl", $page['url']);
		$template->setVariable("valorDescricao", $page['url']);

	/* Botуo */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  Ћ Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "infValLink(document.form_link.lnk_nome, document.form_link.lnk_url, document.form_link.lnk_descricao, document.form_link)");
		
$template->parseCurrentBlock("blk_form_link");

$conteudo = $template->get();
$tituloInterna = "Сrea Restrita";

include("includeInterna.php");
?>