<?php
/**
* arquivo de configura��o
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* include fun��es ajax
*/
include("../ajax/ajaxGerenciar.php");

/**
* incluindo controle de sess�o
*/
$nivelRequerido = "user";
include("../php/controlaSession.php");

/* diret�rio dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'apListagemProcessos.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$template->setCurrentBlock("bloco_processos");

	$nome      = $_SESSION['sessNome'];
	$idCliente = $_SESSION['sessId'];
	$processos = $controlador['processo'];
	$processos->__toFillGeneric();
	
	$qtdPA = $processos->qtd($idCliente, 'andamento');
	$qtdPC = $processos->qtd($idCliente, 'concluido');
	
	$resultadoPA = $processos->processos($idCliente, 'andamento');
	$resultadoPC = $processos->processos($idCliente, 'concluido');
	
	$template->setVariable("campoNome", $nome);
	$template->setVariable("qtdPA",     $qtdPA);
	$template->setVariable("qtdPC",     $qtdPC);
	
	while($dadosPA = $resultadoPA->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_processos_pa");
			$template->setVariable("campoNumero", $dadosPA[$processos->campos[3]]);
			$template->setVariable("campoAcao", $dadosPA[$processos->campos[2]]);
			$template->setVariable("campoJuizo", $dadosPA[$processos->campos[4]]);
			$template->setVariable("campoReu", $dadosPA[$processos->campos[6]]);
			$template->setVariable("linkAndamentoProcesso", "vejaProcesso.php?id=".$dadosPA[$processos->campos[0]]);
		$template->parseCurrentBlock("bloco_processos_pa");
	}

	while($dadosPC = $resultadoPC->fetchRow(DB_FETCHMODE_ASSOC)){
		$template->setCurrentBlock("bloco_processos_pc");
			$template->setVariable("campoNumero", $dadosPC[$processos->campos[3]]);
			$template->setVariable("campoAcao", $dadosPC[$processos->campos[2]]);
			$template->setVariable("campoJuizo", $dadosPC[$processos->campos[4]]);
			$template->setVariable("campoReu", $dadosPC[$processos->campos[6]]);
			$template->setVariable("linkAndamentoProcesso", "vejaProcesso.php?id=".$dadosPC[$processos->campos[0]]);
		$template->parseCurrentBlock("bloco_processos_pc");
	}
	
$template->parseCurrentBlock("bloco_processos");

$conteudo = $template->get();

/* incluindo conteudo na p�gina interna */
include("../php/includeInterna.php");
?>