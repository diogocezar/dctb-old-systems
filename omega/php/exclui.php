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
$op = $_GET['tipo'];

$permitido = false;

@$session = new Session();

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

$id = $_GET['id'];

switch($op){
	case 'admin' :
		$prefix = "O";
		$titulo = "Administrador";
		
		/* Verificando se o usuario pode ser excluido */
		
		$existeNovidade = $dataBase->getOne("SELECT count(*) FROM {$tabela['novidade']} WHERE usu_cod = $id");
		$existeEnquete  = $dataBase->getOne("SELECT count(*) FROM {$tabela['enquete']}  WHERE usu_cod = $id");
		
		if(empty($existeNovidade) && empty($existeEnquete)){
			/* Recuperando o código do email */
			$sql = "SELECT ema_id FROM {$tabela['usuario']} WHERE usu_cod = $id";	
			$idEmail = $dataBase->getOne($sql);
			
			/* Excluindo o email */
			$excluir = new DataBase();
			$excluir->Delete($tabela['email'], "ema_id = $idEmail");
			$excluir->Delete($tabela['usuario'], "usu_cod = $id");
		}
		else{
			$trava_exclusao = true;
		}
		break;
	
	case 'ator' :
		$prefix = "O";
		$titulo = "Administrador";
		
		$existeFilme = $dataBase->getOne("SELECT count(*) FROM {$tabela['ator_filme']} WHERE ato_cod = $id");
		
		if(empty($existeFilme)){
			/* Recuperando e excluindo a imagem */
			$sql = "SELECT ato_foto FROM {$tabela['ator']} WHERE ato_cod = $id";	
			$urlFoto = $dataBase->getOne($sql);
			if(is_file($urlFoto)){
				unlink($urlFoto);
			}
			$excluir = new DataBase();
			$excluir->Delete($tabela['ator'], "ato_cod = $id");
		}
		else{
			$trava_exclusao = true;
		}
		
		break;
	
	case 'categoria' :
		$prefix = "A";
		$titulo = "Categoria";
		
		$existeFilme = $dataBase->getOne("SELECT count(*) FROM {$tabela['filme']} WHERE cat_cod = $id");
		
		if(empty($existeFilme)){			
			$excluir = new DataBase();
			$excluir->Delete($tabela['categoria'], "cat_cod = $id");
		}
		else{
			$trava_exclusao = true;
		}
		
		break;
	
	case 'classificacao' :
		$prefix = "A";
		$titulo = "Categoria";
		
		$existeFilme = $dataBase->getOne("SELECT count(*) FROM {$tabela['filme']} WHERE cla_cod = $id");
		
		if(empty($existeFilme)){			
			$excluir = new DataBase();
			$excluir->Delete($tabela['classificacao'], "cla_cod = $id");
		}
		else{
			$trava_exclusao = true;
		}
		
		break;
	
	case 'diretor' :
		$prefix = "O";
		$titulo = "Diretor";
		
		$existeFilme = $dataBase->getOne("SELECT count(*) FROM {$tabela['diretor_filme']} WHERE dir_cod = $id");
		
		if(empty($existeFilme)){
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['diretor'], "dir_cod = $id");
			
		}
		else{
			$trava_exclusao = true;
		}

		break;
	
	case 'enquete' :
		$prefix = "A";
		$titulo = "Enquete";
		
		/* Excluindo as respostas */
		
			$query = new DataBase();
			
			$query->Query("DELETE FROM {$tabela['respostas']} WHERE enq_id = $id");	
		
		/* Excluindo a pergunta */		
		
		$excluir = new DataBase();
		
		$excluir->Delete($tabela['enquete'], "enq_id = $id");
		
		break;
	
	case 'filme' :
		$prefix = "O";
		$titulo = "Filme";
		
		$existeMidia = $dataBase->getOne("SELECT count(*) FROM {$tabela['midia']} WHERE fil_cod = $id");
		$existeAvaliacao = $dataBase->getOne("SELECT count(*) FROM {$tabela['avaliacao']} WHERE fil_cod = $id");
		
		if(empty($existeMidia) && empty($existeAvaliacao)){
			
			/* Apagando todos os relacionamentos antigos */
			
			$query = new DataBase();
			$query->Query("DELETE FROM {$tabela['ator_filme']} WHERE fil_cod = $id");
			$query->Query("DELETE FROM {$tabela['genero_filme']} WHERE fil_cod = $id");
			$query->Query("DELETE FROM {$tabela['diretor_filme']} WHERE fil_cod = $id");
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['filme'], "fil_cod = $id");
			
		}
		else{
			$trava_exclusao = true;
		}
		
		break;
		
	case 'genero':
		$prefix = "O";
		$titulo = "Gênero";
		
		$existeFilme = $dataBase->getOne("SELECT count(*) FROM {$tabela['genero_filme']} WHERE gen_cod = $id");
		
		if(empty($existeFilme)){
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['genero'], "gen_cod = $id");
			
		}
		else{
			$trava_exclusao = true;
		}
		
		break;	
		
	case 'midia':
		$prefix = "A";
		$titulo = "Mídia";
		
		//$existeLocacao = $dataBase->getOne("SELECT count(*) FROM {$tabela['midia_locacao']} WHERE mid_cod = $id");
		
		//if(empty($existeLocacao)){
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['midia'], "mid_cod = $id");
			
		//}
		//else{
		//	$trava_exclusao = true;
		//}
		
		break;	
		
	case 'novidade' :
		$prefix = "A";
		$titulo = "Novidade";

		$excluir = new DataBase();
		
		$excluir->Delete($tabela['novidade'], "nov_id = $id");
		
		break;
		
	case 'produto' :
		$prefix = "O";
		$titulo = "Produto";
		
		$existeLocacao = $dataBase->getOne("SELECT count(*) FROM {$tabela['produtos_locacao']} WHERE pro_cod = $id");
		
		if(empty($existeLocacao)){
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['produtos'], "pro_cod = $id");
			
		}
		else{
			$trava_exclusao = true;
		}
		
		break;	
		
	case 'taxa' :
		$prefix = "A";
		$titulo = "Taxa";

		$existeCliente = $dataBase->getOne("SELECT count(*) FROM {$tabela['cliente']} WHERE txe_cod = $id");
		
		if(empty($existeCliente)){
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['taxa_entrega'], "txe_cod = $id");
			
		}
		else{
			$trava_exclusao = true;
		}
		
		break;
		
	case 'tipoUser' :
		$prefix = "O";
		$titulo = "Tipo de usuário";
		
		$existeCliente = $dataBase->getOne("SELECT count(*) FROM {$tabela['usuario']} WHERE tip_id_user = $id");
		
		if(empty($existeCliente)){
			
			$excluir = new DataBase();
			
			$excluir->Delete($tabela['tipo_user'], "tip_id_user = $id");
			
		}
		else{
			$trava_exclusao = true;
		}
		
		break;
		
	case 'feriado' :
		$prefix = "O";
		$titulo = "Feriado";
		
		$excluir = new DataBase();
		
		$excluir->Delete($tabela['feriados'], "fer_cod = $id");
	
		break;
		
}

if($trava_exclusao != true){
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/button_cancel.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." foi <b>excluid".strtolower($prefix)."</b> com sucesso.<br><br>";
	$msg .= "<a href=\"#\"><img src=\"../images/bot_voltar.jpg\" onclick=\"javascript:javascript:history.go(-1);\" border=\"0\" alt=\"Voltar !\"></a>";
	$msg .= "</div>";
}
else{
	$msg = "<div align=\"center\">";
	$msg .= "<img src=\"../images/button_cancel.jpg\"><br><br>";
	$titulo = strtolower($titulo);
	$msg .= $prefix." ".$titulo." <b>NÃO</b> pode ser excluid".strtolower($prefix).", pois pode estar sendo referenciado(a) em outra tabela do banco de dados.<br><br>";
	$msg .= "Certifique-se que não há mais refência para esse registro antes de excluí-lo(a).<br><br>";
	$msg .= "<a href=\"#\"><img src=\"../images/bot_voltar.jpg\" onclick=\"javascript:javascript:history.go(-1);'\" border=\"0\" alt=\"Voltar !\"></a>";
	$msg .= "</div>";
}

/* Título da Página Interna */
$tituloInterna = "Exclusão de Registros";

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