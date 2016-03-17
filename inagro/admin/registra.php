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
include("../admin/controlaSession.php");

if(empty($op)){
	echo "<script language=javascript>alert('Uma opção é necessária para inserir ou atualizar o registro.');location.href='index.php'</script>";
	exit();
}

if(empty($acao)){
	echo "<script language=javascript>alert('Uma ação de alteração ou inserção é necessária para manipular um registro.');location.href='index.php'</script>";
	exit();
}
else{
	if($acao == "atualizar"){
		if(empty($id)){
			echo "<script language=javascript>alert('Uma identificação é necessária para manipular um registro.');location.href='index.php'</script>";
			exit();
		}
	}
}

$continuar = false;

switch($op){
	case 'noticia':
		$prefix = "A";
		$titulo = "Notícia";
		$continuar = true;

		$tituloNoticia = $_POST['titulo'];
		$descricao     = $_POST['descricao'];
		$data          = converteData($_POST['data']);
		$arquivo       = $_FILES['foto'];

		/* Se foi enviada a foto */
		if(!empty($arquivo['name'])){
		
			/* Excluindo a foto se necessário*/
			if($acao == "atualizar"){
				$objVer = $controlador[$op];
				$objVer->__toFillGeneric();
				$objVer->__get_db($id);
				$objVer->deletePictures();
			}
			
			/* Enviando a foto */
			$objArq = $controlador['sendfile'];
			$objArq->__go_SendFile($arquivo, $diretorio['noticias']);
			$nomeArquivo = $objArq->getNome();
			
		}//Empty
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$objRec->setTitulo    ($tituloNoticia);
		$objRec->setDescricao ($descricao);
		$objRec->setData      ($data);
		$objRec->setFoto      ($nomeArquivo);
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'empresa':
		$prefix = "A";
		$titulo = "Empresa";
		$continuar = true;

		$nome        = $_POST['nome'];
		$descricao   = $_POST['descricao'];
		$arquivo[0]  = $_FILES['logo'];
		$arquivo[1]  = $_FILES['foto1'];
		$arquivo[2]  = $_FILES['foto2'];
		$arquivo[3]  = $_FILES['foto3'];
		$arquivo[4]  = $_FILES['foto4'];
		$arquivo[5]  = $_FILES['foto5'];
		$arquivo[6]  = $_FILES['foto6'];
		
		if($acao == "atualizar"){
			$objVer = $controlador[$op];
			$objVer->__toFillGeneric();
			$objVer->__get_db($id);
			$nomeArquivo[0] = $objVer->getLogo();
			$nomeArquivo[1] = $objVer->getFoto1();
			$nomeArquivo[2] = $objVer->getFoto2();
			$nomeArquivo[3] = $objVer->getFoto3();
			$nomeArquivo[4] = $objVer->getFoto4();
			$nomeArquivo[5] = $objVer->getFoto5();
			$nomeArquivo[6] = $objVer->getFoto6();
		}

		/* Se foi enviada a foto */
		foreach($arquivo as $indice => $valor){
			if(!empty($valor['name'])){
				/* Excluindo a foto se necessário*/
				if($acao == "atualizar"){
					$objVer->deletePicture($indice);
				}
				
				/* Enviando a foto */
				$objArq = $controlador['sendfile'];
				$objArq->__go_SendFile($valor, $diretorio['empresas']);
				$nomeArquivo[$indice] = $objArq->getNome();
			}//Empty
		}
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$objRec->setNome      ($nome);
		$objRec->setDescricao ($descricao);
		$objRec->setLogo      ($nomeArquivo[0]);
		$objRec->setFoto1     ($nomeArquivo[1]);
		$objRec->setFoto2     ($nomeArquivo[2]);
		$objRec->setFoto3     ($nomeArquivo[3]);
		$objRec->setFoto4     ($nomeArquivo[4]);
		$objRec->setFoto5     ($nomeArquivo[5]);
		$objRec->setFoto6     ($nomeArquivo[6]);
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'evento':
		$prefix = "O";
		$titulo = "Evento";
		$continuar = true;

		$tituloEvento = $_POST['titulo'];
		$descricao    = $_POST['descricao'];
		$data         = converteData($_POST['data']);
		$arquivo[0]   = $_FILES['foto1'];
		$arquivo[1]   = $_FILES['foto2'];
		$arquivo[2]   = $_FILES['foto3'];
		$arquivo[3]   = $_FILES['foto4'];
		$arquivo[4]   = $_FILES['foto5'];
		$arquivo[5]   = $_FILES['foto6'];
		$arquivo[6]   = $_FILES['foto7'];
		$arquivo[7]   = $_FILES['foto8'];

		
		if($acao == "atualizar"){
			$objVer = $controlador[$op];
			$objVer->__toFillGeneric();
			$objVer->__get_db($id);
			$nomeArquivo[0] = $objVer->getFoto1();
			$nomeArquivo[1] = $objVer->getFoto2();
			$nomeArquivo[2] = $objVer->getFoto3();
			$nomeArquivo[3] = $objVer->getFoto4();
			$nomeArquivo[4] = $objVer->getFoto5();
			$nomeArquivo[5] = $objVer->getFoto6();
			$nomeArquivo[6] = $objVer->getFoto7();
			$nomeArquivo[7] = $objVer->getFoto8();
		}

		/* Se foi enviada a foto */
		foreach($arquivo as $indice => $valor){
			if(!empty($valor['name'])){
				/* Excluindo a foto se necessário*/
				if($acao == "atualizar"){
					$objVer->deletePicture($indice);
				}
				
				/* Enviando a foto */
				$objArq = $controlador['sendfile'];
				$objArq->__go_SendFile($valor, $diretorio['eventos']);
				$nomeArquivo[$indice] = $objArq->getNome();
			}//Empty
		}
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$objRec->setTitulo    ($tituloEvento);
		$objRec->setDescricao ($descricao);
		$objRec->setData      ($data);
		$objRec->setFoto1     ($nomeArquivo[0]);
		$objRec->setFoto2     ($nomeArquivo[1]);
		$objRec->setFoto3     ($nomeArquivo[2]);
		$objRec->setFoto4     ($nomeArquivo[3]);
		$objRec->setFoto5     ($nomeArquivo[4]);
		$objRec->setFoto6     ($nomeArquivo[5]);
		$objRec->setFoto7     ($nomeArquivo[6]);
		$objRec->setFoto8     ($nomeArquivo[7]);
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'link':
		$prefix = "O";
		$titulo = "Link";
		$continuar = true;

		$tituloLink  = $_POST['titulo'];
		$link        = $_POST['link'];
		$descricao   = $_POST['descricao'];

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
	
	case 'parceiro':
		$prefix = "O";
		$titulo = "Parceiro";
		$continuar = true;

		$arquivo  = $_FILES['foto'];
		$nome     = $_POST['nome'];
		$link     = $_POST['link'];
		
		/* Se foi enviada a foto */
		if(!empty($arquivo['name'])){
		
			/* Excluindo a foto se necessário*/
			if($acao == "atualizar"){
				$objVer = $controlador[$op];
				$objVer->__toFillGeneric();
				$objVer->__get_db($id);
				$objVer->deletePictures();
			}
			
			/* Enviando a foto */
			$objArq = $controlador['sendfile'];
			$objArq->__go_SendFile($arquivo, $diretorio['parceiros']);
			$nomeArquivo = $objArq->getNome();
		}//Empty

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$objRec->setFoto ($nomeArquivo);
		$objRec->setNome ($nome);
		$objRec->setLink ($link);
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'download':
		$prefix = "O";
		$titulo = "Download";
		$continuar = true;

		$tituloNoticia = $_POST['titulo'];
		$arquivo       = $_FILES['arquivo'];

		/* Se foi enviada a foto */
		if(!empty($arquivo['name'])){
		
			/* Excluindo a foto se necessário*/
			if($acao == "atualizar"){
				$objVer = $controlador[$op];
				$objVer->__toFillGeneric();
				$objVer->__get_db($id);
				$objVer->deletePictures();
			}
			
			/* Enviando a foto */
			$objArq = $controlador['sendfile'];
			$objArq->__go_SendFile($arquivo, $diretorio['downloads']);
			$nomeArquivo = $objArq->getNome();
		}//Empty
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$objRec->setTitulo ($tituloNoticia);
		$objRec->setUrl    ($nomeArquivo);
		
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
	$img = "../images/atualizar.jpg"; 
	$prefixoAcao = "atualizad";
}
else{
	$img = "../images/adicionar.jpg"; 
	$prefixoAcao = "inserid";
}

$titulo = strtolower($titulo);

$msg .= "<div align=\"center\">";
$msg .= "<img src=\"$img\"><br><br>";
$msg .= $prefix." ".$titulo." foi <b>$prefixoAcao".strtolower($prefix)."</b> com sucesso.<br><br>";

if(empty($voltar)){
	$voltar = 'index.php';
}
$msg .= "<input name=\"voltar\" type=\"button\" value=\"Início\" class=\"botao\" onClick=\"javascript:location.href='$voltar'\" /><br /><br />";

if($continuar == true){
	$msg .= "<input name=\"voltar\" type=\"button\" value=\"Continuar\" class=\"botao\" onClick=\"javascript:history.go(-1);\" /><br /><br />";
}

$msg .= "</div>";

$conteudo = $msg;

$titulo = "Registro ".$prefixoAcao."o com sucesso";

if($existePessoa){
	echo "<script language=javascript>alert('A pessoa já está cadastrada em nosso banco de dados.');javascript:history.go(-1);</script>";
	exit();
}

/* incluindo conteudo na página interna */
include("../admin/includeInterna.php");	
?>