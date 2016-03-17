<?php
include("start-brain.php");
$emailsAdm = "diogo@diogocezar.com";
$origem = "geppg-cp@utfpr.edu.br";
$autor = "DIRPPG";
$msgFinal = "testando mensagem final";
$templateHtmlDir = "../view/html/";
$templateHtmlName = "mail.html";
$titulo_email = "GEPPG - Um novo cadastro foi efetuado";
$mail = $brain_controller['sendmail'];
$mail->prepareMail("teste", "teste", $emailsAdm, $origem, $autor, $msgFinal, $templateHtmlDir, $templateHtmlName);
if($mail->goMail()){
	echo "E-mail enviado com sucesso.";	
}
else{
	echo "Não pode ser enviado o email.";
}
?>