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
define(TITULO, ':: Locadora Omega ::');

/**
* E M A I L   D O   A D M I N I S T R A D O R
*/
define(EMAIL, 'no-reply@locadoraomega.com.br');


/**
* L I N K S 
*/
define(HOME, 'http://www.locadoraomega.com.br');

/**
* Q U A N T I D A D E   D E   P A G I N A S   A   M O S T R A R
*/

define(QTD_PAGINAS_SHOW, 18);

/**
* Q U A N T I D A D E   D E   � T E N S   P  O R   P � G I N A
*/

define(PP_ADMIN, 20);
define(PP_ATORES, 50);
define(PP_CATEGORIA, 20);
define(PP_CLASSIFICACAO, 20);
define(PP_ENQUETE, 20);
define(PP_FILMES, 50);
define(PP_GENERO, 20);
define(PP_MIDIA, 50);
define(PP_NOVIDADES, 50);
define(PP_PRODUTOS, 20);
define(PP_TAXAS, 20);
define(PP_TIPOS, 20);
define(PP_MOSTRA_FILMES, 20);
define(PP_NOVIDADES_TODAS, 15);
define(PP_MAIS_LOCADOS, 20);
define(PP_LANCAMENTOS, 20);
define(PP_BUSCA_ADM, 50);
define(PP_LISTA_LOCADOS, 10);
define(PP_LISTA_LOCACOES, 20);

/**
* L I M I T E   D E   S T R   N O  T I T U L  O   D A   N O T  I C I A  I N D E X
*/

define(LIMITE_TITULO_NOTICIA_INDEX, 150);

/**
* L I M I T E   D E   S T R   N O  T I T U L  O   D A   N O T  I C I A
*/

define(LIMITE_TITULO_NOTICIA, 75);

/**
* L I M I T E   D E   S T R   N O   T I T U L O
*/

define(LIMITE_TITULO, 25);

/**
* L I M I T E   D E   L E T R A S   P O R   L I N H A   N O S   T I T U L O S
*/

define(LIMITE_LINHA, 9);

/**
* L I M I T E   D E   S T R   N O   G E R E N C I A M E N T O
*/

define(LIMITE_GENRENCIAR, 55);

/**
* L I M I T E   D E   S T R   N A  E X I B I C A O   P O R   C A P A S
*/

define(LIMITE_GEN_CAPAS, 100);

/**
* L I M I T E   D E   S T R   N A  E X I B I C A O   D A S  L O C A C O E S
*/

define(LIMITE_LOC, 57);

/**
* M E N U S   D A S   P � G I N A S 
*/

$menu['principal']['menu1'] = array("Principal"          => "index.php");
$menu['principal']['menu2'] = array("Quem somos ?"       => "quemSomos.php");
$menu['principal']['menu3'] = array("Conveni�ncia"       => "listarProdutos.php");
$menu['principal']['menu4'] = array("Meu Pedido"         => "carrinho.php");
$menu['principal']['menu5'] = array("D�vidas ?"          => "duvidas.php");
$menu['principal']['menu6'] = array("Contato"            => "contato.php");

$menu['admin'] = array("Administradores"  => array("administradores.php", "administrador.php?acao=adicionar"),
                       "Atores"           => array("atores.php"         , "ator.php?acao=adicionar"),
                       "Categorias"       => array("categorias.php"     , "categoria.php?acao=adicionar"),
                       "Classifica��es"   => array("classificacoes.php" , "classificacao.php?acao=adicionar"),
					   "Diretores"        => array("diretores.php"      , "diretor.php?acao=adicionar"),
					   "Enquetes"         => array("enquetes.php"       , "enquete.php?acao=adicionar"),
					   "Feriados"         => array("feriados.php"       , "feriado.php?acao=adicionar"),
					   "Filmes"           => array("filmes.php"         , "filme.php?acao=adicionar"),
					   "G�neros"          => array("generos.php"        , "genero.php?acao=adicionar"),
					   "M�dias"           => array("midias.php"         , "midia.php?acao=adicionar"),
					   "Novidades"        => array("novidades.php"      , "novidade.php?acao=adicionar"),
					   "Produtos"         => array("produtos.php"       , "produto.php?acao=adicionar"),
					   "Taxas"            => array("taxas.php"          , "taxa.php?acao=adicionar"),
					   "Tipos de Usu�rio" => array("tipos.php"          , "tipo.php?acao=adicionar")
					  );
					  
$menu['admin_gerenciar'] = array("Clientes"              => "clientes.php",
                                 "Emails"                => "emails.php",
								 "M�dias Locadas"        => "midiasLocadas.php",
								 "Loca��es Novas"        => "locacoes.php?filtro=aguardando",
                                 "Loca��es em Andamento" => "locacoes.php?filtro=andamento",
								 "Loca��es Fechadas"     => "locacoes.php?filtro=fechadas",
								 "Todas Loca��es"        => "locacoes.php"
						   );
						   
/**
* B A N N E R S   D O S   P A R C E I R O S   D O   S I T E 
*/

$parceiros = array("Por�o Bar Rock" => array("../images/parceiros/porao.jpg", "http://www.poraobarrock.com.br"),
				   "Nome do parceiro 2" => array("../images/parceiros/banner_1.jpg", "http://www.parceiro.com"),
				   "Nome do parceiro 3" => array("../images/parceiros/banner_1.jpg", "http://www.parceiro.com"),
				   "Nome do parceiro 4" => array("../images/parceiros/banner_1.jpg", "http://www.parceiro.com"),
				   "Nome do parceiro 5" => array("../images/parceiros/banner_1.jpg", "http://www.parceiro.com")
				   );

/**
* B U S C A R   P O  R   ?
*/				   

$buscarPor = array(1 => "T�tulo",
                   2 => "Ator",
				   3 => "Diretor"
		           );
				   
/**
* C O M B O   S I T U A � � O
*/				   

$situacao = array(1 => "Locado",
                  2 => "Fechado",
				  3 => "Aguardando Confirma��o"
		           );
				   
/**
* H O R � R I O S   D E    E N T R E G A
*/

$horarios = array(1  => "11:00 � 11:30",
                  2  => "11:30 � 12:00",
                  3  => "12:00 � 12:30", 
                  4  => "12:30 � 13:00",
                  5  => "13:00 � 13:30",
                  6  => "13:30 � 14:00",
                  7  => "14:00 � 14:30",
                  8  => "14:30 � 15:00",
                  9  => "15:00 � 15:30",
                  10 => "15:30 � 16:00",
                  11 => "16:00 � 16:30",
                  12 => "16:30 � 17:00",
                  13 => "17:00 � 17:30",
                  14 => "17:30 � 18:00",
                  15 => "18:00 � 18:30",
                  16 => "18:30 � 19:00",
                  17 => "19:00 � 19:30",
                  18 => "19:30 � 20:00",
                  19 => "20:00 � 20:30",
                  20 => "20:30 � 21:00",
                  21 => "21:00 � 21:30",
                  22 => "21:30 � 22:00",
                  23 => "22:00 � 22:30",
                  24 => "22:30 � 23:00",
                  25 => "23:00 � 23:30"
				  );
				  
$regHorarios['semana']  = array(1 =>  '#',
                                2 =>  '#',
								3 =>  '#',
								4 =>  '#',
								5 =>  '#',
								6 =>  '#',
								7 =>  '#',
								8 =>  '#',
								9 =>  '#',
								10 => '#',
								11 => '#',
								12 => '#',
								13 => '#',
								14 => '#',
								15 => '#',
								16 => '#',
								17 => '#',
								18 => 18,
								19 => 19,
								20 => '#',
								21 => '#',
								22 => '#',
								23 => '#',
								24 => '#',
								25 => 25
								);
								
$regHorarios['sabado']  = array(1 =>  '#',
                                2 =>  '#',
								3 =>  '#',
								4 =>  '#',
								5 =>  '#',
								6 =>  '#',
								7 =>  '#',
								8 =>  '#',
								9 =>  '#',
								10 => '#',
								11 => '#',
								12 => '#',
								13 => '#',
								14 => '#',
								15 => '#',
								16 => '#',
								17 => '#',
								18 => 18,
								19 => 19,
								20 => '#',
								21 => '#',
								22 => '#',
								23 => '#',
								24 => '#',
								25 => 25
								);

$regHorarios['domingo'] = array(1 =>  '#',
                                2 =>  '#',
								3 =>  '#',
								4 =>  '#',
								5 =>  '#',
								6 =>  '#',
								7 =>  '#',
								8 =>  '#',
								9 =>  '#',
								10 => '#',
								11 => '#',
								12 => '#',
								13 => '#',
								14 => '#',
								15 => '#',
								16 => '#',
								17 => '#',
								18 => 18,
								19 => 19,
								20 => '#',
								21 => '#',
								22 => '#',
								23 => '#',
								24 => '#',
								25 => 25
								);

/**
* P A � S E S
*/

$pais = array("" => "",
			  "Afeganist�o" => "Afeganist�o",
              "�frica do Sul" => "�frica do Sul",
              "Alb�nia" => "Alb�nia",
              "Alemanha" => "Alemanha",
              "Andorra" => "Andorra",
              "Angola" => "Angola",
              "Anguilla" => "Anguilla",
              "Antartica" => "Antartica",
              "Antilhas Holandesas" => "Antilhas Holandesas",
              "Ant�gua e Barbuda" => "Ant�gua e Barbuda",
              "Argentina" => "Argentina",
              "Arg�lia" => "Arg�lia",
              "Arm�nia" => "Arm�nia",
              "Aruba" => "Aruba",
              "Ar�bia Saudita" => "Ar�bia Saudita",
              "Ascens�o" => "Ascens�o",
              "Austr�lia" => "Austr�lia",
              "�ustria" => "�ustria",
              "Azerbaij�o" => "Azerbaij�o",
              "Bahamas" => "Bahamas",
              "Bahrain" => "Bahrain",
              "Bangladesch" => "Bangladesch",
              "Barbados" => "Barbados",
              "Belarus" => "Belarus",
              "Belize" => "Belize",
              "Benin" => "Benin",
              "Bermudas" => "Bermudas",
              "Bol�via" => "Bol�via",
              "Bon� Verde" => "Bon� Verde",
              "Botsuana" => "Botsuana",
              "Brasil" => "Brasil",
              "Brunei" => "Brunei",
              "Bulg�ria" => "Bulg�ria",
              "Burkina Fasso" => "Burkina Fasso",
              "Burundi" => "Burundi",
              "But�o" => "But�o",
              "B�lgica" => "B�lgica",
              "B�snia-Herzeg�vina" => "B�snia-Herzeg�vina",
              "Camar�es" => "Camar�es",
              "Camboja" => "Camboja",
              "Canad�" => "Canad�",
              "Cayman" => "Cayman",
              "Cazaquist�o" => "Cazaquist�o",
              "Chade" => "Chade",
              "Chile" => "Chile",
              "China" => "China",
              "Chipre" => "Chipre",
              "Cingapura" => "Cingapura",
              "Cocos" => "Cocos",
              "Col�mbia" => "Col�mbia",
              "Comares" => "Comares",
              "Congo" => "Congo",
              "Cook" => "Cook",
              "Cor�ia do Norte" => "Cor�ia do Norte",
              "Cor�ia do Sul" => "Cor�ia do Sul",
              "Costa do Marfim" => "Costa do Marfim",
              "Costa Rica" => "Costa Rica",
              "Cro�cia" => "Cro�cia",
              "Cuba" => "Cuba",
              "Dinamarca" => "Dinamarca",
              "Djibuti" => "Djibuti",
              "Dominica" => "Dominica",
              "Egito" => "Egito",
              "El Salvador" => "El Salvador",
              "Emirados �rabes" => "Emirados �rabes",
              "Equador" => "Equador",
              "Eritr�ia" => "Eritr�ia",
              "Eslov�quia" => "Eslov�quia",
              "Eslov�na" => "Eslov�na",
              "Espanha" => "Espanha",
              "Estados Unidos" => "Estados Unidos",
              "Est�nia" => "Est�nia",
              "Eti�pia" => "Eti�pia",
              "Fiji" => "Fiji",
              "Filipinas" => "Filipinas",
              "Finl�ndia" => "Finl�ndia",
              "Fran�a" => "Fran�a",
              "Gab�o" => "Gab�o",
              "Gana" => "Gana",
              "Ge�rgia" => "Ge�rgia",
              "Ge�rgia" => "Ge�rgia",
              "Gibraltar" => "Gibraltar",
              "Granada" => "Granada",
              "Groel�ndia" => "Groel�ndia",
              "Gr�cia" => "Gr�cia",
              "Guadalupe" => "Guadalupe",
              "Guam" => "Guam",
              "Guatemala" => "Guatemala",
              "Guernsey" => "Guernsey",
              "Guiana  " => "Guiana  ",
              "Guiana Francesa" => "Guiana Francesa",
              "Guin�" => "Guin�",
              "Guin� Equatorial" => "Guin� Equatorial",
              "Guin�-Bissau" => "Guin�-Bissau",
              "G�mbia" => "G�mbia",
              "Haiti" => "Haiti",
              "Holanda" => "Holanda",
              "Honduras" => "Honduras",
              "Hong Kong" => "Hong Kong",
              "Hungria" => "Hungria",
              "Ilha Bouvet" => "Ilha Bouvet",
              "Ilha de Man" => "Ilha de Man",
              "Ilha Natal" => "Ilha Natal",
              "Ilha Norfolk" => "Ilha Norfolk",
              "Ilha Pitcairn" => "Ilha Pitcairn",
              "Ilha Reuni�o" => "Ilha Reuni�o",
              "Ilhas de Faeroes" => "Ilhas de Faeroes",
              "Ilhas de Virgens (EUA)" => "Ilhas de Virgens (EUA)",
              "Ilhas Falkland" => "Ilhas Falkland",
              "Ilhas MacDonald" => "Ilhas MacDonald",
              "Ilhas Marianas do Norte" => "Ilhas Marianas do Norte",
              "Ilhas Marshall" => "Ilhas Marshall",
              "Ilhas Salom�o" => "Ilhas Salom�o",
              "Ilhas Seychelles" => "Ilhas Seychelles",
              "Ilhas Tokelau" => "Ilhas Tokelau",
              "Ilhas Turks e Caicos" => "Ilhas Turks e Caicos",
              "�ndia" => "�ndia",
              "Indon�sia" => "Indon�sia",
              "Iraque" => "Iraque",
              "Irlanda" => "Irlanda",
              "Ir�" => "Ir�",
              "Isl�ndia" => "Isl�ndia",
              "Israel" => "Israel",
              "It�lia" => "It�lia",
              "Iugosl�via" => "Iugosl�via",
              "I�men" => "I�men",
              "Jamaica" => "Jamaica",
              "Jap�o" => "Jap�o",
              "Jersey" => "Jersey",
              "Jord�nia" => "Jord�nia",
              "Kiribati" => "Kiribati",
              "Kuait" => "Kuait",
              "Laos" => "Laos",
              "Lesoto" => "Lesoto",
              "Let�nia" => "Let�nia",
              "Lib�ria" => "Lib�ria",
              "Liechtenstein" => "Liechtenstein",
              "Litu�nia" => "Litu�nia",
              "Luxemburgo" => "Luxemburgo",
              "L�bano" => "L�bano",
              "L�bia" => "L�bia",
              "Macau" => "Macau",
              "Maced�nia" => "Maced�nia",
              "Madagascar" => "Madagascar",
              "Maldivas" => "Maldivas",
              "Mali" => "Mali",
              "Malta" => "Malta",
              "Mal�sia" => "Mal�sia",
              "Marrocos" => "Marrocos",
              "Martinica" => "Martinica",
              "Maurit�nia" => "Maurit�nia",
              "Maur�cio" => "Maur�cio",
              "Mayotte" => "Mayotte",
              "Micron�sia" => "Micron�sia",
              "Moldova" => "Moldova",
              "Mong�lia" => "Mong�lia",
              "Montserrat" => "Montserrat",
              "Mo�ambique" => "Mo�ambique",
              "M�xico" => "M�xico",
              "M�naco" => "M�naco",
              "Nam�bia" => "Nam�bia",
              "Nauru" => "Nauru",
              "Nepal" => "Nepal",
              "Nicar�gua" => "Nicar�gua",
              "Nig�ria" => "Nig�ria",
              "Niue" => "Niue",
              "Noruega" => "Noruega",
              "Nova Caled�nia" => "Nova Caled�nia",
              "Nova Zel�ndia" => "Nova Zel�ndia",
              "N�ger" => "N�ger",
              "Oceano �ndico Brit�nico" => "Oceano �ndico Brit�nico",
              "Om�" => "Om�",
              "Palau" => "Palau",
              "Palestina" => "Palestina",
              "Panam�" => "Panam�",
              "Papua-Nova Guin�" => "Papua-Nova Guin�",
              "Paquist�o" => "Paquist�o",
              "Paraguai" => "Paraguai",
              "Peru" => "Peru",
              "Polin�sia Francesa" => "Polin�sia Francesa",
              "Pol�nia" => "Pol�nia",
              "Porto Rico" => "Porto Rico",
              "Portugal" => "Portugal",
              "Qatar" => "Qatar",
              "Quirguist�o" => "Quirguist�o",
              "Qu�nia" => "Qu�nia",
              "Reino Unido" => "Reino Unido",
              "Rep Centro Africana" => "Rep Centro Africana",
              "Rep�blica do Congo" => "Rep�blica do Congo",
              "Rep�blica Dominicana" => "Rep�blica Dominicana",
              "Rep�blica Tcheca" => "Rep�blica Tcheca",
              "Rom�nia" => "Rom�nia",
              "Ruanda" => "Ruanda",
              "R�ssia" => "R�ssia",
              "Saara Ocidental" => "Saara Ocidental",
              "Samoa Ocidental" => "Samoa Ocidental",
              "Samoa Ocidental" => "Samoa Ocidental",
              "San Marino" => "San Marino",
              "Santa Helena" => "Santa Helena",
              "Santa L�cia" => "Santa L�cia",
              "Senegal" => "Senegal",
              "Serra Leoa" => "Serra Leoa",
              "Som�lia" => "Som�lia",
              "Sri Lanka" => "Sri Lanka",
              "Sud�o" => "Sud�o",
              "Suriname" => "Suriname",
              "Suzail�ndia" => "Suzail�ndia",
              "Su�cia" => "Su�cia",
              "Su��a" => "Su��a",
              "Svalbard" => "Svalbard",
              "S�o Crist�v�o e N�vis" => "S�o Crist�v�o e N�vis",
              "S�o Tom� e Pr�ncipe" => "S�o Tom� e Pr�ncipe",
              "S�o Vicent e Granadinas" => "S�o Vicent e Granadinas",
              "S�ria" => "S�ria",
              "Tadjiquist�o" => "Tadjiquist�o",
              "Tail�ndia" => "Tail�ndia",
              "Taiwan" => "Taiwan",
              "Tanz�nia" => "Tanz�nia",
              "Timor Leste" => "Timor Leste",
              "Togo" => "Togo",
              "Tonga" => "Tonga",
              "Trinidad e Tobago" => "Trinidad e Tobago",
              "Tun�sia" => "Tun�sia",
              "Turcomenist�o" => "Turcomenist�o",
              "Turquia" => "Turquia",
              "Tuvalu" => "Tuvalu",
              "Ucr�nia" => "Ucr�nia",
              "Uganda" => "Uganda",
              "Uruguai" => "Uruguai",
              "Uzbequist�o" => "Uzbequist�o",
              "Vanuatu" => "Vanuatu",
              "Vaticano" => "Vaticano",
              "Venezuela" => "Venezuela",
              "Vietn�" => "Vietn�",
              "Virgens(Reino Unido)" => "Virgens(Reino Unido)",
              "yanma" => "yanma",
              "Zaire" => "Zaire",
              "Zimb�bue" => "Zimb�bue",
              "Z�mbia" => "Z�mbia");

/**
* D I R E T � R I O S    P A R A   A L O C A �  � O   D E   A R Q U I V O S
*/

$diretorio['atores'] = "../images/atores";
$diretorio['filmes'] = "../images/filmes";

/**
* T A B E L A S   E   S E U S   R E S P E C T I V O S   C A M P O S
*/

$tabela['email'] = "email";

$campos['email'] = array("ema_email",
                         "ema_send_news"
					     );
// PK -> ema_id

/******************************************************************/

$tabela['tipo_user'] = "tipo_user";

$campos['tipo_user'] = array("tip_tipo",
							 "tip_nivel"
					         );
// PK -> tip_id_user
/******************************************************************/

$tabela['usuario'] = "usuario";

$campos['usuario'] = array("ema_id",
						   "usu_nome",
						   "usu_sobrenome",
						   "usu_login",
						   "usu_senha",
						   "tip_id_user"
					       );
// PK -> usu_cod
/******************************************************************/

$tabela['enquete'] = "enquete";

$campos['enquete'] = array("usu_cod",
						   "enq_pergunta",
						   "enq_exibir"
					       );
// PK -> enq_id
/******************************************************************/

$tabela['respostas'] = "respostas";

$campos['respostas'] = array("enq_id",
						     "res_resposta",
						     "res_votos"
					         );
// PK -> res_id
/******************************************************************/

$tabela['novidade'] = "novidade";

$campos['novidade'] = array("usu_cod",
						    "nov_titulo",
						    "nov_conteudo"
					        );
// PK -> nov_id
// TIMESTAMP -> nov_quando
/******************************************************************/

$tabela['categoria'] = "categoria";

$campos['categoria'] = array("cat_nome",
						     "cat_descricao",
						     "cat_temp_loc",
							 "cat_preco"
					         );
// PK -> cat_cod
/******************************************************************/

$tabela['genero'] = "genero";

$campos['genero'] = array("gen_nome",
						  "gen_descricao"
					      );
// PK -> gen_cod
/******************************************************************/

$tabela['classificacao'] = "classificacao";

$campos['classificacao'] = array("cla_classificacao",
						         "cla_idade_recomendada"
					             );
// PK -> cla_cod
/******************************************************************/

$tabela['filme'] = "filme";

$campos['filme'] = array("cat_cod",
						 "cla_cod",
						 "fil_titulo",
						 "fil_titulo_original",
						 "fil_ano",
						 "fil_duracao",
						 "fil_sinopse",
						 "fil_foto",
						 "fil_distribuidora",
						 "fil_destaque"
					     );
// PK -> fil_cod
/******************************************************************/

$tabela['midia'] = "midia";

$campos['midia'] = array("fil_cod",
                         "mid_cod_controle",
						 "mid_tipo",
						 "mid_audio",
						 "mid_legenda",
						 "mid_regiao",
						 "mid_formato",
						 "mid_status"
					     );
// PK -> mid_cod
/******************************************************************/

$tabela['taxa_entrega'] = "taxa_entrega";

$campos['taxa_entrega'] = array("txe_localizacao",
						        "txe_valor"
					            );
// PK -> txe_cod
/******************************************************************/

$tabela['cliente'] = "cliente";

$campos['cliente'] = array("cli_cpf",
						   "usu_cod",
						   "cli_rg",
						   "cli_rua",
						   "cli_numero",
						   "cli_bairro",
						   "cli_complemento",
						   "cli_telefone",
						   "cli_celular",
						   "cli_data_nascimento",
						   "cli_bloqueado",
						   "txe_cod"
					     );
						 
/******************************************************************/

$tabela['locacao'] = "locacao";

$campos['locacao'] = array("cli_cpf",
						   "loc_data_entrega",
						   "loc_hora_entrega",
						   "loc_data_busca",
						   "loc_hora_busca",
						   "loc_valor",
						   "loc_multa",
						   "loc_obs",
						   "loc_situacao"
					       );
// PK -> loc_cod
// TS -> loc_quando
/******************************************************************/

$tabela['midia_locacao'] = "midia_locacao";

$campos['midia_locacao'] = array("mid_cod",
						         "loc_cod"
								 );
								 
/******************************************************************/

$tabela['produtos'] = "produtos";


$campos['produtos'] = array("pro_nome",
						    "pro_qtd",
						    "pro_preco",
					        );
// PK -> pro_cod
/******************************************************************/

$tabela['diretor'] = "diretor";


$campos['diretor'] = array("dir_nome"
					       );
// PK -> dir_cod
/******************************************************************/

$tabela['ator'] = "ator";

$campos['ator'] = array("ato_nome",
						"ato_nome_nascimento",
						"ato_profissao",
						"ato_data_nascimento",
						"ato_pais_natal",
						"ato_cidade_natal",
						"ato_biografia",
						"ato_foto"
					    );
// PK -> ato_cod
/******************************************************************/

$tabela['genero_filme'] = "genero_filme";

$campos['genero_filme'] = array("gen_cod",
						        "fil_cod"
					            );
								
/******************************************************************/

$tabela['diretor_filme'] = "diretor_filme";

$campos['diretor_filme'] = array("dir_cod",
						         "fil_cod"
					             );
								 
/******************************************************************/

$tabela['ator_filme'] = "ator_filme";

$campos['ator_filme'] = array("ato_cod",
						      "fil_cod"
					          );
								 
/******************************************************************/

$tabela['avaliacao'] = "avaliacao";

$campos['avaliacao'] = array("fil_cod",
						     "cli_cpf",
						     "ava_nota"
					         );

/******************************************************************/

$tabela['produtos_locacao'] = "produtos_locacao";

$campos['produtos_locacao'] = array("pro_cod",
						            "loc_cod",
									"pro_loc_qtd"
					                );

/******************************************************************/

$tabela['feriados'] = "feriados";

$campos['feriados'] = array("fer_data",
                            "fer_nome"
						   );
						   
// PK -> fer_cod
/******************************************************************/

$tabela['favoritos'] = "favoritos";

$campos['favoritos'] = array("cli_cpf",
                             "fil_cod"
							 );
							 
/******************************************************************/
?>