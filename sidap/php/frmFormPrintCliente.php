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
* incluindo controle de sess�o
*/
include("../php/controlaSession.php");

/* extraindo variaveis do navegador */
$acao  = $_GET['acao'];
$id    = $_GET['id'];
$opcao = $_GET['opcao']; 

if(empty($acao)){
	echo "<script language=javascript>alert('Uma a��o � necess�ria para acessar essa p�gina.');location.href='index.php'</script>";
	exit();
}
if(empty($id)){
	echo "<script language=javascript>alert('Uma identifica��o � necess�ria para acessar essa p�gina.');location.href='index.php'</script>";
	exit();
}
if(empty($opcao)){
	echo "<script language=javascript>alert('Uma op��o � necess�ria para acessar essa p�gina.');location.href='index.php'</script>";
	exit();
}

$documentos = false;

switch($opcao){
	case 'documentos':
		$documentos = true;
		$contexto   = "documentos";
	break;
}

$contextoArray = array();

switch($acao){
	case 'adicionar' :
		$contextoArray['action'] = "printCliente.php?opcao=$opcao&id=$id";
		break;
}

/* diret�rio dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = "frm".ucfirst($contexto).".html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	
	
$template->setCurrentBlock("bloco_formulario");

	if($documentos){
		/* formulario */
			$form = "form_".$contexto;
			$template->setVariable("form".ucfirst($contexto), $form);
			$template->setVariable("action".ucfirst($contexto), $contextoArray['action']);
		
		/* nomes dos campos */
			$template->setVariable("campoDocumentos", "documentos");
	}
						
$template->parseCurrentBlock("bloco_formulario");

$conteudo = $template->get();

$template->show();
?>