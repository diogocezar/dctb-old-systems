<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'faleconosco.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("bloco_contato");

	/* Formulario */
		$template->setVariable("formContato", "form_contato");
		$template->setVariable("actionContato", "enviaContato.php");
	
	/* Nomes dos Campos */
		$template->setVariable("campoNome", "nome");
		$template->setVariable("campoEmail", "email");
		$template->setVariable("campoAssunto", "assunto");
		$template->setVariable("campoMensagem", "mensagem");
	
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "rValContato(document.form_contato.nome, document.form_contato.email, document.form_contato.assunto, document.form_contato.mensagem, document.form_contato)");
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
$template->parseCurrentBlock("bloco_contato");

$template->show();
?>