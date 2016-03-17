<?php
include('Imggen.php');
$fonte        = 'GalahadStd-Regular';
$tamanho      = 25;
$texto        = $_GET['texto'];
$corFundo     = '36,36,36';
$corTexto     = '255,255,255';
$transparente = 'sim';
$maxLine      = 80;

$imgGen = new Imggen();
$imgGen->__go_Imggen($fonte, $tamanho, $texto, $corTexto, $corFundo, $transparente, $maxLine);
?>