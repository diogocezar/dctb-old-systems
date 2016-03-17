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

require('./includes/xconfig.php');

/* 

 Classe Cookie -> Nessa classes est�o contida as ferramentas ( fun��es )
 necess�rias para a inser��o, verifica��o e retirada de cookies.

 >> Descri��o das fun��es :
 
 1. GravaCookie($NOME, $VALOR, $EXPIRE = 3600, $PATH = 'DEFAULT', $DOMAIN = 'DEFAULT', $SECURE = 0)->
 Grava determinada cookie, os valores requeridos s�o somente $NOME e $VALOR os demias valores est�o
 como default.
 
 2. ExisteCookie($NOME) -> Verifica se a cookie existe retorna OK case exista
 ou ERRO caso n�o exista.
 
 3. VeriCookie($NOME, $VALOR) -> Verifica se a cookie $NOME possue o $VALOR
 em caso afirmativo retorna OK em caso negativo retorna ERRO.
 
 4. DeletaCookie($NOME) -> Deleta uma cookie com o seguinte nome $NOME.
 
*/

class Cookie{

	function GravaCookie($NOME, $VALOR, $EXPIRE = 3600, $PATH = 'DEFAULT', $DOMAIN = 'DEFAULT', $SECURE = 0){
		global $ENDERECO, $ERRO;
		
		if($DOMAIN == 'DEFAULT'){
			$DOMAIN = $ENDERECO['DOMAIN'];
		}
		if($PATH == 'DEFAULT'){
			$PATH = $ENDERECO['PATCH'];
		}
		
		if(empty($NOME) || empty($VALOR)){
			echo $ERRO[_ERR_COOKIE];
			return ERRO;
		}
		else{
			$EXPIRE += time();
			setcookie($NOME, $VALOR, $EXPIRE, $PATH, $DOMAIN);
			return OK;
		}//Else
	}//GravaCookie
	
	function ExisteCookie($NOME){
		if(!empty($_COOKIE[$NOME])){
			return OK;
		}
		else{
			return ERRO;
		}//Else
	}//ExisteCookie
	
	function VeriCookie($NOME, $VALOR){
		global $ERRO;
		if(empty($NOME) || empty($VALOR)){
			echo $ERRO[_ERR_VERCOO];
			return ERRO;
		}
		else{
			if($_COOKIE[$NOME] == $VALOR){
				return OK;
			}
			else{
				return ERRO;
			}//Else
		}//Else
	}//VeriCookie
	
	function DeletaCookie($NOME, $VALOR, $PATH = 'DEFAULT', $DOMAIN = 'DEFAULT', $SECURE = 0){
		global $ERRO;
		if(empty($NOME)){
			echo $ERRO[_ERR_DELCOO];
			return ERRO;
		}
		else{
			$EXPIRE = 0;
			setcookie($NOME, $VALOR, $EXPIRE, $PATH, $DOMAIN);
			return OK;
		}//Else
	}//DeletarCookie	

}//Cookie

?>