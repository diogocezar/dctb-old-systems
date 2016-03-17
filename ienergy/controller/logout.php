<?php
include("start-brain.php");

$session = $brain_controller['session'];
$session->startSession();

/* recording logout */
$name     = $session->returnSession('sessName',  false);
$ip       = getIp();
$when     = getmyDate(4)."#".getHour(":",1);
$adminInformation = array('ip:'   => $ip,
				          'name:' => $name,
				          'when:' => $when
				          );
registerLogAdmin($conf['files']['log'], $adminInf, false);

$session->startSession();
$session->clearSessions();

echo "<script language=javascript>location.href='index.php'</script>";
?>