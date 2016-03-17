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

$op = anti_sql_injection($_GET['tipo']);
$id = anti_sql_injection($_GET['id']);

include('./controlaSession.php');

switch($op){
	case 'admin' :
		$prefix = "O";
		$titulo = "Administrador";
		
		$nome  = $_POST["adm_nome"];
		$login = $_POST["adm_login"];
		$senha = $_POST["adm_senha"];
		$email = $_POST["adm_email"];
		
		$valores = array(
			$nome,
			$login,
			$senha,
			$email
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['administradores'], "idAdministradores = $id", $campos['administradores'], $valores);

		break;
		
	case 'disciplina':
		$prefix = "A";
		$titulo = "Disciplina";
		
		$nome         = $_POST["dis_nome"];
		$periodo      = $_POST["dis_periodo"];
		$cargaHoraria = $_POST["dis_carga_horaria"];
		$objetivos    = converteQuebra($_POST["dis_objetivos"]);
		$ementas      = converteQuebra($_POST["dis_ementas"]);
		
		$valores = array(
			$nome,
			$periodo,
			$cargaHoraria,
			$objetivos,
			$ementas
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['disciplinas'], "idDisciplinas = $id", $campos['disciplinas'], $valores);
		
		break;


	case 'evento':
		$prefix = "O";
		$titulo = "Evento";
		
		$data      = converteData($_POST["eve_data"]);
		$hora      = $_POST["eve_hora"];
		$local     = $_POST["eve_local"];
		$descricao = converteQuebra($_POST["eve_descricao"]);
		
		$valores = array(
			$sessCod,
			$data,
			$hora,
			$local,
			$descricao
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['eventos'], "idEventos = $id", $campos['eventos'], $valores);
		
		break;

	
	case 'link' :
		$prefix = "O";
		$titulo = "Link";
		
		$nome      = $_POST["lnk_nome"];
		$url       = $_POST["lnk_url"];
		$descricao = converteQuebra($_POST["lnk_descricao"]);
		
		$sql = "SELECT visitasLi FROM {$tabela['links']} WHERE idLinks = $id";	
		$visitas = $dataBase->getOne($sql);
		
		$valores = array(
			$sessCod,
			$nome,
			$url,
			$visitas,
			$descricao
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['links'], "idLinks = $id", $campos['links'], $valores);

		break;
		
	case 'noticia' :
		$prefix = "A";
		$titulo = "Notícia";
		
		$tituloNoticia = converteQuebra($_POST["not_titulo"]);
		$descricao     = $_POST["not_descricao"];
		$imagem        = $_FILES["not_imagem"];	
		
		$sql = "SELECT imagemNo FROM {$tabela['noticias']} WHERE idNoticias = $id";	
		$urlImagem = $dataBase->getOne($sql);
		
		if($imagem['error']  != 4){ // Se a foto não estiver vazia.
			/* Enviando a foto escolhida */
			if(is_file($urlImagem)){
				unlink($urlImagem);
			}
			
			$sendFile = new SendFile($imagem, $diretorio['not']);
			
			$urlImagem  = $sendFile->getNome();
		}
		
		$valores = array(
			$sessCod,
			$tituloNoticia,
			$descricao,
			$urlImagem,
		);
	
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['noticias'], "idNoticias = $id", $campos['noticias'], $valores);

		break;
		
	case 'professor' :
		$prefix = "O";
		$titulo = "Professor";
		
		$nome      = $_POST["pro_nome"];
		$nick      = $_POST["pro_nick"];
		$foto      = $_FILES["pro_foto"];
		$site      = $_POST["pro_site"];
		$descricao = converteQuebra($_POST["pro_descricao"]);
		$email     = $_POST["pro_email"];	
		
		$sql = "SELECT fotoPro FROM {$tabela['professores']} WHERE idProfessores = $id";	
		$urlFoto = $dataBase->getOne($sql);
		
		if($foto['error']  != 4){ // Se a foto não estiver vazia.
			/* Enviando a foto escolhida */
			if(is_file($urlFoto)){
				unlink($urlFoto);
			}
			
			$sendFile = new SendFile($foto, $diretorio['pro']);
			
			$urlFoto  = $sendFile->getNome();
		}
		
		$valores = array(
			$nome,
			$nick,
			$urlFoto,
			$site,
			$descricao,
			$email
		);
	
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['professores'], "idProfessores = $id", $campos['professores'], $valores);

		break;
}

/* Construindo mensagem final */

$titulo = strtolower($titulo);

if(empty($voltar)){
	$voltar = 'administrar.php';
}

$msg  = "<div align=\"center\">";
$msg .= "<img src=\"../images/atualiza.jpg\"><br><br>";
$msg .= $prefix." ".$titulo." foi <b>atualizad".strtolower($prefix)."</b> com sucesso.<br><br>";
$msg .= "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:location.href='$voltar'\" />";
$msg .= "</div>";

$conteudo = $msg;
$tituloInterna = "Cadastro atualizado com sucesso !!!";

include("includeInterna.php");
?>