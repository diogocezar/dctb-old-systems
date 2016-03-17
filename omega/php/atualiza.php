<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');
include('../classes/SendMail.php');
include('../classes/SendFile.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

$op = $_GET['tipo'];

$permitido = false;

@$session = new Session();

$id = $_GET['id'];

if($op != "cliente"){

	if($_SESSION['permitidoSession'] == 'sim'){
		$permitido = true;
		$cod   = sessionNum($session->retornaSession('codSession'));
		$cod   = (int)$cod;
		$nome  = $session->retornaSession('nomeSession');
		$login = $session->retornaSession('loginSession');
		$tipo = sessionNum($session->retornaSession('tipoSession'));
		$tipo = (int)$tipo;
	}

	if($permitido != true){
		echo "<script language=javascript>alert('Desculpe mas você não pode ser identificado !');location.href='login.php'</script>";
		exit();
	}
	
}
else{
	$id = $session->retornaSession('codSession');
}

switch($op){
	case 'admin' :
		$prefix = "O";
		$titulo = "Administrador";
		
		$nome        = $_POST["nome"];
		$sobrenome   = $_POST["sobrenome"];
		$email       = $_POST["email"];
		$login       = $_POST["login"];
		$senha       = $_POST["senha"];
		$tipo        = $_POST["combo_tipo"];
		
		/* Recuperando o código do email */
		
		$sql = "SELECT ema_id FROM {$tabela['usuario']} WHERE usu_cod = $id";	
		$idEmail = $dataBase->getOne($sql);
		
		/* Atualizando o email na tabela de emails */
		
		atualizaEmail($email, $idEmail, "Sim");
					
		$valores = array(
			$idEmail,
			$nome,
			$sobrenome,				
			$login,
			$senha,
			$tipo
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['usuario'], "usu_cod = $id", $campos['usuario'], $valores);

		break;
	
	case 'ator' :
		$prefix = "O";
		$titulo = "Ator";
		
		$nome        = $_POST["nome"];
		$nomeNas     = $_POST["nome_nas"];
		$profissao   = $_POST["profissao"];
		$dataNas     = desconverteData($_POST["data_nascimento"]);
		$pais        = $_POST["combo_pais"];
		$cidade      = $_POST["cidade"];
		$biografia   = converteQuebra($_POST["biografia"]);
		$foto        = $_FILES["foto"];
		
		$sql = "SELECT ato_foto FROM {$tabela['ator']} WHERE ato_cod = $id";	
		$urlFoto = $dataBase->getOne($sql);
		
		if($foto['error']  != 4){ // Se a foto não estiver vazia.
			/* Enviando a foto escolhida */
			if(is_file($urlFoto)){
				unlink($urlFoto);
			}
			$sendFile = new SendFile($foto, $diretorio['atores']);
			
			$nomeFoto  = $sendFile->getNome();
		}
		else{
			$nomeFoto = $urlFoto;
		}
		
		$valores = array(
			$nome,
			$nomeNas,
			$profissao,
			$dataNas,
			$pais,
			$cidade,
			$biografia,
			$nomeFoto
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['ator'], "ato_cod = $id", $campos['ator'], $valores);

		break;
	
	case 'categoria' :
		$prefix = "A";
		$titulo = "Categoria";
		
		$nome       = $_POST["nome"];
		$descricao  = converteQuebra($_POST["descricao"]);
		$tempoLoc   = $_POST["temp_loc"];
		$preco      = converteMoeda($_POST["preco"]);
		
		$valores = array(
			$nome,
			$descricao,
			$tempoLoc,
			$preco
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['categoria'], "cat_cod = $id", $campos['categoria'], $valores);
		
		break;
	
	case 'classificacao' :
		$prefix = "A";
		$titulo = "Classificação";
		
		$classificacao = $_POST["classificacao"];
		$idade         = $_POST["idade"];
		
		$valores = array(
			$classificacao,
			$idade
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['classificacao'], "cla_cod = $id", $campos['classificacao'], $valores);
		
		break;
		
	case 'diretor' :
		$prefix = "O";
		$titulo = "Diretor";
		
		$nome = $_POST['nome'];
		
		$valores = array(
			$nome
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['diretor'], "dir_cod = $id", $campos['diretor'], $valores);
		
		break;
	
	case 'enquete' :
		$prefix = "A";
		$titulo = "Enquete";
		
		$pergunta       = $_POST["pergunta"];
		$resposta[1]    = $_POST["resposta1"];
		$resposta[2]    = $_POST["resposta2"];
		$resposta[3]    = $_POST["resposta3"];
		$resposta[4]    = $_POST["resposta4"];
		$exibir         = $_POST["comboExibir"];
		
		/* Se Exibir for sim, todas as outras enquetes são setadas como não ! */
		
		if($exibir == "Sim"){
			$query = new DataBase();
			$query->Query("UPDATE {$tabela['enquete']} SET enq_exibir = 'Não'");
		}
		
		/* Atualizando a pergunta */
		
		$valores = array(
			$cod,
			$pergunta,
			$exibir
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['enquete'], "enq_id = $id", $campos['enquete'], $valores);
		
		/* Armazenando as QTD's de voto */
		
		$sql = "SELECT res_votos FROM {$tabela['respostas']} WHERE enq_id = $id  ORDER BY res_id ASC";
		$resultado = $dataBase->query($sql);
		$i = 1;
		while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
			$voto[$i] = $dados['res_votos'];
			$i++;
		}
		
		/* Apagando as respostas antigas */
		
		$query = new DataBase();
		
		$query->Query("DELETE FROM {$tabela['respostas']} WHERE enq_id = $id");			
		
		/* Inserindo as respostas */
		
		for($i=1; $i<5; $i++){
			$valores = array(
				$id,
				$resposta[$i],
				$voto[$i]
			);
				
			$inserir = new DataBase();
			
			$inserir->Insert($tabela['respostas'], $campos['respostas'], $valores);
		}

		break;
	
	case 'filme' :
		$prefix = "O";
		$titulo = "Filme";
		
		$tituloFilme    = $_POST["titulo"];
		$tituloOriginal = $_POST["titulo_ori"];
		$ano            = $_POST["ano"];
		$duracao        = $_POST["duracao"];
		$categoria      = $_POST["categoria"];
		$classificacao  = $_POST["classificacao"];
		$sinopse        = converteQuebra($_POST["sinopse"]);
		$foto           = $_FILES["foto"];
		$dist           = $_POST["dist"];
		$destaque       = $_POST["destaque"];
		
		$sql = "SELECT fil_foto FROM {$tabela['filme']} WHERE fil_cod = $id";	
		$urlFoto = $dataBase->getOne($sql);
		
		if($foto['error']  != 4){ // Se a foto não estiver vazia.
			/* Enviando a foto escolhida */
			if(is_file($urlFoto)){
				unlink($urlFoto);
			}
			$sendFile = new SendFile($foto, $diretorio['filmes']);
			
			$nomeFoto  = $sendFile->getNome();
		}
		else{
			$nomeFoto = $urlFoto;
		}

		$valores = array(
			$categoria,
			$classificacao,
			$tituloFilme,
			$tituloOriginal,
			$ano,
			$duracao,
			$sinopse,
			$nomeFoto,
			$dist,
			$destaque				
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['filme'], "fil_cod = $id", $campos['filme'], $valores);
		
		/* Array com os atores */
		
		$listAtores = $_POST['list_atores'];
		
		/* Array com os diretores */
		
		$listDiretores = $_POST['list_diretores'];
		
		/* Array com os gêneroes */
		
		$listGeneros = $_POST['list_generos'];
		
		/* Apagando todos os relacionamentos antigos */
		
		$query = new DataBase();
		$query->Query("DELETE FROM {$tabela['ator_filme']} WHERE fil_cod = $id");
		$query->Query("DELETE FROM {$tabela['genero_filme']} WHERE fil_cod = $id");
		$query->Query("DELETE FROM {$tabela['diretor_filme']} WHERE fil_cod = $id");
		
		/* Cadastrando atores */
		
		$inserir = new DataBase();
		
		for($i=0; $i<count($listAtores); $i++){
			$valoresAtores = array(
			$listAtores[$i],
			$id);
			$inserir->Insert($tabela['ator_filme'], $campos['ator_filme'], $valoresAtores);
		}
		
		/* Cadastrando diretores */
		
		for($i=0; $i<count($listGeneros); $i++){
			$valoresGeneros = array(
			$listGeneros[$i],
			$id);
			$inserir->Insert($tabela['genero_filme'], $campos['genero_filme'], $valoresGeneros);
		}
		
		/* Cadastrando gêneros */
		
		for($i=0; $i<count($listDiretores); $i++){
			$valoresDiretores = array(
			$listDiretores[$i],
			$id);
			$inserir->Insert($tabela['diretor_filme'], $campos['diretor_filme'], $valoresDiretores);
		}
		
		break;
	
	case 'genero' :
		$prefix = "O";
		$titulo = "Gênero";
		
		$nome      = $_POST["nome"];
		$descricao = converteQuebra($_POST["descricao"]);
		
		$valores = array(
			$nome,
			$descricao		
		);

		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['genero'], "gen_cod = $id", $campos['genero'], $valores);
		
		break;	
		
	case 'midia':
		$prefix = "A";
		$titulo = "Mídia";
		
		$codigo  = $_POST["codigo"];
		$filme   = $_POST["filme"];
		$tipo    = $_POST["tipo"];
		$audio   = $_POST["audio"];
		$legenda = $_POST["legenda"];
		$regiao  = $_POST["regiao"];
		$formato = $_POST["formato"];
		$status  = $_POST["status"];

		$valores = array(
			$filme,
			$codigo,
			$tipo,
			$audio,
			$legenda,
			$regiao,
			$formato,
			$status		
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['midia'], "mid_cod = $id", $campos['midia'], $valores);
		
		break;
		
	case 'novidade' :
		$prefix = "A";
		$titulo = "Novidade";
		
		$titulo_nov = $_POST["titulo"];
		$conteudo   = converteQuebra($_POST["conteudo"]);

		$valores = array(
			$cod,
			$titulo_nov,
			$conteudo	
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['novidade'], "nov_id = $id", $campos['novidade'], $valores);
		
		break;
		
	case 'produto' :
		$prefix = "O";
		$titulo = "Produto";
		
		$nome  = $_POST["nome"];
		$qtd   = $_POST["qtd"];
		$preco = converteMoeda($_POST["preco"]);

		$valores = array(
			$nome,
			$qtd,
			$preco	
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['produtos'], "pro_cod = $id", $campos['produtos'], $valores);
		
		break;
		
	case 'taxa' :
		$prefix = "A";
		$titulo = "Taxa";
		
		$loc   = $_POST["localizacao"];
		$valor = converteMoeda($_POST["valor"]);

		$valores = array(
			$loc,
			$valor
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['taxa_entrega'], "txe_cod = $id", $campos['taxa_entrega'], $valores);
		
		break;
		
	case 'tipoUser' :
		$prefix = "O";
		$titulo = "Tipo de usuário";
		
		$tipo  = $_POST["tipo"];
		$nivel = $_POST["nivel"];

		$valores = array(
			$tipo,
			$nivel
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['tipo_user'], "tip_id_user = $id", $campos['tipo_user'], $valores);
		
		break;
		
	case 'feriado' :
		$prefix = "O";
		$titulo = "Feriado";
		
		$nome  = $_POST["nome"];
		$data = desconverteData($_POST["data"]);

		$valores = array(
			$data,
			$nome
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['feriados'], "fer_cod = $id", $campos['feriados'], $valores);
	
		break;
		
	/*
	#######################################################################################
	*/
	
	case 'cliente' :
		$prefix = "O";
		$titulo = "Cliente";
		
		$nome            = $_POST["nome"];
		$sobrenome       = $_POST["sobrenome"];
		$email           = $_POST["email"];
		$news            = $_POST["news"];
		$cpf             = $_GET["id"];
		$rg              = $_POST["rg"];
		$rua             = $_POST["rua"];
		$numero          = $_POST["numero"];
		$bairro          = $_POST["bairro"];
		$complemento     = $_POST["complemento"];
		$telefone        = $_POST["telefone"];
		$celular         = $_POST["celular"];
		$data_nascimento = desconverteData($_POST["data_nascimento"]);
		$localizacao     = $_POST["localizacao"];
		$login           = $_POST["login"];
		$senha           = $_POST["senha"];
		$loc             = $_POST["localizacao"];
		$bloqueado       = "Não";
		
		$tipo = 1; // Tipo de cliente
		
		/* Retornando um array com as chaves necessárias */
		
		$keys = retornaChavesCliente($cpf);
		
		/* Atualiza o email na tabela de emails */
		
		if($news == "Sim"){
			atualizaEmail($email, $keys['ema_id'], "Sim");
		}
		else{
			atualizaEmail($email, $keys['ema_id'], "Não");
		}
		
		/* Atualizando Usuário */
					
		$valores = array(
			$keys['ema_id'],
			$nome,
			$sobrenome,				
			$login,
			$senha,
			$tipo
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['usuario'], "usu_cod = {$keys['usu_cod']}", $campos['usuario'], $valores);
		
		
		/* Atualizando Cliente */

		$valores = array(
			$cpf,
			$keys['usu_cod'],
			$rg,
			$rua,
			$numero,
			$bairro,
			$complemento,
			$telefone,
			$celular,
			$data_nascimento,
			$bloqueado,
			$loc
		);
		
		$atualizar = new DataBase();
		
		$atualizar->Update($tabela['cliente'], "cli_cpf = '$cpf'", $campos['cliente'], $valores);
		
		$msgComple = "Talvez seja necessário que você relogue no site para que todas as alterações sejam efetuadas com sucesso.<br><br>";

		break;
		
}

$msg = "<div align=\"center\">";
$msg .= "<img src=\"../images/agt_reload.jpg\"><br><br>";
$titulo = strtolower($titulo);
$msg .= $prefix." ".$titulo." foi <b>atualizad".strtolower($prefix)."</b> com sucesso.<br><br>";
if(!empty($msgComple)){ $msg .= $msgComple; }
$msg .= "<a href=\"#\"><img src=\"../images/bot_voltar.jpg\" onclick=\"javascript:history.go(-2);\" border=\"0\" alt=\"Voltar !\"></a>";
$msg .= "</div>";

/* Título da Página Interna */
$tituloInterna = "Atualização de Registros";

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Conversão das variáveis dos blocos */

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

/* Bloco Login */
$template->setCurrentBlock("bloco_login");
	if($_SESSION['usuarioSession'] != 'sim'){
		/* Bloco Login Deslogado */
			$template->setVariable("abreForm", "<form action=\"loginUser.php\" method=\"post\" name=\"form_login\" id=\"form_login\">");
			$template->setVariable("conteudo", "Usuário <input name=\"usuario\" type=\"text\" class=\"form\" size=\"10\" onkeypress=\"pulaCampoNoEnter(senha)\"> Senha <input name=\"senha\" type=\"password\" class=\"form\" value=\"\" size=\"10\" onkeypress=\"enviaFormNoEnter(form_login)\">
												<a href=\"#\"><img src=\"../images/seta_go.jpg\" alt=\"Logar\" width=\"34\" height=\"24\" border=\"0\" align=\"absmiddle\" onClick=\"entrar(form_login.usuario, form_login.senha, form_login)\"></a>&nbsp;");
			$template->setVariable("fechaForm", "</form>");
	}
	else{
		/* Bloco Login Logado */
			$template->setVariable("conteudo", "Bem vindo(a), <span class=\"texto4\">".$_SESSION['nomeSession']."</span>&nbsp;&nbsp;&nbsp;<br><b><a href = \"minhaConta.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('img_minha','','../images/bot_minhaconta_rol.gif',1)\"><img src=\"../images/bot_minhaconta.gif\" name=\"img_minha\" border=\"0\" alt=\"Minha conta !\"/></a>
																																		  <a href = \"logout.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('img_sair_login','','../images/bot_logout_rol.gif',1)\"><img src=\"../images/bot_logout.gif\" name=\"img_sair_login\" border=\"0\"  alt=\"Sair !\"/></a>&nbsp;&nbsp;&nbsp;");
	}
$template->parseCurrentBlock("bloco_login");

/* Bloco Busca */
$template->setCurrentBlock("bloco_busca");
	$template->setVariable("actionBusca", "busca.php");
	$template->setVariable("formBusca", "form_busca");
	$template->setVariable("comboGenero", "genero");
	
	/* Recupera os gêneros cadastrados */
	$sql = "SELECT gen_cod, gen_nome FROM {$tabela['genero']} ORDER BY gen_nome";
	$resultado = $dataBase->query($sql);
	$generos = "<option value=\"-1\">Todos</option>";
	while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
		$generos .= "<option value=\"{$dados['gen_cod']}\"";
		$generos .= ">{$dados['gen_nome']}</option>";
	}
	
	$template->setVariable("comboGeneroOpcoes", $generos);
	
	/* Pega do array o buscar por... */

	foreach($buscarPor as $indice => $valor){
		$por .= "<option value=\"$indice\"";
		$por .= ">$valor</option>";
	}
	
	$template->setVariable("comboPor", "por");
	$template->setVariable("comboPorOpcoes", $por);
	
	$template->setVariable("campoNome", "nome");
	$template->setVariable("altBusca", "Buscar !");
	$template->setVariable("linkVejaTodos", "listarTodos.php");
	$template->setVariable("onClickBusca", "buscar(form_busca.nome, form_busca)");
	$template->setVariable("linkBuscar", "#");
$template->parseCurrentBlock("bloco_busca");

/* Bloco Carrinho */
$template->setCurrentBlock("bloco_carrinho");
	$template->setVariable("qtdF", number_format($_SESSION['qtd_filmes'], 0));
	$template->setVariable("qtdC", number_format($_SESSION['qtd_conveniencia'], 0));
	$template->setVariable("valorTotal", "R$ ".number_format($_SESSION['val_total'], 2, ',','.'));
	$template->setVariable("linkFim", "#");
	$template->setVariable("onClickFim", "javascript:location.href='finalizar.php'");
	$template->setVariable("altFim", "Finalizar Pedido !");
$template->parseCurrentBlock("bloco_carrinho");

/* Bloco Parceiros */
$template->setCurrentBlock("bloco_parceiros");
	foreach($parceiros as $indice => $valor){
		$parc .= "<a href =\"{$valor[1]}\"><img src=\"{$valor[0]}\" width=\"213\" height=\"52\" alt=\"$indice\" border=\"0\"></a><br>";
	}
	$template->setVariable("parceiros", $parc);
$template->parseCurrentBlock("bloco_parceiros");

/* Bloco Interno */
$template->setCurrentBlock("bloco_interno");
	$template->setVariable("titulo_interno", $tituloInterna);
	$template->setVariable("conteudo_interno", $msg);
$template->parseCurrentBlock("bloco_interno");

/* Bloco Principal */
$template->setCurrentBlock("bloco_principal");
	/* Menu */
	foreach($menu['principal'] as $menu => $cont){
		foreach($cont as $titulo => $link){
			$template->setVariable($menu, $titulo);
			$lnk = strtoupper($menu[0]).substr($menu, 1, strlen($menu));
			$template->setVariable("link".$lnk, $link);
		}
	}
	
	/* Login */
	$template->setVariable("linkCadastreSe", "cadastrese.php");
	$template->setVariable("linkEsqueci", "esqueci.php");
	$template->setVariable("altCadastreSe", "Cadastre-se !");
	$template->setVariable("altEsqueci", "Esqueceu a senha ?");
	
	/* Kreea */
	$template->setVariable("linkKreea", "http://www.kreea.com.br");
	
$template->parseCurrentBlock("bloco_principal");

$template->show();

?>