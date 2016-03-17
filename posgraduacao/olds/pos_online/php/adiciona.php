<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendMail.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

$op = $_GET['tipo'];

$permitido = false;

@$session = new Session();

if($op != "contato" && $op != "inscricao"){
	
	if($_SESSION['permitido'] == 'sim'){
		$permitido = true;
		$cod   = sessionNum($session->retornaSession('cod'));
		$cod   = (int)$cod;
		$nome  = $session->retornaSession('nome');
		$login = $session->retornaSession('login');
		$curso = sessionNum($session->retornaSession('curso_adm'));
$curso = (int)$curso;
	}
	
	if($permitido != true){
		echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
	}
}


switch($op){
	case 'curso' :
		$prefix = "O";
		$titulo = "Curso";
		$volta  = "administrar.php";
		
		$nome               = $_POST["nome"];
		$inicioCurso        = desconverteData($_POST["inicio"]);
		$terminoCurso       = desconverteData($_POST["termino"]);
		$periodoInscricao   = $_POST["periodo_insc"];
		$periodoMatricula   = $_POST["periodo_matr"];
		$turnoFuncionamento = $_POST["turno"];
		$vagas              = $_POST["vagas"];
		$txInscricao        = $_POST["taxa"];
		$matricula          = $_POST["matricula"];
		$mensalidades       = $_POST["mensalidade"];
		$apresentacao       = converteQuebra($_POST["apresentacao"]);
		$objetivos          = converteQuebra($_POST["objetivos"]);
		$certificado        = converteQuebra($_POST["certificado"]);
		$complementar       = converteQuebra($_POST["complementar"]);
		$resumo             = converteQuebra($_POST["resumo"]);
					
		$valores = array(
			$nome,
			$apresentacao,
			$objetivos,
			$certificado,
			$inicioCurso,
			$terminoCurso,
			$periodoInscricao,
			$periodoMatricula,
			$turnoFuncionamento,
			$vagas,
			$complementar,
			$txInscricao,
			$matricula,
			$mensalidades,
			$resumo
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['cursos'], $campos['cursos'], $valores);

		break;
	
	case 'administrador' :
		$prefix = "O";
		$titulo = "Administrador";
		$volta = "administrar.php";
		
		$curso = $_POST["curso"];
		$nome  = $_POST["nome"];
		$login = $_POST["login"];
		$senha = $_POST["senha"];
		$email = $_POST["email"];
		
		$valores = array(
			$curso,
			$nome,
			$login,
			$senha,
			$email
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['administradores'], $campos['administradores'], $valores);
		
		break;
	
	case 'noticia' :
		$prefix = "A";
		$titulo = "Notcícia";
		$volta = "administrar.php";
		
		$curso        = $_POST["curso"];
		$tituloSalvar = $_POST["titulo"];
		$conteudo     = converteQuebra($_POST["conteudo"]);
		
		$valores = array(
			$curso,
			$tituloSalvar,
			$conteudo,
			$cod
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['noticias'], $campos['noticias'], $valores);
		
		break;
	
	case 'inscricao' :
		$prefix = "A";
		$titulo = "Inscrição";
		$volta = "index.php";
		
		$curso          = $_POST["curso"];
		$nome           = $_POST["nome"];
		$cpf            = $_POST["cpf"];
		$rg             = $_POST["rg"];
		$orgaoEmissor   = $_POST["emissor"];
		$dataNascimento = desconverteData($_POST["data_nascimento"]);
		$estadoCivil    = $_POST["estado_civil"];
		$graduacao      = $_POST["graduacao"];
		$rua            = $_POST["rua"];
		$numero         = $_POST["numero"];
		$complemento    = $_POST["complemento"];
		$bairro         = $_POST["bairro"];
		$cidade         = $_POST["cidade"];
		$estado         = $_POST["estado"];
		$cep            = $_POST["cep"];
		$telefone       = $_POST["telefone"];
		$celular        = $_POST["celular"];
		$email          = $_POST["email"];
		
		$valores = array(
			$curso,
			$nome,
			$cpf,
			$rg,
			$orgaoEmissor,
			$dataNascimento,
			$estadoCivil,
			$graduacao,
			$rua,
			$numero,
			$complemento,
			$bairro,
			$cidade,
			$estado,
			$cep,
			$telefone,
			$celular,
			$email	
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['inscricoes'], $campos['inscricoes'], $valores);
		
		/* Enviando e-mail para o cordenador do curso */
		$nomeCurso = retornaNomaCurso($curso);
		$emailsAdm = retornaEmailAdmin($curso);		
		if(!empty($emailsAdm)){
			$destino   = $emailsAdm;
			if(!empty($destino)){
			
				$titulo    = "Uma nova inscrição foi efetuada";
				$conteudo  = "Olá, houve um novo cadastro no curso administrado por você ! <br>";
				$conteudo .= "Informações : <br>";
				$conteudo .= "Curso : $nomeCurso <br>";
				$conteudo .= "Nome : $nome <br>";
				$conteudo .= "Cpf : $cpf <br>";
				$conteudo .= "Rg : $rg <br>";
				$conteudo .= "Orgão emissor : $orgaoEmissor <br>";
				$conteudo .= "Data de nascimento : $dataNascimento <br>";
				$conteudo .= "Estado civil : $estadoCivil <br>";
				$conteudo .= "Graduação : $graduacao <br>";
				$conteudo .= "Rua : $rua <br>";
				$conteudo .= "Número : $numero <br>";
				if(!empty($complemento)){
					$conteudo .= "Complemento : $complemento <br>";
				}
				$conteudo .= "Bairro : $bairro <br>";
				$conteudo .= "Cidade : $cidade <br>";
				$conteudo .= "Estado : $estado <br>";
				$conteudo .= "Cep : $cep <br>";
				$conteudo .= "Telefone : $telefone <br>";
				$conteudo .= "Celular : $celular <br>";
				$conteudo .= "Email : <a href =\"mailto:$email\">$email</a> <br>";
				$origem    = "depog@cp.cefetpr.br";
				
				$send = new SendMail($titulo, $conteudo, $destino, $origem);
				//$send = new SendMail($titulo, $conteudo, "xgordo@gmail.com", $origem);
				$send->goMail();
			}		
		}
		
		break;
	
	case 'professor' :
		$prefix = "O";
		$titulo = "Professor";
		$volta = "administrar.php";
		
		$nome           = $_POST["nome"];
		$email          = $_POST["email"];
		$paginaPessoal  = $_POST["pagina_pessoal"];
		$atuacao        = converteQuebra($_POST["atuacao"]);
		$titulacao      = converteQuebra($_POST["titulacao"]);
		$formacao       = converteQuebra($_POST["formacao"]);
		
		$valores = array(
			$nome,
			$atuacao,
			$titulacao,
			$formacao,
			$email,
			$paginaPessoal,
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['professores'], $campos['professores'], $valores);

		break;
	
	case 'disciplina' :
		$prefix = "A";
		$titulo = "Disciplina";
		$volta = "administrar.php";
		
		$curso        = $_POST["curso"];
		$professor    = $_POST["professor"];
		$nome         = $_POST["nome"];
		$cargaHoraria = $_POST["carga"];
		$descricao    = converteQuebra($_POST["descricao"]);
		
		$valores = array(
			$curso,
			$professor,
			$nome,
			$cargaHoraria,
			$descricao				
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['disciplinas'], $campos['disciplinas'], $valores);
		
		break;
	
	case 'contato' :
		$prefix = "O";
		$titulo = "Contato";
		$volta = "index.php";
		
		$nome     = $_POST["nome"];
		$telefone = $_POST["telefone"];
		$celular  = $_POST["celular"];
		$cidade   = $_POST["cidade"];
		$estado   = $_POST["estado"];
		$email    = $_POST["email"];
		$curso    = $_POST["curso"];
		
		$valores = array(
			$curso,
			$nome,
			$telefone,
			$celular,	
			$cidade,
			$estado,
			$email		
		);

		$inserir = new DataBase();
		
		$inserir->Insert($tabela['contato'], $campos['contato'], $valores);
		
		/* Enviando e-mail para o cordenador do curso */
		$nomeCurso = retornaNomaCurso($curso);
		$idAdm     = retornaIdAdm($curso);		
		if(!empty($idAdm)){
			$destino   = retornaEmailAdm($idAdm);
			if(!empty($destino)){
			
				$tituloMail = "Uma novo contato foi enviado :";
				$conteudo   = "Olá, houve um novo contato no curso administrado por você ! <br>";
				$conteudo  .= "Informações : <br>";
				$conteudo  .= "Curso : $nomeCurso <br>";
				$conteudo  .= "Nome : $nome <br>";
				$conteudo  .= "Cidade : $cidade <br>";
				$conteudo  .= "Estado : $estado <br>";
				$conteudo  .= "Telefone : $telefone <br>";
				$conteudo  .= "Celular : $celular <br>";
				$conteudo  .= "Email : <a href =\"mailto:$email\">$email</a> <br>";
				$origem     = "depog@cp.cefetpr.br";
				
				$send = new SendMail($tituloMail, $conteudo, $destino, $origem);
				$send->goMail();
			}
		}
		
		break;	
}

$msg = "<div align=\"center\">";
$msg .= "<br><br>";
$msg .= "<img src=\"../icones/button_ok.jpg\"><br><br>";
$titulo = strtolower($titulo);
$msg .= $prefix." ".$titulo." foi <b>inserid".strtolower($prefix)."<b> com sucesso.<br><br>";
$msg .= "<input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"« Voltar\" onclick=\"javascript:location.href='$volta'\">";
$msg .= "</div>";

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[1]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da Página Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Inserindo $titulo");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conteúdo da página interna */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", $msg);
$template->parseCurrentBlock("bloco_conteudo");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Geral */
$template->setCurrentBlock("bloco_geral");
	/* Links Superiores */
	$template->setVariable("linkUtf", UTFPR);
	$template->setVariable("linkDepog", DEPOG);
	/* Menu */
	foreach($menu['principal'] as $menu => $cont){
		foreach($cont as $link => $titulo){
			$template->setVariable($menu, "<a href = \"$titulo\" class = \"link_claro\">$link</a>");
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>