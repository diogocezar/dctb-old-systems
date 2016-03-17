# MySQL-Front 3.2  (Build 2.10)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET CHARACTER SET '' */;


# Host: localhost    Database: omega
# ------------------------------------------------------
# Server version 4.0.21-nt

#
# Table structure for table ator
#

CREATE TABLE `ator` (
  `ato_cod` int(11) NOT NULL auto_increment,
  `ato_nome` varchar(50) NOT NULL default '',
  `ato_nome_nascimento` varchar(50) default NULL,
  `ato_profissao` varchar(250) default NULL,
  `ato_data_nascimento` date default NULL,
  `ato_pais_natal` varchar(50) default NULL,
  `ato_cidade_natal` varchar(50) default NULL,
  `ato_biografia` longtext,
  `ato_foto` varchar(200) default NULL,
  PRIMARY KEY  (`ato_cod`)
) TYPE=MyISAM;

#
# Dumping data for table ator
#


#
# Table structure for table ator_filme
#

CREATE TABLE `ator_filme` (
  `ato_cod` int(11) NOT NULL default '0',
  `fil_cod` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ato_cod`,`fil_cod`)
) TYPE=MyISAM;

#
# Dumping data for table ator_filme
#


#
# Table structure for table avaliacao
#

CREATE TABLE `avaliacao` (
  `fil_cod` int(11) NOT NULL default '0',
  `cli_cpf` int(11) NOT NULL default '0',
  `ava_nota` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fil_cod`,`cli_cpf`)
) TYPE=MyISAM;

#
# Dumping data for table avaliacao
#


#
# Table structure for table categoria
#

CREATE TABLE `categoria` (
  `cat_cod` int(11) NOT NULL auto_increment,
  `cat_nome` varchar(100) NOT NULL default '',
  `cat_descricao` longtext NOT NULL,
  `cat_temp_loc` int(11) NOT NULL default '0',
  `cat_preco` float NOT NULL default '0',
  PRIMARY KEY  (`cat_cod`)
) TYPE=MyISAM;

#
# Dumping data for table categoria
#


#
# Table structure for table classificacao
#

CREATE TABLE `classificacao` (
  `cla_cod` int(11) NOT NULL auto_increment,
  `cla_classificacao` varchar(250) NOT NULL default '',
  `cla_idade_recomendada` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`cla_cod`)
) TYPE=MyISAM;

#
# Dumping data for table classificacao
#


#
# Table structure for table cliente
#

CREATE TABLE `cliente` (
  `cli_cpf` int(11) NOT NULL default '0',
  `usu_cod` varchar(18) NOT NULL default '',
  `cli_rg` varchar(30) NOT NULL default '',
  `cli_rua` varchar(100) NOT NULL default '',
  `cli_numero` int(11) NOT NULL default '0',
  `cli_bairro` varchar(100) NOT NULL default '',
  `cli_telefone` varchar(15) NOT NULL default '',
  `cli_tel_comercial` varchar(15) default NULL,
  `cli_celular` varchar(15) default NULL,
  `cli_data_nascimento` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`cli_cpf`)
) TYPE=MyISAM;

#
# Dumping data for table cliente
#


#
# Table structure for table diretor
#

CREATE TABLE `diretor` (
  `dir_cod` int(11) NOT NULL auto_increment,
  `dir_nome` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`dir_cod`)
) TYPE=MyISAM;

#
# Dumping data for table diretor
#


#
# Table structure for table diretor_filme
#

CREATE TABLE `diretor_filme` (
  `dir_cod` int(11) NOT NULL default '0',
  `fil_cod` int(11) NOT NULL default '0',
  PRIMARY KEY  (`dir_cod`,`fil_cod`)
) TYPE=MyISAM;

#
# Dumping data for table diretor_filme
#


#
# Table structure for table email
#

CREATE TABLE `email` (
  `ema_id` int(11) NOT NULL auto_increment,
  `ema_email` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`ema_id`)
) TYPE=MyISAM;

#
# Dumping data for table email
#


#
# Table structure for table enquete
#

CREATE TABLE `enquete` (
  `enq_id` int(11) NOT NULL auto_increment,
  `usu_cod` int(11) NOT NULL default '0',
  `enq_pergunta` varchar(250) NOT NULL default '',
  `enq_exibir` int(11) NOT NULL default '0',
  PRIMARY KEY  (`enq_id`)
) TYPE=MyISAM;

#
# Dumping data for table enquete
#


#
# Table structure for table filme
#

CREATE TABLE `filme` (
  `fil_cod` int(11) NOT NULL auto_increment,
  `cat_cod` int(11) NOT NULL default '0',
  `cla_cod` int(11) NOT NULL default '0',
  `fil_titulo` varchar(250) NOT NULL default '',
  `fil_titulo_original` varchar(250) default NULL,
  `fil_ano` int(11) NOT NULL default '0',
  `fil_duracao` varchar(50) NOT NULL default '',
  `fil_sinopse` longtext NOT NULL,
  `fil_foto` varchar(200) default NULL,
  `fil_destaque` int(11) NOT NULL default '0',
  PRIMARY KEY  (`fil_cod`)
) TYPE=MyISAM;

#
# Dumping data for table filme
#


#
# Table structure for table genero
#

CREATE TABLE `genero` (
  `gen_cod` int(11) NOT NULL auto_increment,
  `gen_nome` varchar(50) NOT NULL default '',
  `gen_descricao` longtext NOT NULL,
  PRIMARY KEY  (`gen_cod`)
) TYPE=MyISAM;

#
# Dumping data for table genero
#


#
# Table structure for table genero_filme
#

CREATE TABLE `genero_filme` (
  `gen_cod` int(11) NOT NULL default '0',
  `fil_cod` int(11) NOT NULL default '0',
  PRIMARY KEY  (`gen_cod`,`fil_cod`)
) TYPE=MyISAM;

#
# Dumping data for table genero_filme
#


#
# Table structure for table locacao
#

CREATE TABLE `locacao` (
  `loc_cod` int(11) NOT NULL auto_increment,
  `cli_cpf` int(11) NOT NULL default '0',
  `txe_cod` int(11) NOT NULL default '0',
  `loc_quando` date default NULL,
  `loc_data_entrega` date default NULL,
  `loc_hora_entraga` varchar(5) default NULL,
  `loc_data_busca` date default NULL,
  `loc_hora_busca` varchar(5) default NULL,
  `loc_valor` float default NULL,
  `loc_multa` float default NULL,
  `loc_situacao` varchar(30) default NULL,
  PRIMARY KEY  (`loc_cod`)
) TYPE=MyISAM;

#
# Dumping data for table locacao
#


#
# Table structure for table midia
#

CREATE TABLE `midia` (
  `mid_cod` int(11) NOT NULL auto_increment,
  `fil_cod` int(11) NOT NULL default '0',
  `mid_tipo` varchar(50) NOT NULL default '',
  `mid_audio` varchar(250) NOT NULL default '',
  `mid_legenda` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`mid_cod`)
) TYPE=MyISAM;

#
# Dumping data for table midia
#


#
# Table structure for table midia_locacao
#

CREATE TABLE `midia_locacao` (
  `mid_cod` int(11) NOT NULL default '0',
  `loc_cod` int(11) NOT NULL default '0',
  `cod_midia_loc` char(18) NOT NULL default '',
  PRIMARY KEY  (`mid_cod`,`loc_cod`,`cod_midia_loc`)
) TYPE=MyISAM;

#
# Dumping data for table midia_locacao
#


#
# Table structure for table novidade
#

CREATE TABLE `novidade` (
  `nov_id` int(11) NOT NULL auto_increment,
  `usu_cod` int(11) NOT NULL default '0',
  `nov_titulo` varchar(250) NOT NULL default '',
  `nov_conteudo` text NOT NULL,
  `nov_quando` timestamp(14) NOT NULL,
  PRIMARY KEY  (`nov_id`)
) TYPE=MyISAM;

#
# Dumping data for table novidade
#


#
# Table structure for table produtos
#

CREATE TABLE `produtos` (
  `pro_cod` int(11) NOT NULL auto_increment,
  `pro_nome` varchar(100) NOT NULL default '',
  `pro_qtd` int(11) NOT NULL default '0',
  `pro_preco` float NOT NULL default '0',
  PRIMARY KEY  (`pro_cod`)
) TYPE=MyISAM;

#
# Dumping data for table produtos
#


#
# Table structure for table produtos_locacao
#

CREATE TABLE `produtos_locacao` (
  `pro_cod` int(11) NOT NULL default '0',
  `loc_cod` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pro_cod`,`loc_cod`)
) TYPE=MyISAM;

#
# Dumping data for table produtos_locacao
#


#
# Table structure for table respostas
#

CREATE TABLE `respostas` (
  `res_id` int(11) NOT NULL auto_increment,
  `enq_id` int(11) NOT NULL default '0',
  `res_resposta` varchar(250) NOT NULL default '',
  `res_votos` int(11) NOT NULL default '0',
  PRIMARY KEY  (`res_id`)
) TYPE=MyISAM;

#
# Dumping data for table respostas
#


#
# Table structure for table taxa_entrega
#

CREATE TABLE `taxa_entrega` (
  `txe_cod` int(11) NOT NULL auto_increment,
  `txe_localizacao` varchar(100) default NULL,
  `txe_valor` float default NULL,
  PRIMARY KEY  (`txe_cod`)
) TYPE=MyISAM;

#
# Dumping data for table taxa_entrega
#


#
# Table structure for table tipo_user
#

CREATE TABLE `tipo_user` (
  `tip_id_user` int(11) NOT NULL auto_increment,
  `tip_tipo` varchar(50) NOT NULL default '',
  `tip_nivel` int(11) NOT NULL default '0',
  PRIMARY KEY  (`tip_id_user`)
) TYPE=MyISAM;

#
# Dumping data for table tipo_user
#


#
# Table structure for table usuario
#

CREATE TABLE `usuario` (
  `usu_cod` int(11) NOT NULL auto_increment,
  `ema_id` varchar(18) NOT NULL default '',
  `usu_nome` varchar(50) NOT NULL default '',
  `usu_sobrenome` varchar(50) NOT NULL default '',
  `usu_login` varchar(15) NOT NULL default '',
  `usu_senha` varchar(15) NOT NULL default '',
  `tip_id_user` varchar(18) NOT NULL default '',
  PRIMARY KEY  (`usu_cod`)
) TYPE=MyISAM;

#
# Dumping data for table usuario
#


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
