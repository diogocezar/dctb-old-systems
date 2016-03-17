<?
/**
* Arquivo de configura��o da p�gina.
*
* Definindo constantes de configura��o
*/

/**
* T I T U L O
*/

define(TITULO, '- R & R Decora��es -');

/**
* T E X T O   P � G I N A   P R I N C I P A L
*/

define(TEXTO_PRINCIPAL, 'Testando.');

/**
* T E X T O   N E W S L E T T E R 
*/

define(TEXTO_NEWSLETTER, 'Testando.');
/**
* � T E M   P O R   P � G I N A 
*/

define(PP_GERAL, 10);

/**
* N � M E R O   D E   P � G I N A S
*/

define(QTD_PAGINAS_SHOW, 10);

/**
* T A M A N H O   D A   F R A Z E  
*/

define(TAMANHO_FRAZE, 50);

/**
* T A M A N H O   D O   � T E M
*/

define(LIMITE_GENRENCIAR, 150);

/**
* E M A I L 
*/

define(EMAIL, 'contato@rrdecoracoes.com.br');

/**
* D I R E T � R I O S    P A R A   A L O C A �  � O   D E   A R Q U I V O S
*/

$diretorio['log'] = "../log/log.txt";

/**
* P � G I N A S   D O   S I T E 
*/
$paginas = array("principal"   => "principal.php",
				 "login"       => "login.php"
				 );
				 
$nPaginas = "conteudo";


/**
* T A B E L A S   E   S E U S   R E S P E C T I V O S   C A M P O S
*/
			   
/******************************************************************/

$tabela['administradores'] = "administradores";

$campos['administradores'] = array("nomeAdministrador",
						           "loginAdministrador",
						           "senhaAdministrador"
					               );
// PK -> idAdministrador

/******************************************************************/

$tabela['visitantes'] = "visitantes";

$campos['visitantes'] = array("nomeVisitante",
						      "cidadeVisitante",
						      "emailVisitante",
					          );
// PK -> idVisitante

/******************************************************************/

$tabela['configuracoes'] = "configuracoes";

$campos['configuracoes'] = array("textoInstitucional");

/******************************************************************/

$tabela['novidades'] = "novidades";

$campos['novidades'] = array("tituloNovidade",
						     "descricaoNovidade",
					         );
// PK -> idNovidade
// TS -> quandoNovidade

/******************************************************************/

$tabela['servicos'] = "servicos";

$campos['servicos'] = array("nomeServico",
						    "descricaoServico",
					        );
// PK -> idServico

/******************************************************************/

$tabela['clientes'] = "clientes";

$campos['clientes'] = array("nomeCliente",
						    "urlCliente",
					        );
// PK -> idCliente

/******************************************************************/
?>