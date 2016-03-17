<?
include('SendMail.php');
$titulo   = "teste";
$conteudo = "teste";
$origem   = "teste@teste.com";
$destino  = "frufrek@utfpr.edu.br";

$send = new SendMail($titulo, $conteudo, $destino, $origem);
$send->goMail();
?>