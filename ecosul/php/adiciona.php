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

$continuar = false;

switch($op){
	case 'cidade' :
		$prefix = "A";
		$titulo = "Cidade";
		$continuar = true;
		
		$nome        = $_POST["cid_nome"];
		$descricao   = $_POST["cid_descricao"];
		$localizacao = $_POST["cid_localizacao"];
		$acesso      = $_POST["cid_acesso"];
		$fotos       = $_POST["cid_fotos"];
		
		$listaAtividades = $_POST["list_atividades"];
		
		$listaEcoturismos = $_POST["list_ecoturismos"];
		
		/* Criando a pasta para as fotos */
		
		$dir = $diretorio['cidades']."/".$fotos;
		
		if(!is_dir($dir)){
			mkdir($dir);
			chmod($dir, '777');
		}	
				
		$valores = array(
			$nome,
			$descricao,
			$localizacao,
			$acesso,
			$fotos
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['cidades'], $campos['cidades'], $valores);
		
		$sql = "SELECT MAX(idCidade) FROM {$tabela['cidades']}";
		
		$codCidade = $dataBase->getOne($sql);
		
		/* Cadastrando os relacionamentos */
		
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

	case 'ecoturismo' :
		$prefix = "O";
		$titulo = "Ecoturismo";
		$continuar = true;
		
		$nome        = $_POST["eco_nome"];
		$descricao   = $_POST["eco_descricao"];
		$localizacao = $_POST["eco_localizacao"];
		$acesso      = $_POST["eco_acesso"];
		$fotos       = $_POST["eco_fotos"];
		$tipo        = $_POST["eco_combo_tipo"];
		
		/* Criando a pasta para as fotos */
		
		$dir = $diretorio['ecoturismo']."/".$fotos;
		
		if(!is_dir($dir)){
			mkdir($dir);
			chmod($dir, '777');
		}
		
		$valores = array(
			$nome,
			$descricao,
			$localizacao,
			$acesso,
			$fotos,
			$tipo
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['ecoturismo'], $campos['ecoturismo'], $valores);

		break;
		
	case 'atividade':
		$prefix = "A";
		$titulo = "Atividade";
		$continuar = true;
		
		$nome        = $_POST["ati_nome"];
		$descricao   = $_POST["ati_descricao"];
		$localizacao = $_POST["ati_localizacao"];
		$acesso      = $_POST["ati_acesso"];
		$fotos       = $_POST["ati_fotos"];
		$tipo        = $_POST["ati_combo_tipo"];
		
		/* Criando a pasta para as fotos */
		
		$dir = $diretorio['atividades']."/".$fotos;
		
		if(!is_dir($dir)){
			mkdir($dir);
			chmod($dir, '777');
		}
		
		$valores = array(
			$nome,
			$descricao,
			$localizacao,
			$acesso,
			$fotos,
			$tipo
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['atividades'], $campos['atividades'], $valores);

		break;
		
	case 'tipoAtividade':
		$prefix = "O";
		$titulo = "Tipo de Atividade";
		$continuar = true;
		
		$nome = $_POST["tat_nome"];
		
		$valores = array(
			$nome
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['tipoatividade'], $campos['tipoatividade'], $valores);
		
		break;
	
	case 'tipoEcoturismo' :
		$prefix = "O";
		$titulo = "Tipo de Ecoturismo";
		$continuar = true;
		
		$nome = $_POST["tec_nome"];

		$valores = array(
			$nome
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['tipoecoturismo'], $campos['tipoecoturismo'], $valores);

		break;
		
}

/* Construindo mensagem final */

$titulo = strtolower($titulo);

if(empty($voltar)){
	$voltar = 'administrar.php';
}

$msg  = "<div align=\"center\">";
$msg .= "<img src=\"../images/topAdmin.jpg\" width=\"464\" height=\"20\" /><br><br>";
$msg .= "<img src=\"../images/adiciona.jpg\"><br><br>";
$msg .= $prefix." ".$titulo." foi <b>inserid".strtolower($prefix)."</b> com sucesso.<br><br>";
$msg .= "<input name=\"Voltar\" type=\"button\" class=\"comboMarrom\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:location.href='$voltar'\" />";

if($continuar == true){
	$msg .= "<br><br><input name=\"Continuar\" type=\"button\" class=\"comboMarrom\" id=\"Continuar\" value=\"» Continuar cadastrando\" onclick=\"javascript:history.go(-1);\" />";
}

$msg .= "</div>";

$conteudo = $msg;
$tituloInterna = "Cadastro efetuado com sucesso !!!";

include("includeInterna.php");
?>