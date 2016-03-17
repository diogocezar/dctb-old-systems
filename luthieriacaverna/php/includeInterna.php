<?php
/* diretório dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'interna.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* conversão das variáveis dos blocos */

/* bloco do título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");


/* bloco menu */
$template->setCurrentBlock("bloco_menu");
	foreach($menu['principal'] as $menu => $cont){
		foreach($cont as $titulo => $link){
			$template->setVariable($menu, $titulo);
			$lnk = strtoupper($menu[0]).substr($menu, 1, strlen($menu));
			$template->setVariable("link".$lnk, $link);
		}
	}
$template->parseCurrentBlock("bloco_menu");

/* bloco conteudo */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("tituloInterna", $escopo);	
	$template->setVariable("paginaInicial", $caminho);
	$template->setVariable("paginaInterna", $escopo);
	$template->setVariable("linkPaginaInicial", "index.php");
	$template->setVariable("linkPaginaInterna", $pagina);
	$template->setVariable("conteudoInterno", $conteudo);
$template->parseCurrentBlock("bloco_conteudo");

$template->show();
?>