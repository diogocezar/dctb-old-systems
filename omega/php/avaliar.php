<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

@$session = new Session();

if($_SESSION['usuarioSession'] != 'sim'){
	echo "<script language=javascript>alert('Voc� prescisa estar logado para ter acesso � suas compras.');location.href='index.php'</script>";
	exit();
}
else{
	$cod = $session->retornaSession('codSession');
}

/* Caputando c�digo do filme avaliado */

$id = $_GET['id'];

/* Diret�rio dos Templates */
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
		$template->setVariable("titulo", "Avalia��o");
		$template->setVariable("tituloFilme", "Qual � sua avalia��o para o filme <br> <b>".$dados['fil_titulo']."</b> ?");
		
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
		
	/* Informa��es sobre o filme */
	

	/* Bot�o */
		$template->setVariable("linkAvaliar", "#");
		$template->setVariable("altAvaliar", "Avaliar !");
	/* Java Script ao Enviar */
		$template->setVariable("onClickAvaliar", "enviaForm(form_avaliar)");
		
$template->parseCurrentBlock("bloco_avaliar");

$template->show();
?>