<?php
/* Incluindo classes */
include('../classes/Session.php');

@$session = new Session();

$session->limpaSessions();

echo "<script language=javascript>location.href='index.php'</script>";

?>