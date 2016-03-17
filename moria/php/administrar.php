<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Arquivo de controle da Session */
include('./controlaSession.php');

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'menuAdmin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco Produtos */
foreach($menuAdmin['Produtos'] as $menu => $link){
	$template->setCurrentBlock("bloco_produtos_menu");
		$template->setVariable("linkPro", $link);
		$template->setVariable("menuPro", $menu);
	$template->parseCurrentBlock("bloco_produtos_menu");
}

/* Bloco Categorias */
foreach($menuAdmin['Categorias'] as $menu => $link){
	$template->setCurrentBlock("bloco_categorias_menu");
		$template->setVariable("linkCat", $link);
		$template->setVariable("menuCat", $menu);
	$template->parseCurrentBlock("bloco_categorias_menu");
}

/* Bloco Fabricantes */
foreach($menuAdmin['Fabricantes'] as $menu => $link){
	$template->setCurrentBlock("bloco_fabricantes_menu");
		$template->setVariable("linkFab", $link);
		$template->setVariable("menuFab", $menu);
	$template->parseCurrentBlock("bloco_fabricantes_menu");
}

/* Bloco Configura��es */
foreach($menuAdmin['Configura��es'] as $menu => $link){
	$template->setCurrentBlock("bloco_configuracoes_menu");
		$template->setVariable("linkCon", $link);
		$template->setVariable("menuCon", $menu);
	$template->parseCurrentBlock("bloco_configuracoes_menu");
}

/* Bloco do T�tulo */
$template->setCurrentBlock("bloco_admin");
	/* Produtos */
	$sql = "SELECT count(pro_cod) as cnt FROM {$tabela['produtos']}";
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){	
		$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	}
	$qtdProdutos = (int)$dados['cnt'];

	/* Categorias */
	$sql = "SELECT count(cat_cod) as cnt FROM {$tabela['categorias']}";
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){	
		$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	}
	$qtdCategorias = (int)$dados['cnt'];
	
	/* Fabricantes */
	$sql = "SELECT count(fab_cod) as cnt FROM {$tabela['fabricantes']}";
	$resultado = $dataBase->query($sql);
	if(!DB::isError($resultado)){	
		$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
	}
	$qtdFabricantes = (int)$dados['cnt'];
	
	$template->setVariable("infoPro", "Produtos cadastrados : <b>$qtdProdutos</b>");
	$template->setVariable("infoCat", "Categorias cadastradas : <b>$qtdCategorias</b>");
	$template->setVariable("infoFab", "Fabricantes cadastrados : <b>$qtdFabricantes</b>");
$template->parseCurrentBlock("bloco_admin");

$show = $template->get();

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateAdmin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco do T�tulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO_KOMPRE);
$template->parseCurrentBlock("bloco_titulo");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");	
	$template->setVariable("admin",  "Bem vindo <b>$nome</b>, seu IP &eacute; <b>$ip</b>");
	$template->setVariable("logoff", "<a href=\"logout.php\"><img src=\"../images/botLogoff.gif\" border = \"0\"></a>");	
	$template->setVariable("data", getData());
	$template->setVariable("linkKompre", KOMPRE);
	$template->setVariable("altKompre", ALT_KOMPRE);
	$template->setVariable("linkCreditos", CREDITOS);
	$template->setVariable("altCreditos", ALT_CREDITOS);
	$template->setVariable("conteudo_administracao", $show);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>