<?php
/*
        # CONFIGURACAO.PHP

        O arquivo configuracao.php tem como objetivo armazenar as principais
        configurações do site, como titulo, tebelas, cores etc...

*/

/* Configurações do Banco de Daodos */

$MYSQL['HOST'] = "67.19.228.3";   // <- Host
$MYSQL['USER'] = "admin";        // <- Usuário
$MYSQL['PASS'] = "Kae@01*";     // <- Senha
$MYSQL['BASE'] = "aeacp";      // <- Base

/* Defines de erros que são exibidos pelas classes */

define(_ERR_UPDATE, "CAMPOS_DE_TAM_DIF_U");
define(_ERR_INSERT, "CAMPOS_DE_TAM_DIF_I");
define(_ERR_EQUERY, "ERRO_DE_QUERRY");
define(_ERR_CONEXA, "ERRO_NA_CONEXÃO");
define(_ERR_SELECT, "ERRO_NA_SELECÃO");
define(_ERR_SESION, "ERRO_SESSION_CAMPOS_VAZIOS");
define(_ERR_VERSES, "ERRO_SESSION_VERI_CAMPOS_VAZIOS");
define(_ERR_DELSES, "ERRO_SESSION_DELE_CAMPOS_VAZIOS");
define(_ERR_DELMYS, "ERRO_DELET_MYSQL");
define(_ERR_COOKIE, "ERRO_COOKIE_CAMPOS_VAZIOS");
define(_ERR_VERCOO, "ERRO_COOKIE_VERI_CAMPOS_VAZIOS");
define(_ERR_DELCOO, "ERRO_COOKIE_DELE_CAMPOS_VAZIOS");
define(_ERR_FILEXI, "ERRO_ARQUIVO_EXISTENTE");
define(_ERR_MLETRA, "ERRO_ARQUIVO_NOME_EXTENSO");
define(_ERR_GDNOTG, "ERRO_AO_ENCONTRAR_FUNCAO_GIF");
define(_ERR_GDNOTJ, "ERRO_AO_ENCONTRAR_FUNCAO_JPG");
define(_ERR_GDNOTF, "ERRO_CRIANDO_IMAGEM");

/* Define OK e ERRO */

define(OK, 1);
define(ERRO, 0);

/* Definindo quantidade de elementos POR PÁGINA de cada sessão */

define(PP_ADM_NOTI, 10);
define(PP_NOTI, 10);

define(PP_ADM_PAR, 10);
define(PP_PAR, 10);

/* $STYLE -> Cores predefindas */

$STYLE['ERRO'] = "<font face='Verdana' size='2' color='#444444'>";
$STYLE['ENVIO'] = "<font face='Verdana' size='2' color='#000000'>";
$STYLE['FECHA'] = "</font>";
$STYLE['MENU'] = "<font face='Verdana' size='2' color='#0099FF'>";

/* Cores para o calendário */

$STYLE['CALEN_DOMINGO'] = "<font face='Verdana' size='2' color='#FF0000'>";
$STYLE['CALEN_TITULO'] = "<font face='Verdana' size='2' color='#FF0000'>";
$STYLE['CALEN_BGCOLOR'] = "#ffffff";
$STYLE['CALEN_BORDER'] = "#000000";
$STYLE['CALEN_CORFUNDO'] = "#6CABF9";
$STYLE['CALEN_FONTE'] = "<font face='Verdana' size='2' color='#000000'>";

/* Tradução para os ERROS */

$ERRO_ALERTA = "{$STYLE['ERRO']} Oops, um erro foi encontrado : ";

$ERRO['CAMPOS_DE_TAM_DIF_U'] = $ERRO_ALERTA."BANCO.UPDATE -> Para atualizar uma tabela deve-se ter pelo menos o nome da tabela e o  mesmo número de campos para o mesmo número de valores.{$STYLE['FECHA']}";
$ERRO['CAMPOS_DE_TAM_DIF_I'] = $ERRO_ALERTA."BANCO.INSERT -> Para atualizar uma tabela deve-se ter pelo menos o nome da tabela e o mesmo número de campos para o mesmo número de valores.{$STYLE['FECHA']}";
$ERRO['ERRO_NA_CONEXÃO'] = $ERRO_ALERTA."BANCO.CONECTAR -> Erro ao tentar se conectar : ";
$ERRO['ERRO_NA_SELECÃO'] = $ERRO_ALERTA."BANCO.CONECTAR -> Erro na seleção do banco de dados : ";
$ERRO['ERRO_DE_QUERRY'] = $ERRO_ALERTA."BANCO.QUERY -> Não foi possivel concluir o query : ";
$ERRO['ERRO_CAMPOS_VAZIOS'] = $ERRO_ALERTA."COOKIE.GRAVACOOKIE -> Parâmetros insuficientes para setar o Cookie";
$ERRO['ERRO_SESSION_CAMPOS_VAZIOS'] = $ERRO_ALERTA."SESSION.GRAVASESSION -> Parâmetros insuficientes para setar a Session";
$ERRO['ERRO_SESSION_VERI_CAMPOS_VAZIOS'] = $ERRO_ALERTA."SESSION.VERISESSION -> Parâmetros insuficientes para verificar uma Session";
$ERRO['ERRO_SESSION_DELE_CAMPOS_VAZIOS'] = $ERRO_ALERTA."SESSION.DELETASESSION -> Parâmetros insuficientes para deletar uma Session";
$ERRO['ERRO_DELET_MYSQL'] = $ERRO_ALERTA."BANCO.DELTAR -> Parâmetros insuficientes para deletar algum registro da tabela";
$ERRO['ERRO_COOKIE_VERI_CAMPOS_VAZIOS'] = $ERRO_ALERTA."COOKIE.VERICOOKIE -> Parâmetros insuficientes para verificar um Cookie";
$ERRO['ERRO_COOKIE_DELE_CAMPOS_VAZIOS'] = $ERRO_ALERTA."COOKIE.DELETACOOKIE -> Parâmetros insuficientes para deletar um Cookie";
$ERRO['ERRO_ARQUIVO_EXISTENTE'] = $ERRO_ALERTA."FOTOS.CRIA -> Já existe outro arquivo com o mesmo nome.";
$ERRO['ERRO_ARQUIVO_NOME_EXTENSO'] = $ERRO_ALERTA."FOTOS.CRIA -> O nome do arquivo é muito extenso.";
$ERRO['ERRO_AO_ENCONTRAR_FUNCAO_GIF'] = $ERRO_ALERTA."FOTOS.TAMANHOFOTO -> Não foi possivel localizar a função que cria a imagem, certifique-se que a versão do seu GD suporta criação de imagens no formato GIF";
$ERRO['ERRO_AO_ENCONTRAR_FUNCAO_JPG'] = $ERRO_ALERTA."FOTOS.TAMANHOFOTO -> Não foi possivel localizar a função que cria a imagem, certifique-se que a versão do seu GD suporta criação de imagens no formato JPG";
$ERRO['ERRO_CRIANDO_IMAGEM'] = $ERRO_ALERTA."FOTOS.TAMANHOFOTO -> Não foi possivel criar a foto no formato desejado !";

$ERRO['FOTO_COM_ERRO'] = "Erro ao carregar imagem.";


/* Tabelas e seus respectivos campos */


$tabela['noticias'] = "NOTICIAS";
        $camposTab1 = array(
		   0 => "not_id",
		   1 => "not_titulo",
		   2 => "not_fonte",
		   3 => "not_descricao",
		   4 => "adm_id",
        );
		
$tabela['admin'] = "ADMINISTRADORES";
        $camposTab2 = array(		
		   0 => "adm_id",
		   1 => "adm_nome",
		   2 => "adm_email",
		   3 => "adm_login",
		   4 => "adm_senha"
        );
		
$tabela['parceiro'] = "PARCEIROS";
        $camposTab3 = array(		
		   0 => "par_id",
		   1 => "par_link",
		   2 => "par_descricao",
		   3 => "adm_id",
        );
?>