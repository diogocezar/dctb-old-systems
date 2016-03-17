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
		$page['action'] = "adiciona.php?tipo=evento";
		$page['titulo'] = "Inserir Evento";
		break;
	
	case 'atualizar' :
		$page['action'] = "atualiza.php?tipo=evento&id=$id";
		$page['titulo'] = "Atualizar Evento";
		$sql = "SELECT 	dataEv, horaEv, localEv, descricaoEv
		FROM {$tabela['eventos']}
		WHERE idEventos = $id";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$page['data']      = desconverteData($dados['dataEv']);
		$page['hora']      = desconverteHora($dados['horaEv']);
		$page['local']     = $dados['localEv'];
		$page['descricao'] = desconverteQuebra($dados['descricaoEv']);
		break;
}

/* Diretѓrio dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formEvento.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("blk_form_evento");

	/* Formulario */
		$template->setVariable("form_evento", "form_evento");
		$template->setVariable("action", $page['action']);
	
	/* Titulos */
		$template->setVariable("titulo", $page['titulo']);
		$template->setVariable("data", "Data");
		$template->setVariable("hora", "Hora");
		$template->setVariable("local", "Local");
		$template->setVariable("descricao", "Descriчуo");
		
	/* Nomes dos Campos */
		$template->setVariable("campoData", "eve_data");
		$template->setVariable("campoHora", "eve_hora");
		$template->setVariable("campoLocal", "eve_local");
		$template->setVariable("campoDescricao", "eve_descricao");
			
	/* Valores dos Campos */
		$template->setVariable("valorData", $page['data']);
		$template->setVariable("valorHora", $page['hora']);
		$template->setVariable("valorLocal", $page['local']);
		$template->setVariable("valorDescricao", $page['descricao']);

	/* Botуo */
		$template->setVariable("nomeBotao", "enviar");
		$template->setVariable("enviar", $page['titulo']);	
		$template->setVariable("nomeBotaoVoltar", "voltar");
		$template->setVariable("voltar", "  Ћ Voltar   ");
		
	/* Java Script ao Voltar */
		//$template->setVariable("onClickVoltar", "javascript:history.go(-1);");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "infValEvento(document.form_evento.eve_data, document.form_evento.eve_hora, document.form_evento.eve_local,  document.form_evento.eve_descricao, document.form_evento)");
		
$template->parseCurrentBlock("blk_form_evento");

$conteudo = $template->get();
$tituloInterna = "Сrea Restrita";

include("includeInterna.php");
?>