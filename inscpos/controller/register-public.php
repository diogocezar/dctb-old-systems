<?php
include("start-brain.php");

$op = $_GET['tipo'];
$existePessoa = false;

$arrayNoToUp = array("email_adm", "senha_adm");

/* transformando todos os campos enviados em letras maiúsculas
foreach($_POST as $indice => $valor){
	if(!in_array($indice, $arrayNoToUp)){
		$_POST[$indice] = uc_latin1($_POST[$indice]);
	}
}
*/

switch($op){
	case 'inscricao':
		$prefix = "A";
		$titulo = "Inscrição";
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
		
		/* Confirmação de informações */
		$infos .= "Informações Cadastradas: <br />";
		$infos .= "<ul>";
			$infos .= "<li>Data / Hora : $data</li>";
			$infos .= "<li>Curso : $nomeCurso</li>";
			$infos .= "<li>Nome : $nomeINS</li>";
			$infos .= "<li>Data de nascimento : ".$_POST['data_nascimento_ins']."</li>";
			$infos .= "<li>Curso Graduação : $curso_gradINS</li>";
			$infos .= "<li>Profissão : $profissaoINS</li>";
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
			$infos .= "<br /><br />Não foi possível encontrar um coordenador para enviar sua inscrição. Por favor entre em contato com a gerência da pós-graduação pelo e-mail: $origem.<br /><br />";	
		}

	break;
}

/* informações de inserção/atualização */

$titulo = strtolower($titulo);

$msg .= "<div align=\"center\">";

$msg .= "<div align=\"justify\">";

$msg .= 

"Obrigado por escolher a UTFPR! <br /><br />
 
Seu cadastro foi recebido e registrado em nosso sistema. <br />
 
O período para fazer a inscrição é: $periodoInscricao. <br /><br />
 
Procedimento para fazer a inscrição via Correios: <br /><br />

<ol>	 
	<li>	
		Fazer o pagamento da taxa de inscrição por meio de depósito bancário: <br /><br />
		
		<ul>
			<li>FUNTEF-PR (Fundação de Apoio à Educação, Pesquisa e Desenvolvimento Científico e Tecnológico da Universidade Tecnológica Federal do Paraná)</li>
			<li>CAIXA ECONÔMICA FEDERAL</li>
			<li>AGÊNCIA: 0388</li>
			<li>CONTA CORRENTE: 1405-8</li>
			<li>OPERAÇÃO: 03<br /><br /></li>
		</ul>
	</li>
	 
	<li>		
		Enviar para a UTFPR: <br /><br />
		<ul>
			<li>Ficha de inscrição preenchida;</li>
			<li>Comprovante de pagamento da taxa de inscrição;</li>
			<li>01 foto 3x4</li>
			<li>Cópia do diploma ou certificado do curso de graduação;</li>
			<li>Cópia do histórico escolar do curso de graduação;</li>
			<li>Cópia do RG e CPF</li>
			<li>Cópia da certidão de nascimento ou casamento;</li>
			<li>Cópia do título de eleitor;</li>
			<li>Curriculum Vitae.</li>
		</ul>
	</li>
</ol>
 
 
ENDEREÇO DE ENVIO: <br />
UNIVERSIDADE TECNOLÓGICA FEDERAL DO PARANÁ <br />
DIRETORIA DE PESQUISA E PÓS-GRADUAÇÃO <br />
Av. Alberto Carazzai, 1640, Centro <br />
86300 000 Cornélio Procópio - PR <br /><br />";

$msg .= "</div>";


$msg .= "<input name=\"voltar\" type=\"button\" value=\"Voltar\" class=\"button\" onClick=\"javascript:location.href='http://www.utfpr.edu.br/cornelioprocopio'\" /><br /><br />";

$msg .= "<input name=\"imprimir\" type=\"button\" value=\"Imprimir\" class=\"button\" onClick=\"javascript:window.print()\" /><br /><br />";


$msg .= "</div>";

$content = $msg;

$title   = "Inscrição efetuada com sucesso";

if($existePessoa){
	echo "<script language=javascript>alert('O ítem já está cadastrado em nosso banco de dados.');javascript:history.go(-1);</script>";
	exit();
}

/* incluindo conteudo na página interna */
$instrucoes = $infos;
include('inside-include-public.php');
?>