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

/* 

 Classe Util -> Nessa classe est�o presentes algumas utilidades necess�rias
 para outras fun��es assim como utilidades para a prorpia p�gina.

 >> Descri��o das fun��es :
 
 1. PegaTempo() -> Pega o tempo no mento da chamada da fun��o.
 
 2. Ip($TIPO = 0) -> Retorna ao Ip [ 0 -> Usu�rio / 1 -> Servidor ].
 
 3. Data($TIPO = 0) -> Retorna a Data. [ Ver Switch para os Modos ].
 
 4. Codifica($CODIGO) -> Codifica algum n�mero ou string.
 
 5. Sorteia($LIMITE_INFERIOR, $LIMITE_SUPERIOR) -> Sorteia um n�mero 
 entre $LIMITE_INFERIOR e $LIMITE_SUPERIOR.
 
 6. Br($QUEBRA = 1) -> Quebra $QUEBRA linhas.
 
 7. ImprimeArray($ARRAY, $SEPARADOR) -> Imprime um array com $SEPARADOR
 como separa��o.
 
 8. BuscaArray($ARRAY, $BUSCADO) -> Retorna se $BUSCADO est� presente ou naum
 em $ARRAY
 
 9. Hora($SEPARADOR, $TIPO) -> Retorna � hora da chamada da fun��o tipo 0 ->
 hor�rio no formato 12 horas tipo 1 horario no formato 24 horas, mostra o horario
 separado pela string $SEPARADOR
 
 10. PaginaAtual() -> Retorna ao nome da p�gina atual.
 
 11. CodFonte($PAGINA) -> Imprime o c�digo fonte de $PAGINA.
 
*/

require('./includes/configuracao.php');

class Util{

	function PegaTempo(){ 
		list($Sec, $Usec) = explode(" ",microtime()); 
		return ($Sec + $Usec);
	}

	function Ip($TIPO = 0){
		switch($TIPO){
				case 0 : return $_SERVER['REMOTE_ADDR']; break; // Ip do Usu�rio
				case 1 : return $_SERVER['SERVER_ADDR']; break; // Ip do Servidor
		}// Switch
	}// Ip
	
	function Data($TIPO = 0){			
		$DIA_SEMANA = date("w");
		$MES        = date("n");
		$MES_NUM    = date("m");
		$DIA_NUMERO = date("d");
		$ANO        = date("Y");
		$MES_ARRAY[01] = "janeiro";
		$MES_ARRAY[02] = "fevereiro";
		$MES_ARRAY[03] = "mar�o";
		$MES_ARRAY[04] = "abril";
		$MES_ARRAY[05] = "maio";
		$MES_ARRAY[06] = "junho";
		$MES_ARRAY[07] = "julho";
		$MES_ARRAY[08] = "agosto";
		$MES_ARRAY[09] = "setembro";
		$MES_ARRAY[10] = "outubro";
		$MES_ARRAY[11] = "novembro";
		$MES_ARRAY[12] = "dezembro";
		$DIA_ARRAY  = array(
		"Domingo",
		"Segunda",
		"Ter�a",
		"Quarta",
		"Quinta",
		"Sexta",
		"S�bado"
		);
		$EXT_DIA  = $DIA_ARRAY[$DIA_SEMANA];
		$EXT_MES  = $MES_ARRAY[$MES];
		switch($TIPO){
			case 0 : return "$EXT_DIA, $DIA_NUMERO de $EXT_MES de $ANO"; break;// Data total por extenso
			case 1 : return "$EXT_DIA"                                 ; break;// Dia da Semana
			case 2 : return ucfirst($EXT_MES)                          ; break;// M�s extenso
			case 3 : return "$DIA_NUMERO"							   ; break;// Dia do M�s
			case 4 : return "$ANO"        							   ; break;// Ano
			case 5 : return $MES_NUM                       			   ; break;// M�s numerico
		}// Switch
	}// Data
	
	function Codifica($CODIGO){
		return md5($COD);
	}//Codifica
	
	function Sorteia($LIMITE_INFERIOR, $LIMITE_SUPERIOR){
		return rand($LIMITE_INFERIOR, $LIMITE_SUPERIOR);
	}//Sorteia
	
	function Br($QUEBRA = 1){
		for($i=0; $i<$QUEBRA; $i++){
			echo "<br>";
		}//For
	}//Br
	
	function ImprimeArray($ARRAY, $SEPARADOR){
		for($i=0; $i<count($ARRAY); $i++){
			if($ARRAY[$i] != ""){
				if($i == 0){
					echo $ARRAY[$i]." ";
				}
				else{
					echo " ".$SEPARADOR." ".$ARRAY[$i];
				}//Else
			}//IF
		}//For
	}//ImprimeArray	
	
	function BuscaArray($ARRAY, $BUSCADO){
		for($i=0; $i<count($ARRAY); $i++){
			if($ARRAY[$i] == $BUSCADO){
				return OK;
			}
		}
		return ERRO;
	}//BuscaArray
	
	function Hora($SEPARADOR, $FORMATO = 0){ /* $FORMATO -> 0 = 12 horas 1 = 24 horas */
		$HORA_12   = date("h");
		$HORA_24   = date("H");
		$MINUTOS   = date("i");
		$SEGUNDOS  = date("s");
		
		switch($FORMATO){
			case 0 : return $HORA_12.$SEPARADOR.$MINUTOS.$SEPARADOR.$SEGUNDOS; break;
			case 1 : return $HORA_24.$SEPARADOR.$MINUTOS.$SEPARADOR.$SEGUNDOS; break;
		}//Switch
	}//Hora
	
	function PaginaAtual(){
		$PaginaAtual = $_SERVER['PHP_SELF'];
		$Exp = explode('/', $PaginaAtual);
		$Quantos = count($Exp);
		return $Exp[($Quantos-1)];
	}//PaginaAtual
	
	function CodFonte($PAGINA){		
		highlight_string(file_get_contents($PAGINA));
	}//CodFonte
	
	function ReturnCodFonte($PAGINA){
		return file_get_contents($PAGINA);
	}//CodFonte
	
}//Util

?>