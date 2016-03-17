<?php
/**
* Arquivo de configuração das classes.
*
* Definindo constantes de configuração
*/

/**#@+
* Constantes
*/

/**
* B A N C O   D E   D A D O S
*/

/**
* Qual banco de dados ?
* Opções :
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
define(BASE, 'inf');

/**
* Servidor do Banco de Dados.
*/
define(HOST, 'localhost');

/**
* Usuário do Banco de Dados.
*/
define(USER, 'root');

/**
* Senha do Bando de Dados.
*/
define(PASS, 'web#inf');

/**
* Localização do Banco de Dados.
*/
define(PATH, '');

/**
* Variavel que receberá o objeto após a conexão.
*/	 
$DataBase = '';

/**
* E N V I O   D E   E - M A I L 
*/
	 
/**
* Origem do email.
*/
define(ORIGEM, 'xgordo@gmail.com');

/**
* Empresa/Autor do email.
*/
define(AUTOR, 'Cordenação de Informática');

/**
* Mensagem final.
*/
define(MSG_FINAL, 'Caso deseje responder este e-mail utilize o formulário de contatos do site da Rr decorações.<br><br>

Mensagens enviadas para esse e-mail, não serão verificadas.<br><br>

Este e-mail está sendo enviado porque é um usuário registrado da Promotos. Ou também porque participou de alguma promoção ou foi indicado por algum conhecido. E de acordo com o novo Código de Ética AntiSPAM elaborado pela Brasil AntiSPAM e do "Guia de Boas Maneiras" para e-mail marketing da ABEMD - Associação Brasileira de Marketing Direto.<br><br>

Caso não queira continuar recebendo as mensagens da Promotos ou estiver recebendo esta mensagem por engano, pedimos a gentileza de clicar aqui e você será automaticamente removido da nossa lista de relacionamento.<br><br>

Atenciosamente');

/**
* Diretório padrão dos templates.
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
* Path padrão para armazenamento das cookies.
*/
define(PATH_COOKIE, '/');

/**
* Domain.
*/
define(DOMAIN, 'http://rrdecoracoes.com.br/');

/**
* Nivel de segurança da cookie.
*/
define(SECURE, 0);

/**
* E N V I O   D E   A R Q U I V O S
*/

/**
* Limitar as extensões ? (sim ou nao).
*/
define(LIMITAR_EXT, 'sim');

/**
* Extensões autorizadas.
*/
$extValidas = array(0 => '.gif',
					1 => '.jpg',
					2 => '.jpeg',
					3 => '.png',
					4 => '.swf',
					5 => '.zip',
					6 => '.rar');
					
/**
* Array com os MIME types e suas respectivas extensões.
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
* Qualidade da foto que será grava no servidor.
*/
define(QUALIDADE, 90);

/**
* G E R A Ç Ã O   D E   F O T O S 
*/

/**
* Mensagem de erro padrão.
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
* G E R A Ç Ã O   D O   F R E T E
*/

/**
* Frete de origem das encomendas.
*/
define(FRETE_ORIGEM, '86300000');
?>