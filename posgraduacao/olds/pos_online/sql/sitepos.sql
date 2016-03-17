-- phpMyAdmin SQL Dump
-- version 2.7.0-beta1
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tempo de Geração: Nov 29, 2005 as 01:52 PM
-- Versão do Servidor: 4.0.20
-- Versão do PHP: 5.0.3
-- 
-- Banco de Dados: `sitepos`
-- 

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `administradores`
-- 

CREATE TABLE `administradores` (
  `adm_cod` int(11) NOT NULL auto_increment,
  `cur_cod` int(11) default NULL,
  `adm_nome` varchar(50) NOT NULL default '',
  `adm_login` varchar(15) NOT NULL default '',
  `adm_senha` varchar(15) NOT NULL default '',
  `adm_email` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`adm_cod`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Extraindo dados da tabela `administradores`
-- 

INSERT INTO `administradores` VALUES (1, 1, 'Administrador', 'admin', 'p0s2006', 'depog@cp.cefetpr.br');
INSERT INTO `administradores` VALUES (2, 5, 'Diogo Cezar Teixeira Batista', 'xg0rd0', 'panaca', 'xgordo@gmail.com');
INSERT INTO `administradores` VALUES (3, 6, 'Jefferson', 'jefferson', 'panaca', 'xgordo@gmail.com');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `contato`
-- 

CREATE TABLE `contato` (
  `con_cod` int(11) NOT NULL auto_increment,
  `cur_cod` int(11) NOT NULL default '0',
  `con_nome` varchar(50) NOT NULL default '',
  `con_telefone` varchar(15) default NULL,
  `con_celular` varchar(15) default NULL,
  `con_cidade` varchar(50) default NULL,
  `con_estado` char(2) default NULL,
  `con_email` varchar(50) NOT NULL default '',
  `con_quando` timestamp(14) NOT NULL,
  PRIMARY KEY  (`con_cod`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

-- 
-- Extraindo dados da tabela `contato`
-- 

INSERT INTO `contato` VALUES (1, 5, 'Testando', '00-0000-0000', '00-0000-0000', '000000000000', 'PR', 'xgordo@gmail.com', '20051126154349');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `cursos`
-- 

CREATE TABLE `cursos` (
  `cur_cod` int(11) NOT NULL auto_increment,
  `cur_nome` varchar(100) NOT NULL default '',
  `cur_apresentacao` longtext NOT NULL,
  `cur_objetivos` longtext NOT NULL,
  `cur_certificado` longtext NOT NULL,
  `cur_inicio` date NOT NULL default '0000-00-00',
  `cur_termino` date NOT NULL default '0000-00-00',
  `cur_periodo_inscricao` varchar(100) NOT NULL default '',
  `cur_periodo_matricula` varchar(100) NOT NULL default '',
  `cur_turno_funcionamento` varchar(100) NOT NULL default '',
  `cur_vagas` int(11) NOT NULL default '0',
  `cur_complementar` longtext,
  `cur_tx_inscricao` varchar(15) NOT NULL default '',
  `cur_matricula` varchar(15) NOT NULL default '',
  `cur_mensalidades` varchar(15) NOT NULL default '',
  `cur_resumo` longtext NOT NULL,
  PRIMARY KEY  (`cur_cod`)
) TYPE=MyISAM AUTO_INCREMENT=8 ;

-- 
-- Extraindo dados da tabela `cursos`
-- 

INSERT INTO `cursos` VALUES (1, 'DEPOG', '[Site Principal]', '[Site Principal]', '[Site Principal]', '2005-11-26', '2005-11-26', '[Site Principal]', '[Site Principal]', '[Site Principal]', 0, '[Site Principal]', '[Site Principal', '[Site Principal', '[Site Principal', '[Site Principal]');
INSERT INTO `cursos` VALUES (2, 'Curso de Especializa磯 em Instrumentaliza磯 para o Ensino de Matemᴩca', '[completar]', 'Proporcionar estrat駩as de ensino aprendizagem a bachar驳 e/ou licenciados que atuam na Ქa de Matemᴩca do Ensino Fundamental e M餩o, atrav鳠de metodologias, ferramentas matemᴩcas e instrumentos de ensino aprendizagem, visando mudan硳 na atua磯 didᴩca e aprimorando a prᴩca educacional desses profissionais.', '[completar]', '2006-03-11', '2007-03-31', '12/12/05 a 04/02/2006', '08/02/2006 a 25/02/2006', 'Aos sᢡdos no per�o matutino e vespertino', 20, '', '35,00', '200,00', '170,00', 'O II CEIEM oferece uma alternativa relevante para a forma磯 de profissionais, preparando-os para o exerc�o profissional, utilizando metodologias, ferramentas matemᴩcas e instrumentos de ensino aprendizagem para se atualizarem em rela磯 ೠinova絥s aplicadas ao ensino.');
INSERT INTO `cursos` VALUES (3, 'Curso de Especializa磯 em Engenharia de Seguran硠do Trabalho', '[completar]', 'Formar profissionais especializados na prote磯 do trabalhador em todas as suas atividades laborais, considerando as quest?de seguran硠e higiene do trabalho, sem interferꮣia espec�ca de suas competꮣias legais e t飮icas estabelecidas para os Profissionais da Engenharia, Arquitetura ou Agronomia.', 'Certificado de Especialista em Engenharia de Seguran硠do Trabalho.', '2005-09-01', '2006-12-01', '01/05/2005 a 30/05/2005', '01/06/2005 a 30/05/2005', 'Aos sᢡdos no per�o matutino e vespertino', 30, '', '35,00', '288,00', '0,00', 'O Curso de Especializa磯 em Engenharia de Seguran硠do Trabalho, vꥭ de encontro ೠnecessidades de formar profissionais qualificados para atuarem na Ქa de Seguran硠e Higiene do Trabalho, conforme recomenda as Normas Regulamentadoras, e com condi絥s t飮icas para reconhecer, avaliar, atuar e controlar os riscos ࠩntegridade f�ca e psicol󧩣a de trabalhadores em suas atividades laborais, garantindo a defesa dos agentes agressivos existentes nos ambientes de trabalho.');
INSERT INTO `cursos` VALUES (4, 'Curso de Especializa磯 em Cultura, Tecnologia e Ensino de L�uas', '[completar]\r\n', 'Visa a forma磯 e aperfei篡mento ling?o, 鴩co, cultural e tecnol󧩣o do profissional atuante na Ქa da linguagem, instrumentalizando professores de l�uas vernᣵlas e estrangeiras na pesquisa, reflex㯠e busca de solu絥s de quest?inerentes ࠳ala de aula.', 'Certificado de Especialista em Cultura, tecnologia e Ensino de L�uas.', '2006-03-18', '2006-12-09', '13/02/2006 a 23/02/2006', '06/03/2006 a 09/03/2006', 'Aos sᢡdos no per�o matutino e vespertino', 27, '', '35,00', '185,00', '185,00', '[completar]');
INSERT INTO `cursos` VALUES (5, 'Curso de Especializa磯 em Tecnologia Java', '[completar]', 'Qualificar profissionais a desenvolver sistemas corporativos que incluam tecnologia de sistemas e componentes distribu�s, servi篳 Web, tecnologia wireless e demais e desenvolvimentos de sistemas, utilizando para isso a tecnologia Java.', 'conferido Certificado de Especialista em Tecnologia Java', '2006-03-04', '2007-03-04', '13/02/2006 a 18/02/2006', '21/02/2006 a 25/02/2006', 'Aos sᢡdos no per�o matutino e vespertino', 25, '', '0,00', '0,00', '0,00', '[completar]');
INSERT INTO `cursos` VALUES (6, 'Curso de Especializa磯 em Gest㯠da Produ磯', 'As mudan硳 que est㯠ocorrendo na economia mundial, refletem-se em todo segmento empresarial, exigindo das empresas maior competitividade, que para ser alcan硤a, requer t飮icas contempor⮥as de gest㯮 Neste contexto, o mercado de trabalho para profissionais especialistas na Ქa de gest㯠da produ磯 tem crescido muito nos ?os anos. \r\n\r\nFrente a essa necessidade, o CEFET-PR - Unidade de Corn鬩o Proc󰩯 estᠯfertando o segundo Curso de Especializa磯 em Gest㯠da Produ磯. Considerando os recentes avan篳 na Ქa de gest㯬 este curso oferece uma alternativa relevante para a forma磯 de novos profissionais  nesta Ქa, preparando-os para o entendimento, utiliza磯 e adapta磯 de novas tecnologias, bem como  inova絥s tecnol󧩣as. Este curso atenderᠡ profissionais das mais diversas Ქas que almejem ampliar o seu campo de atua磯 no setor produtivo. \r\n\r\nO projeto estᠤe acordo com a Delibera磯 n? 05/2002, a Norma Complementar vigente na Delibera磯 n? 17/98 do Conselho Diretor (Regulamento dos Cursos de P󳭇radua磯 Lato-Sensu) e a Resolu磯 n? 1, de 03 de abril de 2001, da C⭡ra de Ensino Superior, do Conselho Nacional de Educa磯 (CES/CNE), permitindo conferir o t�lo de ?Especialista em Gest㯠da Produ磯?. ', 'Preparar profissionais de n�l superior para o emprego de t飮icas gerenciais em atividades relacionadas com o processo de manufatura, aprimorando e desenvolvendo processos produtivos de acordo com os padr?atuais de qualidade e produtividade;\r\n \r\nProporcionar conhecimentos em concep磯 de sistemas, controle e preven磯 de perdas, sistemas de gest㯠de qualidade, log�ica da cadeia de suprimentos, sistemas de gest㯠de seguran硬 sistemas de gest㯠ambiental e integra磯 de sistemas;\r\n\r\nPermitir flexibilidade e adapta磯 dos produtos da empresa frente ೠmudan硳 do mercado;\r\n\r\nGerenciar equipes de trabalho com base no desenvolvimento organizacional; ', 'Certificado de Especialista em Gest㯠da Produ磯.', '2005-01-29', '2006-02-18', '22/11/2004 a 08/12/2004', '14/12/2004 a 18/12/2004', 'De segunda ࠳exta-feiras: das 14h ೠ21h. Aos sᢡdos das 8h ೠ12h.', 22, '', '20,00', '230,00', '230,00', '[completar]');
INSERT INTO `cursos` VALUES (7, 'Curso de Especializa磯 em Automa磯 e Controle de Processos Industriais', '[completar]', 'Formar profissionais qualificados na Ქa de automa磯 e controle de processos industriais, preparando-os para o entendimento e aplica絥s de tecnologias relacionadas com a respectiva Ქa, de forma a tornar o setor produtivo mais competitivo.', '[completar]', '2006-03-11', '2006-04-01', '[completar]', '[completar]', 'Sᢡdos com aulas das 8 ೠ12 horas e das 13 ೠ17 horas', 23, '', '35,00', '285,00', '285,00', '[completar]');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `disciplinas`
-- 

CREATE TABLE `disciplinas` (
  `dic_cod` int(11) NOT NULL auto_increment,
  `cur_cod` int(11) default NULL,
  `pro_cod` int(11) default NULL,
  `dic_nome` varchar(200) default NULL,
  `dic_carga_horaria` int(11) default NULL,
  `dic_descricao` longtext,
  PRIMARY KEY  (`dic_cod`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Extraindo dados da tabela `disciplinas`
-- 

INSERT INTO `disciplinas` VALUES (1, 5, 1, 'Disciplina de Tecnologia Java', 50, 'teste');
INSERT INTO `disciplinas` VALUES (2, 6, 2, 'Disciplina de Gest㯠da Produ磯', 50, 'testandoooooooooo\r<br>\r<br>teste\r<br>teste\r<br>teste\r<br>teste\r<br>teste\r<br>');
INSERT INTO `disciplinas` VALUES (3, 6, 1, 'Estudos Organizacionais', 16, 'Ementa : \r<br>\r<br>A evolu磯 do pensamento administrativo; organiza磯 e m鴯do; fun絥s administrativas; princ�os de organiza磯; estruturas organizacionais; influꮣia da tecnologia e do ambiente; o processo de organiza磯 ou reorganiza磯. Novas tendꮣias em estudos organizacionais.\r<br>\r<br>Bibliografia : \r<br>\r<br>1) ETZIONI, A. Organiza絥s modernas. S㯠Paulo: Pioneira, 1980.\r<br>2) HAMPTON, D. R. Administra磯 contempor⮥a. 2. ed. S㯠Paulo: McGraw-Hill, 1983.\r<br>3) MAXIMIANO, A. C. A. Teoria geral da administra磯. 2. ed. S㯠Paulo: Atlas, 2000.\r<br>4) MORGAN, G. Imagens da organiza磯. S㯠Paulo: Atlas, 1995. ');
INSERT INTO `disciplinas` VALUES (4, 4, 3, 'teste', 5, 'teste');

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `inscricoes`
-- 

CREATE TABLE `inscricoes` (
  `ins_cod` int(11) NOT NULL auto_increment,
  `cur_cod` int(11) NOT NULL default '0',
  `ins_nome` varchar(50) NOT NULL default '',
  `ins_cpf` varchar(18) NOT NULL default '',
  `ins_rg` varchar(30) NOT NULL default '',
  `ins_orgao_emissor` varchar(100) NOT NULL default '',
  `ins_data_nascimento` date NOT NULL default '0000-00-00',
  `ins_estado_civil` varchar(15) NOT NULL default '',
  `ins_rua` varchar(100) NOT NULL default '',
  `ins_numero` int(11) default NULL,
  `ins_complemento` varchar(100) default NULL,
  `ins_bairro` varchar(100) NOT NULL default '',
  `ins_cidade` varchar(100) NOT NULL default '',
  `ins_estado` char(2) NOT NULL default '',
  `ins_cep` varchar(10) NOT NULL default '',
  `ins_telefone` varchar(15) NOT NULL default '',
  `ins_celular` varchar(15) default NULL,
  `ins_email` varchar(50) NOT NULL default '',
  `ins_quando` timestamp(14) NOT NULL,
  PRIMARY KEY  (`ins_cod`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Extraindo dados da tabela `inscricoes`
-- 


-- --------------------------------------------------------

-- 
-- Estrutura da tabela `noticias`
-- 

CREATE TABLE `noticias` (
  `not_cod` int(11) NOT NULL auto_increment,
  `cur_cod` int(11) NOT NULL default '0',
  `not_titulo` varchar(250) NOT NULL default '',
  `not_conteudo` longtext NOT NULL,
  `not_quando` timestamp(14) NOT NULL,
  `adm_cod` int(11) NOT NULL default '0',
  PRIMARY KEY  (`not_cod`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;

-- 
-- Extraindo dados da tabela `noticias`
-- 

INSERT INTO `noticias` VALUES (1, 5, 'Testando uma not�a de java.', 'Java.', '20051126161535', 1);
INSERT INTO `noticias` VALUES (2, 6, 'Testando uma not�a de gest㯮', 'Gest㯮', '20051126161301', 1);
INSERT INTO `noticias` VALUES (3, 1, 'Testando not�a principal...', 'Teste, teste, teste...Teste, teste, teste... Teste, teste, teste... Teste, teste, teste...', '20051126162406', 1);
INSERT INTO `noticias` VALUES (4, 1, 'testando agora um titulo bem grande para ultrapassar a linha da tabela que 頭uito pequema.', 'At頥ste sᢡdo foram afetados pelo protesto mais de 12.000 passageiros que n㯠conseguiram embarcar nos aeroportos internacional de Ezeiza e no ''Jorge Newbery'' (cabotagem e Uruguai), da capital.\r<br>\r<br>O sindicato dos aeroportuᲩos civis confirmou a greve neste sᢡdo, apesar de uma intima磯 do minist鲩o do Trabalho, que exigiu dos grevistas o cumprimento de um servi篠m�mo de emergꮣia estabelecido pela legisla磯.\r<br>\r<br>Os sindicatos da Associa磯 de Pilotos de Linhas A鲥as (APLA) e da Associa磯 de Pessoal T飮ico Aeronᵴico (APTA) ter㯠que pagar uma multa de 10,5 milh?de pesos (3,5 milh?de d󬡲es) se antes da pr󸩭a quinta-feira n㯠se resolver o conflito. ', '20051128140537', 1);
INSERT INTO `noticias` VALUES (5, 7, 'testandooooooo', 'teste\r<br>\r<br>teste\r<br>\r<br>teste\r<br>\r<br>teste\r<br>\r<br>teste\r<br>\r<br>teste', '20051128140945', 1);
INSERT INTO `noticias` VALUES (6, 5, 'Testando uma not�a', 'Teste ... teste...', '20051128160501', 2);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `professores`
-- 

CREATE TABLE `professores` (
  `pro_cod` int(11) NOT NULL auto_increment,
  `pro_nome` varchar(50) NOT NULL default '',
  `pro_atuacao` longtext,
  `pro_titulacao` longtext,
  `pro_formacao` longtext,
  `pro_email` varchar(50) NOT NULL default '',
  `pro_pag_pessoal` varchar(200) default NULL,
  PRIMARY KEY  (`pro_cod`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;

-- 
-- Extraindo dados da tabela `professores`
-- 

INSERT INTO `professores` VALUES (1, 'Jo㯠Pereira', 'teste', 'teste', 'teste', 'teste@teste.com', 'teste');
INSERT INTO `professores` VALUES (2, 'Paulo dos Santos', 'teste', 'teste', 'teste', 'teste@teste.com', 'teste');
INSERT INTO `professores` VALUES (3, 'Diogo', '', '', '', 'xgordo@gmail.com', '');
