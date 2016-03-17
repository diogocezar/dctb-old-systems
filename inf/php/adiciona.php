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

$continuar = false;

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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['administradores'], $campos['administradores'], $valores);

		break;

	case 'disciplina' :
		$prefix = "A";
		$titulo = "Disciplina";
		$continuar = true;
		
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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['disciplinas'], $campos['disciplinas'], $valores);

		break;
		
	case 'evento':
		$prefix = "O";
		$titulo = "Evento";
		$continuar = true;
		
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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['eventos'], $campos['eventos'], $valores);

		break;
		
	case 'link':
		$prefix = "O";
		$titulo = "Link";
		$continuar = true;
		
		$nome      = $_POST["lnk_nome"];
		$url       = $_POST["lnk_url"];
		$descricao = converteQuebra($_POST["lnk_descricao"]);
		
		$valores = array(
			$sessCod,
			$nome,
			$url,
			"0",
			$descricao
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['links'], $campos['links'], $valores);
		
		break;
	
	case 'noticia' :
		$prefix = "A";
		$titulo = "Notícia";
		$continuar = true;
		
		$tituloNoticia = $_POST["not_titulo"];
		$descricao     = converteQuebra($_POST["not_descricao"]);
		$imagem        = $_FILES["not_imagem"];		

		/* Enviando a foto escolhida se não estiver vazia */
		
		if($imagem['error']  != 4){ // Se a foto não estiver vazia.
		
			$sendFile = new SendFile($imagem, $diretorio['not']);
			
			$urlImagem  = $sendFile->getNome();
		
		}
		
		$valores = array(
			$sessCod,
			$tituloNoticia,
			$descricao,
			$urlImagem,
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['noticias'], $campos['noticias'], $valores);

		break;
		
	case 'professor' :
		$prefix = "O";
		$titulo = "Professor";
		$continuar = true;
		
		$nome      = $_POST["pro_nome"];
		$nick      = $_POST["pro_nick"];
		$foto      = $_FILES["pro_foto"];
		$site      = $_POST["pro_site"];
		$descricao = converteQuebra($_POST["pro_descricao"]);
		$email     = $_POST["pro_email"];	

		/* Enviando a foto escolhida se não estiver vazia */
		
		if($foto['error']  != 4){ // Se a foto não estiver vazia.
		
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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['professores'], $campos['professores'], $valores);

		break;
}

/* Construindo mensagem final */

$titulo = strtolower($titulo);

if(empty($voltar)){
	$voltar = 'administrar.php';
}

$msg  = "<div align=\"center\">";
$msg .= "<img src=\"../images/adiciona.jpg\"><br><br>";
$msg .= $prefix." ".$titulo." foi <b>inserid".strtolower($prefix)."</b> com sucesso.<br><br>";
$msg .= "<input name=\"Voltar\" type=\"button\" class=\"botao\" id=\"Voltar\" value=\"  « Voltar   \" onclick=\"javascript:location.href='$voltar'\" />";

if($continuar == true){
	$msg .= "<br><br><input name=\"Continuar\" type=\"button\" class=\"botao\" id=\"Continuar\" value=\"» Continuar cadastrando\" onclick=\"javascript:history.go(-1);\" />";
}

$msg .= "</div>";

$conteudo = $msg;
$tituloInterna = "Cadastro efetuado com sucesso !!!";

include("includeInterna.php");
?>