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
/* Verificando se o id está vazio */

$id = anti_sql_injection($_GET['id']);
if(empty($id)){
	echo "<script language=javascript>alert('Selecione um evento para ver seus detalhes !');location.href='index.php'</script>";
	exit();
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'mostraEvento.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Selecionando professor */

$sql = "SELECT e.dataEv, e.horaEv, e.localEv, e.descricaoEv, a.nomeAd, a.emailAd 
        FROM {$tabela['eventos']} e, {$tabela['administradores']} a
		WHERE e.Administrador_idAdministrador = a.idAdministradores AND
		      e.idEventos = $id";
$resultado = $dataBase->query($sql);

if(!DB::isError($resultado)){
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);		
}

$template->setCurrentBlock("blk_mostra_evento");
	$template->setVariable("data", desconverteData($dados['dataEv']));
	$template->setVariable("hora", desconverteHora($dados['horaEv']));
	$template->setVariable("local", $dados['localEv']);
	$template->setVariable("descricao", $dados['descricaoEv']);	
	$template->setVariable("enviadoPor", $dados['nomeAd']);	
	$template->setVariable("linkEnviadoPor", "mailto:{$dados['emailAd']}");	
	$template->setVariable("voltar", "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:history.go(-1);\" />");	
$template->parseCurrentBlock("blk_mostra_evento");

$conteudo = $template->get();
$tituloInterna = "Eventos";

include("includeInterna.php");
?>