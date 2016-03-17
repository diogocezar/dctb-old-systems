<?php
/**
* Arquivo de configura��o das classes.
*
* Definindo constantes de configura��o
*/

/**#@+
* Constantes
*/

/**
* B A N C O   D E   D A D O S
*/

/**
* Qual banco de dados ?
* Op��es :
* 1 - dbase
* 2 - fbsql
* 3 - ibase
* 4 - ifx
* 5 - msql
* 6 - mssql
* 7 - mysql
* 8 - mysqli
* 9 - oci8
* 10 - odbc
* 11 - pgsql
* 12 - sqlite
* 13 - storage
* 14 - sybase
*/
define(BASE_TYPE, 'pgsql');
 
/**
* Nome do Banco de Dados.
*/
define(BASE, 'oriant');

/**
* Servidor do Banco de Dados.
*/
define(HOST, 'localhost');

/**
* Usu�rio do Banco de Dados.
*/
define(USER, 'postgres');

/**
* Senha do Bando de Dados.
*/
define(PASS, 'panaca');

/**
* Localiza��o do Banco de Dados.
*/
define(PATH, '');

/**
* Variavel que receber� o objeto ap�s a conex�o.
*/	 
$dataBase = '';

/**
* E N V I O   D E   E - M A I L 
*/
	 
/**
* Diret�rio padr�o dos templates.
*/
define(TEMPLATE_HTML_DIR, '../html/');

/**
* Dom�nio do site.
*/
define(DOMAIN, 'http://'.$_SERVER['HTTP_HOST'].'/');

/**
* E N V I O   D E   A R Q U I V O S
*/

/**
* Limitar as extens�es ? (sim ou nao).
*/
define(LIMITAR_EXT, 'sim');

/**
* Extens�es autorizadas.
*/
$extValidas = array(0 => '.gif',
					1 => '.jpg',
					2 => '.jpeg',
					3 => '.png',
					4 => '.swf',
					5 => '.zip',
					6 => '.rar');
					
/**
* Array com os MIME types e suas respectivas extens�es.
*/

$mimeExt = array('image/gif'   => '.gif',
                 'image/pjpeg' => '.jpg',
				 'image/x-png' => '.png',
				 'application/x-shockwave-flash' => '.swf',
				 'application/x-zip-compressed'  => '.zip',
				 'application/x-rar-compressed'  => '.rar');

/**
* Limitar tamanho de arquivo ? (sim ou nao).
*/
define(LIMITAR_TAMANHO, 'sim');

/**
* Tamanho limite do arquivo em bytes.
*/
define(TAMANHO_BYTES, 50000000);

/**
* Alterar qualidade do arquivo no caso de foto (sim ou nao).
*/
define(ALTERAR_QUALIDADE, 'sim');

/**
* Qualidade da foto que ser� grava no servidor.
*/
define(QUALIDADE, 90);

/**
* G E R A � � O   D E   F O T O S 
*/

/**
* Mensagem de erro padr�o.
*/
define(MSG_IMG_ERRO, 'Erro ao carregar imagem.');

/**
* Altura da imagem no tamanho miniatura.
*/
define(ALTURA_MINIATURA, 90);

/**
* Largura da imagem no tamanho miniatura.
*/
define(LARGURA_MINIATURA, 70);

/**
* Altura da imagem no tamanho grande.
*/
define(ALTURA_GRANDE, 400);

/**
* Largura da imagem no tamanho grande.
*/
define(LARGURA_GRANDE, 380);

/**
* Tempo de espera ap�s carregar a p�gina, at� subistituir os links.
*/
define(TIME, '1500');

/**
* T�tulo do site
*/
define(TITULO, "OriAnt 2007");

/**
* �ndice das cookies
*/
define(COOKIE_GRUPO, 'cke_grupo');
define(COOKIE_QUALG, 'cke_qualg');
define(COOKIE_CONTE, 'cke_conte');
define(COOKIE_TIPOO, 'cke_tipoo');

/**
* �ndice das sessions
*/
define(SESSION_GRUPO, 'ses_grupo');
define(SESSION_QUALG, 'ses_qualg');
define(SESSION_CONTE, 'ses_conte');
define(SESSION_TIPOO, 'ses_tipoo');
define(SESSION_ADMIN, 'ses_admin');
define(SESSION_NOMEA, 'ses_nomea');

/**
* Configura��es padronizadas
*/
define(TIPO_PADRAO, 'obj');
define(CONTEXTO_PADRAO, 'all_pages');
?>