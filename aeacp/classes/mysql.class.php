<?php
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

 Classe Mysql -> Nessa classe est�o presentes fun��es que facilitam
 a conex�o, inser��o e atualiza��o dos dados em um banco de dados MySQL

 >> Descri��o das fun��es :
 
 1. Conectar() -> Conecta ao banco de dado MySQL e seleciona o banco de 
 acordo com as configura��es definidas no arquivo /includes/xconfig.php.
 
 2. Query($STRING, $RESULT = "array") -> Faz uma consulta de query ao 
 banco de dados e retorna de acordo com a op��o selecionada em $RESULT.
 
 3. Close() -> Fecha a conec��o feita em Conectar().
 
 4. Insert($TABELA, $CAMPOS = Array(), $VALORES = Array()) -> Insere na
 tabela $TABELA que possue os campos em um array $CAMPOS, os valores do
 array $VALORES.
 
 5. Deletar($TABELA, $CAMPO, $VALOR) -> Deleta do banco de dados os dados
 que estiverem na $TABELA ONDE $CAMPO = $VALOR.
 
 6. Update($TABELA, $CONDICAO, $CAMPOS = Array(), $VALORES = Array()) ->
 Atualiza determinada $TABELA somente se atender a $CONDIC�O, SETA $VALORES
 nos $CAMPOS ( Arrays ).
 
*/

/* $MYSQL -> Array com as configura��es MySQL */

class MySQL{

	function Conectar(){
		global $MYSQL, $STYLE, $ERRO;				
		$LINK = mysql_connect($MYSQL['HOST'], $MYSQL['USER'], $MYSQL['PASS'])
		OR die("{$STYLE['ERRO']}".$ERRO[_ERR_CONEXA].mysql_error()."{$STYLE['FECHA']}");	
			
	    mysql_select_db($MYSQL['BASE'], $LINK)
	    OR die("{$STYLE['ERRO']}".$ERRO[_ERR_SELECT].mysql_error()."{$STYLE['FECHA']}");
	}//Conectar()
	
	function Query($STRING, $RESULT = "_nenhum"){ 
		global $ERRO; 
		static $TSQL = '', $EXEC = ''; /* Static faz com que esse valor seja atribuido somente na 1� execu��o */
		if($TSQL != $STRING){
			$EXEC = mysql_query($TSQL = $STRING) or die($ERRO[_ERR_EQUERY].mysql_error()); 
		}
		switch ($RESULT){ 
			case '_array': 
				return mysql_fetch_array($EXEC); 
			break; 
			case '_rows': 
				return mysql_num_rows($EXEC);      
			break; 
			case _nenhum: 
				return $EXEC;                      
			break;
		}//Switch 
	}//Query
		
	function Close(){
		return mysql_close();	
	}//Close
	
	function Insert($TABELA, $CAMPOS = Array(), $VALORES = Array()){				
		global $ERRO;
	
		if(count($CAMPOS) != count($VALORES) || empty($TABELA)){
			echo $ERRO[_ERR_INSERT]; /* Retorna erro de incompatibilidade ou Tabela Vazia */
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
			$VALUES .= "\"".$VALOR."\"".$VIRGULA;
		}
		$MySQL = new MySQL;
		$MySQL -> Query("INSERT INTO $TABELA ($FIELDS) VALUES ($VALUES)");					
	}// Insert		
		
	function Deletar($TABELA, $CAMPO, $VALOR){
		global $ERRO;
		$MySQL = new MySQL;
		
		$MySQL -> Query("DELETE FROM $TABELA WHERE $CAMPO = '$VALOR'");
		return OK;
	}// Deletar
		
	function Update($TABELA, $CONDICAO, $CAMPO = Array(), $VALOR = Array()){
		global $ERRO;
			
		if(count($CAMPO) != count($VALOR) || empty($TABELA)){
			echo $ERRO[_ERR_UPDATE]; /* Retorna erro de incompatibilidade ou Tabela Vazia*/
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
		$MySQL = new MySQL;
		$MySQL -> Query($SQL);		
	}//Update
	
}//MySQL

?>