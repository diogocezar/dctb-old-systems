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
	echo "<script language=javascript>alert('Selecione uma disciplina para ver seus detalhes !');location.href='index.php'</script>";
	exit();
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'mostraDisciplina.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Selecionando disciplina */

$sql = "SELECT nomeDi, periodoDi, cargaHorariaDi, objetivosDi, ementasDi
        FROM {$tabela['disciplinas']}
		WHERE idDisciplinas = $id";
$resultado = $dataBase->query($sql);

if(!DB::isError($resultado)){
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);		
}

$template->setCurrentBlock("blk_mostra_disciplina");
	$template->setVariable("nomeDisciplina", $dados['nomeDi']);
	$template->setVariable("periodo", $dados['periodoDi']);
	$template->setVariable("carga", $dados['cargaHorariaDi']);
	$template->setVariable("objetivos", $dados['objetivosDi']);	
	$template->setVariable("ementas", $dados['ementasDi']);	
	$template->setVariable("voltar", "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:history.go(-1);\" />");	
$template->parseCurrentBlock("blk_mostra_disciplina");

$conteudo = $template->get();
$tituloInterna = "Disciplinas";

include("includeInterna.php");
?>