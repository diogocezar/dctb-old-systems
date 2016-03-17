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

require('./includes/configuracao.php');

/* 

 Calendário -> Nessa classe está contida uma função que monta um calendário
 através dos parâmetros passados

 >> Descrição das funções :
 
 1. function Cria($DIA, $MES, $ANO, $ARRAY_DIA = Array(), $ARRAY_LINK = Array())
 
 $DIA -> Dia do mes a ser montado.
 $MES -> Mês a ser montado.
 $ANO -> Ano a ser montado.
 $ARRAY_DIA -> Array com os dias que irão conter links
 $ARRAY_LINK -> Link dos dias
  
*/

class Calendario{ 

   var $Mes = array(
   '1'=>'Janeiro',
   '2'=>'Fevereiro',
   '3'=>'Março',
   '4'=>'Abril',
   '5'=>'Maio',
   '6'=>'Junho',
   '7'=>'Julho',
   '8'=>'Agosto',
   '9'=>'Setembro',
   '10'=>'Outubro',
   '11'=>'Novembro',
   '12'=>'Dezembro');
   
   function Cria($DIA, $MES, $ANO, $ARRAY_DIA = Array(), $ARRAY_LINK = Array()){ 
   
      global $STYLE;
	  
	  $Corrige = date ("d/n/Y", mktime (0, 0, 0, $MES, $DIA ,$ANO));//Corrige qualquer data invalida 
      $Pronto = explode("/" , $Corrige); 
	  
      $DIA = $Pronto[0]; 
      $MES = $Pronto[1]; 
      $ANO = $Pronto[2];
	   
      $Last = date("d", mktime (0, 0, 0, $MES+1, 0, $ANO));//Inteiro do ultimo dia do mês 
      $Diasem = date("w", mktime (0, 0, 0, $MES, 1, $ANO));//Numero de dias na primeira semana do mês 
	  
      $Numt = $Last + $Diasem; //Total de linhas na tabela 
      $Numt = ($Numt%7 != 0)?($Numt+7-$Numt%7):$Numt;
	  
	  if(!empty($ARRAY_DIA) && !empty($ARRAY_LINK)){
		   
			for($i=0; $i < $Numt; $i++){ 
			
				$Data = $i - $Diasem + 1;
					 
				if($i >= $Diasem && $i < ($Diasem+$Last)){ 
				
					if($i%7 != 0){
						for($j=0; $j<count($ARRAY_DIA); $j++){
							if($ARRAY_DIA[$j] == $Data){
								$Aux[$i] = "\n<td width=\"20\"><a href = \"{$ARRAY_LINK[$j]}\">{$STYLE['CALEN_FONTE']}$Data{$STYLE['FECHA']}</a></td>"; 
								break;
							}
							else{
								$Aux[$i] = "\n<td width=\"20\">{$STYLE['CALEN_FONTE']}$Data{$STYLE['FECHA']}</td>"; 
							}
						}
					}
				
					else{ 
						for($j=0; $j<count($ARRAY_DIA); $j++){
							if($ARRAY_DIA[$j] == $Data){
								$Aux[$i] = "\n<td width=\"20\"><a href = \"{$ARRAY_LINK[$j]}\">{$STYLE['CALEN_DOMINGO']}$Data{$STYLE['FECHA']}</a></td>"; 
								break;
							}
							else{
								$Aux[$i] = "\n<td width=\"20\">{$STYLE['CALEN_DOMINGO']}$Data{$STYLE['FECHA']}</td>"; 
							}
						}
					} 
				}
				else{ 
					$Aux[$i] = "\n<td width=\"20\">&nbsp;</td>"; 
				}
				 
				if($i%7 == 0){ 
					$Aux[$i] = "<tr align=\"center\" bgcolor=\"{$STYLE['CALEN_BGCOLOR']}\">".$Aux[$i]; 
				} 
				if($i%7 == 6){ 
					$Aux[$i].= "</tr>\n"; 
				} 
			}			  
	  	}
	  
	  else{
	   
			for($i=0; $i < $Numt; $i++){ 
			
				$Data = $i - $Diasem + 1;
					 
				if($i >= $Diasem && $i < ($Diasem+$Last)){ 
				
					if($i%7 != 0){
						$Aux[$i] = "\n<td width=\"20\">{$STYLE['CALEN_FONTE']}$Data{$STYLE['FECHA']}</td>"; 
					}
				
					else{ 
						$Aux[$i] = "\n<td width=\"20\">{$STYLE['CALEN_DOMINGO']}$Data{$STYLE['FECHA']}</td>"; 
					} 
				}
				
				else{ 
					$Aux[$i] = "\n<td width=\"20\">&nbsp;</td>"; 
				}
				 
				if($i%7 == 0){ 
					$Aux[$i] = "<tr align=\"center\" bgcolor=\"{$STYLE['CALEN_BGCOLOR']}\">".$Aux[$i]; 
				} 
				if($i%7 == 6){ 
					$Aux[$i].= "</tr>\n"; 
				} 
	  	   }			  
	  }

      echo "<table border=\"1\"  cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"{$STYLE['CALEN_BORDER']}\"> 
               <tr> 
                  <td> 
                     <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"> 
                        <tr bgcolor=\"{$STYLE['CALEN_CORFUNDO']}\" align=\"center\"> 
                           <td width=\"100%\" colspan=\"7\">{$STYLE['CALEN_TITULO']}<b>".$this->Mes[$MES]."&nbsp;$ano</b>{$STYLE['FECHA']}</i></td> 
                        </tr> 
                        <tr bgcolor=\"{$STYLE['CALEN_CORFUNDO']}\" align=\"center\"> 
                           <td width=\"20\">{$STYLE['CALEN_FONTE']}D{$STYLE['FECHA']}</td> 
                           <td width=\"20\">{$STYLE['CALEN_FONTE']}S{$STYLE['FECHA']}</td> 
                           <td width=\"20\">{$STYLE['CALEN_FONTE']}T{$STYLE['FECHA']}</td> 
                           <td width=\"20\">{$STYLE['CALEN_FONTE']}Q{$STYLE['FECHA']}</td> 
                           <td width=\"20\">{$STYLE['CALEN_FONTE']}Q{$STYLE['FECHA']}</td> 
                           <td width=\"20\">{$STYLE['CALEN_FONTE']}S{$STYLE['FECHA']}</td> 
                           <td width=\"20\">{$STYLE['CALEN_FONTE']}S{$STYLE['FECHA']}</td> 
                       </tr>"; 
					   
      				   echo implode(" ",$Aux); 
      				   echo
		            "</table> 
                  </td> 
               </tr> 
            </table>"; 
   }//Cria 
   
}//Calendario

?>