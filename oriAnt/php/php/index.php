<?php
session_start();

/**
* Incluindo o cerebro
*/
include('../cerebro/includeCerebro.php');

/**
* Biblioteca de funções
*/
include("../lib/library.php");

/**
* Incluindo funções ajax
*/ 
include("../ajax/ajax.php");

/* Variáveis de GET */

$filtro   = rawurldecode($_GET['filtro']);
$endereco = rawurldecode($_GET['rss']);

if(empty($filtro)){
	$filtro = -1;
}

if(empty($endereco)){
	echo "<script language=javascript>location.href='../pages/ultimas_noticias.php';</script>";
}

$feedName = explode('.', $endereco);
$feedName = ucfirst($feedName[1]);

@$tree = $controlador['tree'];
$tree->__go_Tree(true);

if($feedName == "Google"){
	$uft8 = true;
}
else{
	$uft8 = false;
}

$noticiasRss   = $controlador['noticiasrss'];
$categoriaName = $noticiasRss->getNameNew($endereco);

$feeds = $controlador['noticesrss'];
$feeds->__go_NoticiasRss($endereco, $noticiasRss);
$tags = array("title","link","description","pubDate");

$noticiasRss->__get_db_endereco($endereco);
$qtdFeed       = $feeds->getQuantidade()-2; 
$qtdCadastrada = $noticiasRss->getQtd();
$inicio        = $qtdCadastrada-$qtdFeed;


$base = $feeds->getBase();
$time = $feeds->getRemain();

if($filtro != -1 && ($filtro < $inicio || $filtro > ($qtdCadastrada+1))){
	//echo $filtro."<".$inicio;
	//echo "<br>";
	//echo $filtro.">".$qtdCadastrada;
	echo "<script language=javascript>alert('Não foi possível localizar a notícia solicitada!');location.href='../pages/ultimas_noticias.php';</script>";
}

/* Avaliação */
include("../avaliacao/computarAvaliacao.php");

/* Comentários */
include("../comentarios/comentario.php");

/* Painel Login/Admin */

if(!allowedAdmin()){

	$lista = $tree->makeTree();

	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Capturando Pedido */
	$templateHtmlName = 'formLogin.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Bloco Html */
	$template->setCurrentBlock("bloco_html");
		$template->setVariable("cmp_form_login", "login");
		$template->setVariable("cmp_form_senha", "senha");
		$template->setVariable("java_onclick", "call_login(login.value, senha.value)");
	$template->parseCurrentBlock("bloco_html");
	
	$painel = $template->get();
}
else{

	$lista = $tree->makeTreeAdmin();

	/* Diretório dos Templates */
	$templateHtmlDir = '../html';
	
	/* Capturando Pedido */
	$templateHtmlName = 'formAdmin.html';
	
	/* Setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* Instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* Bloco Html */
	$template->setCurrentBlock("bloco_html");
		$nomeAdmin = $controlador['session']->retornaSession(SESSION_NOME);
		$template->setVariable("cmp_nome_admin", $nomeAdmin);
		$template->setVariable("cmp_form_nome", "nome");
		$template->setVariable("cmp_form_feed", "feed");
		$template->setVariable("cmp_form_ordem", "ordem");
		$template->setVariable("java_onclick_enviar", "call_addCategoria(nome.value, feed.value, ordem.value)");
		$template->setVariable("java_onclick_sair", "call_logout()");
	$template->parseCurrentBlock("bloco_html");
	
	$painel = $template->get();
}

/* Diretório dos Templates */
$templateHtmlDir = '../html';

/* Capturando Pedido */
$templateHtmlName = 'noticiasRss.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco Titulo */
	$template->setCurrentBlock("bloco_titulo");
		$template->setVariable("titulo", TITULO);
	$template->parseCurrentBlock("bloco_titulo");
	
/* Bloco JavaScript */
	$template->setCurrentBlock("bloco_javascript");
		$template->setVariable("sjax", sajax_show_javascript());
	$template->parseCurrentBlock("bloco_javascript");
	
/* Bloco Menu Arvore */
	$template->setCurrentBlock("bloco_menu_arvore");
		$template->setVariable("lista_menu", $lista);
	$template->parseCurrentBlock("bloco_menu_arvore");
		
/* Bloco Html */
	$template->setCurrentBlock("bloco_html");
	
		/*Gerando Notícias */
		if($incremento == 0){
			$incremento = 1;
		}
		$j=1;
		if($inicio == 0){
			$inicio=1;
		}
		$i=$inicio;
		while ($c = $feeds->getTag($tags)){
			$titulo         = clean($c['title'], $uft8);
			$pubDate        = $c['pubDate'];
			$endPutGet      = rawurlencode($_GET['rss']);
			$endNotGet      = rawurldecode($_GET['rss']);
			$linkDescricao  = "?rss=$endPutGet&filtro=$i";
			$linkPar        = $_SERVER['PHP_SELF']."rss=$endNotGet&filtro=$i";
			$star           = $controlador['avaliacao']->getStars($linkPar);
			$comentariosQtd = $controlador['comentarios']->getComments($linkPar);
			$linkDireto     = clean($c['link'], $uft8);
			$descricao      = clean($c['description'], $uft8);
			if($filtro == -1){
				if(!eregi("Google News Brasil", $titulo) && !eregi("Terra - RSS -", $titulo) && !eregi("Terra", $titulo)){
					$template->setCurrentBlock("bloco_box");
						$template->setVariable("titulo", "$j - ".$titulo."<br />");$j++;
						$template->setVariable("estrelas", escreveEstrelas($star)."<br />");
						$template->setVariable("comentarios", "<b>".$comentariosQtd."</b> - Comentário(s)<br />");
						$template->setVariable("quando", $pubDate."<br />");
						$template->setVariable("link", "<a href =\"$linkDescricao\">Detalhes</a>");
						$template->setVariable("link_completo", " - <a href =\"$linkDireto\">Ir para notícia</a>");
						$noticias = "";
					$template->parseCurrentBlock("bloco_box");
				}
			}
			else{
			
				$compara = $i;
				if($i>$inicio){
					$compara = $i+1;
				}
				if($filtro == $compara){
					$noticias = $descricao;
					$template->setVariable("voltar", "<a href =\"javascript:history.back(1);\">« Voltar</a>");
					$template->setCurrentBlock("bloco_box");
						$template->setVariable("titulo_detalhes", "Detalhes da Notícia");
						if(!$utf8){
							$noticias = "<br />".$noticias;
						}
						$template->setVariable("conteudo_detalhes", $noticias);
						$template->setVariable("link_completo_detalhes", "<br><a href =\"$linkDireto\">Ir para notícia</a>");
					$template->parseCurrentBlock("bloco_box");
					
					/* Avaliação */
					$template->setCurrentBlock("bloco_box");
						$divAvaliacao .= "<div id=\"avaliacao\">";
						$divAvaliacao .= $avaliacao;
						$divAvaliacao .= "</div>";
						$divAvaliacao .= "<div id=\"comunicacao_avaliacao\"></div>";
						$template->setVariable("conteudo_detalhes", $divAvaliacao);
					$template->parseCurrentBlock("bloco_box");
					
					/* Comentários Lista */
					$template->setCurrentBlock("bloco_box");
						$divComentarioList .= "<div id=\"comunicacao_comentario\">";
						$divComentarioList .= $listarComentario;
						$divComentarioList .= "</div>";
						$template->setVariable("conteudo_detalhes", $divComentarioList);
					$template->parseCurrentBlock("bloco_box");
					
					/* Comentários Form */
					$template->setCurrentBlock("bloco_box");
						$divComentario .= $comentarios;
						$template->setVariable("conteudo_detalhes", $divComentario);
					$template->parseCurrentBlock("bloco_box");
				}
			}
			$i++;
		}
	
		$template->setVariable("categoria", $categoriaName);
		$template->setVariable("feed", $feedName);
		$template->setVariable("count", $qtdFeed);
		$template->setVariable("base", $base);
		$template->setVariable("time", "Restam: <span class=\"fonteVermelha\">".$time."</span> para a próxima atualização");
		
		/* Painel */		
		$template->setVariable("conteudo_box_login", $painel);
		
	$template->parseCurrentBlock("bloco_html");

$template->show();

?>