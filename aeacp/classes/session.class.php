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

/* 

 Classe Session -> Nessa classes est�o contida as ferramentas ( fun��es )
 necess�rias para a inicializa��o, inser��o, verifica��o e retirada de 
 session

 >> Descri��o das fun��es :
 
 1. IniciaSession() -> Inicia uma session.
 
 2. GravaSession($NOME, $VALOR) -> Grava determinada session de acordo com
 seu $NOME e se $VALO.
 
 3. ExisteSession($NOME) -> Verifica se a session existe retorna OK case exista
 ou ERRO caso n�o exista.
 
 4. VeriSession($NOME, $VALOR) -> Verifica se a session $NOME possue o $VALOR
 em caso afirmativo retorna OK em caso negativo retorna ERRO.
 
 5. DeletaSession($NOME) -> Deleta uma session com o seguinte nome $NOME.
 
 6. LimpaSession() -> Limpa todas as sessions.
 
*/


class Session{

	function RetornaSession($NOME){
		return $_SESSION[$NOME];
	}//retornaSession

	function IniciaSession(){
		return session_start();
	}//IniciaSession

	function GravaSession($NOME, $VALOR){
		global $ERRO;
		if(empty($NOME) || empty($VALOR)){
			echo $NOME.' -- '.$VALOR;
			echo $ERRO[_ERR_SESION];
			return ERRO;
		}
		else{
			$_SESSION[$NOME] = $VALOR;
			return OK;
		}//Else
	}//GravaSession
	
	function ExisteSession($NOME){
		if(!empty($_SESSION[$NOME])){
			return OK;
		}
		else{
			return ERRO;
		}//Else
	}//ExisteSession
	
	function VeriSession($NOME, $VALOR){
		global $ERRO;
		if(empty($NOME) || empty($VALOR)){
			echo $ERRO[_ERR_VERSES];
			return ERRO;
		}
		else{
			if($_SESSION[$NOME] == $VALOR){
				return OK;
			}
			else{
				return ERRO;
			}//Else
		}//Else
	}//VeriSession
	
	function DeletaSession($NOME){
		global $ERRO;
		if(empty($NOME)){
			echo $ERRO[_ERR_DELSES];
			return ERRO;
		}
		else{
			unset($_SESSION[$NOME]);
			return OK;
		}//Else
	}//DeletarSession
	
	function LimpaSession(){
		return session_unset();
	}//LimpaSession

}//Session

?>