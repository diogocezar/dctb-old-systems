<?php
/**
* Arquivo de configuraчуo da pсgina inf.
*
* Definindo constantes de configuraчуo
*/

/**
* T I T U L O
*/

define(TITULO, 'Curso Superior de Tecnologia em Desenvolvimento de Sistemas de Informaчуo - UTFPR');

/**
* L I N K S
*/

define(LINK_INF, 'http://inf.cp.cefetpr.br');
define(LINK_UTF, 'http://www.cp.cefetpr.br');
define(LINK_KREEA, 'http://www.kreea.com.br');


/**
* D I R E T г R I O S    P A R A   A L O C A Ч  У O   D E   A R Q U I V O S
*/

$diretorio['log'] = "../log/log.txt";

$diretorio['log_login'] = "../log/log_login.txt";

$diretorio['not'] = "../images/noticias";

$diretorio['pro'] = "../images/professores";

/**
* T A M A N  H O   D A S   F O  T O S
*/

$altura['pro']  = 100;
$largura['pro'] = 100;
$scalar['pro']  = 'sim';

$altura['pro_min']  = 50;
$largura['pro_min'] = 50;
$scalar['pro_min']  = 'nуo';


$altura['not']  = 128;
$largura['not'] = 170;
$scalar['not']  = 'nуo';

$altura['not_min']  = 65;
$largura['not_min'] = 86;
$scalar['not_min']  = 'nуo';


/**
* C O N F I G U R A Ч е E S   D O  G E R E N C I A M E N T O 
*/

define(QTD_PAGINAS_SHOW, 10);

define(LIMITE_GENRENCIAR, 65);

define(PP_GERENCIAR, 15);

/**
* L I M I T E S    D E   C A R A C T E R E S
*/

define(LIMITE_LOCAL, 40);

define(LIMITE_DESCRICAO_EVENTO, 40);

define(LIMITE_TITULO_NOTICIA, 40);

define(LIMITE_DESCRICAO_NOTICIA, 120);

define(LIMITE_DESCRICAO_PROFESSOR, 100);

define(LIMITE_DESCRICAO_DISCIPLINA, 100);

/**
* T E X T O S   E S T С T I C O S
*/

define(SOBRE_O_CURSO, "O Curso de Tecnologia em Desenvolvimento de Sistemas do CEFET-PR / Unidade de Cornщlio Procѓpio tem como objetivo geral a formaчуo de recursos humanos para a automaчуo dos sistemas de informaчуo das organizaчѕes, com vistas a atender as necessidades do mercado de trabalho corrente.");

define(DESTAQUE, "Testando um destaque.");

/**
* M E N U S   D A S   P С G I N A S 
*/

$menu['principal']['menu1'] = array("Pсgina Principal" => "index.php");
$menu['principal']['menu2'] = array("Sobre o Curso"    => "sobre.php");
$menu['principal']['menu3'] = array("Professores"      => "professores.php");
$menu['principal']['menu4'] = array("Disciplinas"      => "disciplinas.php");
$menu['principal']['menu5'] = array("Eventos"          => "eventos.php");
$menu['principal']['menu6'] = array("Notэcias"         => "noticias.php");
$menu['principal']['menu7'] = array("Links"            => "links.php");
$menu['principal']['menu8'] = array("Contato"          => "contato.php");

/**
* T A B E L A S   E   S E U S   R E S P E C T I V O S   C A M P O S
*/
			   
/******************************************************************/

$tabela['administradores'] = "administradores";

$campos['administradores'] = array("nomeAd",
						           "loginAd",
						           "senhaAd",
								   "emailAd"
					             );
// PK -> idAdministradores

/******************************************************************/

$tabela['disciplinas'] = "disciplinas";

$campos['disciplinas'] = array("nomeDi",
						       "periodoDi",
						       "cargaHorariaDi",
							   "objetivosDi",
							   "ementasDi"
					           );
// PK -> idDisciplinas

/******************************************************************/

$tabela['eventos'] = "eventos";

$campos['eventos'] = array("Administrador_idAdministrador",
						   "dataEv",
						   "horaEv",
						   "localEv",
						   "descricaoEv"
					       );							  
// PK -> idEventos

/******************************************************************/

$tabela['links'] = "links";

$campos['links'] = array("Administrador_idAdministrador",
                         "nomeLi",
						 "urlLi",
						 "visitasLi",
						 "descricaoLi"
					     );
// PK -> idLinks

/******************************************************************/

$tabela['noticias'] = "noticias";

$campos['noticias'] = array("Administrador_idAdministrador",
						    "tituloNo",
							"descricaoNo",
							"imagemNo"
					        );
// PK -> idNoticias
// TS -> dataHoraNo

/******************************************************************/

$tabela['professores'] = "professores";

$campos['professores'] = array("nomePro",
						       "nickPro",
							   "fotoPro",
							   "sitePro",
							   "descricaoPro",
							   "emailPro"
					           );
// PK -> idProfessores

/******************************************************************/
?>