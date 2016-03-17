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

require('./includes/xconfig.php');

/* $FBIRD -> Array com as configurações MySQL */

$FBIRD['HOST'] = "localhost";
$FBIRD['PATH'] = "C:\Apache\htdocs\bd";
$FBIRD['USER'] = "SYSDBA";
$FBIRD['PASS'] = "masterkey";		
$FBIRD['BASE'] = "VIP"; 

class FireBird{

	function Conectar(){
		global $STYLE, $ERRO, $FBIRD;
		$DATA_BASE = $FBIRD['HOST'].":".$FBIRD['PATH']."\\".$FBIRD['BASE'];
		ibase_connect($DATA_BASE, $FBIRD['USER'], $FBIRD['PASS']) 
		OR die("{$STYLE['ERRO']}".$ERRO[_ERR_CONEXA].ibase_errmsg()."{$STYLE['FECHA']}");
	}//Conectar()
	
	function Query($STRING){ 
		global $ERRO; 
		static $TSQL = '', $EXEC = ''; /* Static faz com que esse valor seja atribuido somente na 1ª execução */
		if($TSQL != $STRING){
			$EXEC = ibase_query($TSQL = $STRING) or die($ERRO[_ERR_EQUERY].ibase_errmsg());
		}
		return $EXEC;
	}//Query
		
	function Close(){
		return ibase_close();	
	}//Close
	
	function Insert($TABELA, $CAMPOS = Array(), $VALORES = Array()){				
		global $ERRO;
		
		if(count($CAMPOS) != count($VALORES) || empty($TABELA)){
			echo $ERRO[_ERR_INSERT]; /* Retorna erro de incompatibilidade (nº de campos diferente do nº de valores para inserir) ou Tabela Vazia */
			return ERRO;
		}
		
		foreach($CAMPOS  as $CAMPO){
			$x++;
			$VIRGULA = ",";
			if($x == count($CAMPOS)){
				$VIRGULA="";
			}
			$FIELDS .= $CAMPO.$VIRGULA;			
		}
		foreach($VALORES as $VALOR){
			$y++;
			$VIRGULA = ",";
			if($y == count($VALORES)){
				$VIRGULA="";
			}
			if($VALOR != NULL || $VALOR != ""){		
				$VALUES .= "'".$VALOR."'".$VIRGULA;
			}
			else{
				$VALUES .= $VALOR.$VIRGULA;
			}
		}
		echo "INSERT INTO $TABELA ($FIELDS) VALUES ($VALUES)"; // debug
		$FireBird = new FireBird;
		$FireBird -> Query("INSERT INTO $TABELA ($FIELDS) VALUES ($VALUES)");		
	}// Insert		
		
	function Deletar($TABELA, $CAMPO, $VALOR){
		global $ERRO;
		$FireBird = new FireBird;
		if(empty($TABELA) || empty($CAMPO) || empty($VALOR)){
			echo $ERRO[_ERR_DELMYS];
			return ERRO;
		}
		else{
			$FireBird -> Query("DELETE FROM $TABELA WHERE $CAMPO = '$VALOR'");
			return OK;
		}//Else
	}// Deletar
		
	function Update($TABELA, $CONDICAO, $CAMPO = Array(), $VALOR = Array()){
		global $ERRO;
		$Util = new Util;
			
		if(count($CAMPO) != count($VALOR) || empty($TABELA)){
			echo $ERRO[_ERR_UPDATE]; /* Retorna erro de incompatibilidade (nº de campos diferente do nº de valores para inserir) ou Tabela Vazia*/
			return ERRO;
		}
		
		$LIMITE = count($CAMPO);
		$SQL = "UPDATE $TABELA SET ";
		$IGUAL = " = ";
		$VIRGULA = ", ";
		for($i=0; $i<$LIMITE; $i++){
			$SQL.= $CAMPO[$i].$IGUAL."'".$VALOR[$i]."'";
			if($i<($LIMITE-1)){
				$SQL.= $VIRGULA;
			}		
		}
		$SQL.= " WHERE $CONDICAO";
		//echo $SQL;
		$FireBird = new FireBird;
		$FireBird -> Query($SQL);		
	}//Update
	
}//FireBird

?>