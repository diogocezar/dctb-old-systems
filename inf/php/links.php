<?php
/* Incluindo classes */
include('../classes/Session.php');
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');

/* Incluindo arquivo de configura��o da p�gina */
include('./configSite.php');

/* Incluindo arquivos de fun��es */
include('../lib/util.php');
include('../lib/library.php');

/* Diret�rio dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'mostraLinks.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Selecionando not�cia */

$sql = "SELECT l.idLinks, l.nomeLi, l.urlLi, l.visitasLi, l.descricaoLi, a.nomeAd, a.emailAd 
        FROM {$tabela['links']} l, {$tabela['administradores']} a
		WHERE l.Administrador_idAdministrador = a.idAdministradores";
$resultado = $dataBase->query($sql);

$template->setCurrentBlock("blk_mostra_link");
	if(!DB::isError($resultado)){
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){		
			$template->setCurrentBlock("blk_mostra_link_list");
				$template->setVariable("nomeLink", $dados['nomeLi']);
				$template->setVariable("link", "goLink.php?id={$dados['idLinks']}");
				$template->setVariable("visitas", $dados['visitasLi']);
				$template->setVariable("descricao", $dados['descricaoLi']);	
				$template->setVariable("enviadoPor", $dados['nomeAd']);	
				$template->setVariable("linkEnviadoPor", "mailto:{$dados['emailAd']}");	
			$template->parseCurrentBlock("blk_mostra_link_list");
		}
	}
	$template->setVariable("voltar", "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  � Voltar   \" onclick=\"javascript:history.go(-1);\" />");	
$template->parseCurrentBlock("blk_mostra_link");

$conteudo = $template->get();
$tituloInterna = "Links";

include("includeInterna.php");
?>