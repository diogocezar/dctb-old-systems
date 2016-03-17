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

if($op != "cliente" && $op != "locacao" && $op != "favorito"){

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
	$voltar = "index.php";
	if($op == "locacao" || $op == "favorito"){
		if($_SESSION['usuarioSession'] != 'sim'){
			echo "<script language=javascript>alert('Você prescisa estar logado para inserir uma locação.');location.href='index.php'</script>";
			exit();
		}
		else{
			$cod = $session->retornaSession('codSession');
		}
	}
}

$continuar = false;

switch($op){
	case 'admin' :
		$prefix = "O";
		$titulo = "Administrador";
		$continuar = true;
		
		$nome        = $_POST["nome"];
		$sobrenome   = $_POST["sobrenome"];
		$email       = $_POST["email"];
		$login       = $_POST["login"];
		$senha       = $_POST["senha"];
		$tipo        = $_POST["combo_tipo"];
		
		/* Gravando o email na tabela de emails */
		
		$idEmail = insereEmail($email, "Sim");
					
		$valores = array(
			$idEmail,
			$nome,
			$sobrenome,				
			$login,
			$senha,
			$tipo
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['usuario'], $campos['usuario'], $valores);

		break;

	case 'ator' :
		$prefix = "O";
		$titulo = "Ator";
		$continuar = true;
		
		$nome        = $_POST["nome"];
		$nomeNas     = $_POST["nome_nas"];
		$profissao   = $_POST["profissao"];
		$dataNas     = desconverteData($_POST["data_nascimento"]);
		$pais        = $_POST["combo_pais"];
		$cidade      = $_POST["cidade"];
		$biografia   = converteQuebra($_POST["biografia"]);
		$foto        = $_FILES["foto"];
		
		/* Enviando a foto escolhida se não estiver vazia */
		
		if($foto['error']  != 4){ // Se a foto não estiver vazia.
		
			$sendFile = new SendFile($foto, $diretorio['atores']);
			
			$nomeFoto  = $sendFile->getNome();
		
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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['ator'], $campos['ator'], $valores);

		break;
	
	case 'categoria' :
		$prefix = "A";
		$titulo = "Categoria";
		$continuar = true;
		
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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['categoria'], $campos['categoria'], $valores);
		
		break;
	
	case 'classificacao' :
		$prefix = "A";
		$titulo = "Classificação";
		$continuar = true;
		
		$classificacao = $_POST["classificacao"];
		$idade         = $_POST["idade"];
		
		$valores = array(
			$classificacao,
			$idade
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['classificacao'], $campos['classificacao'], $valores);
		
		break;
				
	case 'diretor' :
		$prefix = "O";
		$titulo = "Diretor";
		$continuar = true;
		
		$nome = $_POST['nome'];
		
		$valores = array(
			$nome
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['diretor'], $campos['diretor'], $valores);
		
		break;
	
	case 'enquete' :
		$prefix = "A";
		$titulo = "Enquete";
		$continuar = true;
		
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
		
		/* Adicionando a pergunta */
		
		$valores = array(
			$cod,
			$pergunta,
			$exibir
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['enquete'], $campos['enquete'], $valores);
		
		$sql = "SELECT MAX(enq_id) FROM {$tabela['enquete']}";	
		$codEnquete = $dataBase->getOne($sql);
		
		/* Adicionando as respostas */
		
		for($i=1; $i<5; $i++){
			$valores = array(
				$codEnquete,
				$resposta[$i],
				0
			);
				
			$inserir = new DataBase();
			
			$inserir->Insert($tabela['respostas'], $campos['respostas'], $valores);
		}

		break;
	
	case 'filme' :
		$prefix = "O";
		$titulo = "Filme";
		$continuar = true;
		$midia = true;
		
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
		
		/* Array com os atores */
		
		$listAtores = $_POST['list_atores'];
		
		/* Array com os diretores */
		
		$listDiretores = $_POST['list_diretores'];
		
		/* Array com os gêneroes */
		
		$listGeneros = $_POST['list_generos'];

		
		if(empty($listGeneros)){
			echo "<script language=javascript>alert('Selecione ao menos um gênero para cadastrar o filme.');javascript:history.go(-1);</script>";
			exit();
		}
				
		/* Enviando a foto escolhida se não estiver vazia */
		
		if($foto['error']  != 4){ // Se a foto não estiver vazia.
		
			$sendFile = new SendFile($foto, $diretorio['filmes']);
			
			$nomeFoto  = $sendFile->getNome();
		
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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['filme'], $campos['filme'], $valores);
		
		$sql = "SELECT MAX(fil_cod) FROM {$tabela['filme']}";
		
		$codFilme = $dataBase->getOne($sql);
				
		/* Cadastrando atores */
		
		for($i=0; $i<count($listAtores); $i++){
			$valoresAtores = array(
			$listAtores[$i],
			$codFilme);
			$inserir->Insert($tabela['ator_filme'], $campos['ator_filme'], $valoresAtores);
		}
		
		/* Cadastrando diretores */
		
		for($i=0; $i<count($listGeneros); $i++){
			$valoresGeneros = array(
			$listGeneros[$i],
			$codFilme);
			$inserir->Insert($tabela['genero_filme'], $campos['genero_filme'], $valoresGeneros);
		}
		
		/* Cadastrando gêneros */
		
		for($i=0; $i<count($listDiretores); $i++){
			$valoresDiretores = array(
			$listDiretores[$i],
			$codFilme);
			$inserir->Insert($tabela['diretor_filme'], $campos['diretor_filme'], $valoresDiretores);
		}
		
		break;
	
	case 'genero' :
		$prefix = "O";
		$titulo = "Gênero";
		$continuar = true;
		
		$nome      = $_POST["nome"];
		$descricao = converteQuebra($_POST["descricao"]);
		
		$valores = array(
			$nome,
			$descricao		
		);

		$inserir = new DataBase();
		
		$inserir->Insert($tabela['genero'], $campos['genero'], $valores);
		
		break;
		
	case 'midia' :
		$prefix = "A";
		$titulo = "Mídia";
		$continuar = true;
		
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
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['midia'], $campos['midia'], $valores);
		
		break;
		
	case 'novidade' :
		$prefix = "A";
		$titulo = "Novidade";
		$continuar = true;
		
		$titulo_nov = $_POST["titulo"];
		$conteudo   = converteQuebra($_POST["conteudo"]);

		$valores = array(
			$cod,
			$titulo_nov,
			$conteudo	
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['novidade'], $campos['novidade'], $valores);
		
		break;
		
	case 'produto' :
		$prefix = "O";
		$titulo = "Produto";
		$continuar = true;
		
		$nome  = $_POST["nome"];
		$qtd   = $_POST["qtd"];
		$preco = converteMoeda($_POST["preco"]);

		$valores = array(
			$nome,
			$qtd,
			$preco	
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['produtos'], $campos['produtos'], $valores);
		
		break;
		
	case 'taxa' :
		$prefix = "A";
		$titulo = "Taxa";
		$continuar = true;
		
		$loc   = $_POST["localizacao"];
		$valor = converteMoeda($_POST["valor"]);

		$valores = array(
			$loc,
			$valor
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['taxa_entrega'], $campos['taxa_entrega'], $valores);
		
		break;
		
	case 'tipoUser' :
		$prefix = "O";
		$titulo = "Tipo de usuário";
		$continuar = true;
		
		$tipo  = $_POST["tipo"];
		$nivel = $_POST["nivel"];

		$valores = array(
			$tipo,
			$nivel
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['tipo_user'], $campos['tipo_user'], $valores);
		
		break;
		
	case 'feriado' :
		$prefix = "O";
		$titulo = "Feriado";
		$continuar = true;
		
		$nome = $_POST["nome"];
		$data = desconverteData($_POST["data"]);

		$valores = array(
			$data,
			$nome
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['feriados'], $campos['feriados'], $valores);
	
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
		$cpf             = retiraSeparadores($_POST["cpf"]);
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
		
		if(existeLogin($login)){
			echo "<script language=javascript>alert('O login digitado já existe !');location.href='cadastrese.php'</script>";
			exit();
		}
		
		if(existeEmail($email)){
			echo "<script language=javascript>alert('O e-mail digitado já existe !');location.href='cadastrese.php'</script>";
			exit();
		}
		
		if(validaCPF($cpf)){	
		
			$tipo = 1; // Tipo de cliente
			
			/* Gravando o email na tabela de emails */
			
			if($news == "Sim"){
				$idEmail = insereEmail($email, "Sim");
			}
			else{
				$idEmail = insereEmail($email, "Não");
			}
			
			/* Inserindo Usuário */
						
			$valores = array(
				$idEmail,
				$nome,
				$sobrenome,				
				$login,
				$senha,
				$tipo
			);
			
			$inserir = new DataBase();
			
			$inserir->Insert($tabela['usuario'], $campos['usuario'], $valores);
			
			$sql = "SELECT MAX(usu_cod) FROM {$tabela['usuario']}";
			$codUsuario = $dataBase->getOne($sql);
			
			/* Inserindo Cliente */
	
			$valores = array(
				$cpf,
				$codUsuario,
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
			
			$inserir = new DataBase();
			
			$inserir->Insert($tabela['cliente'], $campos['cliente'], $valores);
			
		}
		else{
			echo "<script language=javascript>alert('CPF Digitado é inválido !');location.href='cadastrese.php'</script>";
			exit();
		}
		break;
		
	case 'locacao':
		$prefix = "A";
		$titulo = "Locação";
		
		$cpf         = $cod;
		$quando      = date("Y-m-d");
		$dataEntrega = desconverteData($_POST['data_locacao']);
		$horaEntrega = $_POST['hora_entrega'];
		$dataBusca   = desconverteData($_POST['data_devolucao']);
		$horaBusca   = $_POST['hora_devolucao'];
		$valor       = $_POST['valor'];
		$obs         = converteQuebra($_POST['obs']);
		
		$valores = array(
			$cpf,
			$dataEntrega,
			$horaEntrega,
			$dataBusca,
			$horaBusca,
			$valor,
			0,
			$obs,
			$situacao[3]
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['locacao'], $campos['locacao'], $valores);
		
		$sql = "SELECT MAX(loc_cod) FROM {$tabela['locacao']}";
		$codLocacao = $dataBase->getOne($sql);
		
		/* Inserindo os Filmes Locados */
		
		if(!empty($_SESSION['filmes'])){
			foreach($_SESSION['filmes'] as $indice => $valor){
					$codMidia = $valor['cod_midia'];
					
					$valores = array(
						$codMidia,
						$codLocacao
					);
					
					$inserir = new DataBase();
					
					$inserir->Insert($tabela['midia_locacao'], $campos['midia_locacao'], $valores);
					
					/* Seta a midia como locada */
					alteraStatus($codMidia);
			}
		}
		
		/* Inserindo Produtos Comprados */
		
		if(!empty($_SESSION['produtos'])){
			foreach($_SESSION['produtos'] as $indice => $valor){
					$codProd = $valor['cod'];
					$qtdProd = $valor['qtd'];
					
					$valores = array(
						$codProd,
						$codLocacao,
						$qtdProd
					);
					
					$inserir = new DataBase();
					
					$inserir->Insert($tabela['produtos_locacao'], $campos['produtos_locacao'], $valores);
					
					/* Retira a qtd no estoque */
					alteraQtd($codProd, $qtdProd);
			}
		}
		
		/* Limpa Filmes e Produtos da Session */
		
		unset($_SESSION['produtos']);
		unset($_SESSION['filmes']);
		unset($_SESSION['qtd_filmes']);
		unset($_SESSION['qtd_conveniencia']);
		unset($_SESSION['val_total']);
		
		/* Enviando o email para o administrador do site */
		
		$conteudo  = "Olá Administrador, houve uma nova locação em seu site, <a href=\"".HOME."\"><b>".HOME."</b></a><br><br>";
		$conteudo .= "Para vizualisar os detalhes dessa nova locação, você prescisa estar logado como administrador.<br><br>";
		$conteudo .= "A nova locação pode ser acessada pelo link : <a href=\"http://www.locadoraomega.com.br/php/locacoes.php?id=$codLocacao\"><b>http://www.locadoraomega.com.br/php/locacoes.php?id=$codLocacao</b></a>";
		
		$titulo    = "Nova locação pelo web-site.";
		
		$email = new SendMail($titulo, $conteudo, EMAIL);
		$email->goMail();
		
		$emailCel = new SendMail($titulo, $conteudo, '4399325882@tim.com.br');
		$emailCel->goMail();
		
		break;
		
	case 'favorito':
		$prefix = "O";
		$titulo = "Filme Favorito";
		
		$id = $_GET['id'];
		
		$valores = array(
			$cod,
			$id
		);
		
		$inserir = new DataBase();
		
		$inserir->Insert($tabela['favoritos'], $campos['favoritos'], $valores);
		break;	
		
}

$msg = "<div align=\"center\">";
$msg .= "<img src=\"../images/button_ok.jpg\"><br><br>";
$titulo = strtolower($titulo);
$msg .= $prefix." ".$titulo." foi <b>inserid".strtolower($prefix)."</b> com sucesso.<br><br>";
if(empty($voltar)){ $voltar = 'administrar.php'; }
$msg .= "<a href=\"#\"><img src=\"../images/bot_voltar.jpg\" onclick=\"javascript:location.href='$voltar'\" border=\"0\" alt=\"Voltar !\"></a>";
if($continuar == true){
$msg .= "<a href=\"#\"><img src=\"../images/bot_continuar_inserindo.jpg\" onclick=\"javascript:history.go(-1);\" border=\"0\" alt=\"Continuar Inserindo !\"></a>";
}
if($midia == true){
$msg .= "<a href=\"#\"><img src=\"../images/bot_inserirmidia.jpg\" onclick=\"javascript:location.href='midia.php?acao=adicionar&idFilme=$codFilme'\" border=\"0\" alt=\"Inserir Mídia !\"></a>";
}
$msg .= "</div>";

/* Título da Página Interna */
$tituloInterna = "Inserção de Registros";

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