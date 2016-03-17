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
INSERT INTO empresa VALUES (24,'Latic�nios Bor�','Com sede em Avar�, a Coalhada Bor� conquistou o mercado regional e hoje � comercializada em todo sudoeste do Estado de S�o Paulo.\r\n\r\nFeitas artesanalmente, as Coalhadas Bor� s�o produzidas na Fazenda','../arquivos/empresas/bora2.jpg','../arquivos/empresas/dsc08280_resize.jpg','../arquivos/empresas/dsc08295_resize.jpg','../arquivos/empresas/dsc08573_resize.jpg','../arquivos/empresas/dsc08570_resize.jpg','../arquivos/empresas/dsc08572_resize.jpg','../arquivos/empresas/dsc08575_resize.jpg');
INSERT INTO empresa VALUES (27,'Caf� Manduri','Torrefa��o e Comercializa��o de caf�s  Gourmet \"Esspresso\" e Torrado e Mo�do � V�cuo e Tradicional','../arquivos/empresas/cafe_manduri_banner.jpg','','','','','','');
INSERT INTO empresa VALUES (26,'Casinha da Ro�a','Produ��o Artesanal de doces em Piraju.','../arquivos/empresas/rotulo_casinhadaroca10x5.jpg','','','','','','');

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

INSERT INTO evento VALUES (10,'Churrasco de Marketin','Tem um casal novo circulando em S�o Paulo: Ana Claudia Michels e Tato Malzoni - ele mesmo, o  ex-namorado de Daniella Cicarelli, com quem a modelo protagonizou cenas t�rridas   na praia de Tarifa, na Espanha. Ana Claudia e o empres�rio chegaram de m�os dadas ao desfile de Waldemar I�dice, no shopping Iguatemi na quinta-feira, 19, terceiro dia da  S�o Paulo Fashion Week. ','2008-06-19','../arquivos/eventos/2005-mustang-gtr-006.jpg','../arquivos/eventos/keira-knightley-1024x768-15867.jpg','','','','','','');
INSERT INTO evento VALUES (9,'Testando evento 2','Tem um casal novo circulando em S�o Paulo: Ana Claudia Michels e Tato Malzoni - ele mesmo, o ex-namorado de Daniella Cicarelli, com quem a modelo protagonizou cenas t�rridas na praia de Tarifa, na Espanha. Ana Claudia e o empres�rio chegaram de m�os dadas ao desfile de Waldemar I�dice, no shopping Iguatemi na quinta-feira, 19, terceiro dia da S�o Paulo Fashion Week. ','2008-06-19','../arquivos/eventos/034_g.sized.jpg','../arquivos/eventos/010_g.sized.jpg','','','','','','');
INSERT INTO evento VALUES (8,'Testando evento 1','Tem um casal novo circulando em S�o Paulo: Ana Claudia Michels e Tato Malzoni - ele mesmo, o ex-namorado de Daniella Cicarelli, com quem a modelo protagonizou cenas t�rridas na praia de Tarifa, na Espanha. Ana Claudia e o empres�rio chegaram de m�os dadas ao desfile de Waldemar I�dice, no shopping Iguatemi na quinta-feira, 19, terceiro dia da S�o Paulo Fashion Week. ','2008-06-19','../arquivos/eventos/cep_profile_01_large[1].jpg','../arquivos/eventos/cep_profile_03_large[1].jpg','../arquivos/eventos/cep_profile_02_large[3].jpg','','','','','');
INSERT INTO evento VALUES (11,'Festa de Anivers�rio','Tem um casal novo circulando em S�o Paulo: Ana Claudia Michels e Tato Malzoni - ele mesmo, o ex-namorado de Daniella Cicarelli, com quem a modelo protagonizou cenas t�rridas na praia de Tarifa, na Espanha.','2008-06-19','../arquivos/eventos/viking2[1].jpg','','','','','','','');
INSERT INTO evento VALUES (12,'Aprocamp','Apresenta��o dos Filiados','2008-06-22','../arquivos/eventos/dsc05530_resize.jpg','../arquivos/eventos/dsc05531_resize.jpg','../arquivos/eventos/dsc05556_resize.jpg','../arquivos/eventos/dsc09726_resize.jpg','../arquivos/eventos/dsc09727_resize.jpg','../arquivos/eventos/dsc09728_resize.jpg','../arquivos/eventos/dsc09729_resize.jpg','../arquivos/eventos/dsc05530_resize[1].jpg');

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

INSERT INTO noticia VALUES (28,'Justi�a Militar decreta pris�o de 4 envolvidos no caso da Provid�ncia','O juiz Edmundo Franca de Oliveira, da 2� auditoria da Justi�a Militar, decretou a pris�o preventiva de quatro envolvidos na morte de tr�s jovens do Morro da Provid�ncia, na Zona Portu�ria do Rio, ocorrida no fim de semana.\r\n\r\n\r\nO tenente Vinicius Ghidetti de Moraes Andrade, o sargento Leandro Maia Bueno e os soldados Jos� Ricardo Rodrigues de Ara�jo e Fabiano El�i dos Santos, que j� est�o presos no 1� Batalh�o da Pol�cia do Ex�rcito, na Tijuca, responder�o pelos poss�veis crimes militares que tenham cometido.\r\n\r\n \r\n\r\nEles est�o presos cumprindo determina��o da Justi�a comum e continuar�o a cumprir o novo mandado no mesmo local.\r\n\r\n \r\n\r\nA promotora da Justi�a Militar Hevelize Jourdan Covas tomou o depoimento do capit�o Laerte Ferrari, respons�vel pela pol�cia judici�ria no dia da ocorr�ncia, e o tenente Vinicius. Em depoimento ao delegado da 4�. DP (Centro), o tenente Vinicius disse que n�o cumpriu a determina��o do capit�o Ferreti para soltar os tr�s jovens temendo a rea��o da tropa.\r\n\r\n \r\n\r\nSe condenados, a pena para os 11 militares pode chegar a 90 anos de pris�o. �Decidi pelos 11 porque todos tiveram participa��o. Quem n�o quisesse participar, que descesse do caminh�o antes�, disse o delegado respons�vel pelo caso, Ricardo Dominguez.\r\n\r\n \r\n Laudo confirma tortura\r\n\r\nSegundo o laudo do Instituto M�dico Legal (IML), Wellington Gonzaga, de 19 anos, foi atingido por 19 tiros e sofreu mutila��es, David Wilson Floren�o, de 24 anos, levou 26 tiros e estava com as m�o amarradas, e o menor, que levou um tiro no peito, foi arrastado pela favela com as pernas amarradas. Os corpos foram encontrados no domingo (15) no lix�o de Gramacho, em Duque de Caxias, na Baixada Fluminense.\r\n\r\nDe acordo com a pol�cia, os chefes do tr�fico do Morro da Mineira, Anderson Rocha Mendon�a, conhecido como Coelho, e Rog�rio Rios Mosqueira, o Roupinol, teriam ordenado o assassinado dos jovens.\r\n\r\nContra os dois h� tr�s mandados de pris�o por homic�dio. As investiga��es tentam descobrir agora se um corpo encontrado na quarta-feira (18) na favela � do traficante que teria negociado com os militares.\r\n\r\n \r\n Inqu�rito conclu�do\r\n\r\nO delegado concluiu o inqu�rito depois de ouvir o depoimento do capit�o do Ex�rcito que ordenou a libera��o dos jovens. Em depoimento, o militar contou que n�o considerou nenhum fato ofensivo que justificasse a pris�o e mandou que os tr�s fossem entregues �s fam�lias.\r\n\r\nO capit�o disse, ainda, que foi procurado por parentes logos depois. Eles informaram que os jovens foram deixados no Morro da Mineira, e que receberam um telefonema avisando: �J� eram�, ou seja, j� estavam mortos.\r\n\r\nCinco dias depois dos assassinatos dos tr�s jovens do Morro da Provid�ncia entregues por militares a traficantes do Morro da Mineira, suspeitos continuavam andando livremente armados na favela onde o grupo foi morto. Ainda n�o foram feitas opera��es para buscar os respons�veis pelo crime.\r\n\r\n \r\n TRE investiga uso eleitoral de obras\r\n\r\nO Tribunal Regional Eleitoral (TRE) do Rio de Janeiro est� investigando o poss�vel uso eleitoral do projeto Cimento Social, que prev� melhoras em moradias no Morro da Provid�ncia, no Centro do Rio, em favor de candidatos nas pr�ximas elei��es.\r\n\r\nPr�-candidato � Prefeitura do Rio, o senador Marcelo Crivella (PRB) � o criador do projeto, que conta com o apoio do governo federal, por meio do Minist�rio da Defesa e do Minist�rio das Cidades.\r\n\r\nUm relat�rio do setor de intelig�ncia do Ex�rcito revela que alguns moradores n�o concordaram com a �rea escolhida para as obras, alegando que o local j� tinha sido contemplado com um programa de urbaniza��o da prefeitura, e que deveria ser dada a oportunidade para regi�es do morro mais carente.\r\n\r\nO documento mostra ainda que o assessor de senador, identificado como Eduardo, teria feito um acordo com traficantes para garantir a seguran�a dos oper�rios. O relat�rio tamb�m cita um outro suposto assessor de Crivella, identificado como Gilmar.\r\n\r\nO senador Marcelo Crivella divulgou nota, nesta quinta-feira, em que declara ser falsa a informa��o de que um assessor tenha negociado o acordo. Ele afirmou que Gilmar nunca foi assessor do seu gabinete.\r\n\r\nAinda segundo a nota de Crivella, o Comando do Ex�rcito instaurou inqu�rito administrativo para apurar vazamentos de informa��es sobre fatos n�o comprovados. Ele tamb�m defendeu o projeto Cimento Social e associou a divulga��o do assunto � proximidade do in�cio da disputa eleitoral. \r\n\r\n \r\n\r\nEm nota, o Comando Militar do Leste declarou que n�o fornece informa��es sobre documentos operacionais relativos � participa��o das tropas no Morro da Provid�ncia e negou ter realizado reuni�es com pol�ticos ou assessores sobre o projeto Cimento Social.\r\n\r\n \r\n\r\nLeia mais not�cias do Rio de Janeiro','2008-06-19','../arquivos/noticias/sleepy_hollow.jpg');
INSERT INTO noticia VALUES (25,'teste','teste','2008-06-18','../arquivos/noticias/cep_profile_02_large.jpg');
INSERT INTO noticia VALUES (26,'Testando','testando','2008-06-19','../arquivos/noticias/pic23977.jpg');
INSERT INTO noticia VALUES (27,'iuhiuh','iuhiuhih','2008-06-19','');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
