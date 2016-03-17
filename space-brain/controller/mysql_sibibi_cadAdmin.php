<?php
include("start-brain.php");

/**
 * @package controller
 */

$admin = $brain_controller['administrador'];
$admin->__toFillGeneric();

$admin->setIdAdministrador(5);
$admin->setNome('space_brain');
$admin->setLogin('sb');
$admin->setSenha('123');
$admin->setDataCadastro('NOW()');
$admin->setDataBaixa('NULL');
$admin->setSituacao('TRUE');

$admin->save();
?>