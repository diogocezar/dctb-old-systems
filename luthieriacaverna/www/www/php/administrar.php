<?php
/**
* arquivo de configuraчуo
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* include funчѕes ajax
*/
include("../ajax/ajaxGerenciar.php");

/**
* incluindo controle de sessуo
*/
$nivelRequerido = "admin";
include("../php/controlaSession.php");

/* diretѓrio dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'admin.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$template->setCurrentBlock("bloco_html");

	$template->setVariable("linkInserirDica",       "frmDica.php?acao=adicionar");
	$template->setVariable("linkGerenciarDicas",    "gerenciar.php?tabela=dica&campos=1,2");
	
	$template->setVariable("linkInserirEquipe",     "frmEquipe.php?acao=adicionar");
	$template->setVariable("linkGerenciarEquipe",   "gerenciar.php?tabela=equipe&campos=1,2");
	
	$template->setVariable("linkInserirLink",       "frmLink.php?acao=adicionar");
	$template->setVariable("linkGerenciarLinks",    "gerenciar.php?tabela=link&campos=1,2,3");	
	
	$template->setVariable("linkInserirNoticia",    "frmNoticia.php?acao=adicionar");
	$template->setVariable("linkGerenciarNoticias", "gerenciar.php?tabela=noticia&campos=1,2,3");	
	
	$template->setVariable("linkInserirServico",     "frmServico.php?acao=adicionar");
	$template->setVariable("linkGerenciarServicos",  "gerenciar.php?tabela=servico&campos=1,2");
	
	$template->setVariable("linkInserirTrabalho",    "frmTrabalho.php?acao=adicionar");
	$template->setVariable("linkGerenciarTrabalhos", "gerenciar.php?tabela=trabalho&campos=1,3");	
	
	$template->setVariable("alterarInformacoes", "frmInformacoes.php");
	
	$template->setVariable("linkKompre", "../kompre/");
	
	$template->setVariable("linkLogOut", "logout.php");
	
$template->parseCurrentBlock("bloco_html");

$conteudo = $template->get();

/* incluindo conteudo na pсgina interna */
include("../php/includeInterna.php");
?>