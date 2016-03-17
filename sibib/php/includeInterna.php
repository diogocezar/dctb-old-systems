<?php
/**
/* diretório dos templates 
*/
$templateHtmlDir = '../html';

$templateHtmlName = 'principal.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* conversão das variáveis dos blocos */

/* executando onLoad */
$template->setVariable("on_load_js", $onLoad);

/* bloco do título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

	/* informações do usuário */
	$session = $controlador['session'];
	$nome    = $session->retornaSession('sessNome',  false);
	$login   = $session->retornaSession('sessLogin', false);
	$id      = $session->retornaSession('sessId',    false);
	
if(!empty($id)){
	/* bloco topo */
	$template->setCurrentBlock("bloco_topo");
		$template->setVariable("login", "Bem vindo, $nome ($login)");
		$inicio = "<a href=\"../index.php\" class=\"linkBranco\">Início</a>";
		$ajuda  = "<a href=\"ajuda.php\" class=\"linkBranco\">Ajuda</a>";
		$sair   = "<a href=\"sair.php\" class=\"linkBranco\">Sair</a>";
		$template->setVariable("sair",  $inicio.' - '.$ajuda.' - '.$sair);
	$template->parseCurrentBlock("bloco_topo");
	
	/* bloco menu */
	$template->setCurrentBlock("bloco_menu");
		$template->setVariable("menu", "MENU_1");
	$template->parseCurrentBlock("bloco_menu");
}
else{
	/* bloco topo */
	$template->setCurrentBlock("bloco_topo");
		$template->setVariable("login", "Sistema Sibib ".date(Y));
		$inicio = "<a href=\"../index.php\" class=\"linkBranco\">Início</a>";
		$ajuda  = "<a href=\"ajuda.php\" class=\"linkBranco\">Ajuda</a>";
		$template->setVariable("sair",  $inicio.' - '.$ajuda);
	$template->parseCurrentBlock("bloco_topo");
	
	/* bloco login */
	$template->setCurrentBlock("bloco_login");
		$template->setVariable("login", TEXTO_LOGIN);
	$template->parseCurrentBlock("bloco_login");
}

if($exiteAjax){
	/* java script ajax */
	$template->setVariable("js_sajax", sajax_show_javascript());
}
else{
	$template->setVariable("js_sajax", '');
}

/* bloco conteudo */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("titulo", $titulo);
	$template->setVariable("conteudo", $conteudo);
$template->parseCurrentBlock("bloco_conteudo");

/* bloco footer */
$template->setCurrentBlock("bloco_footer");
	$template->setVariable("creditos", CREDITOS);
$template->parseCurrentBlock("bloco_footer");

$template->show();
?>