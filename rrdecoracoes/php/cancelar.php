<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivos de funções */
include('../lib/util.php');
include('../lib/library.php');

$send = $_GET['send'];

if($send == "ok"){
	$email = $_POST['email'];
	$count = $dataBase->getOne("SELECT count(*) FROM {$tabela['visitantes']} WHERE emailVisitante = '$email'");
	if($count > 0){
		$dataBase->Query("DELETE FROM {$tabela['visitantes']} WHERE emailVisitante = '$email'");
		echo "<script language=javascript>alert('Seu cadastro foi removido com sucesso !');location.href='principal.php'</script>";
		exit();
	}
	else{
		echo "<script language=javascript>alert('O e-mail informado não consta em nossa lista de e-mails');location.href='principal.php'</script>";
		exit();
	}
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'cancelar.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);	

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco form_cadastro */
$template->setCurrentBlock("bloco_cancelar");

	/* Formulario */
		$template->setVariable("formCancelar", "form_cancelar");
		$template->setVariable("actionCancelar", "cancelar?send=ok");
	
	/* Nomes dos Campos */
		$template->setVariable("campoEmail", "email");
	
	/* Java Script ao Enviar */
		$template->setVariable("onClickEnviar", "rValCancelar(document.form_cancelar.email, document.form_cancelar)");
		
$template->parseCurrentBlock("bloco_cancelar");

$template->show();
?>