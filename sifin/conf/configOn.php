<?php
/**
* Arquivo de configuracao das classes.
*
* Definindo constantes de configuracao
*/

/**#@+
* Constantes
*/

/**
* Incluindo as configuracoes do site
*/
include("configSite.php");

/**
* B A N C O   D E   D A D O S
*/

/**
* Qual banco de dados ?
* Opcoes :
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
define(BASE, 'sifin');

/**
* Servidor do Banco de Dados.
*/
define(HOST, '127.0.0.1');

/**
* Usuario do Banco de Dados.
*/
define(USER, 'sifin');

/**
* Senha do Bando de Dados.
*/
define(PASS, 's1f1n');

/**
* Localizacao do Banco de Dados.
*/
define(PATH, '');

/**
* Variavel que recebera o objeto apos a conexao.
*/	 
$dataBase = '';

define(TEMPLATE_HTML_DIR, '../html/');


/**
* C O O K I E S
*/
	 
/**
* Tempo para a cookie expirar.
*/
define(EXPIRE, 3600);

/**
* Path padrao para armazenamento das cookies.
*/
define(PATH_COOKIE, '/');

/**
* Domain.
*/
define(DOMAIN, 'http://luthieriarockcp.com.br');

/**
* Nivel de seguranca da cookie.
*/
define(SECURE, 0);

/**
* E N V I O   D E   A R Q U I V O S
*/

/**
* Limitar as extensoes ? (sim ou nao).
*/
define(LIMITAR_EXT, 'sim');

/**
* Extensoes autorizadas.
*/
$extValidas = array(0 => '.doc',
					1 => '.pdf',
					2 => '.xls',
					3 => '.docx',
					4 => '.xlsx'
					);
					
/**
* Array com os MIME types e suas respectivas extensoes.
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
* Qualidade da foto que sera grava no servidor.
*/
define(QUALIDADE, 90);

/**
* G E R A c a O   D E   F O T O S 
*/

/**
* Mensagem de erro padrao.
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
* G E R A c a O   D O   F R E T E
*/

/**
* Frete de origem das encomendas.
*/
define(FRETE_ORIGEM, '86300000');

/**
* Tempo de espera apos carregar a pagina, ate subistituir os links.
*/
define(TIME, '500');
?>
