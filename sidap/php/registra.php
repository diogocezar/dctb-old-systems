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

		$nivel        = $_POST['nivel'];
		$nome         = $_POST['nome'];
		$loginUsuario = $_POST['loginUsuario'];
		$senhaUsuario = $_POST['senhaUsuario'];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$lastId = $objRec->max_r();
		
		$objRec->setId           ($lastId);
		$objRec->setIdnivel      ($nivel);
		$objRec->setNome         ($nome);
		$objRec->setLogin        ($loginUsuario);
		$objRec->setSenha        ($senhaUsuario);
		$objRec->setDatabaixa    ('NULL');
		$objRec->setSituacao     ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
		
	case 'nivel' :
		$prefix = "O";
		$titulo = "Nivel";
		$continuar = true;
		
		$descricao = $_POST["descricao"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$lastId = $objRec->max_r();
		
		$objRec->setId        ($lastId);
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'cliente':
		$prefix = "O";
		$titulo = "Cliente";
		$continuar = true;
		
		$grupo          = $_POST['grupo'];
		$nome           = $_POST['nome'];
		$datanascimento = converteData($_POST['datanascimento']);
		$bairro         = $_POST['bairro'];
		$cidade         = $_POST['cidade'];
		$endereco       = $_POST['endereco'];
		$cep            = $_POST['cep'];
		$estado         = $_POST['estado'];
		$telefone1      = $_POST['telefone1'];
		$telefone2      = $_POST['telefone2'];
		$celular        = $_POST['celular'];
		$numbeneficio   = $_POST['numbeneficio'];
		$nit            = $_POST['nit'];
		$observacao     = $_POST['observacao'];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$idUsuario = $_SESSION['sessId'];
		
		$lastId = $objRec->max_r();
		
		$objRec->setIdcliente($lastId);
		$objRec->setIdgrupo($grupo);
		$objRec->setIdusuario($idUsuario);
		$objRec->setNome($nome);
		$objRec->setDatanascimento($datanascimento);
		$objRec->setBairro($bairro);
		$objRec->setCidade($cidade);
		$objRec->setEndereco($endereco);
		$objRec->setCep($cep);
		$objRec->setEstado($estado);
		$objRec->setTelefone1($telefone1);
		$objRec->setTelefone2($telefone2);
		$objRec->setCelular($celular);
		$objRec->setNumbeneficio($numbeneficio);
		$objRec->setNit($nit);
		$objRec->setObservacao($observacao);
		$objRec->setDatabaixa('NULL');
		$objRec->setSituacao('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'agenda':
		$prefix = "O";
		$titulo = "Agendamento";
		$continuar = true;
		
		$tipo              = $_POST['tipo'];
		$cliente           = $_POST['cliente'];
		$datasolicitacao   = converteData($_POST['datasolicitacao']);
		$dataagendada      = converteData($_POST['dataagendada']);
		$horaagendada      = $_POST['horaagendada'];
		$descricao         = $_POST['descricao'];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$idUsuario = $_SESSION['sessId'];
		
		$lastId = $objRec->max_r();

		$objRec->setIdagenda($lastId);
		$objRec->setIdtipo($tipo);
		$objRec->setIdcliente($cliente);
		$objRec->setIdusuario($idUsuario);;
		$objRec->setDatasolicitacao($datasolicitacao);
		$objRec->setDataagenda($dataagendada);
		$objRec->setHoraagenda($horaagendada);
		$objRec->setDescricao($descricao);
		$objRec->setDatabaixa('NULL');
		$objRec->setSituacao('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;

	case 'grupo' :
		$prefix = "O";
		$titulo = "Grupo";
		$continuar = true;
		
		$descricao = $_POST["descricao"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$lastId = $objRec->max_r();
		
		$objRec->setId        ($lastId);
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'tipo' :
		$prefix = "O";
		$titulo = "Tipo";
		$continuar = true;
		
		$descricao = $_POST["descricao"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$lastId = $objRec->max_r();
		
		$objRec->setId        ($lastId);
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
	echo "<script language=javascript>alert('O ítem já está cadastrado em nosso banco de dados.');javascript:history.go(-1);</script>";
	exit();
}

/* incluindo conteudo na página interna */
include("../php/includeInterna.php");	
?>