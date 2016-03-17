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

$continuar = false;

switch($op){
	case 'usuario':
		$prefix = "O";
		$titulo = "Usuário";
		$continuar = true;

		$nivel     = $_POST['nivel'];
		$nome      = $_POST['nome'];
		$login     = $_POST['login'];
		$senha     = $_POST['senha'];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$lastId = $objRec->max_r();
		
		$objRec->setId        ($lastId);
		$objRec->setIdnivel   ($nivel);
		$objRec->setNome      ($nome);
		$objRec->setLogin     ($login);
		$objRec->setSenha     ($senha);
		$objRec->setSituacao  ('TRUE');
		$objRec->setDatabaixa ('NULL');
		
		if($acao == "adicionar"){
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
		
		$lastId = $objRec->max_r();
		
		$objRec->setId        ($lastId);
		$objRec->setDescricao ($descricao);
		$objRec->setSituacao  ('TRUE');
		$objRec->setDatabaixa ('NULL');
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'banco' :
		$prefix = "O";
		$titulo = "Banco";
		$continuar = true;
		
		$descricao = $_POST["descricao"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$lastId = $objRec->max_r();
		
		$objRec->setId        ($lastId);
		$objRec->setDescricao ($descricao);
		$objRec->setSituacao  ('TRUE');
		$objRec->setDatabaixa ('NULL');
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'tipodocumento' :
		$prefix = "O";
		$titulo = "Tipo de documento";
		$continuar = true;
		
		$descricao = $_POST["descricao"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$lastId = $objRec->max_r();
		
		$objRec->setId        ($lastId);
		$objRec->setDescricao ($descricao);
		$objRec->setSituacao  ('TRUE');
		$objRec->setDatabaixa ('NULL');
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;

	case 'periodicidade' :
		$prefix = "A";
		$titulo = "Periodicidade";
		$continuar = true;
		
		$descricao   = $_POST["descricao"];
		$qtdnumerico = $_POST["qtdnumerico"];
		$tipoperiodo = $_POST["tipoperiodo"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$lastId = $objRec->max_r();
		
		$objRec->setId          ($lastId);
		$objRec->setDescricao   ($descricao);
		$objRec->setQtdnumerico ($qtdnumerico);
		$objRec->setTipoperiodo ($tipoperiodo);
		$objRec->setSituacao    ('TRUE');
		$objRec->setDatabaixa   ('NULL');
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'pessoafisica' :
		$prefix       = "A";
		$titulo       = "Pessoa física";
		$continuar    = true;
		$existePessoa = false;
		
		$cpf       = $_POST["cpf"];
		$rg        = $_POST["rg"];
		$nome      = $_POST["nome"];
		$sobrenome = $_POST["sobrenome"];
		
		$endereco     = $_POST["endereco"];
		$bairro       = $_POST["bairro"];
		$cidade       = $_POST["cidade"];
		$uf           = $_POST["uf"];
		$cep          = $_POST["cep"];
		$fone         = $_POST["fone"];
		$fax          = $_POST["fax"];
		$site         = $_POST["site"];
		$obs          = $_POST["obs"];
		$compraminima = 0;
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		if(!$objRec->exists($nome, $sobrenome) && $acao == "adicionar"){
		
			$objRecPessoa = $controlador['pessoa'];
			$objRecPessoa->__toFillGeneric();
			
			$lastId       = $objRec->max_r();
			$lastIdPessoa = $objRecPessoa->max_r();
			
			if($acao != "adicionar"){		
				/* recuperando id da pessoa física */
				$objRecPessoa->__get_db($id);
				$idPessoaFisica = $objRecPessoa->getIdpessoafisica();
			}
			
			$objRec->setId        ($lastId);
			$objRec->setCpf       ($cpf);
			$objRec->setRg        ($rg);
			$objRec->setNome      ($nome);
			$objRec->setSobrenome ($sobrenome);
			
			$objRecPessoa->setId               ($lastIdPessoa);
			$objRecPessoa->setIdpessoajuridica ('NULL');
			$objRecPessoa->setIdpessoafisica   ($lastId);
			$objRecPessoa->setEndereco         ($endereco);
			$objRecPessoa->setBairro           ($bairro);
			$objRecPessoa->setCidade           ($cidade);
			$objRecPessoa->setUf               ($uf);
			$objRecPessoa->setCep              ($cep);
			$objRecPessoa->setFone             ($fone);
			$objRecPessoa->setFax              ($fax);
			$objRecPessoa->setSite             ($site);
			$objRecPessoa->setObs              ($obs);
			$objRecPessoa->setCompraminima     ($compraminima);
			$objRecPessoa->setSituacao         ('TRUE');
			$objRecPessoa->setDatabaixa        ('NULL');
			
			if($acao == "adicionar"){
				$objRec->save();
				$objRecPessoa->save();
			}
			else{
				$continuar = false;
				
				$objRecPessoa->setId($id);
				$objRecPessoa->setIdpessoafisica($idPessoaFisica);
				$objRec->setId($idPessoaFisica);
				$objRecPessoa->update();
				$objRec->update();
			}
		}
		else{
			$existePessoa = true;
		}
	break;
	
	case 'pessoajuridica' :
		$prefix = "A";
		$titulo = "Pessoa jurídica";
		$continuar = true;
		
		$cnpj               = $_POST["cnpj"];
		$inscricaoestadual  = $_POST["inscricaoestadual"];
		$inscricaomunicipal = $_POST["inscricaomunicipal"];
		$razaosocial        = $_POST["razaosocial"];
		$nomefantasia       = $_POST["nomefantasia"];
		
		$endereco     = $_POST["endereco"];
		$bairro       = $_POST["bairro"];
		$cidade       = $_POST["cidade"];
		$uf           = $_POST["uf"];
		$cep          = $_POST["cep"];
		$fone         = $_POST["fone"];
		$fax          = $_POST["fax"];
		$site         = $_POST["site"];
		$obs          = $_POST["obs"];
		$compraminima = trocaVirgula($_POST["compramin"]);
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		if(!$objRec->exists($razaosocial, $nomefantasia) && $acao == "adicionar"){
		
			$objRecPessoa = $controlador['pessoa'];
			$objRecPessoa->__toFillGeneric();
			
			$lastId       = $objRec->max_r();
			$lastIdPessoa = $objRecPessoa->max_r();
			
			if($acao != "adicionar"){		
				/* recuperando id da pessoa física */
				$objRecPessoa->__get_db($id);
				$idPessoaJuridica = $objRecPessoa->getIdpessoajuridica();
			}
			
			$objRec->setId                 ($lastId);
			$objRec->setCnpj               ($cnpj);
			$objRec->setInscricaoestadual  ($inscricaoestadual);
			$objRec->setInscricaomunicipal ($inscricaomunicipal);
			$objRec->setRazaosocial        ($razaosocial);
			$objRec->setNomefantasia       ($nomefantasia);
			
			$objRecPessoa->setId               ($lastIdPessoa);
			$objRecPessoa->setIdpessoajuridica ($lastId);
			$objRecPessoa->setIdpessoafisica   ('NULL');
			$objRecPessoa->setEndereco         ($endereco);
			$objRecPessoa->setBairro           ($bairro);
			$objRecPessoa->setCidade           ($cidade);
			$objRecPessoa->setUf               ($uf);
			$objRecPessoa->setCep              ($cep);
			$objRecPessoa->setFone             ($fone);
			$objRecPessoa->setFax              ($fax);
			$objRecPessoa->setSite             ($site);
			$objRecPessoa->setObs              ($obs);
			$objRecPessoa->setCompraminima     ($compraminima);
			$objRecPessoa->setSituacao         ('TRUE');
			$objRecPessoa->setDatabaixa        ('NULL');
			
			if($acao == "adicionar"){
				$objRec->save();
				$objRecPessoa->save();
			}
			else{
				$continuar = false;
				
				$objRecPessoa->setId($id);
				$objRecPessoa->setIdpessoajuridica($idPessoaJuridica);
				$objRec->setId($idPessoaJuridica);
				$objRecPessoa->update();
				$objRec->update();
			}
		}
		else{
			$existePessoa = true;
		}
	break;
	
	case 'contato' :
		$prefix = "O";
		$titulo = "Contato";
		$continuar = true;
		
		$pessoa       = $_POST["pessoa"];
		$nome         = $_POST["nome"];
		$email        = $_POST["email"];
		$msn          = $_POST["msn"];
		$skype        = $_POST["skype"];
		$fone         = $_POST["fone"];
		$fax          = $_POST["fax"];
		$celular      = $_POST["celular"];
		$ramal        = $_POST["ramal"];
		$departamento = $_POST["departamento"];
		
		if($pessoa == 'pessoa_juridica'){
			$idPessoa = $_POST["comboPessoaJuridica"];
		}
		else{
			$idPessoa = $_POST["comboPessoaFisica"];
		}
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$lastId = $objRec->max_r();
		
		$objRec->setId           ($lastId);
		$objRec->setIdpessoa     ($idPessoa);
		$objRec->setNome         ($nome);
		$objRec->setEmail        ($email);
		$objRec->setMsn          ($msn);
		$objRec->setSkype        ($skype);
		$objRec->setFone         ($fone);
		$objRec->setFax          ($fax);
		$objRec->setCelular      ($celular);
		$objRec->setRamal        ($ramal);
		$objRec->setDepartamento ($departamento);
		$objRec->setSituacao     ('TRUE');
		$objRec->setDatabaixa    ('NULL');
		
		if($acao == "adicionar"){
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
	break;
	
	case 'conta' :
		$prefix = "A";
		$titulo = "Conta";
		$continuar = true;
		
		$documento      = $_POST["documento"];
		$descricao      = $_POST["descricao"];
		$numeroparcelas = $_POST["numeroparcelas"];
		$valortotal     = trocaVirgula($_POST["valortotal"]);
		$tipoconta      = $_POST["tipoconta"];
		$tipoconta      = 'credito';
		$pessoa         = $_POST["pessoa"];
		
		/* combos */
		$comboPessoaFisica   = $_POST["comboPessoaFisica"];
		$comboPessoaJuridica = $_POST["comboPessoaJuridica"];
		$comboTipodocumento  = $_POST["comboTipodocumento"];
		$comboPeriodicidade  = $_POST["comboPeriodicidade"];
		$comboBanco          = $_POST["comboBanco"];
		
		if($pessoa == 'pessoa_juridica'){
			$idPessoa = $comboPessoaJuridica;
		}
		else{
			$idPessoa = $comboPessoaFisica;
		}
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		
		$lastId = $objRec->max_r();
				
		$session = $controlador['session'];
		$idUsuario = $session->retornaSession('sessId', false);
		
		$objRec->setId              ($lastId);
		$objRec->setIdusuario       ($idUsuario);
		$objRec->setIdusuariobaixa  ('NULL');
		$objRec->setIdtipodocumento ($comboTipodocumento);
		$objRec->setIdperiodicidade ($comboPeriodicidade);
		$objRec->setIdbanco         ($comboBanco);
		$objRec->setIdpessoa        ($idPessoa);
		$objRec->setDocumento       ($documento);
		$objRec->setDatacadastro    ('NOW()');
		$objRec->setDescricao       ($descricao);
		$objRec->setNumparcelas     ($numeroparcelas);
		$objRec->setValortotal      ($valortotal);
		$objRec->setTipoconta       ($tipoconta);
		$objRec->setSituacao        ('TRUE');
		$objRec->setDatabaixa       ('NULL');
		
		if($acao == "adicionar"){
			$id = $lastId;
			$objRec->save();
		}
		else{
			$continuar = false;
			$objRec->setId($id);
			$objRec->update();
		}
		
		$gerar  = $_GET['gerar'];
		
		if($gerar == 'sim'){
		
			$objParRec = $controlador['parcela'];
			$objParRec->__toFillGeneric();
			
			/* apagando as parcelas caso atualização */
			if($acao == "atualizar"){
				$objParRec->deleteParcelas($id);
			}
			
			/* cadastrando as parcelas */			
			for($i=0; $i<$numeroparcelas; $i++){
			
				$dataparcela  = converteData($_POST["data_parcela_$i"]);
				$valorparcela = trocaVirgula($_POST["valor_parcela_$i"]);			
			
				$lastIdPar = $objParRec->max_r();
			
				$objParRec->setId             ($lastIdPar);
				$objParRec->setIdconta        ($id);
				$objParRec->setValor          ($valorparcela);
				$objParRec->setDatavencimento ($dataparcela);
				$objParRec->setDatapagamento  ('NULL');
				$objParRec->setSituacao       ('TRUE');
				$objParRec->setDatabaixa      ('NULL');
				
				$objParRec->save();
			}
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
include("../php/includeInterna.php");	
?>