<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/IniFile.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'servicos.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$servico = $_GET['id'];

/* Conversão das variáveis dos blocos */

$sql = "SELECT idServico, nomeServico FROM {$tabela['servicos']} ORDER BY nomeServico LIMIT 10";	
$resultado = $dataBase->query($sql);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$servicos .= "<img src=\"../images/seta.gif\" />&nbsp;<a href = \"rServicos.php?id={$dados['idServico']}\">".$dados['nomeServico']."</a><br>";
}

/* Bloco Servicos */
$template->setCurrentBlock("bloco_servicos");
	$template->setVariable("servicos", $servicos);
$template->parseCurrentBlock("bloco_servicos");

/* Bloco Conteúdo */
$template->setCurrentBlock("bloco_conteudo");
	if(!empty($servico)){
		$sql = "SELECT nomeServico, descricaoServico FROM {$tabela['servicos']} WHERE idServico = $servico";	
		$resultado = $dataBase->query($sql);
		$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
		$template->setVariable("titulo", $dados['nomeServico']);
		$template->setVariable("conteudo", $dados['descricaoServico']);
	}
	else{
		$template->setVariable("titulo", "Selecione um dos serviços ao lado...");
		$template->setVariable("conteudo", "Selecione um dos serviços ao lado para obter maiores informações.");
	}
$template->parseCurrentBlock("bloco_conteudo");


$template->show();
?>