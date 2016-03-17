<?php
/**
* Arquivo de configura��o da p�gina.
*
* Definindo constantes de configura��o
*/

/**#@+
* Constantes
*/

/**
* T � T U L O
*/
define(TITULO, 'Sifin '.date('Y'));

/**
* E M A I L   D O   A D M I N I S T R A D O R
*/
define(EMAIL, '');


/**
* L I N K S 
*/
define(HOME, '');

					   
/**
* D I R E T � R I O S
*/

$diretorio['log'] = "../log/log.txt";

/**
* C O N F I G U R A � � E S   D O  G E R E N C I A M E N T O 
*/

define(QTD_PAGINAS_SHOW, 10);

define(LIMITE_GENRENCIAR, 65);

define(PP_GERENCIAR, 10);

/**
* C R � D I T O S
*/

define(CREDITOS, "SIFIN ".date('Y')." / Copyright � xbrain.com.br");

/**
* T E X T O   L O G I N
*/

define(TEXTO_LOGIN, "Caro Colaborador seja bem vindo(a)! <br><br> <p align=\"justify\">Visando uma melhoria no processo da empresa, estamos colocando no ar uma nova forma de controle, caso tenha alguma d�vida, por favor entre em contato conosco.</p><br> Att.<br> Ger�ncia.");

/**
* E S T A D O S   B R A S I L E I R O S
*/

$estados     = array("AC" => "Acre",
					 "AL" => "Alagoas",
					 "AM" => "Amazonas",
					 "AP" => "Amap&aacute;",
					 "BA" => "Bahia",
					 "CE" => "Cear&aacute;",
					 "DF" => "Distrito Federal",
					 "ES" => "Espirito Santo",
					 "GO" => "Goi&aacute;s",
					 "MA" => "Maranh&atilde;o",
					 "MG" => "Minas Gerais",
					 "MS" => "Mato Grosso do Sul",
					 "MT" => "Mato Grosso",
					 "PA" => "Par&aacute;",
					 "PB" => "Paraiba",
					 "PE" => "Pernambuco",
					 "PI" => "Piaui",
					 "PR" => "Paran&aacute;",
					 "RJ" => "Rio de Janeiro",
					 "RN" => "Rio Grande do Norte",
					 "RO" => "Rond&ocirc;nia",
					 "RR" => "Roraima",
					 "RS" => "Rio Grande do Sul",
					 "SC" => "Santa Catarina",
					 "SE" => "Sergipe",
					 "SP" => "S&atilde;o Paulo",
					 "TO" => "Tocantins"
					);

$estadosPadrao = "PR";

?>