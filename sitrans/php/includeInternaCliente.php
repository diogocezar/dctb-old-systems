<?php
/**
/* diretório dos templates 
*/
$templateHtmlDir = '../html/cliente/';

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
	$nomeContato = $session->retornaSession('sessNomeContato',  false);
	$nomeEmpresa = $session->retornaSession('sessNomeEmpresa', false);
	$idContato   = $session->retornaSession('sessIdContato', false);
	$idEmpresa   = $session->retornaSession('sessIdEmpresa', false);
	
	/* recuperando descrição do nível */	
	if(!empty($id)){
		$objNivel = $controlador['nivel'];
		$objNivel->__toFillGeneric();
		$objNivel->__get_db($id);
		$descricaoNivel = $objNivel->getDescricao();
	}

if($interface == "login"){
	/* bloco login */
	$template->setCurrentBlock("bloco_login");
		$template->setVariable("instrucoesLogin", INSTRUCOES_CLIENTE);
	$template->parseCurrentBlock("bloco_login");
}
else{
	/* bloco menu */
	$template->setCurrentBlock("bloco_menu");
		$nome         = $nomeContato;
		$empresa      = $nomeEmpresa;
		$inicio       = "<a href=\"../index.php\" class=\"linkBranco\">Início</a>";
		$alterarSenha = "<a href=\"javascript:;\" onclick=\"tb_show('Alterar a sua senha:', 'frmAlterarSenha.php?height=200&width=250&tcliente=sim', '');\" class=\"linkBranco\">Alterar Senha</a>";
		$template->setVariable("linha1", "Bem vindo, $nome - $empresa (".$alterarSenha.")");
		$template->setVariable("linha2",  $titulo);
	$template->parseCurrentBlock("bloco_menu");
}

$template->setVariable("js_sajax", sajax_show_javascript());

/* bloco conteudo */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("titulo", $titulo);
	$template->setVariable("conteudo", $conteudo);
$template->parseCurrentBlock("bloco_conteudo");

/* bloco footer */
$template->setCurrentBlock("bloco_footer");
	$template->setVariable("creditos", CREDITOS_CLIENTE);
$template->parseCurrentBlock("bloco_footer");

$template->show();
?>