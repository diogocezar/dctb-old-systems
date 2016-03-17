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

/* Arquivo de controle da Session */
include('./controlaSession.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';
	
$templateHtmlName = 'formEmpresa.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$sql = "SELECT textoInstitucional
FROM {$tabela['configuracoes']}";	

$resultado = $dataBase->query($sql);
$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
$texto['texto'] = $dados['textoInstitucional'];

/* Bloco form_cadastro */
$template->setCurrentBlock("form_texto");

	/* Formulario */
		$template->setVariable("formTexto", "form_texto");
		$template->setVariable("actionTexto", "atualiza.php?tipo=texto");
	
	/* Nomes dos Campos */
		$template->setVariable("campoTexto", "texto");
	
	/* Valores dos Campos */
		$template->setVariable("valorTexto", $texto['texto']);
		
	/* Botão */
		$template->setVariable("btnVoltar", "voltar");
		$template->setVariable("labelVoltar", "  « Voltar   ");
		
	/* Java Script ao Voltar */
		$template->setVariable("onClickVoltar", "javascript:location.href='administrar.php'");
		
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "rValTexto(document.form_texto)");
		
$template->parseCurrentBlock("form_texto");

$template->show();
?>