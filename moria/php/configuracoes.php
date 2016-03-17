<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Arquivo de controle da Session */
include('./controlaSession.php');

/* Recuperando informa��es */
$ini = new IniFile($diretorio['opcoes']);
$arrayOpcoes = $ini->getIni(true);

foreach($arrayOpcoes['sessionOpcoesDisponibilidade'] as $indice => $valor){
	$listaDisp .= "<option value=\"$valor\"";
	$listaDisp .= ">".$valor."</option>";
}

foreach($arrayOpcoes['sessionOpcoesClassifica��o'] as $indice => $valor){
	$listaClas .= "<option value=\"$valor\"";
	$listaClas .= ">".$valor."</option>";
}

$numProdPag = $arrayOpcoes['configura��esGerais']['numProdPag'];

$numPorPag  = $arrayOpcoes['configura��esGerais']['numPorPag'];

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'formConfiguracoes.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

$template->setCurrentBlock("bloco_configuracoes");

	/* Bot�es */
		$template->setVariable("btnEnviar",  "Enviar");
		$template->setVariable("btnVoltar", "Voltar");

	/* Formulario */
		$template->setVariable("formConfiguracoes", "form_config");
		$template->setVariable("actionConfiguracoes", "alteraConfiguracoes.php");
	
	/* Titulos */
		$template->setVariable("tituloConfiguracoes", "Configura��es Gerais");

	/* Nomes dos Campos */
		$template->setVariable("campoDisponibilidade", "disponibilidade");
		$template->setVariable("campoClassificacao", "classificacao");
		$template->setVariable("listDisponibilidade", "list_disp[]");
		$template->setVariable("listDisponibilidadeID", "list_disp");
		$template->setVariable("listClassicacao", "list_clas[]");
		$template->setVariable("listClassicacaoID", "list_clas");
		$template->setVariable("numPrincipal", "num_pag_principal");
		$template->setVariable("numPorPagina", "num_por_pagina");
		
	/* Preenchendo as Listas */
		$template->setVariable("listDisponibilidadeOpcoes", $listaDisp);
		$template->setVariable("listClassicacaoOpcoes", $listaClas);
		
	/* Java Script Add and Rmv */
		$template->setVariable("addDisp",   "adicionaLista('disponibilidade', 'list_disp')");
		$template->setVariable("rmvDisp",   "retiraLista('list_disp')");
		$template->setVariable("addCla",    "adicionaLista('classificacao', 'list_clas')");
		$template->setVariable("rmvCla", "retiraLista('list_clas')");
		
	/* Setando op��es como selected */
		$template->setVariable("selPRI_$numProdPag", "selected");
		$template->setVariable("selPOR_$numPorPag",  "selected");
	
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "selecionaTodosLista('list_disp');selecionaTodosLista('list_clas');enviaForm(document.form_config)");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
$template->parseCurrentBlock("bloco_configuracoes");

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