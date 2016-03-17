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

$op = anti_sql_injection($_GET['tipo']);
$id = anti_sql_injection($_GET['id']);

$trava_exclusao = false;

switch($op){
	case 'admin' :
		$prefix = "O";
		$titulo = "Administrador";
		
		$existeEvento = $dataBase->getOne("SELECT count(*) FROM {$tabela['eventos']} WHERE Administrador_idAdministrador = $id");
		$existeNoticia  = $dataBase->getOne("SELECT count(*) FROM {$tabela['noticias']}  WHERE Administrador_idAdministrador = $id");
		$existeLink  = $dataBase->getOne("SELECT count(*) FROM {$tabela['links']}  WHERE Administrador_idAdministrador = $id");
		
		if(empty($existeEvento) && empty($existeNoticia) && empty($existeLink)){
			$excluir = new DataBase();
			$excluir->Delete($tabela['administradores'], "idAdministradores = $id");
		}
		else{
			$trava_exclusao = true;
		}
	
		break;

	case 'disciplina' :
		$prefix = "A";
		$titulo = "Disciplina";
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['disciplinas'], "idDisciplinas = $id");

		break;
		
	case 'link':
		$prefix = "O";
		$titulo = "Link";
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['links'], "idLinks = $id");

		break;
		
	case 'evento':
		$prefix = "O";
		$titulo = "Evento";
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['eventos'], "idEventos = $id");

		break;
			
	case 'noticia':
		$prefix = "A";
		$titulo = "Notícia";
		
		$sql = "SELECT imagemNo FROM {$tabela['noticias']} WHERE idNoticias = $id";	
		$urlImagem = $dataBase->getOne($sql);
		
		if(is_file($urlImagem)){
			unlink($urlImagem);
		}
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['noticias'], "idNoticias = $id");
		
		break;
	
	case 'professor' :
		$prefix = "O";
		$titulo = "Professor";

		$sql = "SELECT fotoPro FROM {$tabela['professores']} WHERE idProfessores = $id";	
		$urlFoto = $dataBase->getOne($sql);
		
		if(is_file($urlFoto)){
			unlink($urlFoto);
		}
			
		$excluir = new DataBase();
		$excluir->Delete($tabela['professores'], "idProfessores = $id");

		break;
}

if($trava_exclusao != true){
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/exclui.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." foi <b>excluid".strtolower($prefix)."</b> com sucesso.<br><br>";
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:history.go(-1);\" />";
	$msg .= "</div>";
	$tituloInterna = "Registro excluido com sucesso !!!";
}
else{
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/exclui.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." <b>NÃO</b> pode ser excluid".strtolower($prefix).", pois pode estar sendo referenciado(a) em outra tabela do banco de dados.<br><br>";
	$msg .= "Certifique-se que não há mais refência para esse registro antes de excluí-lo(a).<br><br>";
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:history.go(-1);\" />";
	$msg .= "</div>";
	$tituloInterna = "O registro não pode ser excluido !!!";
}

$conteudo = $msg;

include("includeInterna.php");
?>