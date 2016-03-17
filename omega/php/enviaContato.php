<?php
/* Setando tempo limite da p�gina para infinito (Caso o email demore para ser enviado) */
set_time_limit(0);

/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendMail.php');
include('../classes/SendFile.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivo de fun��es */
include('../lib/library.php');
include('../lib/util.php');

@$session = new Session();

$permitido = false;

$nome       = $_POST['nome'];
$email      = $_POST['email'];
$telefone   = $_POST['telefone'];
$cidade     = $_POST['cidade'];
$comentario = converteQuebra($_POST['comentario']);

/* Enviando o email para o administrador do site */

$titulo     = "Contato Locado Omega";

$conteudo   = "Ol� administrador, a seguinte pessoa fez contato pelo site :<br><br>";
$conteudo  .= "Nome : <b>$nome</b><br>";
$conteudo  .= "Email : <b>$email</b><br>";
$conteudo  .= "Telefone : <b>$telefone</b><br>";
$conteudo  .= "Cidade : <b>$cidade</b><br><br>";
$conteudo  .= "Coment�rio : <div align=\"justify\">$comentario";

$email = new SendMail($titulo, $conteudo, EMAIL);

$email->goMail();

echo "<script language=javascript>alert('Obrigado, seu contato es'ta sendo encaminhado � nossos administradores.');javascript:history.go(-1);</script>";
?>