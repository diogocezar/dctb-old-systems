<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/Session.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

@$session = new Session();

if($_SESSION['usuarioSession'] != 'sim'){
	echo "<script language=javascript>alert('Voc� prescisa estar logado para confirmar uma avalia��o.');location.href='index.php'</script>";
	exit();
}
else{
	$cpf = $session->retornaSession('codSession');
}

$id = $_GET['id'];

$op = $_POST['avaliacao'];

$valores = array(
	$id,
	$cpf,
	$op	
);

$inserir = new DataBase();

$inserir->Insert($tabela['avaliacao'], $campos['avaliacao'], $valores);

echo "<script language=javascript>alert('Obrigado, sua avalia��o foi computada com sucesso !!!');window.close();</script>";
?>