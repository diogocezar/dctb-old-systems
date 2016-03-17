<?
####################################################################
#                      CLASSE PADRAO XCLASSE                       #
####################################################################
#																   #
#	Essa classe tem como objetivo suprir todas as necessidades 	   #
#	b�sicas que uma p�gina feita em Php que necessite de           #
#   ferramentas para gerenciamento de 3 bancos de dados s�o eles:  #
#   															   #
#   MySQL														   #
#   PostGre														   #
#   FireBird                                                       #
#																   #
#	Tamb�m apresenta as seguintes serramentas :					   #
#																   #
#		1. Uma classe de utilit�rios diversos*                     #
#		2. Sistema de envio de email							   #
#		3. Utilit�rios como : Data, Hora, Ip etc... *			   #
#		4. Calend�rio com Links     							   #
#		5. Sistema de Envio de Fotos              		           #	
#		6. Gerenciamento de SESSIONS                               #
#       7. Gerenciamento de COOKIES      						   #
#																   #
#		*Ver fun��es da classe Utilitarios						   #
#																   #
####################################################################

require('./includes/configuracao.php');
require('./includes/phpmailer/class.phpmailer.php'); // -> Envio de Email

/* 

 Classe EnviaEmail -> Nessa classe est�o contidas as ferramentas ( fun��es )
 necess�rias para envio de email�s exitem 2 tipos de emails a serem enviados
 as 2 primeiras fun��es utilizam o PHPMAILER e a 3 utiliza a fun��o mail nativa do
 php.
 
 Ps. Para funcionar o PHPMAILER � necess�rio a configura��o de certos par�metros no
 xconfig.php
 

 >> Descri��o das fun��es :
 
 1. EnviaSimples($PARA, $TITULO, $CORPO, $MSG = "YES") -> Envia um email para
 $PARA com $TITULO, com a mensagem $CORPO caso $MSG estaja default "YES" ent�o 
 � exibido na tela as informa��es relativa ao email caso contrario n�o.
 
 2. EnviaComplex($TITULO, $CORPO, $FROM, $NAME , $PARA = Array(), 
 $ANEXOS = Array(), $CORPO_NO_HTML = '', $MSG = "YES") -> Possue as mesmas
 propriedades do EnviaSimples entretanto � possivel com ele enviar a mesma 
 mensagem para um ARRAY de pessoas $PARA = array, e com arquivos anexos notados
 em $ANEXOS = array.
 
 3. EnviaMail($TITULO, $CORPO, $FROM, $PARA, $MSG = "YES") -> Envia um email
 normalmente pela fun��o mail.
 
 
*/


class EnviaEmail{

	function EnviaSimples($PARA, $TITULO, $CORPO, $MSG = "YES"){
	
		global $MAIL, $STYLE, $PHPMAILER_LANG;
		
		$ENVIA = new PHPMailer();
		
		$ENVIA->SetLanguage("br", "./includes/phpmailer/language/"); // Tradu��o para os erros
		
		$ENVIA->IsSMTP(); // Seta como SMTP
		$ENVIA->Host = $MAIL['SMTP']; // Adiciona o host SMTP
		$ENVIA->SMTPAuth = $MAIL['AUTH']; // Sera SMTPAuth como TRUE
		$ENVIA->Username = $MAIL['USER']; // Pega o nome do usu�rio
		$ENVIA->Password = $MAIL['PASS']; // Pega o pass do usu�rio
		
		
		$ENVIA->WordWrap = $MAIL['WRAP']; // Seta o n�mero de WordWrap
		
		$ENVIA->IsHTML($MAIL['HTML']); // Seta o formato de envio como html
		
		/* Inicio da mensagem a ser enviada */
		
		$ENVIA->From = $MAIL['FROM']; // De: Padr�o xconfig.php
		$ENVIA->FromName = $MAIL['NAME']; // Nome: Pad�o xconfig.php
		$ENVIA->AddAddress($PARA); // Define para quem vai o email ( $PARA )
		$ENVIA->Subject = $TITULO; // Assunto ( $TITULO )
		$ENVIA->Body = $CORPO; // Corpo ( $CORPO )

		
		/* Enviando o email */
		
		if(!$ENVIA->Send()){
			echo "{$STYLE['ERRO']}<b>(EnviaEmail)</b>&nbsp;Erro ao enviar e-mail:<br>".$ENVIA->ErrorInfo."{$STYLE['FECHA']}";
			exit;
		}
		else{		
		/* Exibindo a mensagem */
			if($MSG == "YES"){
				echo "{$STYLE['ENVIO']}Sua mensagem foi enviada com sucesso !{$STYLE['FECHA']}";
				$Util = new Util;
				$Util->Br(2);
				echo "{$STYLE['ENVIO']}Para : <b>$PARA</b>{$STYLE['FECHA']}";
				$Util->Br();
				echo "{$STYLE['ENVIO']}Assunto : <b>$TITULO</b>{$STYLE['FECHA']}";
				$Util->Br();
				echo "{$STYLE['ENVIO']}Mensagem : {$STYLE['FECHA']}";
				$Util->Br();
				echo "$CORPO";
			}//If
		}//Else	
	}//EnviaSimples
	
	function EnviaComplex($TITULO, $CORPO, $FROM, $NAME , $PARA = Array(), $ANEXOS = Array(), $CORPO_NO_HTML = '', $MSG = "YES"){
		global $MAIL, $STYLE, $PHPMAILER_LANG;
		
		$ENVIA = new PHPMailer();
		
		$ENVIA->SetLanguage("br", "./includes/phpmailer/language/"); // Tradu��o para os erros
		
		$ENVIA->IsSMTP(); // Seta como SMTP
		$ENVIA->Host = $MAIL['SMTP']; // Adiciona o host SMTP
		$ENVIA->SMTPAuth = $MAIL['AUTH']; // Sera SMTPAuth como TRUE
		$ENVIA->Username = $MAIL['USER']; // Pega o nome do usu�rio
		$ENVIA->Password = $MAIL['PASS']; // Pega o pass do usu�rio
		
		
		$ENVIA->WordWrap = $MAIL['WRAP']; // Seta o n�mero de WordWrap
		
		$ENVIA->IsHTML($MAIL['HTML']); // Seta o formato de envio como html
		
		/* Inicio da mensagem a ser enviada */
		
		if(!empty($FROM)){
			$ENVIA->From = $FROM;
		}
		else{
			$ENVIA->From = $MAIL['FROM']; // De: Padr�o xconfig.php
		}
		
		if(!empty($NAME)){
			$ENVIA->FromName = $NAME;
		}
		else{
			$ENVIA->FromName = $MAIL['NAME']; // Nome: Pad�o xconfig.php
		}
		
		/* Adicionando a lista de emails */		
		for($i=0; $i<count($PARA); $i++){
			$ENVIA->AddAddress($PARA[$i]);
		}		 
		
		/* Adicionando lista de anexos */
		for($i=0; $i<count($ANEXOS); $i++){
			$ENVIA->AddAttachment($ANEXOS[$i]);
		}
		
		$ENVIA->Subject = $TITULO; // Assunto ( $TITULO )
		$ENVIA->Body = $CORPO; // Corpo HTML ( $CORPO )
		$ENVIA->AltBody = $CORPO_NO_HTML; // Corpo TXT ( $CORPO )
		
		/* Enviando o email */
		
		if(!$ENVIA->Send()){
			echo "{$STYLE['ERRO']}<b>(EnviaEmail)</b>&nbsp;Erro ao enviar e-mail:<br>".$ENVIA->ErrorInfo."{$STYLE['FECHA']}";
			exit;
		}
		else{		
		/* Exibindo a mensagem */
			if($MSG == "YES"){
				echo "{$STYLE['ENVIO']}Sua mensagem foi enviada com sucesso !{$STYLE['FECHA']}";
				$Util = new Util;
				$Util->Br(2);
				/* Exibindo lista de emails */
				echo "{$STYLE['ENVIO']}Para : <b>";
				$Util->ImprimeArray($PARA, " - ");
				echo "</b>{$STYLE['FECHA']}";
				
				$Util->Br();
				echo "{$STYLE['ENVIO']}Assunto : <b>$TITULO</b>{$STYLE['FECHA']}";
				$Util->Br();
				
				/* Exibindo anexos se existir */
				if(!empty($ANEXOS)){
					echo "{$STYLE['ENVIO']}Anexos : <b>";
					$Util->ImprimeArray($ANEXOS, " - ");
					echo "</b>{$STYLE['FECHA']}";
				}			
				$Util->Br();
				echo "{$STYLE['ENVIO']}Mensagem : {$STYLE['FECHA']}";
				$Util->Br();
				echo "$CORPO";
			}//If
		}//Else
	}//EnviaComplex
	
	function EnviaMail($TITULO, $CORPO, $FROM, $PARA, $MSG = "YES"){
		$HEADER = "From:$FROM \nContent-type: text/html\n"; 
		if (!mail($PARA, $TITULO, $CORPO, $HEADER)){
			echo "{$STYLE['ERRO']}<b>(EnviaEmail)</b>&nbsp;Erro ao enviar e-mail [ Mail ]{$STYLE['FECHA']}";
			exit;
		}
		else{
			if($MSG == "YES"){
				$Util = new Util;
				echo "{$STYLE['ENVIO']}Sua mensagem foi enviada com sucesso !{$STYLE['FECHA']}";
				$Util->Br();
				echo "{$STYLE['ENVIO']}Para : $PARA<b>";
				$Util->Br();
				echo "{$STYLE['ENVIO']}Assunto : <b>$TITULO</b>{$STYLE['FECHA']}";
				$Util->Br();
				echo "{$STYLE['ENVIO']}Mensagem : {$STYLE['FECHA']}";
				$Util->Br();
				echo "$CORPO";
			}//If
		}//Else
	}//EnviaMail
	
}//EnviaEmail

?>