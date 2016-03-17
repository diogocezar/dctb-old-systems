<?php
include("start-brain.php");

$session = $brain_controller['session'];
$session->startSession();

/* recording logout */
$nameSC     = $_SESSION['sessName'];
$ipSC       = getIp();
$whenSC     = getmyDate(4)."#".getHour(":",1);
$adminInformation = array('ip:'   => $ipSC,
						  'name:' => $nameSC,
						  'when:' => $whenSC
						  );
registerLogAdmin($conf['files']['log'], $adminInformation, false);

$session->startSession();
$session->clearSessions();

echo "<script language=javascript>location.href='index.php'</script>";
?>