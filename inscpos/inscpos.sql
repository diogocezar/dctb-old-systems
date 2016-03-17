# MySQL-Front 5.0  (Build 1.133)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: localhost    Database: inscpos
# ------------------------------------------------------
# Server version 5.0.51b-community-nt

DROP DATABASE IF EXISTS `inscpos`;
CREATE DATABASE `inscpos` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `inscpos`;

#
# Table structure for table administrador
#

CREATE TABLE `administrador` (
  `idadministrador` int(11) NOT NULL auto_increment,
  `idcurso` int(11) default NULL,
  `nome` varchar(250) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `login` varchar(50) NOT NULL default '',
  `senha` varchar(50) NOT NULL default '',
  `situacao` tinyint(1) NOT NULL default '0',
  `data_baixa` varchar(18) default NULL,
  PRIMARY KEY  (`idadministrador`),
  KEY `idcurso` (`idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# Dumping data for table administrador
#
LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;

INSERT INTO `administrador` VALUES (1,1,'Luciano Pansanato','luciano@utfpr.edu.br','luciano','123mudar',1,NULL);
INSERT INTO `administrador` VALUES (2,5,'EDUARDO COTRIN TEIXEIRA','cotrin@utfpr.edu.br','COTRIN','123mudar',1,NULL);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table curso
#

CREATE TABLE `curso` (
  `idcurso` int(11) NOT NULL auto_increment,
  `nome` varchar(250) NOT NULL default '',
  `periodo_inscricao` varchar(255) default NULL,
  `ativo` tinyint(1) NOT NULL default '1',
  `situacao` tinyint(1) NOT NULL default '0',
  `data_baixa` varchar(18) default NULL,
  PRIMARY KEY  (`idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

#
# Dumping data for table curso
#
LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;

INSERT INTO `curso` VALUES (1,'GEEPG','[principal]',1,1,NULL);
INSERT INTO `curso` VALUES (2,'ENGENHARIA DE SEGURAN?A DO TRABALHO','10/07/2010 AT? 10/08/2010',1,1,NULL);
INSERT INTO `curso` VALUES (3,'III CULTURA, TECNOLOGIA E ENSINO DE L?NGUAS','10/07/2010 AT? 10/08/2010',1,1,NULL);
INSERT INTO `curso` VALUES (4,'TECNOLOGIA JAVA','10/07/2010 AT? 10/08/2010',1,1,NULL);
INSERT INTO `curso` VALUES (5,'MBA EM GEST?O DA PRODU??O - 9? TURMA 2010','10/07/2010 AT? 10/08/2010',1,1,NULL);
INSERT INTO `curso` VALUES (6,'VIII AUTOMA??O E CONTROLE DE PROCESSOS INDUSTRIAIS','10/07/2010 AT? 10/08/2010',1,1,NULL);
INSERT INTO `curso` VALUES (7,'II GERONTOLOGIA','10/07/2010 AT? 10/08/2010',1,1,NULL);
INSERT INTO `curso` VALUES (8,'III AUDITORIA E GESTÃO AMBIENTAL','10/07/2010 AT? 10/08/2010',1,1,NULL);
INSERT INTO `curso` VALUES (9,'GERÊNCIA DA MANUTENÇÃO','10/07/2010 AT? 10/08/2010',1,1,NULL);
INSERT INTO `curso` VALUES (10,'EDUCAÇÃO PROFISSIONAL INTEGRADA AEDUCAÇÃO BÁSICA NA MODALIDADE EDUCAÇÃO PARA JOVENS E ADULTOS','10/07/2010 AT? 10/08/2010',1,1,NULL);
INSERT INTO `curso` VALUES (11,'PROCESSOS INDUSTRIAIS SULCROALCOOLEIROS','10/07/2010 AT? 10/08/2010',1,1,NULL);
/*!40000 ALTER TABLE `curso` ENABLE KEYS */;
UNLOCK TABLES;

#
# Table structure for table inscricao
#

CREATE TABLE `inscricao` (
  `idinscricao` int(11) NOT NULL auto_increment,
  `idcurso` int(11) NOT NULL default '0',
  `nome` varchar(250) NOT NULL default '',
  `data_nascimento` date NOT NULL default '0000-00-00',
  `curso_graduacao` varchar(250) NOT NULL default '',
  `instituicao_graduacao` varchar(250) NOT NULL default '',
  `ano_conclusao` int(11) NOT NULL default '0',
  `profissao` varchar(250) NOT NULL default '',
  `cidade` varchar(250) NOT NULL default '',
  `estado` char(2) NOT NULL default '',
  `telefone` varchar(15) NOT NULL default '',
  `celular` varchar(15) default NULL,
  `email` varchar(100) NOT NULL default '',
  `situacao` tinyint(1) NOT NULL default '0',
  `data_baixa` date default NULL,
  `data_cadastro` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`idinscricao`),
  KEY `idcurso` (`idcurso`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

#
# Dumping data for table inscricao
#
LOCK TABLES `inscricao` WRITE;
/*!40000 ALTER TABLE `inscricao` DISABLE KEYS */;

INSERT INTO `inscricao` VALUES (1,4,'LUCINANO TADEU ESTEVES PANSANATO','2068-04-28','CIÊNCIAS DE COMPUTAÇÃO','UNESP',1991,'PROFESSOR','CORNÉLIO PROCÓPIO','PR','43-3523-4111',NULL,'luciano@utfpr.edu.br',1,NULL,'0000-00-00 00:00:00');
INSERT INTO `inscricao` VALUES (2,4,'EDUARDO','1975-09-09','CIENCIA DA COMPUTAÇÃO','UEL',1997,'PROFESSOR','CORNELIO PROCOPIO','PR','43-3523-1591','43-9152-7402','cotrin@utfpr.edu.br',1,'2010-10-10','2010-08-09 15:45:09');
INSERT INTO `inscricao` VALUES (3,5,'pokpok','0000-00-00','hiuhiuh','iuhiuhi',7676,'oijoij','oijoijoij','PR','68-7687-6876','87-6876-8768','oijoij@.',1,NULL,'2010-08-09 18:45:46');
INSERT INTO `inscricao` VALUES (4,5,'pokpok','0000-00-00','hiuhiuh','iuhiuhi',7676,'oijoij','oijoijoij','PR','68-7687-6876','87-6876-8768','oijoij@.',1,NULL,'2010-08-09 18:45:58');
INSERT INTO `inscricao` VALUES (5,5,'pokpok','0000-00-00','hiuhiuh','iuhiuhi',7676,'oijoij','oijoijoij','PR','68-7687-6876','87-6876-8768','oijoij@.',1,NULL,'2010-08-09 18:46:40');
INSERT INTO `inscricao` VALUES (6,5,'pokpok','0000-00-00','hiuhiuh','iuhiuhi',7676,'oijoij','oijoijoij','PR','68-7687-6876','87-6876-8768','oijoij@.',1,NULL,'2010-08-09 18:48:02');
INSERT INTO `inscricao` VALUES (7,5,'pokpok','0000-00-00','hiuhiuh','iuhiuhi',7676,'oijoij','oijoijoij','PR','68-7687-6876','87-6876-8768','oijoij@.',1,NULL,'2010-08-09 18:48:40');
INSERT INTO `inscricao` VALUES (8,5,'pokpok','0000-00-00','hiuhiuh','iuhiuhi',7676,'oijoij','oijoijoij','PR','68-7687-6876','87-6876-8768','oijoij@.',1,NULL,'2010-08-09 18:48:46');
INSERT INTO `inscricao` VALUES (9,5,'pokpok','0000-00-00','hiuhiuh','iuhiuhi',7676,'oijoij','oijoijoij','PR','68-7687-6876','87-6876-8768','oijoij@.',1,NULL,'2010-08-09 18:48:54');
INSERT INTO `inscricao` VALUES (10,5,'pokpok','0000-00-00','hiuhiuh','iuhiuhi',7676,'oijoij','oijoijoij','PR','68-7687-6876','87-6876-8768','oijoij@.',1,NULL,'2010-08-09 18:50:01');
INSERT INTO `inscricao` VALUES (11,5,'pokpok','0000-00-00','hiuhiuh','iuhiuhi',7676,'oijoij','oijoijoij','PR','68-7687-6876','87-6876-8768','oijoij@.',1,NULL,'2010-08-09 18:50:42');
/*!40000 ALTER TABLE `inscricao` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
