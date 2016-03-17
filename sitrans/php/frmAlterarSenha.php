<?php
/**
* arquivo de configuraчуo
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* include funчѕes ajax
*/
include("../ajax/ajax.php");

/**
* incluindo controle de sessуo
*/
include("../php/controlaSession.php");

/* diretѓrio dos templates */
$templateHtmlDir = '../html';

if(!empty($opCliente)){
	$templateHtmlDir = '../html/cliente';
}

$templateHtmlName = "frmAlterarSenha.html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	
	
$template->setCurrentBlock("bloco_formulario");
		
	/* formulario */
		$form = "form_alterarSenha";
		$template->setVariable("formAlterarSenha", $form);
		$template->setVariable("actionAlterarSenha", "alterarSenha.php");
	
	/* nomes dos campos */
		$template->setVariable("campoSenhaAtual",    "senhaAtual");
		$template->setVariable("campoNovaSenha",     "novaSenha");
		$template->setVariable("campoConfirmaSenha", "confirmaSenha");
		
	/* onClick */
		if(empty($opCliente)){
			$template->setVariable("onClick", "javascript:AlterarSenha.send('sitrans')");
		}
		else{
			$template->setVariable("onClick", "javascript:AlterarSenha.send('contato')");
		}
					
	/* foco no campo inicial */
		$onLoad .= "onLoad = \"";
		$onLoad .= "document.$form.senhaAtual.focus();";
		$onLoad .= "\"";
				
$template->parseCurrentBlock("bloco_formulario");

$template->show();
?>