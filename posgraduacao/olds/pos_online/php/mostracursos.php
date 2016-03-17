<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'detalhes.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$sql = "SELECT cur_cod, cur_nome, cur_resumo
FROM {$tabela['cursos']}
WHERE cur_cod <> 1 
ORDER BY cur_nome ASC";

$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$curso['cod']    = $dados['cur_cod'];
	$curso['nome']   = $dados['cur_nome'];
	$curso['resumo'] = $dados['cur_resumo'];
	
	$item     = "<span class=\"curso_{$curso['cod']}\">".$curso['nome']."</span>";
	$conteudo = $curso['resumo'];
	$conteudo .= "<br><br>";
	$conteudo .= "<div align=\"right\">";
	$conteudo .= "<b><a href=\"pagina.php?id={$curso['cod']}\" class=\"link_curso_{$curso['cod']}\">Página do Curso</a></b>";
	$conteudo .= " - ";
	$conteudo .= "<b><a href=\"mostracurso.php?id={$curso['cod']}\" class=\"link_curso_{$curso['cod']}\">Detalhes do Curso</a></b>";
	$conteudo .= "</div>";
	
	$template->setCurrentBlock("bloco_detalhes_item");
			$template->setVariable("item", $item);
			$template->setVariable("conteudo", $conteudo);
	$template->parseCurrentBlock("bloco_detalhes_item");
}
	
$template->setCurrentBlock("bloco_curso");
		$template->setVariable("detalhes", "Cursos atuais oferecidos pelo DEPOG");
		$template->setVariable("nomeBotaoVoltar", "btnVoltar");
		$template->setVariable("voltar", "« Voltar");
		$template->setVariable("onClickVoltar", "javascript:history.go(-1)");
$template->parseCurrentBlock("bloco_curso");

$curso  = "<br>";
$curso .= $template->get();

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[1]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da Página Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Cursos oferecidos pelo DEPOG");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conteúdo da página interna */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", $curso);
$template->parseCurrentBlock("bloco_conteudo");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Geral */
$template->setCurrentBlock("bloco_geral");
	/* Links Superiores */
	$template->setVariable("linkUtf", UTFPR);
	$template->setVariable("linkDepog", DEPOG);
	/* Menu */
	foreach($menu['principal'] as $menu => $cont){
		foreach($cont as $link => $titulo){
			$template->setVariable($menu, "<a href = \"$titulo\" class = \"link_claro\">$link</a>");
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>