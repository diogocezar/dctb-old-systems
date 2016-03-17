<?php
/**
* arquivo de configuraзгo
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* biblioteca de funcoes
*/
include("../lib/library.php");


/* diretуrio dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'principal.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* conversгo das variбveis dos blocos */

/* bloco do tнtulo */
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

$informacoes = $controlador['informacoes'];
$informacoes->__toFillGeneric();
$informacoes->__get_db();

$arte      = $informacoes->getArte();
$historico = $informacoes->getHistorico();

$limiteBoxCima = 150;

/* bloco arte */
$template->setCurrentBlock("bloco_arte");
	$template->setVariable("arteLuthieria", limitaStr($arte, $limiteBoxCima));
	$template->setVariable("linkArte", "arte.php");	
$template->parseCurrentBlock("bloco_arte");

/* bloco empresa */
$template->setCurrentBlock("bloco_empresa");
	$template->setVariable("sobreEmpresa", limitaStr($historico, $limiteBoxCima));
	$template->setVariable("linkEmpresa", "empresa.php");	
$template->parseCurrentBlock("bloco_empresa");

/* bloco noticias */
$template->setCurrentBlock("bloco_noticias");

	$limiteBoxNoticiasTitulo = 50;
	$limiteBoxNoticiasResumo = 100;

	$noticia = $controlador['noticia'];
	$noticia->__toFillGeneric();
	$resultado = $noticia->lastNotices(2);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_noticias_interno");
			$link = "vejaNoticia.php?id=".$dados[$noticia->campos[0]];
			$template->setVariable("tituloNoticia",limitaStr($dados[$noticia->campos[1]], $limiteBoxNoticiasTitulo));
			$template->setVariable("resumoNoticia",limitaStr($dados[$noticia->campos[3]], $limiteBoxNoticiasResumo));
			$template->setVariable("linkNoticia", $link);
			$template->setVariable("dataNoticia", desconverteData($dados[$noticia->campos[4]]));
		$template->parseCurrentBlock("bloco_noticias_interno");
	}	
	$template->setVariable("todasNoticias", "noticias.php");	
$template->parseCurrentBlock("bloco_noticias");

/* bloco dicas */
$template->setCurrentBlock("bloco_dicas");

	$limiteBoxDicasTitulo = 50;
	$limiteBoxDicasResumo = 100;

	$dica = $controlador['dica'];
	$dica->__toFillGeneric();
	$resultado = $dica->lastTips(2);
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_dicas_interno");
			$template->setVariable("tituloDica",limitaStr($dados[$dica->campos[1]], $limiteBoxDicasTitulo));
			$template->setVariable("resumoDica",limitaStr($dados[$dica->campos[2]], $limiteBoxDicasResumo));
		$template->parseCurrentBlock("bloco_dicas_interno");
	}	
	$template->setVariable("todasDicas", "dicas.php");	
$template->parseCurrentBlock("bloco_dicas");

/* bloco depoimento */

$template->setCurrentBlock("bloco_depoimento");
	$depoimento = $controlador['depoimento'];
	$depoimento->__toFillGeneric();
	$resultado = $depoimento->retornaRand();
	$link = "mailto:".$depoimento->getEmail();
	$template->setVariable("depoimento", $depoimento->getDepoimento());
	$template->setVariable("autorDepoimento", $depoimento->getNome());
	$template->setVariable("linkAutorDepoimento", $link);
	$template->setVariable("linkDepoimentos", "depoimentos.php");			
$template->parseCurrentBlock("bloco_depoimento");


$template->show();
?>