<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendFile.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

/* Arquivo de controle da Session */
include('./controlaSession.php');

$op = $_GET['tipo'];
$id = $_GET['id'];

$continuar = false;

switch($op){
	case 'categoria' :
		$prefix = "A";
		$titulo = "Categoria";
	
		/* Verificando se a categoria pode ser excluida */
		
		$existeProduto = $dataBase->getOne("SELECT count(*) FROM {$tabela['produtos']} WHERE cat_cod = $id");
		
		if(empty($existeProduto)){
			$excluir = new DataBase();
			$excluir->Delete($tabela['categorias'], "cat_cod = $id");
		}
		else{
			$trava_exclusao = true;
		}
		
		break;

	case 'fabricante' :
		$prefix = "O";
		$titulo = "Fabricante";
		
		/* Verificando se o fabricante pode ser excluido */
		
		$existeProduto = $dataBase->getOne("SELECT count(*) FROM {$tabela['produtos']} WHERE fab_cod = $id");
		
		if(empty($existeProduto)){
			$excluir = new DataBase();
			$excluir->Delete($tabela['fabricantes'], "fab_cod = $id");
		}
		else{
			$trava_exclusao = true;
		}
		
		break;
	
	case 'produto' :
		$prefix = "O";
		$titulo = "Produto";
		
		/* Excluindo as fotos do produto */
		$sql = "SELECT f.fot_cod, f.fot_url FROM {$tabela['fotos']} f, {$tabela['produtos_fotos']} fp WHERE f.fot_cod = fp.fot_cod AND fp.pro_cod = $id";
		$resultado = $dataBase->query($sql);
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			/* Excluindo o arquivos */
			if(file_exists($dados['fot_url'])){
				@unlink($dados['fot_url']);
			}
			$sql = "DELETE FROM {$tabela['fotos']} WHERE fot_cod = {$dados['fot_cod']}";
			$dataBase->Query($sql);
		}
		
		/* Excluindo os relacionamentos do produto */
		$sql = "DELETE FROM {$tabela['produtos_fotos']} WHERE pro_cod = $id";
		$dataBase->Query($sql);
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['produtos'], "pro_cod = $id");

		break;
	
	case 'administrador' :
		$prefix = "O";
		$titulo = "Administrador";
		$continuar = true;
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['administradores'], "adm_nome = $id");
		
		break;
}

if($trava_exclusao != true){
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/exclui.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." foi <b>excluid".strtolower($prefix)."</b> com sucesso.<br><br>";
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"form\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:javascript:history.go(-1);\" />";
	$msg .= "</div>";
}
else{
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/exclui.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." <b>NÃO</b> pode ser excluid".strtolower($prefix).", pois pode estar sendo referenciado(a) em outra tabela do banco de dados.<br><br>";
	$msg .= "Certifique-se que não há mais refência para esse registro antes de excluí-lo(a).<br><br>";
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"form\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:javascript:history.go(-1);\" />";
	$msg .= "</div>";
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateAdmin.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO_KOMPRE);
$template->parseCurrentBlock("bloco_titulo");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");	
	$template->setVariable("admin",  "Bem vindo <b>$nome</b>, seu IP &eacute; <b>$ip</b>");
	$template->setVariable("logoff", "<a href=\"logout.php\"><img src=\"../images/botLogoff.gif\" border = \"0\"></a>");
	$template->setVariable("data", getData());
	$template->setVariable("linkKompre", KOMPRE);
	$template->setVariable("altKompre", ALT_KOMPRE);
	$template->setVariable("linkCreditos", CREDITOS);
	$template->setVariable("altCreditos", ALT_CREDITOS);
	$template->setVariable("conteudo_administracao", $msg);
$template->parseCurrentBlock("bloco_principal");

$template->show();
?>