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

$op = $_GET['tipo'];
$id = $_GET['id'];

//include('./controlaSession.php');

switch($op){
	case 'cidade' :
		$prefix = "A";
		$titulo = "Cidade";
		
		$nome        = $_POST["cid_nome"];
		$descricao   = $_POST["cid_descricao"];
		$localizacao = $_POST["cid_localizacao"];
		$acesso      = $_POST["cid_acesso"];
		$fotos       = $_POST["cid_fotos"];
		
		$listaAtividades = $_POST["list_atividades"];
		
		$listaEcoturismos = $_POST["list_ecoturismos"];
		
		/* Recuperando pasta Cadastrada */
		
		$sql = "SELECT fotosCidade FROM {$tabela['cidades']} WHERE idCidade = $id";
		
		$fotosCidade = $dataBase->getOne($sql);
		
		$dirAntigo = $diretorio['cidades']."/".$fotosCidade;
		$dirNovo   = $diretorio['cidades']."/".$fotos;
		
		if($fotosCidade != $fotos){
			if(is_dir($dirAntigo)){
				rename($dirAntigo, $dirNovo);
				chmod($dirNovo, '777');
			}
		}
		
		$valores = array(
			$nome,
			$descricao,
			$localizacao,
			$acesso,
			$fotos
		);		
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['cidades'], "idCidade = $id", $campos['cidades'], $valores);
		
		/* Apagando todos os relacionamentos antigos */
		
		$query = new DataBase();
		$query->Query("DELETE FROM {$tabela['cidadesecoturismo']} WHERE idCidade = $id");
		$query->Query("DELETE FROM {$tabela['atividadescidades']} WHERE idCidade = $id");
		
		/* Cadastrando os relacionamentos */
		
		$inserir = new DataBase();
		$codCidade = $id;
		
		for($i=0; $i<count($listaAtividades); $i++){
			$valoresAtividades = array(
			$listaAtividades[$i],
			$codCidade);
			$inserir->Insert($tabela['atividadescidades'], $campos['atividadescidades'], $valoresAtividades);
		}
		
		for($i=0; $i<count($listaEcoturismos); $i++){
			$valoresEcoturismos = array(
			$codCidade,
			$listaEcoturismos[$i]
			);
			$inserir->Insert($tabela['cidadesecoturismo'], $campos['cidadesecoturismo'], $valoresEcoturismos);
		}	

		break;
		
	case 'ecoturismo':
		$prefix = "O";
		$titulo = "Ecoturismo";
		
		$nome        = $_POST["eco_nome"];
		$descricao   = $_POST["eco_descricao"];
		$localizacao = $_POST["eco_localizacao"];
		$acesso      = $_POST["eco_acesso"];
		$fotos       = $_POST["eco_fotos"];
		$tipo        = $_POST["eco_combo_tipo"];
		
		/* Recuperando pasta Cadastrada */
		
		$sql = "SELECT fotosEcoturismo FROM {$tabela['ecoturismo']} WHERE idEcoturismo = $id";
		
		$fotosEcoturismo = $dataBase->getOne($sql);
		
		$dirAntigo = $diretorio['ecoturismo']."/".$fotosEcoturismo;
		$dirNovo   = $diretorio['ecoturismo']."/".$fotos;
		
		if($fotosEcoturismo != $fotos){
			if(is_dir($dirAntigo)){
				rename($dirAntigo, $dirNovo);
				chmod($dirNovo, '777');
			}
		}
		
		$valores = array(
			$nome,
			$descricao,
			$localizacao,
			$acesso,
			$fotos,
			$tipo
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['ecoturismo'], "idEcoturismo = $id", $campos['ecoturismo'], $valores);
		
		break;


	case 'atividade':
		$prefix = "A";
		$titulo = "Atividade";
		
		$nome        = $_POST["ati_nome"];
		$descricao   = $_POST["ati_descricao"];
		$localizacao = $_POST["ati_localizacao"];
		$acesso      = $_POST["ati_acesso"];
		$fotos       = $_POST["ati_fotos"];
		$tipo        = $_POST["ati_combo_tipo"];
		
		/* Recuperando pasta Cadastrada */
		
		$sql = "SELECT fotosAtividade FROM {$tabela['atividades']} WHERE idAtividades = $id";
		
		$fotosAtividade = $dataBase->getOne($sql);
		
		$dirAntigo = $diretorio['ecoturismo']."/".$fotosAtividade;
		$dirNovo   = $diretorio['ecoturismo']."/".$fotos;
		
		if($fotosAtividade != $fotos){
			if(is_dir($dirAntigo)){
				rename($dirAntigo, $dirNovo);
				chmod($dirNovo, '777');
			}
		}
		
		$valores = array(
			$nome,
			$descricao,
			$localizacao,
			$acesso,
			$fotos,
			$tipo
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['atividades'], "idAtividades = $id", $campos['atividades'], $valores);
		
		break;

	
	case 'tipoAtividade' :
		$prefix = "O";
		$titulo = "Tipo de Atividade";
		
		$nome = $_POST["tat_nome"];
		
		$valores = array(
			$nome
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['tipoatividade'], "idTipoAtividade = $id", $campos['tipoatividade'], $valores);

		break;
		
	case 'tipoEcoturismo' :
		$prefix = "O";
		$titulo = "Tipo de Ecoturismo";
		
		$nome = $_POST["tec_nome"];

		$valores = array(
			$nome
		);
	
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['tipoecoturismo'], "idTipoEcoturismo = $id", $campos['tipoecoturismo'], $valores);

		break;
		
}

/* Construindo mensagem final */

$titulo = strtolower($titulo);

if(empty($voltar)){
	$voltar = 'administrar.php';
}

$msg  = "<div align=\"center\">";
$msg .= "<img src=\"../images/topAdmin.jpg\" width=\"464\" height=\"20\" /><br><br>";
$msg .= "<img src=\"../images/atualiza.jpg\"><br><br>";
$msg .= $prefix." ".$titulo." foi <b>atualizad".strtolower($prefix)."</b> com sucesso.<br><br>";
$msg .= "<input name=\"Voltar\" type=\"button\" class=\"comboMarrom\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:location.href='$voltar'\" />";
$msg .= "</div>";

$conteudo = $msg;
$tituloInterna = "Cadastro atualizado com sucesso !!!";

include("includeInterna.php");
?>