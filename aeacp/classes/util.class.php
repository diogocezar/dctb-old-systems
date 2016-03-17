<?
####################################################################
#                      CLASSE PADRAO XCLASSE                       #
####################################################################
#																   #
#	Essa classe tem como objetivo suprir todas as necessidades 	   #
#	básicas que uma página feita em Php que necessite de           #
#   ferramentas para gerenciamento de 3 bancos de dados são eles:  #
#   															   #
#   MySQL														   #
#   PostGre														   #
#   FireBird                                                       #
#																   #
#	Também apresenta as seguintes serramentas :					   #
#																   #
#		1. Uma classe de utilitários diversos*                     #
#		2. Sistema de envio de email							   #
#		3. Utilitários como : Data, Hora, Ip etc... *			   #
#		4. Calendário com Links     							   #
#		5. Sistema de Envio de Fotos              		           #	
#		6. Gerenciamento de SESSIONS                               #
#       7. Gerenciamento de COOKIES      						   #
#																   #
#		*Ver funções da classe Utilitarios						   #
#																   #
####################################################################

/* 

 Classe Util -> Nessa classe estão presentes algumas utilidades necessárias
 para outras funções assim como utilidades para a prorpia página.

 >> Descrição das funções :
 
 1. PegaTempo() -> Pega o tempo no mento da chamada da função.
 
 2. Ip($TIPO = 0) -> Retorna ao Ip [ 0 -> Usuário / 1 -> Servidor ].
 
 3. Data($TIPO = 0) -> Retorna a Data. [ Ver Switch para os Modos ].
 
 4. Codifica($CODIGO) -> Codifica algum número ou string.
 
 5. Sorteia($LIMITE_INFERIOR, $LIMITE_SUPERIOR) -> Sorteia um número 
 entre $LIMITE_INFERIOR e $LIMITE_SUPERIOR.
 
 6. Br($QUEBRA = 1) -> Quebra $QUEBRA linhas.
 
 7. ImprimeArray($ARRAY, $SEPARADOR) -> Imprime um array com $SEPARADOR
 como separação.
 
 8. BuscaArray($ARRAY, $BUSCADO) -> Retorna se $BUSCADO está presente ou naum
 em $ARRAY
 
 9. Hora($SEPARADOR, $TIPO) -> Retorna á hora da chamada da função tipo 0 ->
 horário no formato 12 horas tipo 1 horario no formato 24 horas, mostra o horario
 separado pela string $SEPARADOR
 
 10. PaginaAtual() -> Retorna ao nome da página atual.
 
 11. CodFonte($PAGINA) -> Imprime o código fonte de $PAGINA.
 
*/

require('./includes/configuracao.php');

class Util{

	function PegaTempo(){ 
		list($Sec, $Usec) = explode(" ",microtime()); 
		return ($Sec + $Usec);
	}

	function Ip($TIPO = 0){
		switch($TIPO){
				case 0 : return $_SERVER['REMOTE_ADDR']; break; // Ip do Usuário
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
		$MES_ARRAY[03] = "março";
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
		"Terça",
		"Quarta",
		"Quinta",
		"Sexta",
		"Sábado"
		);
		$EXT_DIA  = $DIA_ARRAY[$DIA_SEMANA];
		$EXT_MES  = $MES_ARRAY[$MES];
		switch($TIPO){
			case 0 : return "$EXT_DIA, $DIA_NUMERO de $EXT_MES de $ANO"; break;// Data total por extenso
			case 1 : return "$EXT_DIA"                                 ; break;// Dia da Semana
			case 2 : return ucfirst($EXT_MES)                          ; break;// Mês extenso
			case 3 : return "$DIA_NUMERO"							   ; break;// Dia do Mês
			case 4 : return "$ANO"        							   ; break;// Ano
			case 5 : return $MES_NUM                       			   ; break;// Mês numerico
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