<?php
/* Incluindo classes */
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/IniFile.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivo de fun��es */
include('../lib/library.php');
include('../lib/util.php');

/* Arquivo de controle da Session */
include('./controlaSession.php');

/* Alterando as configura��es */

$listaDisponibilidade = $_POST['list_disp'];
$listaClassificacao   = $_POST['list_clas'];
$numPagPrincipal      = $_POST['num_pag_principal'];
$numPorPagina         = $_POST['num_por_pagina'];

$arrayIni = array('sessionOpcoesDisponibilidade' => $listaDisponibilidade,
                  'sessionOpcoesClassifica��o'   => $listaClassificacao,
				  'configura��esGerais'          => array('numProdPag' => $numPagPrincipal,
				                                          'numPorPag'  => $numPorPagina
														  )
			      );
				  
$ini = new IniFile($diretorio['opcoes']);
$arrayOpcoes = $ini->setIni($arrayIni);				                                       

$msg  = "<div align=\"center\">";
$msg .= "<img src=\"../images/configuracao.jpg\"><br><br>";
$msg .= "As configura��es foram alteradas com sucesso.<br><br>";
$msg .= "<input name=\"Voltar\" type=\"button\" class=\"form\" id=\"Voltar\" value=\"  � Voltar   \" onclick=\"javascript:location.href='administrar.php'\" />";
$msg .= "</div>";

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
	$template->setVariable("conteudo_administracao", $msg);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>