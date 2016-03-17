<?php
include("start-brain.php");
include("session-control.php");

$op   = $_GET['tipo'];
$acao = $_GET['acao'];
$id   = $_GET['id'];

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

$arrayNoToUp = array("email_adm", "senha_adm");

/* transformando todos os campos enviados em letras maiúsculas
foreach($_POST as $indice => $valor){
	if(!in_array($indice, $arrayNoToUp)){
		$_POST[$indice] = uc_latin1($_POST[$indice]);
	}
}
*/

switch($op){
	case 'administrador':
		$prefix = "O";
		$titulo = "Administrador";
		$continuar = true;
		$gerenciar = "manage.php?table=administrador&fields=2";
		
		$nomeADM  = $_POST['nome_adm'];
		$cursoADM = $_POST['curso_adm'];
		$emailADM = $_POST['email_adm'];
		$loginADM = $_POST['login_adm'];
		$senhaADM = $_POST['senha_adm'];
		
		$objRec = $brain_controller[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setNome         ($nomeADM);
		$objRec->setIdcurso      ($cursoADM);
		$objRec->setEmail        ($emailADM);
		$objRec->setLogin        ($loginADM);
		$objRec->setSenha        ($senhaADM);
		$objRec->setDataBaixa    ('NULL');
		$objRec->setSituacao     ('1');
		
		if($acao == "add"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	case 'curso':
		$prefix = "O";
		$titulo = "Curso";
		$continuar = true;
		$gerenciar = "manage.php?table=curso&fields=1";
		
		$nomeCUR             = $_POST['nome_cur'];
		$periodoInscricaoCUR = $_POST['periodo_inscricao_cur'];
		
		$objRec = $brain_controller[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setNome            ($nomeCUR);
		$objRec->setPeriodoInscricao($periodoInscricaoCUR);
		$objRec->setDataBaixa       ('NULL');
		$objRec->setSituacao        ('1');
		
		if($acao == "add"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	case 'inscricao':
		$prefix = "A";
		$titulo = "Inscrição";
		$continuar = true;
		$gerenciar = "manage.php?table=inscricao&fields=2,8,9,10,11";
		
		$nomeINS            = $_POST['nome_ins'];
		$data_nascimentoINS = converteData($_POST['data_nascimento_ins']);
		$profissaoINS       = $_POST['profissao_ins'];
		$cidadeINS          = $_POST['cidade_ins'];
		$estadoINS          = $_POST['estado_ins'];
		$emailINS           = $_POST['email_ins'];
		$telefoneINS        = $_POST['telefone_ins'];
		$celularINS         = $_POST['celular_ins'];
		$curso_gradINS      = $_POST['curso_grag_ins'];
		$instituicaoINS     = $_POST['instituicao_ins'];
		$anoINS             = $_POST['ano_ins'];
		$cursoINS           = $_POST['curso_ins'];
		
		$objRec = $brain_controller[$op];
		$objAdm = $brain_controller['administrador'];
		$objCur = $brain_controller['curso'];
		$objRec->__toFillGeneric();
		$objAdm->__toFillGeneric();
		$objCur->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setIdcurso             ($cursoINS);
		$objRec->setNome                ($nomeINS);
		$objRec->setDataNascimento      ($data_nascimentoINS);
		$objRec->setCursoGraduacao      ($curso_gradINS);
		$objRec->setInstituicaoGraduacao($instituicaoINS);
		$objRec->setAnoConclusao        ($anoINS);
		$objRec->setProfissao           ($profissaoINS);
		$objRec->setCidade              ($cidadeINS);
		$objRec->setEstado              ($estadoINS);
		$objRec->setTelefone            ($telefoneINS);
		$objRec->setCelular             ($celularINS);
		$objRec->setEmail               ($emailINS);
		$objRec->setDataBaixa           ('NULL');
		$objRec->setSituacao            ('1');
		
		if($acao == "add"){
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

if($acao == "update"){
	$img = "../view/images/atualizar.jpg"; 
	$prefixoAcao = "atualizad";
}
else{
	$img = "../view/images/adicionar.jpg"; 
	$prefixoAcao = "inserid";
}

$titulo = strtolower($titulo);

$msg .= "<div align=\"center\">";
$msg .= "<img src=\"$img\"><br><br>";
$msg .= $prefix." ".$titulo." foi <b>$prefixoAcao".strtolower($prefix)."</b> com sucesso.<br><br>";

if(!empty($gerenciar)){
	$msg .= "<input name=\"voltar\" type=\"button\" value=\"Gerenciar\" class=\"button\" onClick=\"javascript:location.href='$gerenciar'\" /><br /><br />";
}

if($continuar == true){
	$msg .= "<input name=\"voltar\" type=\"button\" value=\"Continuar\" class=\"button\" onClick=\"javascript:history.go(-1);\" /><br /><br />";
}

$msg .= "</div>";

$content = $msg;

$title   = "Registro ".$prefixoAcao."o com sucesso";

if($existePessoa){
	echo "<script language=javascript>alert('O ítem já está cadastrado em nosso banco de dados.');javascript:history.go(-1);</script>";
	exit();
}

/* incluindo conteudo na página interna */
include('inside-include.php');
?>