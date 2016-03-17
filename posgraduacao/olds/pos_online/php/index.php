<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivo de fun��es */
include('../lib/library.php');
include('../lib/util.php');

/* Apagando session do curso navegado */
$_SESSION['curso'] = "";

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateIndex.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);


/* Convers�o das vari�veis dos blocos */

/* Bloco das Not�cias [interno] */
$sql = "SELECT not_cod, not_titulo, not_conteudo FROM {$tabela['noticias']} WHERE cur_cod = 1 ORDER BY not_cod DESC LIMIT 3";
$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$template->setCurrentBlock("bloco_noticias_interno");
		$titulo = "<a href = \"mostranoticia.php?id={$dados['not_cod']}\" class=\"link_escuro\">".limitaStr($dados['not_titulo'], 40)."</a>";
		$template->setVariable("tituloNoticia", $titulo);
		$template->setVariable("conteudoNoticia", limpaQuebra(limitaStr(strtolower($dados['not_conteudo']), 150)));
	$template->parseCurrentBlock("bloco_noticias_interno");
}	

/* Bloco das Not�cias [geral] */
$template->setCurrentBlock("bloco_noticias");
	$template->setVariable("vejaMais", "<a href = \"mostratodas.php\" class=\"link_escuro\">Veja Mais</a>");
	$template->setVariable("vejaGaleria", "<a href = \"galeria.php?id=1\" class=\"link_escuro\">Galeria de Fotos</a>");
$template->parseCurrentBlock("bloco_noticias");

/* Bloco da Descri��o Central */
$template->setCurrentBlock("bloco_descricao");
	$template->setVariable("descricao", BANNER);
	$template->setVariable("vejaMais", "<a href = \"sobre.php\" class=\"link_escuro\">Veja Mais</a>");
$template->parseCurrentBlock("bloco_descricao");

/* Bloco do T�tulo Central */
$template->setCurrentBlock("bloco_titulo_central");
	$template->setVariable("titulo", "Ultimas Not�cias");
$template->parseCurrentBlock("bloco_titulo_central");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infroma��es ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[1]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco dos Cursos */
$template->setCurrentBlock("bloco_cursos");
	$template->setVariable("cursos", "<iframe name=\"cursus\" height=\"253\" width=\"188\" src=\"listaCursos.php?id=$id\" frameborder=\"0\" scrolling=\"auto\"></iframe>");
$template->parseCurrentBlock("bloco_cursos");

/* Bloco Geral */
$template->setCurrentBlock("bloco_geral");
	/* Links Superiores */
	$template->setVariable("linkUtf", UTFPR);
	$template->setVariable("linkDepog", DEPOG);
	/* Menu */
	foreach($menu['principal'] as $menu => $cont){
		foreach($cont as $titulo => $link){
			$template->setVariable($menu, "<a href = \"$link\" class = \"link_claro\">$titulo</a>");
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do T�tulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>