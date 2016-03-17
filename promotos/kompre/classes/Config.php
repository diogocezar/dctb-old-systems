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
define(BASE_TYPE, 'mysql');
 
/**
* Nome do Banco de Dados.
*/
define(BASE, 'promotos');

/**
* Servidor do Banco de Dados.
*/
define(HOST, 'localhost');

/**
* Usu�rio do Banco de Dados.
*/
define(USER, 'root');

/**
* Senha do Bando de Dados.
*/
define(PASS, '[empty]');

/**
* Localiza��o do Banco de Dados.
*/
define(PATH, '');

/**
* Variavel que receber� o objeto ap�s a conex�o.
*/	 
$DataBase = '';

/**
* E N V I O   D E   E - M A I L 
*/
	 
/**
* Origem do email.
*/
define(ORIGEM, 'no-reply@promotos.com.br');

/**
* Empresa/Autor do email.
*/
define(AUTOR, 'Promotos');

/**
* Mensagem final.
*/
define(MSG_FINAL, 'Caso deseje responder este e-mail utilize o formul�rio de contatos do site da Promotos.<br><br>

Mensagens enviadas para esse e-mail, n�o ser�o verificadas.<br><br>

Este e-mail est� sendo enviado porque � um usu�rio registrado da Promotos. Ou tamb�m porque participou de alguma promo��o ou foi indicado por algum conhecido. E de acordo com o novo C�digo de �tica AntiSPAM elaborado pela Brasil AntiSPAM e do "Guia de Boas Maneiras" para e-mail marketing da ABEMD - Associa��o Brasileira de Marketing Direto.<br><br>

Caso n�o queira continuar recebendo as mensagens da Promotos ou estiver recebendo esta mensagem por engano, pedimos a gentileza de clicar aqui e voc� ser� automaticamente removido da nossa lista de relacionamento.<br><br>

Atenciosamente,
Promotos');

/**
* Diret�rio padr�o dos templates.
*/
define(TEMPLATE_HTML_DIR, '../html/');

/**
* Arquivo que indica o template para o email.
*/
define(TEMPLATE_HTML_NAME, 'mail.html');

/**
* C O O K I E S
*/
	 
/**
* Tempo para a cookie expirar.
*/
define(EXPIRE, 3600);

/**
* Path padr�o para armazenamento das cookies.
*/
define(PATH_COOKIE, '/');

/**
* Domain.
*/
define(DOMAIN, 'http://promotos.com.br/');

/**
* Nivel de seguran�a da cookie.
*/
define(SECURE, 0);

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
* G E R A � � O   D O   F R E T E
*/

/**
* Frete de origem das encomendas.
*/
define(FRETE_ORIGEM, '86300000');
?>