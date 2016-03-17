<?
/**
* Arquivo de configuraчуo da pсgina inf.
*
* Definindo constantes de configuraчуo
*/

/**
* T I T U L O
*/

define(TITULO, '.: EcoSul :.');

/**
* D I R E T г R I O S    P A R A   A L O C A Ч  У O   D E   A R Q U I V O S
*/

$diretorio['log'] = "../log/log.txt";

$diretorio['cidades'] = "../images/cidades";

$diretorio['ecoturismo'] = "../images/ecoturismos";

$diretorio['atividades'] = "../images/atividades";

/**
* C O N F I G U R A Ч е E S   D O  G E R E N C I A M E N T O 
*/

define(QTD_PAGINAS_SHOW, 10);

define(LIMITE_GENRENCIAR, 150);

define(LIMITE_DESCRICAO, 300);

define(PP_GERENCIAR, 5);

define(FOTOSPP, 50);

define(COLUNAS, 3);

/**
* L I M I T E S    D E   C A R A C T E R E S
*/

define(LIMITE_LOCAL, 40);

define(LIMITE_DESCRICAO_EVENTO, 50);

define(LIMITE_TITULO_NOTICIA, 10);

define(LIMITE_DESCRICAO_NOTICIA, 10);

/**
* T E X T O S   E S T С T I C O S
*/

define(TEXTO_INICIAL, "O Curso de Tecnologia em Desenvolvimento de Sistemas do CEFET-PR / Unidade de Cornщlio Procѓpio tem como objetivo geral a formaчуo de recursos humanos para a automaчуo dos sistemas de informaчуo das organizaчѕes, com vistas a atender as necessidades do mercado de trabalho corrente.");

/**
* M E N U S   D A S   P С G I N A S 
*/

$menu['links']['linkMenu1'] = "index.php";
$menu['links']['linkMenu2'] = "sobre.php";
$menu['links']['linkMenu3'] = "professores.php";
$menu['links']['linkMenu4'] = "disciplinas.php";
$menu['links']['linkMenu5'] = "eventos.php";
$menu['links']['linkMenu6'] = "noticias.php";
$menu['links']['linkMenu7'] = "links.php";

/**
* T A B E L A S   E   S E U S   R E S P E C T I V O S   C A M P O S
*/
			   
/******************************************************************/

$tabela['cidades'] = "cidades";

$campos['cidades'] = array("nomeCidade",
						   "descricaoCidade",
						   "localizacaoCidade",
						   "acessoCidade",
						   "fotosCidade"
					       );
// PK -> idCidade

/******************************************************************/

$tabela['tipoatividade'] = "tipoatividade";

$campos['tipoatividade'] = array("nomeTipoAtividade");

// PK -> idTipoAtividade

/******************************************************************/

$tabela['atividades'] = "atividades";

$campos['atividades'] = array("nomeAtividade",
						      "descricaoAtividade",
						      "localizacaoAtividade",
						      "acessoAtividade",
						      "fotosAtividade",
						      "idTipoAtividade"
					          );							  
// PK -> idAtividades

/******************************************************************/

$tabela['tipoecoturismo'] = "tipoecoturismo";

$campos['tipoecoturismo'] = array("nomeTipoEcoturismo");

// PK -> idTipoEcoturismo

/******************************************************************/

$tabela['ecoturismo'] = "ecoturismo";

$campos['ecoturismo'] = array("nomeEcoturismo",
							  "descricaoEcoturismo",
						      "localizacaoEcoturismo",
							  "acessoEcoturismo",
							  "fotosEcoturismo",
							  "idTipoEcoturismo"
					          );
// PK -> idEcoturismo

/******************************************************************/

/* N -> N */

$tabela['cidadesecoturismo'] = "cidadesecoturismo";

$campos['cidadesecoturismo'] = array("idCidade",
						             "idEcoturismo",
					                 );
/******************************************************************/

/* N -> N */

$tabela['atividadescidades'] = "atividadescidades";

$campos['atividadescidades'] = array("idAtividades",
						             "idCidade",
					                 );
									 
/******************************************************************/
?>