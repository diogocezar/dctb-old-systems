<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

if(empty($_SESSION['votoSession'])){

	$op = $_POST['op_enquete'];
	
	$db = new DataBase();
	
	$db->Query("UPDATE {$tabela['respostas']} SET res_votos = res_votos+1 WHERE res_id = $op");
	
	echo "<script language=javascript>alert('Obrigado, seu voto foi computado com sucesso !');location.href='index.php'</script>";
	
	$_SESSION['votoSession'] = "sim";

}
else{
	echo "<script language=javascript>alert('O seu voto já foi computado, obrigado.');location.href='index.php'</script>";
}
?>