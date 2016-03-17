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
//include('./controlaSession.php');

$op = $_GET['tipo'];
$id = $_GET['id'];

$trava_exclusao = false;

switch($op){
	case 'cidade' :
		$prefix = "A";
		$titulo = "Cidade";
		
		$sql = "SELECT fotosCidade FROM {$tabela['cidades']} WHERE idCidade = $id";		
		$fotosCidade = $dataBase->getOne($sql);
		
		if(is_dir($fotosCidade)){
			rmdir($fotosCidade);
		}
		
		$query = new DataBase();
		$query->Query("DELETE FROM {$tabela['cidadesecoturismo']} WHERE idCidade = $id");
		$query->Query("DELETE FROM {$tabela['atividadescidades']} WHERE idCidade = $id");
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['cidades'], "idCidade = $id");
	
		break;

	case 'ecoturismo' :
		$prefix = "O";
		$titulo = "Ecoturismo";
		
		$sql = "SELECT fotosEcoturismo FROM {$tabela['ecoturismo']} WHERE idEcoturismo = $id";		
		$fotosEcoturismo = $dataBase->getOne($sql);
		
		if(is_dir($fotosEcoturismo)){
			rmdir($fotosEcoturismo);
		}
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['ecoturismo'], "idEcoturismo = $id");

		break;
		
	case 'atividade':
		$prefix = "A";
		$titulo = "Atividade";
		
		$sql = "SELECT fotosAtividade FROM {$tabela['atividades']} WHERE idAtividades = $id";		
		$fotosAtividade = $dataBase->getOne($sql);
		
		if(is_dir($fotosAtividade)){
			rmdir($fotosAtividade);
		}
		
		$excluir = new DataBase();
		$excluir->Delete($tabela['atividades'], "idAtividades = $id");

		break;
		
	case 'tipoAtividade':
		$prefix = "O";
		$titulo = "Tipo de Atividade";
		
		$existeAtividade = $dataBase->getOne("SELECT count(*) FROM {$tabela['atividades']} WHERE idTipoAtividade = $id");
		
		if(empty($existeAtividade)){
			$excluir = new DataBase();
			$excluir->Delete($tabela['tipoatividade'], "idTipoAtividade = $id");		
		}
		else{
			$trava_exclusao = true;
		}
		break;
			
	case 'tipoEcoturismo':
		$prefix = "O";
		$titulo = "Tipo de Ecoturismo";
		
		$existeEcoturismo = $dataBase->getOne("SELECT count(*) FROM {$tabela['ecoturismo']} WHERE idTipoEcoturismo = $id");
		
		if(empty($existeEcoturismo)){
			$excluir = new DataBase();
			$excluir->Delete($tabela['tipoecoturismo'], "idTipoEcoturismo = $id");		
		}
		else{
			$trava_exclusao = true;
		}		
		break;
}

if($trava_exclusao != true){
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/topAdmin.jpg\" width=\"464\" height=\"20\" /><br><br>";
	$msg .= "<img src=\"../images/exclui.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." foi <b>excluid".strtolower($prefix)."</b> com sucesso.<br><br>";
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"comboMarrom\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:javascript:history.go(-1);\" />";
	$msg .= "</div>";
	$tituloInterna = "Registro excluido com sucesso !!!";
}
else{
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/topAdmin.jpg\" width=\"464\" height=\"20\" /><br><br>";
	$msg .= "<img src=\"../images/exclui.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." <b>NÃO</b> pode ser excluid".strtolower($prefix).", pois pode estar sendo referenciado(a) em outra tabela do banco de dados.<br><br>";
	$msg .= "Certifique-se que não há mais refência para esse registro antes de excluí-lo(a).<br><br>";
	$msg .= "<input name=\"Voltar\" type=\"button\" class=\"comboMarrom\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:javascript:history.go(-1);\" />";
	$msg .= "</div>";
	$tituloInterna = "O registro não pode ser excluido !!!";
}

$conteudo = $msg;

include("includeInterna.php");
?>