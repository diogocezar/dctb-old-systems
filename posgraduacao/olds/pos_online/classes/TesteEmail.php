<?
include('SendMail.php');
$titulo   = "teste";
$conteudo = "teste";
$origem   = "teste@teste.com";
$destino  = "xgordo@gmail.com";

$send = new SendMail($titulo, $conteudo, $destino, $origem);
$send->goMail();
?>