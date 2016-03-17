<?php
/* Incluindo classes */
include('../classes/Session.php');

@$session = new Session();

$genero = $_GET['genero'];

$_SESSION['maiorSession'] = "Sim";

echo "<script language=javascript>location.href='busca.php?genero=$genero'</script>";

?>