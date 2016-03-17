<?php
include("start-brain.php");

$op = $_GET['tipo'];
$existePessoa = false;

$arrayNoToUp = array("email_adm", "senha_adm");

/* transformando todos os campos enviados em letras mai�sculas
foreach($_POST as $indice => $valor){
	if(!in_array($indice, $arrayNoToUp)){
		$_POST[$indice] = uc_latin1($_POST[$indice]);
	}
}
*/

switch($op){
	case 'inscricao':
		$prefix = "A";
		$titulo = "Inscri��o";
		$continuar = true;
		
		$nomeINS            = $_POST['nome_ins'];
		$data_nascimentoINS = converteData($_POST['data_nascimento_ins']);
		$profissaoINS       = $_POST['profissao_ins'];
		$cidadeINS          = $_POST['cidade_ins'];
		$estadoINS          = $_POST['estado_ins'];
		$emailINS           = strtolower($_POST['email_ins']);
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
		
		//if(!$objRec->checkUnique()){
		//	$existePessoa = true;
		//	break;
		//}
		
		$objRec->save();
		$last = $objRec->returnLast();
		$objRec->__get_db($last);
		$last = $objRec->getIdcurso();
		$data = date('d/m/Y - H:i:s');
		
		/* Enviando e-mail para o cordenador do curso */
		$objCur->__get_db($last);
		$nomeCurso = $objCur->getNome();
		$periodoInscricao = $objCur->getPeriodoInscricao();
		
		/* Confirma��o de informa��es */
		$infos .= "Informa��es Cadastradas: <br />";
		$infos .= "<ul>";
			$infos .= "<li>Data / Hora : $data</li>";
			$infos .= "<li>Curso : $nomeCurso</li>";
			$infos .= "<li>Nome : $nomeINS</li>";
			$infos .= "<li>Data de nascimento : ".$_POST['data_nascimento_ins']."</li>";
			$infos .= "<li>Curso Gradua��o : $curso_gradINS</li>";
			$infos .= "<li>Profiss�o : $profissaoINS</li>";
			$infos .= "<li>Cidade : $cidadeINS</li>";
			$infos .= "<li>Estado : $estadoINS</li>";
			$infos .= "<li>Telefone : $telefoneINS</li>";
			$infos .= "<li>Celular : $celularINS</li>";
			$infos .= "<li>Email : <a href =\"mailto:$emailINS\">$emailINS</a>";
		$infos .= "</ul>";		
		
		$emailsAdm = $objAdm->returnEmails($last);
		
		$origem = "geppg-cp@utfpr.edu.br";
		
		$autor = "DIRPPG";
		
		$msgFinal = "";
		
		$templateHtmlDir = "../view/html/";
		
		$templateHtmlName = "mail.html";
		
		if(!empty($emailsAdm)){
				$titulo_email = "GEPPG - Um novo cadastro foi efetuado";
				$mail = $brain_controller['sendmail'];
				$mail->prepareMail($titulo, $infos, $emailsAdm, $origem, $autor, $msgFinal, $templateHtmlDir, $templateHtmlName);
				$mail->goMail();
		}
		else{
			$infos .= "<br /><br />N�o foi poss�vel encontrar um coordenador para enviar sua inscri��o. Por favor entre em contato com a ger�ncia da p�s-gradua��o pelo e-mail: $origem.<br /><br />";	
		}

	break;
}

/* informa��es de inser��o/atualiza��o */

$titulo = strtolower($titulo);

$msg .= "<div align=\"center\">";

$msg .= "<div align=\"justify\">";

$msg .= 

"Obrigado por escolher a UTFPR! <br /><br />
 
Seu cadastro foi recebido e registrado em nosso sistema. <br />
 
O per�odo para fazer a inscri��o �: $periodoInscricao. <br /><br />
 
Procedimento para fazer a inscri��o via Correios: <br /><br />

<ol>	 
	<li>	
		Fazer o pagamento da taxa de inscri��o por meio de dep�sito banc�rio: <br /><br />
		
		<ul>
			<li>FUNTEF-PR (Funda��o de Apoio � Educa��o, Pesquisa e Desenvolvimento Cient�fico e Tecnol�gico da Universidade Tecnol�gica Federal do Paran�)</li>
			<li>CAIXA ECON�MICA FEDERAL</li>
			<li>AG�NCIA: 0388</li>
			<li>CONTA CORRENTE: 1405-8</li>
			<li>OPERA��O: 03<br /><br /></li>
		</ul>
	</li>
	 
	<li>		
		Enviar para a UTFPR: <br /><br />
		<ul>
			<li>Ficha de inscri��o preenchida;</li>
			<li>Comprovante de pagamento da taxa de inscri��o;</li>
			<li>01 foto 3x4</li>
			<li>C�pia do diploma ou certificado do curso de gradua��o;</li>
			<li>C�pia do hist�rico escolar do curso de gradua��o;</li>
			<li>C�pia do RG e CPF</li>
			<li>C�pia da certid�o de nascimento ou casamento;</li>
			<li>C�pia do t�tulo de eleitor;</li>
			<li>Curriculum Vitae.</li>
		</ul>
	</li>
</ol>
 
 
ENDERE�O DE ENVIO: <br />
UNIVERSIDADE TECNOL�GICA FEDERAL DO PARAN� <br />
DIRETORIA DE PESQUISA E P�S-GRADUA��O <br />
Av. Alberto Carazzai, 1640, Centro <br />
86300 000 Corn�lio Proc�pio - PR <br /><br />";

$msg .= "</div>";


$msg .= "<input name=\"voltar\" type=\"button\" value=\"Voltar\" class=\"button\" onClick=\"javascript:location.href='http://www.utfpr.edu.br/cornelioprocopio'\" /><br /><br />";

$msg .= "<input name=\"imprimir\" type=\"button\" value=\"Imprimir\" class=\"button\" onClick=\"javascript:window.print()\" /><br /><br />";


$msg .= "</div>";

$content = $msg;

$title   = "Inscri��o efetuada com sucesso";

if($existePessoa){
	echo "<script language=javascript>alert('O �tem j� est� cadastrado em nosso banco de dados.');javascript:history.go(-1);</script>";
	exit();
}

/* incluindo conteudo na p�gina interna */
$instrucoes = $infos;
include('inside-include-public.php');
?>