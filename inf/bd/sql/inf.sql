# MySQL-Front 3.2  (Build 2.10)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET CHARACTER SET '' */;


# Host: localhost    Database: inf
# ------------------------------------------------------
# Server version 4.0.21-nt

#
# Table structure for table administrador
#

CREATE TABLE `administrador` (
  `idAdministrador` int(10) unsigned NOT NULL auto_increment,
  `nomeAd` varchar(50) default NULL,
  `loginAd` varchar(10) default NULL,
  `senhaAd` varchar(10) default NULL,
  `emailAd` varchar(30) default NULL,
  PRIMARY KEY  (`idAdministrador`)
) TYPE=MyISAM;

#
# Dumping data for table administrador
#


#
# Table structure for table disciplinas
#

CREATE TABLE `disciplinas` (
  `idDisciplinas` int(10) unsigned NOT NULL auto_increment,
  `nomeDi` varchar(200) default NULL,
  `periodoDi` varchar(100) default NULL,
  `cargaHorariaDi` int(10) unsigned default NULL,
  `objetivosDi` text,
  `ementasDi` text,
  PRIMARY KEY  (`idDisciplinas`)
) TYPE=MyISAM;

#
# Dumping data for table disciplinas
#


#
# Table structure for table eventos
#

CREATE TABLE `eventos` (
  `idEventos` int(10) unsigned NOT NULL auto_increment,
  `Administrador_idAdministrador` int(10) unsigned NOT NULL default '0',
  `dataEv` date default NULL,
  `horaEv` time default NULL,
  `localEv` varchar(250) default NULL,
  `descricaoEv` text,
  PRIMARY KEY  (`idEventos`),
  KEY `Eventos_FKIndex1` (`Administrador_idAdministrador`)
) TYPE=MyISAM;

#
# Dumping data for table eventos
#


#
# Table structure for table links
#

CREATE TABLE `links` (
  `idLinks` int(10) unsigned NOT NULL auto_increment,
  `nomeLi` varchar(200) default NULL,
  `urlLi` varchar(200) default NULL,
  `visitasLi` int(10) unsigned default NULL,
  PRIMARY KEY  (`idLinks`)
) TYPE=MyISAM;

#
# Dumping data for table links
#


#
# Table structure for table noticias
#

CREATE TABLE `noticias` (
  `idNoticias` int(10) unsigned NOT NULL auto_increment,
  `Administrador_idAdministrador` int(10) unsigned NOT NULL default '0',
  `tituloNo` varchar(250) default NULL,
  `descricaoNo` text,
  `imagemNo` varchar(200) default NULL,
  `dataHoraNo` timestamp(14) NOT NULL,
  PRIMARY KEY  (`idNoticias`),
  KEY `Noticias_FKIndex1` (`Administrador_idAdministrador`)
) TYPE=MyISAM;

#
# Dumping data for table noticias
#


#
# Table structure for table professores
#

CREATE TABLE `professores` (
  `idProfessores` int(10) unsigned NOT NULL auto_increment,
  `nomePro` varchar(100) default NULL,
  `nickPro` varchar(15) default NULL,
  `imagemPro` varchar(200) default NULL,
  `sitePro` varchar(200) default NULL,
  `descricaoPro` text,
  PRIMARY KEY  (`idProfessores`)
) TYPE=MyISAM;

#
# Dumping data for table professores
#


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
