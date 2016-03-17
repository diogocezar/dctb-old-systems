<?php
$filtro = $_GET['filtro'];
$_GET['rss'] = "http%3A%2F%2Fnews.google.com%2Fnews%3Fned%3Dpt-BR_br%26topic%3Dt%26output%3Drss";
if(!empty($filtro)){
$_GET['filtro'] = $filtro;
}
include("../php/index.php");
?>