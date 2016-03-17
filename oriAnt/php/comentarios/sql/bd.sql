--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `pg` varchar(120) default NULL,
  `nome` varchar(120) default NULL,
  `email` varchar(120) default NULL,
  `url` varchar(120) default NULL,
  `comentario` text,
  `timestamp` int(11) default NULL
) 
