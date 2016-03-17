<?php
/**
* arquivo de configura��o
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* include fun��es ajax
*/
include("../ajax/ajaxGerenciar.php");

/**
* incluindo controle de sess�o
*/
include("../php/controlaSession.php");


/* defini��es para p�gina interna */
$tabela = $_GET['tabela'];
$campos = $_GET['campos'];
$nome   = $nomeTab[$tabela];

if(empty($tabela) || empty($campos)){
	echo "<script language=javascript>alert('Deve-se selecionar a tabela e seus campos para acionar o gerenciamento.');location.href='../php/index.php'</script>";
	exit();
}

/* diret�rio dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'gerenciar.html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$template->setCurrentBlock("bloco_html");
	
	$onLoad .= "onLoad = \"";
	$onLoad .= "call_getFiltredRegistersContato(true, event);";
	$onLoad .= "document.getElementById('digitado').focus();";
	$onLoad .= "\"";

	/* java script */
	$template->setVariable("js_sajax", sajax_show_javascript());
	$template->setVariable("js_tabela", $tabela);
	$template->setVariable("js_campos", $campos);
	$template->setVariable("js_onLoad", $onLoad);
	
	
	$template->setVariable("cmp_procura", "Procurar: ");
	$template->setVariable("cmp_form_procura", "digitado");
	$template->setVariable("cmp_form_key_press", "call_getFiltredRegistersContato(false, event)");
	$template->setVariable("cmp_detalhe_titulo", "DETALHES DO REGISTRO:");
	
	if(eregi(",", $campos)){
		$campos      = explode(",", $campos);
		$campoIndex  = $campos[0];
	}
	else{
		$campoIndex  = $campos;
	}
	
	$i=0;
	if(is_array($campos)){
		foreach($campos as $campoAtual){
			$camposReplace .= $aliasMap[$tabela][$campoAtual];
			$i++;
			if($i != count($campos)){
				$camposReplace .= ", ";
			}
		}
		$camposReplace = 'empresa, '.$camposReplace;
		$template->setVariable("cmp_campos_procura", $camposReplace);
	}
	else{
		$campo = $aliasMap[$tabela][$campoIndex];
		$template->setVariable("cmp_campos_procura", $campo);
	}
	
$template->parseCurrentBlock("bloco_html");

$conteudo = $template->get();

$titulo = "Gerenciar registros de: ".ucfirst($nomeTab[$tabela]);

/* incluindo conteudo na p�gina interna */
include("../php/includeInterna.php");

?>