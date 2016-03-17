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

$templateHtmlName = 'clientes.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$servico = $_GET['id'];

/* Conversão das variáveis dos blocos */

/* Contando registros */
$qtd = $dataBase->getOne("SELECT count(*) FROM ".$tabela['clientes']);

$sql = "SELECT nomeCliente, urlCliente  FROM {$tabela['clientes']} ORDER BY nomeCliente";	
$resultado = $dataBase->query($sql);
$i=0;
$clientes  = "<table width=\"600\" border=\"0\">";
$clientes .= "<tr>";
$clientes .= "<td width=\"150\">";

while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$i++;
	$link = $dados['urlCliente'];
	if(!ereg("http://",$link)){
		$link  = "http://".$link;
	}
	$clientes .= "<span class=\"fonte10\"><b>";
	$clientes .= $dados['nomeCliente']."</b><br>";
	$clientes .= "<img src=\"../images/seta.gif\" />&nbsp;<a href = \"$link\" target=\"_blank\">".$link."</a><br><br>";
	$clientes .= "</span>";
	if($i == 6){
		$i = 0;
		$clientes .= "</td>";
		$clientes .= "<td width=\"150\">";		
	}
}
$clientes .= "</td>";
$clientes .= "</tr>";
$clientes .= "</table>";

/* Bloco Servicos */
$template->setCurrentBlock("bloco_clientes");
	$template->setVariable("conteudo", $clientes);
$template->parseCurrentBlock("bloco_clientes");

$template->show();
?>