<?php
/**
* Arquivo de configuração
*/
include("../conf/config.php");

/**
* Cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* Inclue funções ajax
*/
include("../ajax/ajaxGerenciar.php");

$tabela = 'comentarios';
$campos = '1,2,3';

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'gerenciar.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

$template->setCurrentBlock("bloco_html");

	$onLoad .= "call_getFiltredRegisters();";
	$onLoad .= "document.getElementById('digitado').focus();";

	/* Java Script */
	$template->setVariable("js_sajax", sajax_show_javascript());
	$template->setVariable("js_tabela", $tabela);
	$template->setVariable("js_campos", $campos);
	$template->setVariable("js_onLoad", $onLoad);
	
	$template->setVariable("cmp_titulo", "Gerenciando registros de: ". ucfirst($tabela));
	$template->setVariable("cmp_procura", "Procurar: ");
	$template->setVariable("cmp_form_procura", "digitado");
	$template->setVariable("cmp_form_key_up", "call_getFiltredRegisters()");
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
		$template->setVariable("cmp_campos_procura", $camposReplace);
	}
	else{
		$campo = $aliasMap[$tabela][$campoIndex];
		$template->setVariable("cmp_campos_procura", $campo);
	}

$template->parseCurrentBlock("bloco_html");

$template->show();

?>