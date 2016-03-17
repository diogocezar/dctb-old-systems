<?php
include("start-brain.php");

/**
 * @package controller
 */

$tipo = $brain_controller['tipoacervo'];
$tipo->__toFillGeneric();

$tipo->setNome('space_brain');
$tipo->setSenha('123');
$tipo->setDataCadastro('NOW()');
$tipo->setDataBaixa('NULL');
$tipo->setSituacao('TRUE');

$tipo->save();
?>