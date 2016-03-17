# MySQL-Front 3.2  (Build 2.10)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET CHARACTER SET '' */;


CREATE TABLE download (
  id int(11) NOT NULL auto_increment,
  titulo varchar(200) NOT NULL default '',
  url varchar(200) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

INSERT INTO download VALUES (1,'Planilha de Contas','planilha.pdf');
INSERT INTO download VALUES (2,'Testando download','');
INSERT INTO download VALUES (3,'oijoij','../arquivos/downloads/cep_profile_01_large.jpg');

CREATE TABLE empresa (
  id int(11) NOT NULL auto_increment,
  nome varchar(200) NOT NULL default '',
  descricao varchar(200) NOT NULL default '',
  logo varchar(200) NOT NULL default '',
  foto1 varchar(200) default NULL,
  foto2 varchar(200) default NULL,
  foto3 varchar(200) default NULL,
  foto4 varchar(200) default NULL,
  foto5 varchar(200) default NULL,
  foto6 varchar(200) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

INSERT INTO empresa VALUES (22,'teste','teste','../arquivos/empresas/avatar.jpg','../arquivos/empresas/at.jpg','../arquivos/empresas/avs.jpg','','','','');
INSERT INTO empresa VALUES (23,'Empresa teste','Testando a empresa','../arquivos/empresas/mo.jpg','../arquivos/empresas/hero.jpg','../arquivos/empresas/test_018.jpg','../arquivos/empresas/monstro3.gif','../arquivos/empresas/014_g.sized.jpg','../arquivos/empresas/020_g.sized.jpg','../arquivos/empresas/033_g.sized.jpg');
INSERT INTO empresa VALUES (24,'Laticínios Borá','Com sede em Avaré, a Coalhada Borá conquistou o mercado regional e hoje é comercializada em todo sudoeste do Estado de São Paulo.\r\n\r\nFeitas artesanalmente, as Coalhadas Borá são produzidas na Fazenda','../arquivos/empresas/bora2.jpg','../arquivos/empresas/dsc08280_resize.jpg','../arquivos/empresas/dsc08295_resize.jpg','../arquivos/empresas/dsc08573_resize.jpg','../arquivos/empresas/dsc08570_resize.jpg','../arquivos/empresas/dsc08572_resize.jpg','../arquivos/empresas/dsc08575_resize.jpg');
INSERT INTO empresa VALUES (27,'Café Manduri','Torrefação e Comercialização de cafés  Gourmet \"Esspresso\" e Torrado e Moído à Vácuo e Tradicional','../arquivos/empresas/cafe_manduri_banner.jpg','','','','','','');
INSERT INTO empresa VALUES (26,'Casinha da Roça','Produção Artesanal de doces em Piraju.','../arquivos/empresas/rotulo_casinhadaroca10x5.jpg','','','','','','');

CREATE TABLE evento (
  id int(11) NOT NULL auto_increment,
  titulo varchar(200) default NULL,
  descricao text,
  data date NOT NULL default '0000-00-00',
  foto1 varchar(200) default NULL,
  foto2 varchar(200) default NULL,
  foto3 varchar(200) default NULL,
  foto4 varchar(200) default NULL,
  foto5 varchar(200) default NULL,
  foto6 varchar(200) default NULL,
  foto7 varchar(200) default NULL,
  foto8 varchar(200) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

INSERT INTO evento VALUES (10,'Churrasco de Marketin','Tem um casal novo circulando em São Paulo: Ana Claudia Michels e Tato Malzoni - ele mesmo, o  ex-namorado de Daniella Cicarelli, com quem a modelo protagonizou cenas tórridas   na praia de Tarifa, na Espanha. Ana Claudia e o empresário chegaram de mãos dadas ao desfile de Waldemar Iódice, no shopping Iguatemi na quinta-feira, 19, terceiro dia da  São Paulo Fashion Week. ','2008-06-19','../arquivos/eventos/2005-mustang-gtr-006.jpg','../arquivos/eventos/keira-knightley-1024x768-15867.jpg','','','','','','');
INSERT INTO evento VALUES (9,'Testando evento 2','Tem um casal novo circulando em São Paulo: Ana Claudia Michels e Tato Malzoni - ele mesmo, o ex-namorado de Daniella Cicarelli, com quem a modelo protagonizou cenas tórridas na praia de Tarifa, na Espanha. Ana Claudia e o empresário chegaram de mãos dadas ao desfile de Waldemar Iódice, no shopping Iguatemi na quinta-feira, 19, terceiro dia da São Paulo Fashion Week. ','2008-06-19','../arquivos/eventos/034_g.sized.jpg','../arquivos/eventos/010_g.sized.jpg','','','','','','');
INSERT INTO evento VALUES (8,'Testando evento 1','Tem um casal novo circulando em São Paulo: Ana Claudia Michels e Tato Malzoni - ele mesmo, o ex-namorado de Daniella Cicarelli, com quem a modelo protagonizou cenas tórridas na praia de Tarifa, na Espanha. Ana Claudia e o empresário chegaram de mãos dadas ao desfile de Waldemar Iódice, no shopping Iguatemi na quinta-feira, 19, terceiro dia da São Paulo Fashion Week. ','2008-06-19','../arquivos/eventos/cep_profile_01_large[1].jpg','../arquivos/eventos/cep_profile_03_large[1].jpg','../arquivos/eventos/cep_profile_02_large[3].jpg','','','','','');
INSERT INTO evento VALUES (11,'Festa de Aniversário','Tem um casal novo circulando em São Paulo: Ana Claudia Michels e Tato Malzoni - ele mesmo, o ex-namorado de Daniella Cicarelli, com quem a modelo protagonizou cenas tórridas na praia de Tarifa, na Espanha.','2008-06-19','../arquivos/eventos/viking2[1].jpg','','','','','','','');
INSERT INTO evento VALUES (12,'Aprocamp','Apresentação dos Filiados','2008-06-22','../arquivos/eventos/dsc05530_resize.jpg','../arquivos/eventos/dsc05531_resize.jpg','../arquivos/eventos/dsc05556_resize.jpg','../arquivos/eventos/dsc09726_resize.jpg','../arquivos/eventos/dsc09727_resize.jpg','../arquivos/eventos/dsc09728_resize.jpg','../arquivos/eventos/dsc09729_resize.jpg','../arquivos/eventos/dsc05530_resize[1].jpg');

CREATE TABLE link (
  id int(11) NOT NULL auto_increment,
  titulo varchar(200) NOT NULL default '',
  link varchar(200) NOT NULL default '',
  descricao text NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

INSERT INTO link VALUES (1,'Globo','http://www.globo.com','Link do site da globo');
INSERT INTO link VALUES (2,'Uol','http://www.uol.com.br','Link do site da uol');
INSERT INTO link VALUES (3,'teste','www.globo.com','teste');

CREATE TABLE noticia (
  id int(11) NOT NULL auto_increment,
  titulo varchar(200) NOT NULL default '',
  descricao text NOT NULL,
  data date NOT NULL default '0000-00-00',
  foto varchar(200) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

INSERT INTO noticia VALUES (28,'Justiça Militar decreta prisão de 4 envolvidos no caso da Providência','O juiz Edmundo Franca de Oliveira, da 2ª auditoria da Justiça Militar, decretou a prisão preventiva de quatro envolvidos na morte de três jovens do Morro da Providência, na Zona Portuária do Rio, ocorrida no fim de semana.\r\n\r\n\r\nO tenente Vinicius Ghidetti de Moraes Andrade, o sargento Leandro Maia Bueno e os soldados José Ricardo Rodrigues de Araújo e Fabiano Elói dos Santos, que já estão presos no 1º Batalhão da Polícia do Exército, na Tijuca, responderão pelos possíveis crimes militares que tenham cometido.\r\n\r\n \r\n\r\nEles estão presos cumprindo determinação da Justiça comum e continuarão a cumprir o novo mandado no mesmo local.\r\n\r\n \r\n\r\nA promotora da Justiça Militar Hevelize Jourdan Covas tomou o depoimento do capitão Laerte Ferrari, responsável pela polícia judiciária no dia da ocorrência, e o tenente Vinicius. Em depoimento ao delegado da 4ª. DP (Centro), o tenente Vinicius disse que não cumpriu a determinação do capitão Ferreti para soltar os três jovens temendo a reação da tropa.\r\n\r\n \r\n\r\nSe condenados, a pena para os 11 militares pode chegar a 90 anos de prisão. “Decidi pelos 11 porque todos tiveram participação. Quem não quisesse participar, que descesse do caminhão antes”, disse o delegado responsável pelo caso, Ricardo Dominguez.\r\n\r\n \r\n Laudo confirma tortura\r\n\r\nSegundo o laudo do Instituto Médico Legal (IML), Wellington Gonzaga, de 19 anos, foi atingido por 19 tiros e sofreu mutilações, David Wilson Florenço, de 24 anos, levou 26 tiros e estava com as mão amarradas, e o menor, que levou um tiro no peito, foi arrastado pela favela com as pernas amarradas. Os corpos foram encontrados no domingo (15) no lixão de Gramacho, em Duque de Caxias, na Baixada Fluminense.\r\n\r\nDe acordo com a polícia, os chefes do tráfico do Morro da Mineira, Anderson Rocha Mendonça, conhecido como Coelho, e Rogério Rios Mosqueira, o Roupinol, teriam ordenado o assassinado dos jovens.\r\n\r\nContra os dois há três mandados de prisão por homicídio. As investigações tentam descobrir agora se um corpo encontrado na quarta-feira (18) na favela é do traficante que teria negociado com os militares.\r\n\r\n \r\n Inquérito concluído\r\n\r\nO delegado concluiu o inquérito depois de ouvir o depoimento do capitão do Exército que ordenou a liberação dos jovens. Em depoimento, o militar contou que não considerou nenhum fato ofensivo que justificasse a prisão e mandou que os três fossem entregues às famílias.\r\n\r\nO capitão disse, ainda, que foi procurado por parentes logos depois. Eles informaram que os jovens foram deixados no Morro da Mineira, e que receberam um telefonema avisando: “Já eram”, ou seja, já estavam mortos.\r\n\r\nCinco dias depois dos assassinatos dos três jovens do Morro da Providência entregues por militares a traficantes do Morro da Mineira, suspeitos continuavam andando livremente armados na favela onde o grupo foi morto. Ainda não foram feitas operações para buscar os responsáveis pelo crime.\r\n\r\n \r\n TRE investiga uso eleitoral de obras\r\n\r\nO Tribunal Regional Eleitoral (TRE) do Rio de Janeiro está investigando o possível uso eleitoral do projeto Cimento Social, que prevê melhoras em moradias no Morro da Providência, no Centro do Rio, em favor de candidatos nas próximas eleições.\r\n\r\nPré-candidato à Prefeitura do Rio, o senador Marcelo Crivella (PRB) é o criador do projeto, que conta com o apoio do governo federal, por meio do Ministério da Defesa e do Ministério das Cidades.\r\n\r\nUm relatório do setor de inteligência do Exército revela que alguns moradores não concordaram com a área escolhida para as obras, alegando que o local já tinha sido contemplado com um programa de urbanização da prefeitura, e que deveria ser dada a oportunidade para regiões do morro mais carente.\r\n\r\nO documento mostra ainda que o assessor de senador, identificado como Eduardo, teria feito um acordo com traficantes para garantir a segurança dos operários. O relatório também cita um outro suposto assessor de Crivella, identificado como Gilmar.\r\n\r\nO senador Marcelo Crivella divulgou nota, nesta quinta-feira, em que declara ser falsa a informação de que um assessor tenha negociado o acordo. Ele afirmou que Gilmar nunca foi assessor do seu gabinete.\r\n\r\nAinda segundo a nota de Crivella, o Comando do Exército instaurou inquérito administrativo para apurar vazamentos de informações sobre fatos não comprovados. Ele também defendeu o projeto Cimento Social e associou a divulgação do assunto à proximidade do início da disputa eleitoral. \r\n\r\n \r\n\r\nEm nota, o Comando Militar do Leste declarou que não fornece informações sobre documentos operacionais relativos à participação das tropas no Morro da Providência e negou ter realizado reuniões com políticos ou assessores sobre o projeto Cimento Social.\r\n\r\n \r\n\r\nLeia mais notícias do Rio de Janeiro','2008-06-19','../arquivos/noticias/sleepy_hollow.jpg');
INSERT INTO noticia VALUES (25,'teste','teste','2008-06-18','../arquivos/noticias/cep_profile_02_large.jpg');
INSERT INTO noticia VALUES (26,'Testando','testando','2008-06-19','../arquivos/noticias/pic23977.jpg');
INSERT INTO noticia VALUES (27,'iuhiuh','iuhiuhih','2008-06-19','');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
