<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'empresa.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

$sql = "SELECT textoInstitucional FROM {$tabela['configuracoes']}";	
$resultado = $dataBase->query($sql);
$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);

/* Bloco Empresa */
$template->setCurrentBlock("bloco_empresa");
	$template->setVariable("conteudo", $dados['textoInstitucional']);
$template->parseCurrentBlock("bloco_empresa");

$template->show();
?>