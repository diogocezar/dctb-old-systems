<?php
/**
* arquivo de configuração
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* incluindo controle de sessão
*/
include("../php/controlaSession.php");

/* extraindo variaveis do navegador */
$id    = $_GET['id'];
$opcao = $_GET['opcao'];

if(empty($id)){
	echo "<script language=javascript>alert('Uma identificação é necessária para acessar essa página.');location.href='index.php'</script>";
	exit();
}

if(empty($opcao)){
	echo "<script language=javascript>alert('Uma opção é necessária para acessar essa página.');location.href='index.php'</script>";
	exit();
}

$contexto      = "cliente";
$contextoArray = array();
$nome          = $nomeTab[$contexto];

$objRec = $controlador[$contexto];
$objRec->__toFillGeneric();
$objRec->__get_db($id);

$documentos = false;

switch($opcao){
	case 'documentos':
		$documentos         = true;
		$documentosConteudo = $_POST['documentos'];
		$templateHtmlName   = "printClienteDocumentos.html";
	break;
}

/* diretório dos templates */
$templateHtmlDir = '../html';

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	
	
$template->setCurrentBlock("bloco_cliente");
				
		$template->setVariable("valorNome",           trim($objRec->getNome()));
		$template->setVariable("valorDatanascimento", desconverteData($objRec->getDatanascimento(),true));
		$template->setVariable("valorBairro",         trim($objRec->getBairro()));
		$template->setVariable("valorCidade",         trim($objRec->getCidade()));
		$template->setVariable("valorEndereco",       trim($objRec->getEndereco()));
		$template->setVariable("valorEstado",         trim($objRec->getEstado()));
		$template->setVariable("valorCep",            trim($objRec->getCep()));
		$template->setVariable("valorEstado",         trim($objRec->getEstado()));
		$template->setVariable("valorTelefone1",      trim($objRec->getTelefone1()));
		$template->setVariable("valorTelefone2",      trim($objRec->getTelefone2()));
		$template->setVariable("valorCelular",        trim($objRec->getCelular()));
		$template->setVariable("valorNumbeneficio",   trim($objRec->getNumbeneficio()));
		$template->setVariable("valorNit",            trim($objRec->getNit()));
		$template->setVariable("valorObservacao",     $objRec->getObservacao());
		$template->setVariable("valorSituacao",       trim($textoSituacao));
		
		if($documentos){
			$template->setCurrentBlock("bloco_cliente_documentos");
				$template->setVariable("valorDocumentos", $documentosConteudo);
			$template->parseCurrentBlock("bloco_cliente_documentos");
		}
		
				
$template->parseCurrentBlock("bloco_cliente");

$conteudo = $template->show();
?>