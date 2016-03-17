<?php
/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

$session = $controlador['session'];
$session->startSession();
$session->limpaSessions();

echo "<script language=javascript>location.href='index.php'</script>";
?>