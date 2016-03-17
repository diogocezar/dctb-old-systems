<?php
include("start-brain.php");

/**
 * @package controller
 */

$usuario = $brain_controller['usuario'];
$usuario->__toFillGeneric();


$usuario->setIdnivel('1');
$usuario->setNome('123');
$usuario->setLogin('login');
$usuario->setSenha('senha');
$usuario->setDatacadastro('NOW()');
$usuario->setDatabaixa('NULL');
$usuario->setSituacao('TRUE');

$usuario->save();
?>