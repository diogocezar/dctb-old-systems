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
include("../php/controlaSession.php");

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

$continuar    = false;
$mostraCodigo = false;


/* transformando todos os campos enviados em letras maiúsculas */
foreach($_POST as $indice => $valor){
	if(!in_array($indice, $arrayNoToUp)){
		$_POST[$indice] = uc_latin1($_POST[$indice]);
	}
}

switch($op){
	case 'usuario':
		$prefix = "O";
		$titulo = "Usuário";
		$continuar = true;
		$gerenciar = "gerenciar.php?tabela=usuario&campos=1,2";

		$nome         = $_POST['nome'];
		$telefone     = $_POST['telefone'];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setNome         ($nome);
		$objRec->setTelefone     ($telefone);
		$objRec->setDataBaixa    ('NULL');
		$objRec->setSituacao     ('1');
		
		if($acao == "adicionar"){
			$objRec->setDataCadastro('NOW()');
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'administrador':
		$prefix = "O";
		$titulo = "Administrador";
		$continuar = true;
		$gerenciar = "gerenciar.php?tabela=administrador&campos=1,2";
		
		$nomeADM  = $_POST['nome_adm'];
		$loginADM = $_POST['login_adm'];
		$senhaADM = $_POST['senha_adm'];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setNome         ($nomeADM);
		$objRec->setLogin        ($loginADM);
		$objRec->setSenha        ($senhaADM);
		$objRec->setDataBaixa    ('NULL');
		$objRec->setSituacao     ('1');
		
		if($acao == "adicionar"){
			$objRec->setDataCadastro('NOW()');
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;

	case 'acervo':
		$prefix = "O";
		$titulo = "Acervo";
		$continuar = true;
		$gerenciar = "gerenciar.php?tabela=acervo&campos=6,4";
		
		$numero      = $_POST['numero'];
		$volume      = $_POST['volume'];
		$tipoacervo  = $_POST['tipoacervo'];
		$tituloAce   = $_POST['titulo'];
		$autor       = $_POST['autor'];
		$editora     = $_POST['editora'];
		$qtdvolumes  = $_POST['qtdvolumes'];
		$status      = $_POST['status'];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setIdTipoAcervo($tipoacervo);
		$objRec->setIdAutor($autor);
		$objRec->setIdEditora($editora);
		$objRec->setNumero($numero);
		$objRec->setVolume($volume);		
		$objRec->setTitulo($tituloAce);
		$objRec->setQtdVolumes($qtdvolumes);
		$objRec->setStatus($status);

		$objRec->setDataBaixa('NULL');
		$objRec->setSituacao('1');
		
		if($acao == "adicionar"){
			$objRec->setDataCadastro('NOW()');
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'locacao':
		$prefix = "A";
		$titulo = "Locação";
		$continuar = true;
		$gerenciar = "gerenciar.php?tabela=locacao&campos=3,4,5";
		
		$usuario        = $_POST["usuario"];
		$lista_acervos  = $_POST["lista_acervos"];
		$data_locacao   = converteData($_POST["data_locacao"]);
		$data_devolucao = converteData($_POST["data_devolucao"]);
		$status         = $_POST["status"];

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$administrador = $_SESSION['sessId'];
		
		$objRec->setIdUsuario      ($usuario);
		$objRec->setIdAdministrador($administrador);
		$objRec->setDataLocacao    ($data_locacao);
		$objRec->setDataDevolucao  ($data_devolucao);
		$objRec->setStatus         ($status);
		$objRec->setDataBaixa      ('NULL');
		$objRec->setSituacao       ('1');
		
		$objAcervoLocacao = $controlador['acervolocacao'];
		$objAcervoLocacao->__toFillGeneric();
		
		if($acao == "adicionar"){
			$objRec->setDataCadastro('');
			$objRec->startTransaction();
				$objRec->save();
			$objRec->commitTransaction();
			
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->startTransaction();
				$objRec->update();
			$objRec->commitTransaction();
			
			if($status != "FECHADO"){
				/* Excluindo conhecimentos antigos */
					$objAcervoLocacao->deleteAcer($id);
				/* FIM */
			}
		}
		if($status != "FECHADO"){
			/* Salvando conhecimentos */
				if(empty($id)){ $id = $objRec->max_r(); }
				$objAcervoLocacao->saveAcer($lista_acervos, $id);
			/* FIM */
		}
	break;
	
	case 'tipoacervo' :
		$prefix = "O";
		$titulo = "Tipo de acervo";
		$continuar = true;
		$gerenciar = "gerenciar.php?tabela=tipoacervo&campos=1";
		
		$nome = $_POST["nome"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$lastId = $objRec->max_r();
		
		$objRec->setNome      ($nome);
		$objRec->setDataBaixa ('NULL');
		$objRec->setSituacao  ('1');
		
		if($acao == "adicionar"){
			$objRec->setDataCadastro('NOW()');
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'autor' :
		$prefix = "O";
		$titulo = "Autor";
		$continuar = true;
		$gerenciar = "gerenciar.php?tabela=autor&campos=1";
		
		$nome = $_POST["nome"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$lastId = $objRec->max_r();
		
		$objRec->setNome      ($nome);
		$objRec->setDataBaixa ('NULL');
		$objRec->setSituacao  ('1');
		
		if($acao == "adicionar"){
			$objRec->setDataCadastro('NOW()');
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'editora' :
		$prefix = "A";
		$titulo = "Editora";
		$continuar = true;
		$gerenciar = "gerenciar.php?tabela=editora&campos=1";
		
		$nome = $_POST["nome"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$lastId = $objRec->max_r();
		
		$objRec->setNome      ($nome);
		$objRec->setDataBaixa ('NULL');
		$objRec->setSituacao  ('1');
		
		if($acao == "adicionar"){
			$objRec->setDataCadastro('NOW()');
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

if(!empty($gerenciar)){
	$msg .= "<input name=\"voltar\" type=\"button\" value=\"Gerenciar\" class=\"botao\" onClick=\"javascript:location.href='$gerenciar'\" /><br /><br />";
}

if($continuar == true){
	$msg .= "<input name=\"voltar\" type=\"button\" value=\"Continuar\" class=\"botao\" onClick=\"javascript:history.go(-1);\" /><br /><br />";
}

$msg .= "</div>";

$conteudo = $msg;

$titulo = "Registro ".$prefixoAcao."o com sucesso";

if($existePessoa){
	echo "<script language=javascript>alert('O ítem já está cadastrado em nosso banco de dados.');javascript:history.go(-1);</script>";
	exit();
}

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>