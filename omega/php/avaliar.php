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

@$session = new Session();

if($_SESSION['usuarioSession'] != 'sim'){
	echo "<script language=javascript>alert('Você prescisa estar logado para ter acesso à suas compras.');location.href='index.php'</script>";
	exit();
}
else{
	$cod = $session->retornaSession('codSession');
}

/* Caputando código do filme avaliado */

$id = $_GET['id'];

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'avaliarFilme.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco do Login */
$template->setCurrentBlock("bloco_avaliar");

	$sql = "SELECT fil_titulo
			FROM {$tabela['filme']}
			WHERE fil_cod = $id";	
	$resultado = $dataBase->query($sql);
	$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);

	/* Titulo */
		$template->setVariable("tituloAvaliar", "Avalie o Filme :");
		$template->setVariable("titulo", "Avaliação");
		$template->setVariable("tituloFilme", "Qual é sua avaliação para o filme <br> <b>".$dados['fil_titulo']."</b> ?");
		
	/* Formulario */
		$template->setVariable("formAvaliar", "form_avaliar");
		$template->setVariable("actionAvaliar", "avaliarFim.php?id=$id");

	/* Titulos dos Campos */	
		$template->setVariable("avaliacao", "avaliacao");
		$template->setVariable("val5", "5");
		$template->setVariable("val4", "4");
		$template->setVariable("val3", "3");
		$template->setVariable("val2", "2");
		$template->setVariable("val1", "1");
		
	/* Informações sobre o filme */
	

	/* Botão */
		$template->setVariable("linkAvaliar", "#");
		$template->setVariable("altAvaliar", "Avaliar !");
	/* Java Script ao Enviar */
		$template->setVariable("onClickAvaliar", "enviaForm(form_avaliar)");
		
$template->parseCurrentBlock("bloco_avaliar");

$template->show();
?>