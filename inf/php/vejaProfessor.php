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

/* Incluindo ajax */
include('../classes/sAjax/Sajax.php');
include('../ajax/ajax.php');

/* Verificando se o id está vazio */
$id = anti_sql_injection($_GET['id']);
if(empty($id)){
	echo "<script language=javascript>alert('Selecione um professor para ver seus detalhes !');location.href='index.php'</script>";
	exit();
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'mostraProfessor.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Selecionando professor */

$sql = "SELECT nomePro, nickPro, fotoPro, sitePro, descricaoPro, emailPro
        FROM {$tabela['professores']}
		WHERE idProfessores = $id";
$resultado = $dataBase->query($sql);

if(!DB::isError($resultado)){
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);		
}

$template->setCurrentBlock("blk_mostra_professor");
	$template->setVariable("nome", $dados['nomePro']);
	$template->setVariable("nick", $dados['nickPro']);
	if(!empty($dados['fotoPro'])){
		$template->setCurrentBlock("blk_mostra_professor_img");
			$alt = $altura['pro'];
			$lar = $largura['pro'];
			$sca = $scalar['pro'];
			$template->setVariable("img", "<img src=\"img.php?loc={$dados['fotoPro']}&a=$alt&l=$lar&s=$sca\" border=\"0\">");	
		$template->parseCurrentBlock("blk_mostra_professor_img");	
	}
	$template->setVariable("email", $dados['emailPro']);
	$template->setVariable("linkEmail", "mailto:".$dados['emailPro']);	
	$template->setVariable("site", replaceLink($dados['sitePro']));	
	$template->setVariable("linkSite", replaceLink($dados['sitePro']));
	$template->setVariable("descricao", $dados['descricaoPro']);	
	$template->setVariable("voltar", "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:history.go(-1);\" />");	
$template->parseCurrentBlock("blk_mostra_professor");

$conteudo = $template->get();
$tituloInterna = "Professores";
$existeAjax = false;

include("includeInterna.php");
?>