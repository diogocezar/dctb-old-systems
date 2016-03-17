<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendFile.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

/* Arquivo de controle da Session */
include('./controlaSession.php');

$op = $_GET['tipo'];
$id = $_GET['id'];

$continuar = false;

switch($op){
	case 'visitante' :
		$prefix = "O";
		$titulo = "Visitante";
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['visitantes'], "idVisitante = $id");
		
		break;

	case 'cliente' :
		$prefix = "O";
		$titulo = "Cliente";
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['clientes'], "idCliente = $id");

		break;
		
	case 'newsletter':
		$prefix = "A";
		$titulo = "Newsletter";
		$continuar = true;
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['novidades'], "idNovidade = $id");

		break;
		
	case 'admin':
		$prefix = "O";
		$titulo = "Administrador";
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['administradores'], "idAdministrador = $id");
		
		break;
	
	case 'servico' :
		$prefix = "O";
		$titulo = "Serviço";
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['servicos'], "idServico = $id");

		break;
}

if($trava_exclusao != true){
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/exclui.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." foi <b>excluid".strtolower($prefix)."</b> com sucesso.<br><br>";
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:javascript:history.go(-1);\" />";
	$msg .= "</div>";
}
else{
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/exclui.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." <b>NÃO</b> pode ser excluid".strtolower($prefix).", pois pode estar sendo referenciado(a) em outra tabela do banco de dados.<br><br>";
	$msg .= "Certifique-se que não há mais refência para esse registro antes de excluí-lo(a).<br><br>";
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:javascript:history.go(-1);\" />";
	$msg .= "</div>";
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'finalizado.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco Texto */
$template->setCurrentBlock("bloco_finalizado");
	$template->setVariable("conteudo", $msg);
$template->parseCurrentBlock("bloco_finalizado");

$template->show();
?>