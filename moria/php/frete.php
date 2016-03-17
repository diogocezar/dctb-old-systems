<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Frete.php');

/* Incluindo sAjax */
include('../classes/sAjax/Sajax.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Funções executadas pelo sAjax */
function calculaFrete($cep, $peso){
	$cep    = str_replace(".", "", $cep);
	$cep    = str_replace("-", "", $cep);
	
	$frete = new Frete("40010", $cep, $peso);	
	return number_format($frete->goFrete(), 2, ',','.');
}

/* Configurando o sAjax */

sajax_init();

$sajax_debug_mode = 0;

sajax_export("calculaFrete");

sajax_handle_client_request();

/* Bloco JavaScript sAjax */

$funcaoJs  = "function executado(frete){
			     document.getElementById(\"resultado\").innerHTML = \"R$\" + frete;
              }";

$funcaoJs .= "function frete(peso){
				  var cep = document.getElementById(\"cep\");
				  if(cep.value == \"\"){
				  	alert('Digite um CEP para calcular o frete do produto.');
					cep.focus();
				  }
				  x_calculaFrete(cep.value, peso, executado);
              }";

/* Extraindo variaveis do navegador */
$id = $_GET['id'];

if(empty($id)){
	echo "<script language=javascript>location.href='index.php'</script>";
	exit();
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'frete.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco JavaScript sAjax */
$template->setCurrentBlock("bloco_javascript_sajax");
	$template->setVariable("sajax_javascript", sajax_show_javascript());
	$template->setVariable("funcoes_javascript", $funcaoJs);	
$template->parseCurrentBlock("bloco_javascript_sajax");

$id   = $_GET['id'];

$sql       = "SELECT pro_peso FROM {$tabela['produtos']} WHERE pro_cod = $id";
$resultado = $dataBase->query($sql);
$dados     = $resultado->fetchRow(DB_FETCHMODE_ASSOC);

$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", "Cálculo de Frete");
$template->parseCurrentBlock("bloco_titulo");

$template->setCurrentBlock("bloco_detalhes");
	$peso = number_format($dados['pro_peso'], 2, '.','.');
	$template->setVariable("peso", $peso);
	$template->setVariable("btnCalcular", "calcular");
	$template->setVariable("campoCep", "cep");
	$template->setVariable("tituloFrete", "Cálculo de frete:");
	$template->setVariable("resultado", "resultado");
	$template->setVariable("onClickCalcular", "frete($peso)");
$template->parseCurrentBlock("bloco_detalhes");

$template->show();
?>