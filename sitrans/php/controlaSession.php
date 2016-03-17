<?php
/**
* Verificando a opção para cadastro direto do cliente
*/
$opCliente = $_GET['tcliente'];

$session = $controlador['session'];

$session->startSession();

$permitidoCS   = false;
$permitidoCL   = false;
$registraCS    = false;
$registraCL    = false;
$passouLoginCS = false;
$passouLoginCL = false;

/* transformando todos os campos enviados em letras maiúsculas */

foreach($_POST as $indice => $valor){
	if(!in_array($indice, $arrayNoToUp)){
		$_POST[$indice] = uc_latin1($_POST[$indice]);
	}
}

$loginCS = $_POST['login'];
$senhaCS = $_POST['senha'];

if(!empty($loginCS) && !empty($senhaCS)){

	if(!empty($opCliente)){
	
		$passouLoginCL = true;
		$mensagemCL    = true;
	
		$contato = $controlador['contato'];
		$contato->__toFillGeneric();
		$resultadoCL = $contato->allowLoginContato($loginCS, $senhaCS);
		
		if($resultadoCL != false){
			$registraCL    = true;
			$idCL          = (string)$resultadoCL['id'];
			$nomeCL        = $resultadoCL['nome'];
			$loginCL       = $resultadoCL['login'];
			$senhaCL       = $resultadoCL['senha'];
			
			$cliente = $controlador['cliente'];
			$cliente->__toFillGeneric();
			$resultadoEM =  $cliente->returnIdByContact($idCL);
			
			$empresaIdCL   = $resultadoEM['idcliente'];
			$empresaNomeCL = $resultadoEM['nome'];
			
			$redirecionaCL = "index.php?tcliente=sim";
		}
		
		if($registraCL != false){
			$ipCL = getIp();
			$sessions = array('sessIdContato'    => $idCL,
							  'sessNomeContato'  => $nomeCL,
							  'sessIdEmpresa'    => $empresaIdCL,
							  'sessNomeEmpresa'  => $empresaNomeCL,
							  'sessLoginContato' => $loginCL,
							  );
						
			$session->__go_Session($sessions);
			
			/* guardando log */
			$quandoCL = getData(4)."#".getHora(":",1);
			$adminInfos = array('ip:'        => $ipCL,
								'contato:'   => $nomeCL,
								'idcontato:' => $idCL,
								'empresa:'   => $empresaNomeCL,
								'idempresa:' => $empresaIdCL,
								'quando:'    => $quandoCL
								);
			registraLogAdmin($diretorio['logCliente'], $adminInfos, true);
		}
	}
	else{
		$passouLoginCS = true;
		$mensagemCS    = true;
		
		$usuario = $controlador['usuario'];
		$usuario->__toFillGeneric();
		$resultadoCS = $usuario->allowLogin($loginCS, $senhaCS);
		
		if($resultadoCS != false){
			$registraCS    = true;
			$idCS          = (string)$resultadoCS['id'];
			$nomeCS        = $resultadoCS['nome'];
			$loginCS       = $resultadoCS['login'];
			$senhaCS       = $resultadoCS['senha'];
			$nivelCS       = (string)$resultadoCS['nivel'];
			$redirecionaCS = "index.php";
		}
		
		if($registraCS){
			$ipCS = getIp();
			$sessions = array('sessId'    => $idCS,
							  'sessNivel' => $nivelCS,
							  'sessNome'  => $nomeCS,
							  'sessLogin' => $loginCS
							  );
							  
			$session->__go_Session($sessions);
			
			/* guardando log */
			$quandoCS = getData(4)."#".getHora(":",1);
			$adminInfos = array('ip:'     => $ipCS,
								'nivel:'  => $nivelCS,
								'nome:'   => $nomeCS,
								'quando:' => $quandoCS
								);
			registraLogAdmin($diretorio['log'], $adminInfos, true);
		}
	}
}

if(!empty($_SESSION['sessId']) || !empty($_SESSION['sessIdContato'])){
	$permitidoCS = true;
}

if($permitidoCS != true){
	$mensagem = "";
	$echo     = "<script language=javascript>";
	if($mensagemCS == true || $mensagemCL == true){
		$mensagem = "Desculpe, você não foi identificado no sistema.";
	}
	if(!empty($mensagem)){
		$echo .= "alert('$mensagem');";
	}
	$echo .= "location.href='login.php";
	if(!empty($opCliente)){
		$echo .= "?tcliente=sim";
	}
	$echo .= "'</script>";
	echo $echo;
	exit();
}

if($passouLoginCS){
	echo "<script language=javascript>location.href='$redireciona'</script>";
	exit();
}
?>