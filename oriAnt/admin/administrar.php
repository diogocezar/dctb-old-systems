<?php
/**
* Arquivo de configura��o
*/
include("../conf/config.php");

/**
* Biblioteca de fun��es
*/
include("../lib/library.php");

/**
* Indioma do sistema
*/
include("../lang/lang.php");

/**
* Cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* Controle de sess�o
*/
include("./controlaSession.php");

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'admin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco Titulo */
	$template->setCurrentBlock("bloco_titulo");
		$template->setVariable("titulo", TITULO);		
	$template->parseCurrentBlock("bloco_titulo");
	
/* Bloco Admin */	
	$template->setCurrentBlock("bloco_admin");
		$nomeAdmin = $session->retornaSession(SESSION_NOMEA);
		$template->setVariable("nomeAdmin", $nomeAdmin);	
		$template->setVariable("logOutLink", "logout.php");	
		$template->setVariable("logOut", "Sair");	
		
		$template->setVariable("frequencia", "Consulta de Freq�encia dos Grupos");	
		$template->setVariable("linkFrequencia", "conFrequencia.php");	
		
		$template->setVariable("paginasCadastradas", "Consulta de P�ginas Cadastradas");	
		$template->setVariable("linkPaginasCadastradas", "../gerenciar/gerenciar.php?tabela=pagina&campos=2");	
		
		
		$template->setVariable("inserirGrupo", "Inserir Grupo");	
		$template->setVariable("linkInserir", "frmGrupo.php?acao=adicionar");	
		
		$template->setVariable("gerenciarGrupos", "Gerenciar Grupos Cadastrados");	
		$template->setVariable("linkGerenciarGrupos", "../gerenciar/gerenciar.php?tabela=grupo&campos=2");	
		
		$template->setVariable("alterarTemplate", "Alterar Template da Camada OriAnt");	
		$template->setVariable("linkAlterarTemplate", "frmTemplate.php?acao=atualizar");	
		
		$template->setVariable("instrucoesTemplate", "Instru��es para Cria��o de Templates");	
		$template->setVariable("linkInstrucoesTemplate", "instrucoes.php");	
		
		$template->setVariable("alterarParametros", "Alterar Par�metros Administrativos");	
		$template->setVariable("linkAlterarParametros", "frmParAdm.php?acao=atualizar");	
		
		$template->setVariable("paginasCadastradas", "Consulta de P�ginas Cadastradas");	
		$template->setVariable("linkConPaginas", "conPaginas.php");	
		
		$template->setVariable("consultarFeromonio", "Consultar Quantidade de Ferom�nio");	
		$template->setVariable("linkConFeromonio", "../gerenciar/gerenciar.php?tabela=feromonio&campos=4");	
			
	$template->parseCurrentBlock("bloco_admin");	
	
$template->show();
?>