<?php

/* template directory */
$templateHtmlDir = '../view/html';

/* template file */
$templateHtmlName = 'index.html';

/* setting template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instantiating the class */
$template->loadTemplatefile($templateHtmlName, true, true);

/* title block */
$template->setCurrentBlock("title_block");
	$template->setVariable("title", $conf['info']['title']);
$template->parseCurrentBlock("title_block");

	/* user informations */
	$session = $brain_controller['session'];
	$name    = $session->returnSession('sessName',   false);
	$login   = $session->returnSession('sessLogin',  false);
	$iduser  = $session->returnSession('sessIdUser', false);
	// false, não retorna erro caso a sessão esteja vazia.
	// false, don't returns error if the session be empty.

if(!empty($iduser)){
	/* top block */
	$template->setCurrentBlock("top_block");
		$template->setVariable("login", "Bem vindo, $name");
		$init = "<a href=\"../index.php\" class=\"linkWhite\">Início</a>";
		$help  = "<a href=\"help.php\" class=\"linkWhite\">Ajuda</a>";
		$exit   = "<a href=\"logout.php\" class=\"linkWhite\">Sair</a>";
		$template->setVariable("exit",  $init.' - '.$help.' - '.$exit);
	$template->parseCurrentBlock("top_block");
	
	/* menu block */
	$template->setCurrentBlock("menu_block");
		$template->setVariable("menu", "MENU");
	$template->parseCurrentBlock("menu_block");
}
else{
	/* top block */
	$template->setCurrentBlock("top_block");
		$template->setVariable("login", $conf['info']['label']);
		$init = "<a href=\"../index.php\" class=\"linkWhite\">Início</a>";
		$help  = "<a href=\"help.php\" class=\"linkWhite\">Ajuda</a>";
		$template->setVariable("exit",  $init.' - '.$help);
	$template->parseCurrentBlock("bloco_topo");
	
	/* login block */
	$template->setCurrentBlock("login_block");
		$template->setVariable("login", $conf['info']['login_text']);
	$template->parseCurrentBlock("login_block");
}

if($isAjax){
	/* java script ajax */
	$template->setVariable("js_sajax", sajax_show_javascript());
}
else{
	$template->setVariable("js_sajax", '');
}

/* content block */
$template->setCurrentBlock("content_block");
	$template->setVariable("title", $title);
	$template->setVariable("content", $content);
$template->parseCurrentBlock("content_block");

/* footer block */
$template->setCurrentBlock("footer_block");
	$template->setVariable("credits", $conf['info']['credits']);
$template->parseCurrentBlock("footer_block");

$template->show();
?>