<?php
include('Imggen.php');
$fonte        = $_GET['fonte'];
$tamanho      = $_GET['tamanho'];
$texto        = $_GET['texto'];
$corFundo     = $_GET['corFundo'];
$corTexto     = $_GET['corTexto'];
$transparente = $_GET['transparente'];

$imgGen = new Imggen();
$imgGen->__go_Imggen($fonte, $tamanho, $texto, $corTexto, $corFundo, $transparente);
?>