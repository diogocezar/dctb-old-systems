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

$templateHtmlName = 'principal.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Inicial */
$template->setCurrentBlock("bloco_inicial");
	$template->setVariable("textoInicial", TEXTO_PRINCIPAL);
$template->parseCurrentBlock("bloco_inicial");

/* Bloco Newsletter */
$template->setCurrentBlock("bloco_newsletter");
	$template->setVariable("textoNewsletter", TEXTO_NEWSLETTER);
$template->parseCurrentBlock("bloco_newsletter");

/* Resgatando um serviço aleatório */
$sql = "SELECT idServico, nomeServico, descricaoServico FROM {$tabela['servicos']}";
$resultado = $dataBase->query($sql);
$i=0;
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$servicos[$i++] = $dados['idServico']."$<b>".limitaStr($dados['nomeServico'], TAMANHO_FRAZE)."</b><br> ".limitaStr($dados['descricaoServico'], TAMANHO_FRAZE);
}

if(!empty($servicos)){
	shuffle($servicos);
}

$printServicos = explode("$", $servicos[0]);

/* Bloco Serviços */
$template->setCurrentBlock("bloco_servicos");
	$template->setVariable("servicos", $printServicos[1]);
$template->parseCurrentBlock("bloco_newsletter");

/* Bloco Link Newsletter */
$template->setCurrentBlock("bloco_link_news");
	$template->setVariable("linkCadastrese", "cadastro.php?acao=adicionar");
$template->parseCurrentBlock("bloco_link_news");

/* Bloco Servicos */
$template->setCurrentBlock("bloco_link_servicos");
	$template->setVariable("linkServicos", "rServicos.php?id={$printServicos[0]}");
$template->parseCurrentBlock("bloco_link_servicos");

$template->show();
?>