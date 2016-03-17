<?php
/**
* arquivo de configuração
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

/**
* incluindo controle de sessão
*/
$nivelRequerido = "admin";
include("../php/controlaSession.php");

$op   = $_GET['tipo'];
$acao = $_GET['acao'];
$id   = $_GET['id'];

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
		$descricao  = $_POST["descricao"];
		
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
					
		$titulo    = $_POST["titulo"];
		$foto      = $_FILES["foto"];
		$descricao = $_POST["descricao"];
			
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$objRec->setId          ($id);
		$objRec->setTitulo      ($titulo);
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
		
		$titulo     = $_POST["titulo"];
		$autor      = $_POST["autor"];
		$descricao  = $_POST["descricao"];
						
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->setTitulo         ($titulo);
		$objRec->setAutor          ($autor);
		$objRec->setDescricao      ($descricao);
		
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
		
		$titulo    = $_POST["titulo"];
		$link      = $_POST["link"];
		$descricao = $_POST["descricao"];
						
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->setTitulo    ($titulo);
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
		
		$titulo    = $_POST["titulo"];
		$descricao = $_POST["descricao"];
						
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->setTitulo    ($titulo);
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
		
		$historico  = $_POST["historico"];
		$equipe     = $_POST["equipe"];
		$servicos   = $_POST["servicos"];
		$links      = $_POST["links"];
		$dicas      = $_POST["dicas"];
		$trabalhos  = $_POST["trabalhos"];
						
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		$objRec->setHistorico  ($historico);
		$objRec->setEquipe     ($equipe);
		$objRec->setServicos   ($servicos);
		$objRec->setLinks      ($links);
		$objRec->setDicas      ($dicas);
		$objRec->setTrabalhos  ($trabalhos);
		
		$continuar = false;
		$objRec->update();
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

$msg .= "<link href=\"../css/gerenciar.css\" rel=\"stylesheet\" type=\"text/css\"/>";
$msg .= "<div id=\"titulo_gerenciar\"></div>";
$msg .= "<br /><br />";
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