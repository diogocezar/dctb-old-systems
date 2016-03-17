<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'servicos.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$servico = $_GET['id'];

/* Convers�o das vari�veis dos blocos */

$sql = "SELECT idServico, nomeServico FROM {$tabela['servicos']} ORDER BY nomeServico LIMIT 10";	
$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$servicos .= "<img src=\"../images/seta.gif\" />&nbsp;<a href = \"rServicos.php?id={$dados['idServico']}\">".$dados['nomeServico']."</a><br>";
}

/* Bloco Servicos */
$template->setCurrentBlock("bloco_servicos");
	$template->setVariable("servicos", $servicos);
$template->parseCurrentBlock("bloco_servicos");

/* Bloco Conte�do */
$template->setCurrentBlock("bloco_conteudo");
	if(!empty($servico)){
		$sql = "SELECT nomeServico, descricaoServico FROM {$tabela['servicos']} WHERE idServico = $servico";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$template->setVariable("titulo", $dados['nomeServico']);
		$template->setVariable("conteudo", $dados['descricaoServico']);
	}
	else{
		$template->setVariable("titulo", "Selecione um dos servi�os ao lado...");
		$template->setVariable("conteudo", "Selecione um dos servi�os ao lado para obter maiores informa��es.");
	}
$template->parseCurrentBlock("bloco_conteudo");


$template->show();
?>