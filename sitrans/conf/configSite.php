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
define(TITULO, 'Sitrans '.date('Y'));

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

$diretorio['logCliente'] = "../log/logCliente.txt";

/**
* C O N F I G U R A � � E S   D O  G E R E N C I A M E N T O 
*/

define(QTD_PAGINAS_SHOW, 10);

define(LIMITE_GENRENCIAR, 65);

define(PP_GERENCIAR, 10);

/**
* C R � D I T O S
*/

define(CREDITOS, "SITRANS ".date('Y')." / Copyright � xbrain.com.br");

define(CREDITOS_CLIENTE, "Todos os direitos reservados - Sitrans ".date("Y")."<br />XBRAIN - Solu��es inteligentes para problemas complexos.");

/**
* T E X T O   L O G I N
*/

define(TEXTO_LOGIN, "Caro Colaborador seja bem vindo(a)! <br><br> <p align=\"justify\">Visando uma melhoria no processo da empresa, estamos colocando no ar uma nova forma de controle, caso tenha alguma d�vida, por favor entre em contato conosco.</p><br> Att.<br> Ger�ncia.");

define(INSTRUCOES_CLIENTE, "Bem vindo ao sistema de coletas Aguias Unidas. Qualquer d�vida contate-nos pelo telefone: (43) 3027-6800");

define(TEXTO_LOGIN_CLIENTE, "Tenha total controle das coletas de sua empresa! <br><br> Com o objetivo de tornar sua vida mais f�cil, desenvolvemos  um sistema simples para o agendamento e gerenciamento de suas coletas. <br><br> Obrigado por utilizar os nossos servi�os.");

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

/* array dos campos que n�o v�o ficar mai�sculos */
$arrayNoToUp = array('pessoa', 'email', 'conhecimentos');

/* configurac�es dos relat�rios */

$relTipos = array('sintetico'       => 'Sint�tico',
				  'analitico'       => 'Anal�tico',
    			  'performace'      => 'Performace',
				  'detalhes_coleta' => 'Detalhes das Coletas');
				  
$relDescSinte = array('total_coletas' => 'Total de Coletas',
					  'total_notas'   => 'Total de Notas Fiscais',
					  'total_peso'    => 'Total de Peso (kgs)',
					  'total_volumes' => 'Total de Volumes');
					  
$relReplaceStatus = array('CANCELADO'    => 'Coletas Canceladas',
                          'REMANEJADO'   => 'Coletas Remanejadas',
						  'EM ANDAMENTO' => 'Coletas Em Andamento',
						  'CADASTRADO'   => 'Coletas Cadastradas',
						  'BAIXADO'      => 'Coletas Baixadas',
						  'PENDENTE'     => 'Coletas Pendentes',
						  'REAGENDADO'   => 'Coletas Reagendadas');
?>