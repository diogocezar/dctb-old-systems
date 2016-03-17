<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendFile.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivo de fun��es */
include('../lib/library.php');
include('../lib/util.php');

/* Arquivo de controle da Session */
include('./controlaSession.php');

$op = $_GET['tipo'];
$id = $_GET['id'];

$continuar = false;

switch($op){
	case 'loja' :
		$prefix = "A";
		$titulo = "Loja";
		
		/* Selecionando a foto do banco */		
		$sql = "SELECT loj_foto_url FROM {$tabela['lojas']} WHERE loj_cod = $id";	
		$urlFoto = $dataBase->getOne($sql);	
		
		/* Apagando foto */
		if(is_file($urlFoto)){
			unlink($urlFoto);
		}
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['lojas'], "loj_cod = $id");
		
		break;

	case 'dica' :
		$prefix = "A";
		$titulo = "Dica";
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['dicas'], "dic_cod = $id");

		break;
	
	case 'servico' :
		$prefix = "O";
		$titulo = "Servi�o";
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['servicos'], "ser_cod = $id");

		break;
}

if($trava_exclusao != true){
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/exclui.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." foi <b>excluid".strtolower($prefix)."</b> com sucesso.<br><br>";
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"form\" id=\"Voltar\" value=\"  � Voltar   \" onclick=\"javascript:javascript:history.go(-1);\" />";
	$msg .= "</div>";
}
else{
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/exclui.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." <b>N�O</b> pode ser excluid".strtolower($prefix).", pois pode estar sendo referenciado(a) em outra tabela do banco de dados.<br><br>";
	$msg .= "Certifique-se que n�o h� mais ref�ncia para esse registro antes de exclu�-lo(a).<br><br>";
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"form\" id=\"Voltar\" value=\"  � Voltar   \" onclick=\"javascript:javascript:history.go(-1);\" />";
	$msg .= "</div>";
}

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'finalizado.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco Texto */
$template->setCurrentBlock("bloco_finalizado");
	$template->setVariable("conteudo", $msg);
$template->parseCurrentBlock("bloco_finalizado");

$show = $template->get();

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Convers�o das vari�veis dos blocos */

/* Bloco T�tulo */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");


/* Bloco Menu */
$template->setCurrentBlock("bloco_menu");
	$i = 0;
	foreach($menu as $replace => $link){
		$template->setVariable($replace, $link);
	}
$template->parseCurrentBlock("bloco_menu");

/* Bloco Interno */
$template->setCurrentBlock("bloco_interno");
	$template->setVariable("conteudoInterno", $show);
$template->parseCurrentBlock("bloco_interno");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	$template->setVariable("linkKreea", CREDITOS);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>