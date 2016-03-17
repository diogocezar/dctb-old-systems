<?php
include("start-brain.php");

/* session control */
$messageSC = false; // block start message
include("session-control.php");


$title   = 'Bem vindo ao SGCP';
$content = 'Pequeno texto descrevendo o sistema.';

include('inside-include.php');
?>
