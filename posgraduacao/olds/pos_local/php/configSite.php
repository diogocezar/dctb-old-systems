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
define(TITULO, 'DEPOG - Departamento de Pósgraduação e Pesquisa.');

/**
* L O C A L I Z A Ç Ã O
*/
$localizacao  = "<br>";
$localizacao .= "<div align=\"center\"><img src=\"../images/localizacao.jpg\"></div>";
$localizacao .= "<br><br><div align=\"center\"><input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"« Voltar\" onclick=\"javascript:history.go(-1)\"></div><br><br>";
define(LOCALIZACAO, $localizacao);

/**
* G A L E R I A   D E   F O T O S
*/

$galeria = array('1' => '../galerias/depog',
                 '2' => '../galerias/matematica',
                 '3' => '../galerias/seguranca',
				 '4' => '../galerias/cultura',
				 '5' => '../galerias/java',
				 '6' => '../galerias/gestao',
				 '7' => '../galerias/processos'
				);

/**
* S O B R E   O D E P O G
*/
$menu_sobre = array('Processo de afastamento de Servidores para Pós-Graduação'           => 'afastamento.php',
                    'Encaminhamento de projetos de pesquisas para organismos de fomento' => 'encaminhamento.php',
				    'Procedimentos  de abertura de novos cursos de Especialização'       => 'procedimento.php'
					);
				
$sobre = "<br>";
$sobre .= "<b>Missão</b><br>
<div align=\"justify\">O Departamento de Ensino de Pós-Graduação e Pesquisa  (DEPOG) tem como missão coordenar, estimular e supervisionar as atividades de pesquisa e de pós-graduação desenvolvidas nn Campus Cornélio Procópio, de acordo com as políticas definidas pela Diretoria de Pós-Graduação e Pesquisa.</div>";
$sobre .= "<br><br>";
$sobre .= "<b>Catálogo da pós-graduação</b><br>
<div align=\"justify\">No Catálogo você poderá encontrar informações  dos cursos de pós-graduação em nível de Especialização oferecidos pelo Campus de Cornélio Procópio.</div>";
$sobre .= "<br><br>";
$sobre .= "<b>Anexos</b><br>";
$sobre .= "<div align=\"justify\">";
foreach($menu_sobre as $titulo => $url){
	$sobre .= "<img src=\"../images/seta_preta.gif\"> <a href=\"$url\" class=\"link_escuro\">$titulo</a><br>";
}
$sobre .= "</div>";
$sobre .= "<br><br>";
$sobre .= "<b>Equipe</b><br>
Devanil Antonio Francisco – Chefia<br> 
Elaine Pinheiro Neves de Macedo - Secretária<br>
Ramais: 4006 – Chefia, 4035 - Secretária<br>
E-mail: <a href = \"mailto:depog@cp.cefetpr.br\" class=\"link_escuro\">depog@cp.cefetpr.br</a><br>";
$sobre .= "<br><br><div align=\"center\"><input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"« Voltar\" onclick=\"javascript:history.go(-1)\"></div>";

define(SOBRE, $sobre);


/**
* B A N N E R   C E N T R A L   D A   P Á G I N A   P R I  N C I P A L
*/
define(BANNER, 'O Departamento de Ensino de Pós-Graduação e Pesquisa  (DEPOG) tem como missão coordenar, estimular e supervisionar as atividades de pesquisa e de pós-graduação desenvolvidas no Campus Cornélio Procópio, de acordo com as políticas definidas pela Diretoria de Pós-Graduação e Pesquisa.');

/**
* B A N N E R   M A I O  R E S   I N F O R M A Ç Õ E S
*/
define(MAIORES_INFOS, "<a href = \"contato.php?acao=adicionar\"><img src=\"../images/saibacomo.gif\" border=\"0\"></a>");


/**
* L I N K S 
*/
define(UTFPR, 'http://www.cp.cefetpr.br');
define(DEPOG, 'index.php');

/**
* Q U A N T I D A D E   D E   Í T E N S   P  O R   P Á G I N A
*/
define(PP_PROFESSORES, 10);
define(PP_CONTATOS, 10);
define(PP_ADMINISTRADORES, 10);
define(PP_CURSOS, 10);
define(PP_DISCIPLINAS, 10);
define(PP_INSCRICOES, 10);
define(PP_NOTICIAS, 10);

define(PP_NOTICIAS_GERAL, 10);
define(PP_DISCIPLINAS_GERAL, 20);

/**
* C O N T A T O S
*/

$contato[1]  = '<b>Contato:</b><br><br>';
$contato[1] .= '<b>Chefe DePOG :</b> Devanil Antonio Francisco <br>';
$contato[1] .= 'Contato: (43)3520-4006 / <a href = \'mailto:devanil@cp.cefetpr.br\' class = \'link_claro\'><b>devanil@cp.cefetpr.br</b></a><br><br>';
$contato[1] .= '<b>Secretaria do DEPOG :</b> Elaine Pinheiro Neves de Macedo <br>';
$contato[1] .= 'Contato: (43)3520-4035 / <a href = \'mailto:depog@cp.cefetpr.br\' class = \'link_claro\'><b>depog@cp.cefetpr.br</b></a>';

$contato[2]  = '<b>Contato:</b><br><br>';
$contato[2] .= '<b>Profª. MSc.:</b> Elaine Cristina Ferruzzi<br><br>';
$contato[2] .= '<a href = \'mailto:elaineferruzzi@cp.cefetpr.br\' class = \'link_claro\'><b>elaineferruzzi@cp.cefetpr.br</b></a>';

$contato[3]  = '<b>Contato:</b><br><br>';
$contato[3] .= '<b>Prof.:</b> Edson Luis Bassetto<br><br>';
$contato[3] .= 'Contato: (43)3520-4053 / (43)9907-6004<br><br>';
$contato[3] .= '<a href = \'mailto:ceest@cp.cefetpr.br\' class = \'link_claro\'><b>ceest@cp.cefetpr.br</b></a>';

$contato[4]  = '<b>Contato:</b><br><br>';
$contato[4] .= '<b>Profª.:</b> Marisa Marques de Souza<br><br>';
$contato[4] .= 'Contato: (43)3523-1687 / (43)9934-7836 <br><br>';
$contato[4] .= '<a href = \'mailto:marisa@cp.cefetpr.br\' class = \'link_claro\'><b>marisa@cp.cefetpr.br</b></a>';

$contato[5]  = '<b>Contato:</b><br><br>';
$contato[5] .= '<b>Prof.:</b> Maurício Correia Lemes Neto<br><br>';
$contato[5] .= 'Contato: Fone:(43)3520-4060 / Fax:(43)3520-4010<br><br>';
$contato[5] .= '<a href = \'mailto:mauricio@cp.cefetpr.br\' class = \'link_claro\'><b>mauricio@cp.cefetpr.br</b></a><br>';
$contato[5] .= '<a href = \'mailto:cpgtj@cp.cefetpr.br\' class = \'link_claro\'><b>cpgtj@cp.cefetpr.br</b></a><br>';

$contato[6]  = '<b>Contato:</b><br><br>';
$contato[6] .= '<b>Prof.:</b> Jefferson Luis Cesar Salles<br><br>';
$contato[6] .= 'Contato (43)3520-4035 / (43)3520-4013<br><br>';
$contato[6] .= '<a href = \'mailto:cegp@cp.cefetpr.br\' class = \'link_claro\'><b>cegp@cp.cefetpr.br</b></a>';

$contato[7] = '<b>Contato:</b><br><br>';
$contato[7] .= '<b>Prof. Dr.:</b> Sérgio Augusto Oliveira da Silva<br><br>';
$contato[7] .= 'Contato : (43) 3520-4035 / (43) 3520-4015<br><br>';
$contato[7] .= '<a href = \'mailto:augus@cp.cefetpr.br\' class = \'link_claro\'><b>augus@cp.cefetpr.br</b></a>';

/**
* M E N U S   D A S   P Á G I N A S 
*/

$menu['principal']['menu1'] = array("Principal"            => "index.php");
$menu['principal']['menu2'] = array("Sobre o DEPOG"        => "sobre.php");
$menu['principal']['menu3'] = array("Inscrições"           => "inscricao.php?acao=adicionar");
$menu['principal']['menu4'] = array("Os cursos"            => "mostracursos.php");
$menu['principal']['menu5'] = array("Localização"          => "localizacao.php");
$menu['principal']['menu6'] = array("Notícias"             => "mostratodas.php");
$menu['principal']['menu7'] = array("Maiores informações"  => "contato.php?acao=adicionar");

$menu['interno']['menu1'] = array("Principal"            => "index.php");
$menu['interno']['menu2'] = array("Sobre o curso"        => "mostracurso.php#"); // Adicionar ?id=id_do_curso
$menu['interno']['menu3'] = array("Inscrições"           => "inscricao.php?acao=adicionar");
$menu['interno']['menu4'] = array("Disciplinas"          => "mostradisciplinas.php#");// Adicionar ?id=id_do_curso
$menu['interno']['menu5'] = array("Localização"          => "localizacao.php");
$menu['interno']['menu6'] = array("Notícias"             => "mostratodas.php#");// Adicionar ?id=id_do_curso
$menu['interno']['menu7'] = array("Maiores informações"  => "contato.php?acao=adicionar");


$menu['admin'] = array("Gerenciar Curso"           => "curso.php?acao=atualizar&id=#", // # recebe o id do curso.
                       "Adicionar Administrador"   => "administrador.php?acao=adicionar",
                       "Adicionar Curso"           => "curso.php?acao=adicionar",
                       "Adicionar Disciplina"      => "disciplina.php?acao=adicionar",
					   "Adicionar Notícia"         => "noticia.php?acao=adicionar",
                       "Adicionar Professor"       => "professor.php?acao=adicionar",
					   "Gerenciar Administradores" => "administradores.php",
					   "Gerenciar Contatos"        => "contatos.php",
					   "Gerenciar Cursos"          => "cursos.php",
					   "Gerenciar Disciplinas"     => "disciplinas.php",
					   "Gerenciar Inscrições"      => "inscricoes.php",
					   "Gerenciar Noticias"        => "noticias.php",
					   "Gerenciar Professores"     => "professores.php",
					   "Alterar Senha"             => "alterasenha.php",
					   "Sair"                      => "login.php?acao=logout"
					  );					   

/**
* E S T A D O S   C I V I S
*/

$estadosCivis = array("Casado(a)", "Divorciado(a)", "Solteiro(a)", "Viúvo(a)");

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

/**
* T E M P L A T E S   E   C U R S O S
*/
$infoTemplate = array(2 => 'templateMatematica.html',
                      3 => 'templateSeguranca.html',
					  4 => 'templateCultura.html', // ALTERAR
					  5 => 'templateJava.html', // ALTERAR
				      6 => 'templateGestao.html',
					  7 => 'templateProcessos.html'
					 );

/**
* T A B E L A S   E   S E U S   R E S P E C T I V O S   C A M P O S
*/

$tabela['cursos'] = "cursos";

$campos['cursos'] = array("cur_nome",
						  "cur_apresentacao",
						  "cur_objetivos",
						  "cur_certificado",
						  "cur_inicio",
						  "cur_termino",
						  "cur_periodo_inscricao",
						  "cur_periodo_matricula",
						  "cur_turno_funcionamento",
						  "cur_vagas",
						  "cur_complementar",
						  "cur_tx_inscricao",
						  "cur_matricula",
						  "cur_mensalidades",
						  "cur_resumo"
					     );
//cur_cod -> PK

$tabela['administradores'] = "administradores";

$campos['administradores'] = array("cur_cod",
								   "adm_nome",
								   "adm_login",
								   "adm_senha",
								   "adm_email"
								  );
//adm_cod -> PK

$tabela['noticias'] = "noticias";

$campos['noticias'] = array("cur_cod",
							"not_titulo",
							"not_conteudo",
							"adm_cod"
						   );
//not_cod -> PK
//not_quando -> TIMESTAMP

$tabela['inscricoes'] = "inscricoes";

$campos['inscricoes'] = array("cur_cod",
							  "ins_nome",
							  "ins_cpf",
							  "ins_rg",
							  "ins_orgao_emissor",
							  "ins_data_nascimento",
							  "ins_estado_civil",
							  "ins_rua",
							  "ins_numero",
							  "ins_complemento",
							  "ins_bairro",
							  "ins_cidade",
							  "ins_estado",
							  "ins_cep",
							  "ins_telefone",
							  "ins_celular",
							  "ins_email"
							 );
//ins_cod -> PK
//ins_quando -> TIMESTAMP

$tabela['professores'] = "professores";

$campos['professores'] = array("pro_nome",
							   "pro_atuacao",
							   "pro_titulacao",
							   "pro_formacao",
							   "pro_email",
							   "pro_pag_pessoal"
							  );
//pro_cod -> PK

$tabela['disciplinas'] = "disciplinas";

$campos['disciplinas'] = array("cur_cod",
							   "pro_cod",
							   "dic_nome",
							   "dic_carga_horaria",
							   "dic_descricao"
							  );
//dic_cod -> PK

$tabela['contato'] = "contato";

$campos['contato'] = array("cur_cod",
						   "con_nome",
						   "con_telefone",
						   "con_celular",
						   "con_cidade",
						   "con_estado",
						   "con_email"
						  );
//con_cod -> PK		
//con_quando -> TIMESTAMP				  
?>