<?php
/**
* Arquivo de configuração da página.
*
* Definindo constantes de configuração
*/

/**#@+
* Constantes
*/

/**
* T Í T U L O
*/
define(TITULO, 'Promotos');
define(TITULO_KOMPRE, "Kompre - v1.0");

/**
* L I N K S 
*/
define(HOME, 'http://www.promotos.com.br');

/**
* Q U A N T I D A D E   D E   Í T E N S   P O R   P Á G I N A   -   A D M I N I S T R A Ç Ã O
*/

define(PP_PRODUTOS, 20);
define(PP_CATEGORIAS, 20);
define(PP_FABRICANTES, 20);
define(PP_ADMINISTRADORES, 20);

/**
* Q U A N T I D A D E   D E   L E R T R A S   P O R   I T E M   -   A D M I N I S T R A Ç Ã O
*/

define(LIMITE_GENRENCIAR, 100);

/**
* Q U A N T I D A D E   D E   P Á G I N A S  -   A D M I N I S T R A Ç Ã O
*/

define(QTD_PAGINAS_SHOW, 10);

/**
* D I R E T Ó R I O S    P A R A   A L O C A Ç  Ã O   D E   A R Q U I V O S
*/

$diretorio['produtos'] = "../images/produtos";

$diretorio['banners']  = "../config/banners.ini";

$diretorio['opcoes']   = "../config/opcoes.ini";

$diretorio['logs']     = "../log/log.txt";

/**
* T O P S   D O   S H O W R O O M
*/


$top[1]['imag'] = "<img src=\"../images/superOfertas.gif\" border=\"0\">";
$top[1]['link'] = "ofertas.php";

$top[2]['imag'] = "<img src=\"../images/novosProdutos.gif\" border=\"0\">";
$top[2]['link'] = "novosProdutos.php";

/**
* L I N K / A L T   D O S   C R E D I T O S
*/

define(CREDITOS, "http://www.kreea.com.br");
define(ALT_CREDITOS, "Kreea");
define(KOMPRE, "http://kompre.kreea.com.br");
define(ALT_KOMPRE, "Kompre 1.0");

/**
* M E N U  P R I N C I P A L
*/

$menuPrincipal = array("Principal"      => "index.php",
                       "Novos Produtos" => "novosProdutos.php",
					   "Ofertas"        => "ofertas.php",
					   "Fabricantes"    => "mostraFabricantes.php",
					   "Categorias"     => "mostraCategorias.php",
					   "Contato"        => "../../php/contato.php"
					   );

/**
* M E N U  A D M I N I S T R A Ç Ã O
*/

$menuAdmin = array(
                   "Produtos" => array(
					   "Inserir produto"     => "produto.php?acao=adicionar",
					   "Gerenciar produtos"  => "produtos.php",
				   ),
				   "Categorias" => array(
					   "Inserir categoria"    => "categoria.php?acao=adicionar",
					   "Gerenciar categorias" => "categorias.php",
				   ),
				   "Fabricantes" => array(
					   "Inserir fabricante"    => "fabricante.php?acao=adicionar",
					   "Gerenciar fabricantes" => "fabricantes.php",
				   ),
				   "Configurações" => array(
					   "Configurações Gerais"      => "configuracoes.php",
					   "Inserir administrador"     => "administrador.php?acao=adicionar",
					   "Gerenciar administradores" => "administradores.php",
				   )
		     );

/**
* T A B E L A S   E   S E U S   R E S P E C T I V O S   C A M P O S
*/

$tabela['administradores'] = "kom_Administradores";

$campos['administradores'] = array("adm_nome",
                                   "adm_email",
						           "adm_login",
						           "adm_senha"
					               );
// PK -> adm_cod

/******************************************************************/


$tabela['fotos'] = "kom_fotos";

$campos['fotos'] = array("fot_url"
					     );
// PK -> fot_cod

/******************************************************************/

$tabela['fabricantes'] = "kom_fabricantes";

$campos['fabricantes'] = array("fab_nome",
						       "fab_telefone",
						       "fab_website"
					           );
// PK -> fab_cod

/******************************************************************/

$tabela['categorias'] = "kom_categorias";

$campos['categorias'] = array("cat_nome",
						      "cat_descricao"
					          );
// PK -> cat_cod

/******************************************************************/

$tabela['produtos'] = "kom_produtos";

$campos['produtos'] = array("pro_nome",
						    "pro_peso",
							"pro_preco",
							"pro_qtd",
							"pro_disponibilidade",
							"pro_classificacao",
							"pro_promocao",
							"pro_descricao",
							"pro_especificacao",
							"pro_dados_tecnicos",
							"pro_itens_inclusos",
							"pro_garantia",
							"cat_cod",
							"fab_cod"
					        );
// PK -> pro_cod
// TS -> pro_quando

/******************************************************************/

$tabela['produtos_fotos'] = "kom_produtos_fotos";

$campos['produtos_fotos'] = array("pro_cod",
						          "fot_cod",
								  "pro_fot_principal"
					        );

/******************************************************************/
?>