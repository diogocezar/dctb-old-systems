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

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'sobre.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Lista de disciplinas */

$sql = "SELECT idDisciplinas, nomeDi FROM {$tabela['disciplinas']} ORDER BY nomeDi ASC";
$resultado = $dataBase->query($sql);

if(!DB::isError($resultado)){
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){			
		$disciplinas .= "<img src=\"../images/setaPreta.gif\" width=\"3\" height=\"5\" align=\"absmiddle\"/>&nbsp;<a href=\"vejaDisciplina.php?id={$dados['idDisciplinas']}\" class=\"linkPaginacao\"><b>{$dados['nomeDi']}</b></a><br>";
	}
}

$sql = "SELECT idProfessores, nomePro FROM {$tabela['professores']} ORDER BY nomePro ASC";
$resultado = $dataBase->query($sql);

if(!DB::isError($resultado)){
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){			
		$professores .= "<img src=\"../images/setaPreta.gif\" width=\"3\" height=\"5\" align=\"absmiddle\"/>&nbsp;<a href=\"vejaProfessor.php?id={$dados['idProfessores']}\" class=\"linkPaginacao\"><b>{$dados['nomePro']}</b></a><br>";
	}
}

/* Bloco Sobre */
$template->setCurrentBlock("blk_sobre");
	$template->setVariable("disciplinas", $disciplinas);
	$template->setVariable("professores", $professores);
	$template->setVariable("titulo", "Mais sobre o curso");
	$template->setVariable("voltar", "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:history.go(-1);\" />");	
$template->parseCurrentBlock("blk_sobre");

$conteudo = $template->get();
$tituloInterna = "Mais sobre o curso";

include("includeInterna.php");
?>