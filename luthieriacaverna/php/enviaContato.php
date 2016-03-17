<?php
/* setando tempo limite da p�gina para infinito (Caso o email demore para ser enviado) */
set_time_limit(0);

/**
* arquivo de configura��o
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* biblioteca de funcoes
*/
include('../lib/library.php');
include('../lib/util.php');

$nome      = $_POST['nome'];
$email     = $_POST['email'];
$assunto   = $_POST['assunto'];
$mensagem  = converteQuebra($_POST['mensagem']);

/* enviando o email para o administrador do site */

$titulo     = "Contato Luthieria Caverna";

$conteudo   = "Ol� administrador, a seguinte pessoa fez contato pelo site :<br><br>";
$conteudo  .= "Nome : <b>$nome</b><br>";
$conteudo  .= "Email : <b>$email</b><br>";
$conteudo  .= "Assunto : <b>$assunto</b><br>";
$conteudo  .= "Coment�rio : <div align=\"justify\">$mensagem</div>";

$email = $controlador['sendmail'];
$email->__go_SendMail($titulo, $conteudo, EMAIL);
$email->goMail();

echo "<script language=javascript>alert('Obrigado, seu contato est� sendo encaminhado � nossos administradores.');history.go(-1);</script>";
?>