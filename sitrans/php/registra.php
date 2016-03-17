<?php
/**
* Verificando a opção para cadastro direto do cliente
*/
$opCliente = $_GET['tcliente'];

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

if(empty($opCliente)){
	/**
	* incluindo controle de nível
	*/
	include("../php/controlaNivel.php");
}

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
		
		/* verificando a existência do usuario */
		$verifica = false;
		if($acao == "adicionar"){
			$verifica = true;
		}
		else{
			if($acao == "atualizar"){
				$objRec->__get_db($id);
				if($nome != $objRec->getNome() && $loginUsuario != $objRec->getLogin){
					$verifica = true;
				}
			}
		}
		if($verifica){
			if($objRec->exists($nome, $loginUsuario)){
				$existeUsuario = true;
				break;
			}
		}
		/* fim */
		
		$objRec->setIdnivel      ($nivel);
		$objRec->setNome         ($nome);
		$objRec->setLogin        ($loginUsuario);
		$objRec->setSenha        ($senhaUsuario);
		$objRec->setDatabaixa    ('NULL');
		$objRec->setSituacao     ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
		
	case 'nivel' :
		$prefix = "O";
		$titulo = "Nível";
		$continuar = true;
		
		$descricao = $_POST["descricao"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'fornecedor' :
		$prefix       = "O";
		$titulo       = "Fornecedor";
		$continuar    = true;
		$existePessoa = false;
		
		$inscestadual = $_POST["inscestadual"];
		$cnpj         = $_POST["cnpj"];
		$razaosocial  = $_POST["razaosocial"];		
		$nomefantasia = $_POST["nomefantasia"];
		
		settype($inscestadual, "string");
		settype($cnpj, "string");

		
		$rua          = $_POST["rua"];
		$numero       = $_POST["numero"];
		$complemento  = $_POST["complemento"];
		$bairro       = $_POST["bairro"];
		$cep          = $_POST["cep"];
		$cidade       = $_POST["cidade"];
		$estado       = $_POST["estado"];
		$telefone     = $_POST["telefone"];
		$fax          = $_POST["fax"];
		$email        = $_POST["email"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)){
			$objRec->__get_db($id);
		}
		
		$objRecPessoa = $controlador['pessoa'];
		$objRecPessoa->__toFillGeneric();
		
		if($acao == "atualizar"){
			$idPessoa = $objRec->getIdpessoa();
			$objRecPessoa->__get_db($idPessoa);
		}
		
		/* verificando a existência do fornecedor */
		$verifica = false;
		if($acao == "adicionar"){
			$verifica = true;
		}
		else{
			if($nomefantasia != $objRec->getNomefantasia()){
				$verifica = true;
			}
		}
		if($verifica){
			if($objRec->exists($nome)){
				$existePessoa = true;
				break;
			}
		}
		/* fim */
				
		/* dados do fornecedor */
		$objRec->setInscestadual ($inscestadual);
		$objRec->setCnpj         ($cnpj);
		$objRec->setRazaosocial  ($razaosocial);
		$objRec->setNomefantasia ($nomefantasia);
		$objRec->setDatabaixa    ('NULL');
		$objRec->setSituacao     ('TRUE');
		
		/* dados da pessoa */
		$objRecPessoa->setRua          ($rua);
		$objRecPessoa->setNumero       ($numero);
		$objRecPessoa->setComplemento  ($complemento);
		$objRecPessoa->setBairro       ($bairro);
		$objRecPessoa->setCep          ($cep);
		$objRecPessoa->setCidade       ($cidade);
		$objRecPessoa->setEstado       ($estado);
		$objRecPessoa->setTelefone     ($telefone);
		$objRecPessoa->setFax          ($fax);
		$objRecPessoa->setEmail        ($email);
		
		if($acao == "adicionar"){
			$objRecPessoa->startTransaction();			
				$objRecPessoa->save();
				$lastIdPessoa = $objRecPessoa->max_r();
			
				$objRec->setDatacadastro('NOW()');
				$objRec->setIdpessoa($lastIdPessoa);
				$objRec->save();
			$objRec->commitTransaction();			
		}
		else{
			$continuar = false;	
					
			$objRec->setId       ($id);
			$objRec->setIdpessoa ($idPessoa);
			$objRecPessoa->setId ($idPessoa);
				
			$objRecPessoa->startTransaction();							
				$objRecPessoa->update();
			
				$objRec->update();
			$objRec->commitTransaction();	
		}
	break;
	
	case 'cliente' :
		$prefix       = "O";
		$titulo       = "Cliente";
		$continuar    = true;
		$existePessoa = false;
		
		$frequenciacoleta = $_POST["frequenciacoleta"];
		$nome             = $_POST["nome"];
		$cnpjcpf          = $_POST["cnpjcpf"];		
		$inscestadualrg   = $_POST["inscestadualrg"];
		
		settype($inscestadualrg, "string");
		settype($cnpjcpf, "string");
		
		$rua              = $_POST["rua"];
		$numero           = $_POST["numero"];
		$complemento      = $_POST["complemento"];
		$bairro           = $_POST["bairro"];
		$cep              = $_POST["cep"];
		$cidade           = $_POST["cidade"];
		$estado           = $_POST["estado"];
		$telefone         = $_POST["telefone"];
		$fax              = $_POST["fax"];
		$email            = $_POST["email"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)){
			$objRec->__get_db($id);
		}
		
		$objRecPessoa = $controlador['pessoa'];
		$objRecPessoa->__toFillGeneric();
		
		if($acao == "atualizar"){
			$idPessoa = $objRec->getIdpessoa();
			$objRecPessoa->__get_db($idPessoa);
		}
		
		/* verificando a existência do cliente */
		$verifica = false;
		if($acao == "adicionar"){
			$verifica = true;
		}
		else{
			if($nome != $objRec->getNome()){
				$verifica = true;
			}
		}
		if($verifica){
			if($objRec->exists($nome)){
				$existePessoa = true;
				break;
			}
		}
		/* fim */
		
		/* dados do cliente */
		$objRec->setIdfrequenciacoleta ($frequenciacoleta);
		$objRec->setNome               ($nome);
		$objRec->setCnpjcpf            ($cnpjcpf);
		$objRec->setInscestadualrg     ($inscestadualrg);
		$objRec->setDatabaixa          ('NULL');
		$objRec->setSituacao           ('TRUE');
		
		/* dados da pessoa */		
		$objRecPessoa->setRua          ($rua);
		$objRecPessoa->setNumero       ($numero);
		$objRecPessoa->setComplemento  ($complemento);
		$objRecPessoa->setBairro       ($bairro);
		$objRecPessoa->setCep          ($cep);
		$objRecPessoa->setCidade       ($cidade);
		$objRecPessoa->setEstado       ($estado);
		$objRecPessoa->setTelefone     ($telefone);
		$objRecPessoa->setFax          ($fax);
		$objRecPessoa->setEmail        ($email);
		
		if($acao == "adicionar"){		
			$objRecPessoa->startTransaction();			
				$objRecPessoa->save();
				$lastIdPessoa = $objRecPessoa->max_r();
			
				$objRec->setDatacadastro('NOW()');
				$objRec->setIdpessoa($lastIdPessoa);
				$objRec->save();
			$objRec->commitTransaction();
		}
		else{
			$continuar = false;		
				
			$objRec->setId       ($id);
			$objRec->setIdpessoa ($idPessoa);
			$objRecPessoa->setId ($idPessoa);
				
			$objRecPessoa->startTransaction();							
				$objRecPessoa->update();
				$objRec->update();
			$objRec->commitTransaction();	
		}
	break;
	
	case 'frequenciacoleta' :
		$prefix = "A";
		$titulo = "Freqüencia de Coleta";
		$continuar = true;
		
		$descricao  = $_POST["descricao"];
		$qtdadedias = $_POST["qtdadedias"]; 
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setDescricao    ($descricao);
		$objRec->setQtdadedias   ($qtdadedias);
		$objRec->setDatabaixa    ('NULL');
		$objRec->setSituacao     ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'agregado' :
		$prefix       = "O";
		$titulo       = "Agregado";
		$continuar    = true;
		$existePessoa = false;
		
		$nome             = $_POST["nome"];
		$cnpjcpf          = $_POST["cnpjcpf"];		
		$inscestadualrg   = $_POST["inscestadualrg"];
		
		settype($inscestadualrg, "string");
		settype($cnpjcpf, "string");
		
		$rua              = $_POST["rua"];
		$numero           = $_POST["numero"];
		$complemento      = $_POST["complemento"];
		$bairro           = $_POST["bairro"];
		$cep              = $_POST["cep"];
		$cidade           = $_POST["cidade"];
		$estado           = $_POST["estado"];
		$telefone         = $_POST["telefone"];
		$fax              = $_POST["fax"];
		$email            = $_POST["email"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)){
			$objRec->__get_db($id);
		}
		
		$objRecPessoa = $controlador['pessoa'];
		$objRecPessoa->__toFillGeneric();
		
		if($acao == "atualizar"){
			$idPessoa = $objRec->getIdpessoa();
			$objRecPessoa->__get_db($idPessoa);
		}
		
		/* verificando a existência do cliente */
		$verifica = false;
		if($acao == "adicionar"){
			$verifica = true;
		}
		else{
			if($nome != $objRec->getNome()){
				$verifica = true;
			}
		}
		if($verifica){
			if($objRec->exists($nome)){
				$existePessoa = true;
				break;
			}
		}
		/* fim */
		
		/* dados do agredado */		
		$objRec->setIdfrequenciacoleta ($frequenciacoleta);
		$objRec->setNome               ($nome);
		$objRec->setCnpjcpf            ($cnpjcpf);
		$objRec->setInscestadualrg     ($inscestadualrg);
		$objRec->setDatabaixa          ('NULL');
		$objRec->setSituacao           ('TRUE');
		
		/*  dados da pessoa */		
		$objRecPessoa->setRua          ($rua);
		$objRecPessoa->setNumero       ($numero);
		$objRecPessoa->setComplemento  ($complemento);
		$objRecPessoa->setBairro       ($bairro);
		$objRecPessoa->setCep          ($cep);
		$objRecPessoa->setCidade       ($cidade);
		$objRecPessoa->setEstado       ($estado);
		$objRecPessoa->setTelefone     ($telefone);
		$objRecPessoa->setFax          ($fax);
		$objRecPessoa->setEmail        ($email);
		
		if($acao == "adicionar"){
			$objRecPessoa->startTransaction();			
				$objRecPessoa->save();
				$lastIdPessoa = $objRecPessoa->max_r();
			
				$objRec->setDatacadastro('NOW()');
				$objRec->setIdpessoa($lastIdPessoa);
				$objRec->save();
			$objRec->commitTransaction();
		}
		else{
			$continuar = false;		
				
			$objRec->setId       ($id);
			$objRec->setIdpessoa ($idPessoa);
			$objRecPessoa->setId ($idPessoa);
				
			$objRecPessoa->startTransaction();							
				$objRecPessoa->update();
			
				$objRec->update();
			$objRec->commitTransaction();	
		}
	break;

	case 'categoria' :
		$prefix = "A";
		$titulo = "Categoria";
		$continuar = true;
		
		$descricao = $_POST["descricao"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'veiculo' :
		$prefix = "O";
		$titulo = "Veículo";
		$continuar = true;
		
		$categoria = $_POST["categoria"];
		$agregado  = $_POST["agregado"];
		$placa     = $_POST["placa"];
		$marca     = $_POST["marca"];
		$modelo    = $_POST["modelo"];
		$prefixo   = $_POST["prefixo"];
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setIdcategoria ($categoria);
		$objRec->setIdagregado  ($agregado);
		$objRec->setPlaca       ($placa);
		$objRec->setMarca       ($marca);
		$objRec->setModelo      ($modelo);
		$objRec->setPrefixo     ($prefixo);
		$objRec->setDescricao   ($descricao);
		$objRec->setDatabaixa   ('NULL');
		$objRec->setSituacao    ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'contato' :
		$prefix = "O";
		$titulo = "Contato";
		$continuar = true;
		
		$pessoa   = $_POST["pessoa"];
		$nome     = $_POST["nome"];
		$funcao   = $_POST["funcao"];
		$telefone = $_POST["telefone"];
		$celular  = $_POST["celular"];
		$ramal    = $_POST["ramal"];
		$email    = $_POST["email"];
		$loginCliente = $_POST["login_cliente"];
		$senhaCliente = $_POST["senha_cliente"];
		
		switch($pessoa){
			case 'pessoa_fornecedor':
				$idPessoa = $_POST["fornecedor"];
			break;
			
			case 'pessoa_cliente':
				$idPessoa = $_POST["cliente"];
			break;
			
			case 'pessoa_agregado':
				$idPessoa = $_POST["agregado"];
			break;
		}
				
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		if($pessoa == 'pessoa_cliente'){
			if(empty($loginCliente)){
				if(empty($id)){
					$id = $objRec->max_r('max');
				}
				$expNome = explode(' ',$nome);
				$loginCliente = $expNome[0].$id;
			} 
			if(empty($senhaCliente)){
				echo $senhaCliente;
				$senhaCliente = strtoupper("".substr(md5(date('i:s')), 0, 6));
			}
		}
		
		$objRec->setIdpessoa     ($idPessoa);
		$objRec->setNome         ($nome);
		$objRec->setFuncao       ($funcao);
		$objRec->setTelefone     ($telefone);
		$objRec->setCelular      ($celular);
		$objRec->setRamal        ($ramal);
		$objRec->setEmail        ($email);
		$objRec->setDatabaixa    ('NULL');
		$objRec->setSituacao     ('TRUE');
		$objRec->setLogin        ($loginCliente);
		$objRec->setSenha        ($senhaCliente);
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'status' :
		$prefix = "O";
		$titulo = "Status";
		$continuar = true;
		
		$descricao = $_POST["descricao"];

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'motivo' :
		$prefix = "O";
		$titulo = "Motivo";
		$continuar = true;
		
		$idColeta = $_GET['idcoleta'];
		$idStatus = $_GET['idstatus'];
		$versao   = $_GET['versao'];
		
		if(empty($idColeta) || empty($idStatus) || empty($versao)){
			echo "<script language=javascript>alert('Faltam dados para inserir um motivo corretamente.');location.href='index.php'</script>";
			exit();
		}
		
		$descricao = $_POST["descricao"];

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
		
		/* Salvando a coleta */
				
		$idMotivo = $objRec->max_r();
		$objColeta = $controlador['coleta'];
		$objColeta->__toFillGeneric();
		if(!empty($idColeta)) $objColeta->__get_db($idColeta);
		$versao     = $objColeta->getVersao();
		$novaVersao = $versao+1;
		$objColeta->setVersao($novaVersao);
		$objColeta->setDatabaixa('NOW()');
		$objColeta->setIdmotivo($idMotivo);
		$objColeta->setIdstatus(3);
		$objColeta->setIdusuariobaixa($_SESSION['sessId']);
		$objColeta->startTransaction();
			$objColeta->save();
		$objColeta->commitTransaction();
	break;
	
	case 'restricao' :
		$prefix = "A";
		$titulo = "Restrição";
		$continuar = true;
		
		$descricao = $_POST["descricao"];

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'embalagem' :
		$prefix = "A";
		$titulo = "Embalagem";
		$continuar = true;
		
		$descricao = $_POST["descricao"];

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'coleta' :
		$prefix       = "A";
		$titulo       = "Coleta";
		$continuar    = true;
		$mostraCodigo = true;
		$versao       = $_GET['versao'];
		
		/* inputs */
		$qtdadeNotaFiscal = $_POST["qtdadeNotaFiscal"];
		$qtdadeVolumes    = $_POST["qtdadeVolumes"];
		$data             = converteData($_POST["data"]);
		$hora             = $_POST["hora"];
		$peso             = str_replace(',','.',$_POST["peso"]);
		$obsColeta        = $_POST["obsColeta"];		

		/* combos*/
		$cliente    = $_POST["cliente"];
		/* se cliente vazio e op cliente, recebe a sessão */
		if(empty($cliente) && !empty($opCliente)){ $cliente = $_SESSION['sessIdEmpresa']; }
		$contato    = $_POST["contato"];
		/* se contato vazio e op cliente, recebe a sessão */
		if(empty($contato) && !empty($opCliente)){ $contato = $_SESSION['sessIdContato']; }
		$veiculo    = $_POST["veiculo"];
		$fornecedor = $_POST["fornecedor"];
		$status     = $_POST["status"];
		/* se cliente status recebe 1 cadastrado */
		if(empty($status) && !empty($opCliente)){ $status = 1; }
		$embalagem  = $_POST["embalagem"];
		$restricao  = $_POST["restricao"];
		
		/* se for atendente, preenche status como CADASTRADO */
		if(!$nivel['permissao']['veiculo']){
			$status  = 1; // código para status cadastrado
		}
		$session = $controlador['session'];		
		$idusuario  = $session->retornaSession('sessId');

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_dbColeta($id, $versao);
		$objRec->startTransaction();
		$lastId = $objRec->max_r('max');
		
		$codigo = $lastId;
		$codigo = "C".$codigo;
				
		$objRec->setIdcliente        ($cliente);
		$objRec->setIdcontato        ($contato);
		$objRec->setIdveiculo        ($veiculo);
		$objRec->setIdfornecedor     ($fornecedor);
		$objRec->setIdusuario        ($idusuario);
		$objRec->setIdusuariobaixa   ('NULL');
		$objRec->setIdstatus         ($status);
		$objRec->setIdmotivo         ('NULL');
		$objRec->setIdembalagem      ($embalagem);
		$objRec->setIdrestricao      ($restricao);
		$objRec->setQtdadenotafiscal ($qtdadeNotaFiscal);
		$objRec->setQtdadevolumes    ($qtdadeVolumes);
		$objRec->setData             ($data);
		$objRec->setHora             ($hora);
		$objRec->setPeso             ($peso);
		$objRec->setObscoleta        ($obsColeta);
		$objRec->setDatabaixa        ('NULL');
		$objRec->setSituacao         ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setVersao(1);
			$objRec->setCodigo($codigo);
			$objRec->setDatacadastro('NOW()');
				$objRec->save();
			$objRec->commitTransaction();
		}
		else{
			$continuar = false;
			$continuarAtualizarColeta = true;
			$objRec->setId($id);
			$versao     = $objRec->getVersao();
			$novaVersao = $versao+1;
			$objRec->setVersao($novaVersao);
			$codigo = $objRec->getCodigo();
			$objRec->setDatacadastro('NOW()');
				$objRec->save();
			$objRec->commitTransaction();
		}
	break;
	
	case 'statusmanifesto' :
		$prefix = "O";
		$titulo = "Status do Manifesto";
		$continuar = true;
		
		$descricao = $_POST["descricao"];

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'manifesto':
		$prefix = "O";
		$titulo = "Manifesto";
		$continuar = true;
		
		$fornecedor      = $_POST["fornecedor"];
		$statusManifesto = $_POST["statusmanifesto"];
		$cidade          = $_POST["cidade"];
		$numero          = $_POST["numero"];
		$horaChegada     = $_POST["horachegada"];
		$totalCTRC       = $_POST["totalctrc"];
		$totalVolumes    = $_POST["totalvolumes"];
		$totalPeso       = trocaVirgula($_POST["totalpeso"]);
		$valorTotalNF    = trocaVirgula($_POST["valortotalnf"]);
		$valorTotalFrete = trocaVirgula($_POST["valortotalfrete"]);
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		$objRec->startTransaction();
		$lastId = $objRec->max_r('max');
		
		$codigo = $lastId;
		$codigo = "M".$codigo;
		
		$objRec->setIdfornecedor      ($fornecedor);
		$objRec->setIdstatusmanifesto ($statusManifesto);
		$objRec->setCidade            ($cidade);
		$objRec->setNumero            ($numero);
		$objRec->setHorariochegada    ($horaChegada);
		$objRec->setTotalctrc         ($totalCTRC);
		$objRec->setTotalvolumes      ($totalVolumes);
		$objRec->setTotalpeso         ($totalPeso);
		$objRec->setValortotalnf      ($valorTotalNF);
		$objRec->setValortotalfrete   ($valorTotalFrete);
		$objRec->setDatabaixa         ('NULL');
		$objRec->setSituacao          ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
			$objRec->setCodigo      ($codigo);
				$objRec->save();
			$objRec->commitTransaction();
			$_SESSION['sessManifesto'] = $lastId;
			$cadastrarConhecimentos = true;
			$mostraCodigo = true;
		}
		else{
			$continuar = false;
			$objRec->setId($id);
				$objRec->update();
			$objRec->commitTransaction();	
		}
	break;
	
	case 'conhecimento':
		$prefix = "O";
		$titulo = "Conhecimento";
		$continuar = true;
		
		if(!empty($_POST["statusconhecimento"])){
			$statusconhecimento  = $_POST["statusconhecimento"];
		}
		else{
			$statusconhecimento  = 1; // em aberto
		}
		
		$manifesto           = $_POST["manifesto"];
		$numero              = $_POST["numero"];
		$dataemissao         = converteData($_POST["dataemissao"]);
		
		$clienteremetente    = $_POST["cnpf_remetente"];
		$clientedestinatario = $_POST["cnpf_destinatario"];
		
		$peso                = trocaVirgula($_POST['peso']);
		$volumes             = $_POST['volumes'];
		$valornotafiscal     = trocaVirgula($_POST['valornotafiscal']);
		$valorfrete          = trocaVirgula($_POST['valorfrete']);
		
		settype($clienteremetente, "string");
		settype($clientedestinatario, "string");
		settype($numero, "string");
		
		/* Verificando se os clientes existem e cadastrando em caso negativo */
		
		$clienteRemetente    = $controlador['cliente'];
		$clienteDestinatario = $controlador['cliente'];
		
		$clienteRemetente->__toFillGeneric();
		$clienteDestinatario->__toFillGeneric();
		
		if($clienteRemetente->existsByCnpf($clienteremetente)){
			$idClienteRemetente = $clienteRemetente->returnIdByCnpf($clienteremetente); 
		}
		else{
			$objCliente = $controlador['cliente'];
			$objCliente->__toFillGeneric();
			
			$objClientePessoa = $controlador['pessoa'];
			$objClientePessoa->__toFillGeneric();
			
			$nome           = $_POST["nome_remetente"];
			$cnpjcpf        = $_POST["cnpf_remetente"];
			$inscestadualrg = $_POST["inscestadualrg_remetente"];
			
			$rua         = $_POST["rua_remetente"];
			$numero      = $_POST["numero_remetente"];
			$complemento = $_POST["complemento_remetente"];
			$bairro      = $_POST["bairro_remetente"];
			$cep         = $_POST["cep_remetente"];
			$cidade      = $_POST["cidade_remetente"];
			$estado      = $_POST["estado_remetente"];
			$telefone    = $_POST["telefone_remetente"];
			$fax         = $_POST["fax_remetente"];
			$email       = $_POST["email_remetente"];
			
			/* Verificando a existência do cliente */			
			if($objCliente->exists($nome)){
				$existePessoa = true;
				break;
			}
			
			/* dados do cliente */
			$objCliente->setIdfrequenciacoleta ('NULL');
			$objCliente->setNome               ($nome);
			$objCliente->setCnpjcpf            ($cnpjcpf);
			$objCliente->setInscestadualrg     ($inscestadualrg);
			$objCliente->setDatabaixa          ('NULL');
			$objCliente->setSituacao           ('TRUE');
			
			/* dados da pessoa */		
			$objClientePessoa->setRua          ($rua);
			$objClientePessoa->setNumero       ($numero);
			$objClientePessoa->setComplemento  ($complemento);
			$objClientePessoa->setBairro       ($bairro);
			$objClientePessoa->setCep          ($cep);
			$objClientePessoa->setCidade       ($cidade);
			$objClientePessoa->setEstado       ($estado);
			$objClientePessoa->setTelefone     ($telefone);
			$objClientePessoa->setFax          ($fax);
			$objClientePessoa->setEmail        ($email);
			
			$objCliente->startTransaction();			
				$objClientePessoa->save();
				$lastIdPessoa = $objClientePessoa->max_r();
			
				$objCliente->setDatacadastro('NOW()');
				$objCliente->setIdpessoa($lastIdPessoa);
				$objCliente->save();
				
				$idClienteRemetente = $objCliente->max_r();
			$objCliente->commitTransaction();
		}
		
		if($clienteDestinatario->existsByCnpf($clientedestinatario)){
			$idClienteDestinatario = $clienteDestinatario->returnIdByCnpf($clientedestinatario); 
		}
		else{
			$objCliente = $controlador['cliente'];
			$objCliente->__toFillGeneric();
			
			$objClientePessoa = $controlador['pessoa'];
			$objClientePessoa->__toFillGeneric();
			
			$nome           = $_POST["nome_destinatario"];
			$cnpjcpf        = $_POST["cnpf_destinatario"];
			$inscestadualrg = $_POST["inscestadualrg_destinatario"];
			
			$rua         = $_POST["rua_destinatario"];
			$numero      = $_POST["numero_destinatario"];
			$complemento = $_POST["complemento_destinatario"];
			$bairro      = $_POST["bairro_destinatario"];
			$cep         = $_POST["cep_destinatario"];
			$cidade      = $_POST["cidade_destinatario"];
			$estado      = $_POST["estado_destinatario"];
			$telefone    = $_POST["telefone_destinatario"];
			$fax         = $_POST["fax_destinatario"];
			$email       = $_POST["email_destinatario"];
			
			/* Verificando a existência do cliente */			
			if($objCliente->exists($nome)){
				$existePessoa = true;
				break;
			}
			
			/* dados do cliente */
			$objCliente->setIdfrequenciacoleta ('');
			$objCliente->setNome               ($nome);
			$objCliente->setCnpjcpf            ($cnpjcpf);
			$objCliente->setInscestadualrg     ($inscestadualrg);
			$objCliente->setDatabaixa          ('NULL');
			$objCliente->setSituacao           ('TRUE');
			
			/* dados da pessoa */		
			$objClientePessoa->setRua          ($rua);
			$objClientePessoa->setNumero       ($numero);
			$objClientePessoa->setComplemento  ($complemento);
			$objClientePessoa->setBairro       ($bairro);
			$objClientePessoa->setCep          ($cep);
			$objClientePessoa->setCidade       ($cidade);
			$objClientePessoa->setEstado       ($estado);
			$objClientePessoa->setTelefone     ($telefone);
			$objClientePessoa->setFax          ($fax);
			$objClientePessoa->setEmail        ($email);
			
			$objCliente->startTransaction();			
				$objClientePessoa->save();
				$lastIdPessoa = $objClientePessoa->max_r();
			
				$objCliente->setDatacadastro('NOW()');
				$objCliente->setIdpessoa($lastIdPessoa);
				$objCliente->save();
				
				$idClienteDestinatario = $objCliente->max_r();
			$objCliente->commitTransaction();
		}
		
		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setIdmanifesto           ($manifesto);
		$objRec->setNumero                ($numero);
		$objRec->setDataemissao           ($dataemissao);
		$objRec->setIdstatusconhecimento  ($statusconhecimento);
		$objRec->setIdclienteremetente    ($idClienteRemetente);
		$objRec->setIdclientedestinatario ($idClienteDestinatario);
		$objRec->setPeso                  ($peso);
		$objRec->setVolumes               ($volumes);
		$objRec->setValornotafiscal       ($valornotafiscal);
		$objRec->setValorfrete            ($valorfrete);
		$objRec->setDatabaixa             ('NULL');
		$objRec->setSituacao              ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'statusconhecimento' :
		$prefix = "O";
		$titulo = "Status do Conhecimento";
		$continuar = true;
		
		$descricao = $_POST["descricao"];

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setDescricao ($descricao);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
		}
	break;
	
	case 'saidamanifesto' :
		$prefix = "A";
		$titulo = "Saída de Manifesto";
		$continuar = true;
		
		$veiculo       = $_POST["veiculo"];
		$data          = converteData($_POST["data"]);
		$hora          = $_POST["hora"];
		$conhecimentos = $_POST["conhecimentos"];

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setIdveiculo ($veiculo);
		$objRec->setData      ($data);
		$objRec->setHora      ($hora);
		$objRec->setDatabaixa ('NULL');
		$objRec->setSituacao  ('TRUE');
		
		$objEntrega = $controlador['entregas'];
		$objEntrega->__toFillGeneric();
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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
			
			/* Excluindo conhecimentos antigos */
				$objEntrega->deleteCon($id);
			/* FIM */
		}
		
		/* Salvando conhecimentos */
			if(empty($id)){ $id = $objRec->max_r(); }
			$objEntrega->saveCon($conhecimentos, $id);
		/* FIM */
	break;

	case 'baixaconhecimento' :
		$prefix = "A";
		$titulo = "Baixa de CTRC";
		$continuar = true;
		
		$conhecimento  = $_POST["conhecimento"];
		$nome          = $_POST["nome"];
		$data          = converteData($_POST["data"]);
		$hora          = $_POST["hora"];

		$objRec = $controlador[$op];
		$objRec->__toFillGeneric();
		if(!empty($id)) $objRec->__get_db($id);
		
		$objRec->setIdconhecimento($conhecimento);
		$objRec->setNome          ($nome);
		$objRec->setData          ($data);
		$objRec->setHora          ($hora);
		$objRec->setDatabaixa     ('NULL');
		$objRec->setSituacao      ('TRUE');
		
		/* Alterando status do conhecimento */
		$objConhecimento = $controlador['conhecimento'];
		$objConhecimento->__toFillGeneric();
		$objConhecimento->chanceStatusCon($conhecimento, 4);
		
		if($acao == "adicionar"){
			$objRec->setDatacadastro('NOW()');
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

if($mostraCodigo){
	$msg .= "O código d".strtolower($prefix)." ".strtolower($titulo)." é: <b>$codigo</b>";
	$msg .= "<br><br>";
}

/* se não for cliente */
if(empty($opCliente)){
	if(empty($voltar)){
		$voltar = 'index.php';
	}
	$msg .= "<input name=\"voltar\" type=\"button\" value=\"Início\" class=\"botao\" onClick=\"javascript:location.href='$voltar'\" /><br /><br />";
	
	if($continuar == true){
		$msg .= "<input name=\"continuar\" type=\"button\" value=\"Continuar\" class=\"botao\" onClick=\"javascript:history.go(-1);\" /><br /><br />";
	}
	if($continuarAtualizarColeta == true){
		$msg .= "<input name=\"continuar\" type=\"button\" value=\"Continuar\" class=\"botao\" onClick=\"javascript:history.go(-2);\" /><br /><br />";
	}
	if($cadastrarConhecimentos == true){
		$voltar = "frmConhecimento.php?acao=adicionar";
		$msg .= "<input name=\"conhecimentos\" type=\"button\" value=\"Conhecimentos\" class=\"botao\" onClick=\"javascript:location.href='$voltar'\" /><br /><br />";
	}
	
	$msg .= "</div>";
}

$conteudo = $msg;

$titulo = "Registro ".$prefixoAcao."o com sucesso";

if($existePessoa){
	echo "<script language=javascript>alert('O ítem já está cadastrado em nosso banco de dados.');javascript:history.go(-1);</script>";
	exit();
}

if($existeUsuario){
	echo "<script language=javascript>alert('O usuário já está cadastrado em nosso banco de dados.');javascript:history.go(-1);</script>";
	exit();
}

if(!empty($opCliente)){
	/* incluindo conteudo na página interna específica para cliente*/
	include("../php/includeInternaCliente.php");	
}
else{
	/* incluindo conteudo na página interna */
	include("../php/includeInterna.php");	
}
?>