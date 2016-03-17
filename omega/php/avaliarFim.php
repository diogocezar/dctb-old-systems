<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

@$session = new Session();

if($_SESSION['usuarioSession'] != 'sim'){
	echo "<script language=javascript>alert('Você prescisa estar logado para confirmar uma avaliação.');location.href='index.php'</script>";
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

echo "<script language=javascript>alert('Obrigado, sua avaliação foi computada com sucesso !!!');window.close();</script>";
?>