<?php
$filtro = $_GET['filtro'];
$_GET['rss'] = "http%3A%2F%2Frss.terra.com.br%2F0%2C%2CEI1119%2C00.xml";
if(!empty($filtro)){
$_GET['filtro'] = $filtro;
}
include("../php/index.php");
?>