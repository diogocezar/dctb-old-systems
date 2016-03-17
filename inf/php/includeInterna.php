<?php
/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'interna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

if($existeAjax){
	$template->setVariable("js_sajax", sajax_show_javascript());
	$template->setVariable("on_load", $onLoad);
}

/* Bloco Título */
$template->setCurrentBlock("blk_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("blk_titulo");

/* Destaque */
$template->setVariable("destaque", DESTAQUE);

/* Bloco Top */
$template->setCurrentBlock("blk_top");
	/* Menu */
	$i = 1;
	foreach($menu['principal'] as $menuPri => $cont){
		foreach($cont as $titulo => $link){
			$template->setVariable($menuPri, $titulo);
			$template->setVariable("linkMenu$i", $link);
			$i++;
		}
	}
			
$template->parseCurrentBlock("blk_top");

/* Bloco Titulo */
$template->setCurrentBlock("blk_tituloInterna");
	$template->setVariable("tituloInterna", $tituloInterna);
$template->parseCurrentBlock("blk_tituloInterna");


/* Bloco Conteúdo */
$template->setCurrentBlock("blk_conteudo");
	$template->setVariable("conteudo", $conteudo);
$template->parseCurrentBlock("blk_conteudo");

/* Bloco Menu Inferior */
$template->setCurrentBlock("blk_menu_inferior");
	/* Menu */
	$i = 1;
	foreach($menu['principal'] as $menuInf => $cont){
		foreach($cont as $titulo => $link){
			$template->setVariable($menuInf, $titulo);
			$template->setVariable("linkMenu$i", $link);
			$i++;
		}
	}
$template->parseCurrentBlock("blk_menu_inferior");

/* Bloco Map */
$template->setCurrentBlock("blk_maps");
	$template->setVariable("linkInf", LINK_INF);
	$template->setVariable("linkUtf", LINK_UTF);	
	$template->setVariable("linkKreea", LINK_KREEA);
$template->parseCurrentBlock("blk_maps");

$template->show();
?>