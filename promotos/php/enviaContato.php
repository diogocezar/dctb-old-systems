<?php
/* Setando tempo limite da página para infinito (Caso o email demore para ser enviado) */
set_time_limit(0);

/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendMail.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

@$session = new Session();

$permitido = false;

$nome       = $_POST['nome'];
$email      = $_POST['email'];
$assunto    = $_POST['assunto'];
$mensagem   = converteQuebra($_POST['mensagem']);

/* Enviando o email para o administrador do site */

$titulo     = "Contato Promotos";

$conteudo   = "Olá administrador, a seguinte pessoa fez contato pelo site :<br><br>";
$conteudo  .= "Nome : <b>$nome</b><br>";
$conteudo  .= "Email : <b>$email</b><br>";
$conteudo  .= "Assunto : <b>$assunto</b><br>";
$conteudo  .= "Mensagem : <div align=\"justify\">$mensagem</div>";

$email = new SendMail($titulo, $conteudo, EMAIL, $email);

$email->goMail();

echo "<script language=javascript>alert('Obrigado, seu contato está sendo encaminhado à nossos administradores.');history.go(-1);</script>";
?>