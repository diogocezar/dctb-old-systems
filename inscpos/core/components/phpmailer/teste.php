<? require_once("../phpmailer/class.phpmailer.php"); ?>

<?
$corpo = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">" .
"<html xmlns=\"http://www.w3.org/1999/xhtml\">" .
"<head>" .
"<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />" .
"<title>Pesquisa de Satisfação</title>" .
"</head>" .
"<body>" .
"<h1>Pesquisa de satisfação sobre o site da UTFPR</h1>" .
"<p>A UTFPR iniciou ontem, 25, uma pesquisa de satisfação sobre o  site da instituição, tanto da Reitoria quanto dos Campi. </p>" .
"<p>A pesquisa, que irá <strong>até o dia 31 de maio (domingo)</strong>, objetiva levantar sugestões e necessidades dos visitantes das páginas para compor o planejamento do projeto do novo portal.</p>" .
"<p>Todos podem participar da pesquisa, alunos da instituição ou não, servidores, comunidade externa, e sua opinião será de grande valia para a equipe responsável pelo novo projeto.</p>" .
"<p>Por isso, você que já utilizou de nosso site para pesquisar alguma informação ou inscrever-se em algum de nossos cursos e eventos é convidado especial a participar desta pesquisa.</p>" .
"<p><a href=\"http://spreadsheets.google.com/viewform?formkey=cmRoeTNvZ3Jrd1ZnRFMtXzhVY0ZIamc6MA\">Clique aqui para participar respondendo nossa pesquisa.</a></p>" .
"<p>Agradecemos desde já sua atenção e colaboração.</p>" .
"<p><a href=\"http://www.ld.utfpr.edu.br/\">UTFPR Londrina</a></p>" .
"<p>Obs.: caso não queira mais receber e-mails sobre pesquisas da instituição, responda-nos indicando.</p>" .
"</body>" .
"</html>";
?>

<?

		$email_para = "xgordo@gmail.com";
		
		$mail = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host = "smtp.utfpr.edu.br"; // SMTP server
		$mail->From = "assinfdsv-cp@utfpr.edu.br";
		$mail->FromName = "UTFPR - Campus Corn�lio Proc�pio";
		$mail->AddAddress($email_para);
		$mail->Subject = "Testando";
		$mail->Body = $corpo;
		$mail->CharSet = "utf-8";
		$mail->ContentType = "text/html";
		//$mail->ConfirmReadingTo = "correio-ld@utfpr.edu.br";
		
		/* comentado para evitar execução acidental do script */
		if(!$mail->Send())
		{
		   echo "Mensagem nao enviada para " . $email_para . "<br />";
		   echo "Mailer Error: " . $mail->ErrorInfo . "<br />";
		} else {
		   echo "Mensagem enviada para " . $email_para . "<br />";
		}

?>