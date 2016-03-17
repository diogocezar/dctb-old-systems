<?php
/**
* arquivo de configuração
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

$op   = $_GET['tipo'];
$acao = $_GET['acao'];
$id   = $_GET['id'];

/**
* incluindo controle de sessão
*/
if($op != 'depoimento' && $acao != 'adicionar'){
	$nivelRequerido = "admin";
	include("../php/controlaSession.php");
}
else{
	/**
	* biblioteca de funcoes
	*/
	include("../lib/library.php");
	include("../lib/util.php");
}

/* definições para página interna */
$pagina = getPaginaAtual();
$escopo = "Adminsitração";
$caminho = "Página Inicial";

if(empty($op)){
	echo "<script language=javascript>alert('Uma opção é necessária para inserir ou atualizar o registro.');location.href='administrar.php'</script>";
	exit();
}

if(empty($acao)){
	echo "<script language=javascript>alert('Uma ação de alteração ou inserção é necessária para manipular um registro.');location.href='administrar.php'</script>";
	exit();
}
else{
	if($acao == "atualizar"){
		if(empty($id)){
			echo "<script language=javascript>alert('Uma identificação é necessária para manipular um registro.');location.href='administrar.php'</script>";
			exit();
		}
	}
}

$continuar = false;

switch($op){
	case 'dica' :
		$prefix = "A";
		$titulo = "Dica";
		$continuar = true;
		
		$tituloDica = $_POST["titulo"];
		$descricao  = converteQuebra($_POST["descricao"]);
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->setTitulo    ($tituloDica);
		$objRec->setDescricao ($descricao);
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
		
	case 'equipe' :
		$prefix = "O";
		$titulo = "Membro da Equipe";
		$continuar = true;
		
		$nome         = $_POST["nome"];
		$email        = $_POST["email"];
		$apresentacao = $_POST["apresentacao"];
				
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->Nome        ($cliente);
		$objRec->Email       ($pro_acao);
		$objRec->Apresentacao($numero);
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;

	case 'trabalho' :
		$prefix = "O";
		$titulo = "Trabalho";
		$continuar = true;
		
		$objRec  = $controlador[$op];
		$objRec->__toFillGeneric();
		
		if(!empty($id)){		
			/* recuperando dados da fase */
			$objRec->__get_db($id);
			$anexoAntigo = $objRec->getFoto();
		}
		else{
			$id = $objRec->max_r();
		}
					
		$tituloTrab = $_POST["titulo"];
		$foto       = $_FILES["foto"];
		$descricao  = $_POST["descricao"];
			
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$objRec->setId          ($id);
		$objRec->setTitulo      ($tituloTrab);
		$objRec->setDescricao   ($descricao);
		
		if($acao == "adicionar"){
			/* enviando o anexo */
			if($anexo['error']  != 4){
				$sendFile = $controlador['sendfile'];
				$sendFile->__go_SendFile($anexo, $diretorio['trb']);				
				$nomeAnexo = $sendFile->getNome();			
			}		
			$objRec->setFoto($nomeAnexo);
			$objRec->save();
			
		}
		else{		
			/* enviando o anexo caso tenha sido enviado */
			if($anexo['error']  != 4){
				/* apagando anexo antigo */
				if(is_file($anexoAntigo)){
					unlink($anexoAntigo);
				}
				$sendFile = $controlador['sendfile'];
				$sendFile->__go_SendFile($anexo, $diretorio['fas']);				
				$nomeAnexo = $sendFile->getNome();			
			}
			else{
				$nomeAnexo = $anexoAntigo;
			}
			$continuar = false;
			$objRec->setFoto($nomeAnexo);
			$objRec->update();
		}
		
	break;

	case 'noticia' :
		$prefix = "A";
		$titulo = "Notícia";
		$continuar = true;
		
		$tituloNot  = $_POST["titulo"];
		$autor      = $_POST["autor"];
		$descricao  = converteQuebra($_POST["descricao"]);
		$data       = date("Y-m-d");
						
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->setTitulo         ($tituloNot);
		$objRec->setAutor          ($autor);
		$objRec->setDescricao      ($descricao);
		$objRec->setData           ($data);
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;	
		
	case 'link' :
		$prefix = "O";
		$titulo = "Link";
		$continuar = true;
		
		$tituloLink = $_POST["titulo"];
		$link       = $_POST["link"];
		$descricao  = converteQuebra($_POST["descricao"]);
						
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->setTitulo    ($tituloLink);
		$objRec->setLink      ($link);
		$objRec->setDescricao ($descricao);
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'servico' :
		$prefix = "O";
		$titulo = "Servico";
		$continuar = true;
		
		$tituloServ = $_POST["titulo"];
		$descricao  = converteQuebra($_POST["descricao"]);
						
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->setTitulo    ($tituloServ);
		$objRec->setDescricao ($descricao);
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
		
	case 'informacoes' :
		$prefix = "As";
		$titulo = "Informações";
		$continuar = true;
		
		$historico  = converteQuebra($_POST["historico"]);
		$arte       = converteQuebra($_POST["arte"]);
						
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->setHistorico  ($historico);
		$objRec->setArte       ($arte);
		
		$continuar = false;
		$objRec->update();
	break;
	
	case 'depoimento' :
		$prefix = "O";
		$titulo = "Depoimento";
		$continuar = true;
		
		$nome       = $_POST["nome"];
		$email      = $_POST["email"];
		$depoimento = converteQuebra($_POST["depoimento"]);
						
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->setNome       ($nome);
		$objRec->setEmail      ($email);
		$objRec->setDepoimento ($depoimento);
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
}


/* informações de inserção/atualização */

if($acao == "atualizar"){
	$img = "../images/alterado.jpg"; 
	$prefixoAcao = "atualizad";
}
else{
	$img = "../images/inserido.jpg"; 
	$prefixoAcao = "inserid";
}

$titulo = strtolower($titulo);

$msg .= "<div align=\"center\">";
$msg .= "<img src=\"$img\"><br><br>";
$msg .= $prefix." ".$titulo." foi <b>$prefixoAcao".strtolower($prefix)."</b> com sucesso.<br><br>";

if(empty($voltar)){
	$voltar = 'administrar.php';
}
$msg .= "<a href=\"#\"><img src=\"../images/botVoltar.jpg\" onclick=\"javascript:location.href='$voltar'\" border=\"0\" alt=\"Voltar !\"></a>";

if($continuar == true){
	$msg .= "<a href=\"#\"><img src=\"../images/botContinuar.jpg\" onclick=\"javascript:history.go(-1);\" border=\"0\" alt=\"Continuar Inserindo !\"></a>";
}

$msg .= "</div>";

$conteudo = $msg;

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>