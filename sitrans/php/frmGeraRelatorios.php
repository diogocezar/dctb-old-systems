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
include("../php/controlaSession.php");

/* diretório dos templates */
$templateHtmlDir = '../html';

$templateHtmlName = "frmGeraRelatorios.html";

/* setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);	
$tipo        = $_POST['tipo'];                   if(empty($tipo)) $tipo = $_GET['tipo'];
$dataDe      = converteData($_POST['data_de']);  if($dataDe == '--') $dataDe = $_GET['data_de'];
$dataAte     = converteData($_POST['data_ate']); if($dataAte == '--') $dataAte = $_GET['data_ate'];
$tipoData    = $_POST['tipo_data'];              if(empty($tipoData)) $tipoData = $_GET['tipo_data'];
$cliente     = $_POST['cliente'];                if(empty($cliente)) $cliente = $_GET['cliente'];
$contato     = $_POST['contato'];                if(empty($contato)) $contato = $_GET['contato'];
$veiculo     = $_POST['veiculo'];                if(empty($veiculo)) $veiculo = $_GET['veiculo'];
$fornecedor  = $_POST['fornecedor'];             if(empty($fornecedor)) $fornecedor = $_GET['fornecedor'];
$usuario     = $_POST['usuario'];                if(empty($usuario)) $usuario = $_GET['usuario'];

$tipoDetalhe = $_GET['tdetalhe'];				 if(empty($tipoDetalhe)) $tipoDetalhe = $_GET['tdetalhe'];
$inside      = $_GET['inside'];                  if(empty($inside)) $inside = $_POST['inside'];



//print_r($_POST);
//exit;

if($tipoData == "DATACADASTRO"){
	$dataCon = "datacadastro";
	$label   = "Data de Cadastro";
}
else{
	$dataCon = "data";
	$label   = "Data da Coleta";
}

$resumo .= "Tipo: ".$relTipos[strtolower($tipo)]."<br />";
$resumo .= "Período de: ".desconverteData($dataDe, true)." até: ".desconverteData($dataAte, true)."<br />";
$resumo .= "Data a consultar: $label";

$template->setVariable("resumoRelatorio", $resumo);

switch($tipo){
	case 'SINTETICO':
		$sqlTotais = "SELECT COUNT(DISTINCT codigo) as total_coletas, SUM(qtdadenotafiscal) as total_notas, SUM(PESO) as total_peso, SUM(qtdadevolumes) as total_volumes 
		              FROM coleta c WHERE $dataCon BETWEEN '".$dataDe." 00:00:00' AND '".$dataAte." 23:59:59'
		              AND c.versao = (SELECT max(versao) from coleta t where t.codigo = c.codigo)";
					  
		$sqlColetas = "SELECT s.descricao, COUNT(c.codigo) as total_coletas FROM status s, coleta c 
					   WHERE c.idstatus = s.idstatus 
		               AND c.$dataCon BETWEEN '".$dataDe." 00:00:00' AND '".$dataAte." 23:59:59'
					   AND c.versao = (SELECT max(versao) from coleta t where t.codigo = c.codigo) GROUP BY s.descricao, c.idstatus";
					   					   
		$template->setCurrentBlock("bloco_relatorio");
			$template->setCurrentBlock("bloco_relatorio_totais");
				$db = new DataBase();
				$resultado = $db->query($sqlTotais);
				if(!DB::isError($resultado)){
					$template->setVariable("headerDescricaoTotais", "Descrição");
					$template->setVariable("headerTotalizadorTotais", "Totalizador");
					$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
					foreach($relDescSinte as $key => $desc){
						if(empty($dados[$key]))  $dados[$key] = 0;
						$template->setCurrentBlock("bloco_relatorio_content_totais");	
							$template->setVariable("contentDescricaoTotais", $desc);
							if($key == 'total_coletas' && $dados[$key] != 0){
								$link = "<a href=\"javascript:;\" class=\"linkRelatorio\" onclick=\"tb_show('Detalhes das coletas', 'frmGeraRelatorios.php?tdetalhe=$key&tipo=DETALHES_COLETA&data_de=$dataDe&data_ate=$dataAte&tipo_data=$tipoData&height=500&width=920&inside=false&cliente=$cliente&contato=$contato&veiculo=$veiculo&fornecedor=$fornecedor&usuario=$usuario', '');\">".$dados['total_coletas']."</a>";	
								$template->setVariable("contentTotalizadorTotais", $link);
							}
							else{
								$template->setVariable("contentTotalizadorTotais", $dados[$key]);
							}
						$template->parseCurrentBlock("bloco_relatorio_content_totais");
					}
				}
			$template->parseCurrentBlock("bloco_relatorio_totais");
			
			$template->setCurrentBlock("bloco_relatorio_coletas");
				$db = new DataBase();
				$resultado = $db->query($sqlColetas);
				if(!DB::isError($resultado)){
					$template->setVariable("headerDescricaoColetas", "Situação da Coleta");
					$template->setVariable("headerTotalizadorColetas", "Quantidade");
					while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
						if(empty($dados['total_coletas']))  $dados['total_coletas'] = 0;
						$template->setCurrentBlock("bloco_relatorio_content_coletas");	
							$template->setVariable("contentDescricaoColetas", $relReplaceStatus[$dados['descricao']]);
							if($dados['total_coletas'] != 0){
								$link = "<a href=\"javascript:;\" class=\"linkRelatorio\" onclick=\"tb_show('Detalhes das coletas', 'frmGeraRelatorios.php?tdetalhe=".$dados['descricao']."&tipo=DETALHES_COLETA&data_de=$dataDe&data_ate=$dataAte&tipo_data=$tipoData&height=500&width=920&inside=false&cliente=$cliente&contato=$contato&veiculo=$veiculo&fornecedor=$fornecedor&usuario=$usuario', '');\">".$dados['total_coletas']."</a>";
								$template->setVariable("contentTotalizadorColetas", $link);
							}
							else{
								$template->setVariable("contentTotalizadorColetas", $dados['total_coletas']);
							}
						$template->parseCurrentBlock("bloco_relatorio_content_coletas");
					}
				}
				
			$template->parseCurrentBlock("bloco_relatorio_coletas");
			
			$template->setVariable("footerSintetico", "Relatório gerado em: ".date("d/m/Y - H:i"));

		$template->parseCurrentBlock("bloco_relatorio");
	break;
	
	case 'ANALITICO':
		$sqlTotais  = "";
		$sqlTotais .= "SELECT COUNT(DISTINCT c.codigo) as total_coletas, SUM(c.qtdadenotafiscal) as total_notas, SUM(c.peso) as total_peso, SUM(qtdadevolumes) as total_volumes 
		               FROM coleta c";
					  
					  /* Selecionando as tabelas que estiverem com filtro */
					  
					  if(!empty($cliente)){
					  	$sqlTotais .= ", cliente k";
					  }
					  
					  if(!empty($contato)){
					  	$sqlTotais .= ", contato co";
					  }
					  
					  if(!empty($veiculo)){
					  	$sqlTotais .= ", veiculo v";
					  }
					  
					  if(!empty($fornecedor)){
					  	$sqlTotais .= ", fornecedor f";
					  }
					  
					  if(!empty($usuario)){
					  	$sqlTotais .= ", usuario u";
					  }

	    $sqlTotais .= " WHERE c.$dataCon BETWEEN '".$dataDe." 00:00:00' AND '".$dataAte." 23:59:59'
		                AND c.versao = (SELECT min(versao) from coleta t where t.codigo = c.codigo)";
					  
					  /* Ligando as tabelas que estiverem com filtro */
					  
					  if(!empty($cliente)){
					  	$sqlTotais .= " AND c.idcliente = k.idcliente";
					  }
					  
					  if(!empty($contato)){
					  	$sqlTotais .= " AND c.idcontato = co.idcontato";
					  }
					  
					  if(!empty($veiculo)){
					  	$sqlTotais .= " AND c.idveiculo = v.idveiculo";
					  }
					  
					  if(!empty($fornecedor)){
					  	$sqlTotais .= " AND c.idfornecedor = f.idfornecedor";
					  }
					  
					  if(!empty($usuario)){
					  	$sqlTotais .= " AND c.idusuario = u.idusuario";
					  }		
					  			  
					  /* Inserindo o filtro selecionado */
					  
					  if(!empty($cliente)){
					  	$sqlTotais .= " AND c.idcliente = ".$cliente;
					  }
					  
					  if(!empty($contato)){
					  	$sqlTotais .= " AND c.idcontato = ".$contato;
					  }
					  
					  if(!empty($veiculo)){
					  	$sqlTotais .= " AND c.idveiculo = ".$veiculo;
					  }
					  
					  if(!empty($fornecedor)){
					  	$sqlTotais .= " AND c.idfornecedor = ".$fornecedor;
					  }
					  
					  if(!empty($usuario)){
					  	$sqlTotais .= " AND c.idusuario = ".$usuario;
					  }	
					  				  
		$sqlColetas  = "";					  
		$sqlColetas .= "SELECT s.descricao, COUNT(c.codigo) as total_coletas FROM status s, coleta c";
		
					   /* Selecionando as tabelas que estiverem com filtro */
						  
						  if(!empty($cliente)){
							$sqlColetas .= ", cliente k";
						  }
						  
						  if(!empty($contato)){
							$sqlColetas .= ", contato co";
						  }
						  
						  if(!empty($veiculo)){
							$sqlColetas .= ", veiculo v";
						  }
						  
						  if(!empty($fornecedor)){
							$sqlColetas .= ", fornecedor f";
						  }
						  
						  if(!empty($usuario)){
							$sqlColetas .= ", usuario u";
						  }
						  		
		$sqlColetas .= " WHERE c.idstatus = s.idstatus
		                 AND c.$dataCon BETWEEN '".$dataDe." 00:00:00' AND '".$dataAte." 23:59:59'
					     AND c.versao = (SELECT min(versao) from coleta t where t.codigo = c.codigo)";
						 
						 
					   /* Ligando as tabelas que estiverem com filtro */
						  
						 if(!empty($cliente)){
							$sqlColetas .= " AND c.idcliente = k.idcliente";
						 }
						  
						 if(!empty($contato)){
							$sqlColetas .= " AND c.idcontato = co.idcontato";
						 }
						  
						 if(!empty($veiculo)){
							$sqlColetas .= " AND c.idveiculo = v.idveiculo";
						 }
						  
						 if(!empty($fornecedor)){
							$sqlColetas .= " AND c.idfornecedor = f.idfornecedor";
						 }
						 
						 if(!empty($usuario)){
							$sqlColetas .= " AND c.idusuario = u.idusuario";
						 }						  
						  /* Inserindo o filtro selecionado */
						  
						 if(!empty($cliente)){
							$sqlColetas .= " AND c.idcliente = ".$cliente;
						 }
						  
						 if(!empty($contato)){
							$sqlColetas .= " AND c.idcontato = ".$contato;
						 }
						  
						 if(!empty($veiculo)){
							$sqlColetas .= " AND c.idveiculo = ".$veiculo;
						 }
						  
						 if(!empty($fornecedor)){
							$sqlColetas .= " AND c.idfornecedor = ".$fornecedor;
						 }
						 
						 if(!empty($usuario)){
							$sqlColetas .= " AND c.idusuario = ".$usuario;
						 }
						 						 
		$sqlColetas .= "GROUP BY s.descricao, c.idstatus";
		
		print_r($_POST);
		echo "<br><br>";
		echo $sqlTotais;
		echo "<br><br>";
		echo $sqlColetas;
		//exit;
					   					   
		$template->setCurrentBlock("bloco_relatorio");
			$template->setCurrentBlock("bloco_relatorio_totais");
				$db = new DataBase();
				$resultado = $db->query($sqlTotais);
				if(!DB::isError($resultado)){
					$template->setVariable("headerDescricaoTotais", "Descrição");
					$template->setVariable("headerTotalizadorTotais", "Totalizador");
					$dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC);
					foreach($relDescSinte as $key => $desc){
						if(empty($dados[$key]))  $dados[$key] = 0;
						$template->setCurrentBlock("bloco_relatorio_content_totais");	
							$template->setVariable("contentDescricaoTotais", $desc);
							if($key == 'total_coletas' && $dados[$key] != 0){
								$link = "<a href=\"javascript:;\" class=\"linkRelatorio\" onclick=\"tb_show('Detalhes das coletas', 'frmGeraRelatorios.php?tdetalhe=$key&tipo=DETALHES_COLETA&data_de=$dataDe&data_ate=$dataAte&tipo_data=$tipoData&height=500&width=920&inside=false&cliente=$cliente&contato=$contato&veiculo=$veiculo&fornecedor=$fornecedor&usuario=$usuario', '');\">".$dados['total_coletas']."</a>";								
								$template->setVariable("contentTotalizadorTotais", $link);
							}
							else{
								$template->setVariable("contentTotalizadorTotais", $dados[$key]);
							}
						$template->parseCurrentBlock("bloco_relatorio_content_totais");
					}
				}
			$template->parseCurrentBlock("bloco_relatorio_totais");
			
			$template->setCurrentBlock("bloco_relatorio_coletas");
				$db = new DataBase();
				$resultado = $db->query($sqlColetas);
				if(!DB::isError($resultado)){
					$template->setVariable("headerDescricaoColetas", "Situação da Coleta");
					$template->setVariable("headerTotalizadorColetas", "Quantidade");
					while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
						if(empty($dados['total_coletas']))  $dados['total_coletas'] = 0;
						$template->setCurrentBlock("bloco_relatorio_content_coletas");	
							$template->setVariable("contentDescricaoColetas", $relReplaceStatus[$dados['descricao']]);
							if($dados['total_coletas'] != 0){
								$link = "<a href=\"javascript:;\" class=\"linkRelatorio\" onclick=\"tb_show('Detalhes das coletas', 'frmGeraRelatorios.php?tdetalhe=".$dados['descricao']."&tipo=DETALHES_COLETA&data_de=$dataDe&data_ate=$dataAte&tipo_data=$tipoData&height=500&width=920&inside=false&cliente=$cliente&contato=$contato&veiculo=$veiculo&fornecedor=$fornecedor&usuario=$usuario', '');\">".$dados['total_coletas']."</a>";
								$template->setVariable("contentTotalizadorColetas", $link);
							}
							else{
								$template->setVariable("contentTotalizadorColetas", $dados['total_coletas']);
							}
						$template->parseCurrentBlock("bloco_relatorio_content_coletas");
					}
				}
				
			$template->parseCurrentBlock("bloco_relatorio_coletas");
			
			$template->setVariable("footerSintetico", "Relatório gerado em: ".date("d/m/Y - H:i"));

		$template->parseCurrentBlock("bloco_relatorio");
	break;

	
	case 'DETALHES_COLETA':
	
		if($tipoDetalhe == 'total_coletas'){
		
			$sqlTotal  = "";
			$sqlTotal .= "SELECT DISTINCT c.codigo, c.datacadastro , k.nome, f.nomefantasia, c.qtdadenotafiscal, c.qtdadevolumes, c.peso, c.databaixa, s.descricao
  						  FROM coleta c, cliente k, fornecedor f, status s";
						  
					   /* Selecionando as tabelas que estiverem com filtro */
						  
						  if(!empty($contato)){
							$sqlTotal .= ", contato co";
						  }
						  
						  if(!empty($veiculo)){
							$sqlTotal .= ", veiculo v";
						  }
						  
						  if(!empty($usuario)){
							$sqlTotal .= ", usuario u";
						  }						  
						 
  			$sqlTotal .= " WHERE c.idcliente = k.idcliente
  						   AND   c.idfornecedor = f.idfornecedor
						   AND   c.idstatus = s.idstatus";
						   
						  if(!empty($contato)){
							$sqlTotal .= " AND c.idcontato = co.idcontato";
						  }
						  
						  if(!empty($veiculo)){
							$sqlTotal .= " AND c.idveiculo = v.idveiculo";
						  }
						  
						  if(!empty($usuario)){
							$sqlTotal .= " AND c.idusuario = u.idusuario";
						  }						
						  /* Inserindo o filtro selecionado */
						  
						 if(!empty($cliente)){
							$sqlTotal .= " AND c.idcliente = ".$cliente;
						 }
						  
						 if(!empty($contato)){
							$sqlTotal .= " AND c.idcontato = ".$contato;
						 }
						  
						 if(!empty($veiculo)){
							$sqlTotal .= " AND c.idveiculo = ".$veiculo;
						 }
						  
						 if(!empty($fornecedor)){
							$sqlTotal .= " AND c.idfornecedor = ".$fornecedor;
						 }	
						 
						 if(!empty($usuario)){
							$sqlTotal .= " AND c.idusuario = ".$usuario;
						 }	

			$sqlTotal .= " AND c.$dataCon BETWEEN '".$dataDe." 00:00:00' AND '".$dataAte." 23:59:59'
						   AND c.versao = (SELECT max(versao) from coleta t where t.codigo = c.codigo)";
						   
			//print_r($_GET);
			
			//echo "<br>";
			
			//echo $sqlTotal;
						   
			$template->setCurrentBlock("bloco_relatorio_detalhes_coletas");
			$db = new DataBase();
			$resultado = $db->query($sqlTotal);
			if(!DB::isError($resultado)){
									
				$template->setVariable("headerCadastroDetalhesColetas", "Cadastro");
				$template->setVariable("headerCodigoDetalhesColetas", "Cod.");
				$template->setVariable("headerClienteDetalhesColetas", "Cliente");
				$template->setVariable("headerFornecedorDetalhesColetas", "Fornecedor");
				$template->setVariable("headerNotasDetalhesColetas", "Notas");
				$template->setVariable("headerVolumesDetalhesColetas", "Vol's");
				$template->setVariable("headerPesoDetalhesColetas", "Peso");
				$template->setVariable("headerBaixaDetalhesColetas", "Baixa");
				while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
					$template->setCurrentBlock("bloco_relatorio_content_detalhes_coletas");
						if(empty($dados['qtdadenotafiscal'])) $dados['qtdadenotafiscal'] = "N/A";
						if(empty($dados['qtdadevolumes'])) $dados['qtdadevolumes'] = "N/A";
						if(empty($dados['databaixa'])){
							$dados['databaixa'] = "N/A";
						}
						else{
							$dados['databaixa'] = substr(desconverteData($dados['databaixa']), 0, 10);
						}
						$template->setVariable("contentCadastroDetalhesColetas", substr(desconverteData($dados['datacadastro']), 0, 10));
						$template->setVariable("contentCodigoDetalhesColetas", $dados['codigo']);
						$template->setVariable("contentClienteDetalhesColetas", $dados['nome']);
						$descricaoTitle = "STATUS: ".$dados['descricao'];
						if(!empty($descricaoMotivo)){	
							$descricaoTitle .= " / MOTIVO: ".$descricaoMotivo.".";	
						}
						$template->setVariable("titleCliente", $descricaoTitle);
						$template->setVariable("contentFornecedorDetalhesColetas", $dados['nomefantasia']);
						$template->setVariable("contentNotasDetalhesColetas", $dados['qtdadenotafiscal']);
						$template->setVariable("contentVolumesDetalhesColetas", $dados['qtdadevolumes']);
						$template->setVariable("contentPesoDetalhesColetas", $dados['peso']);
						$template->setVariable("contentBaixaDetalhesColetas", $dados['databaixa']);
					$template->parseCurrentBlock("bloco_relatorio_content_detalhes_coletas");
				}
			}
			$template->parseCurrentBlock("bloco_relatorio_detalhes_coletas");
		}
		else{
			$sqlStatus  = "";
			$sqlStatus .= "SELECT DISTINCT c.codigo, c.datacadastro, k.nome, f.nomefantasia, c.qtdadenotafiscal, c.qtdadevolumes, c.peso, c.databaixa, c.idstatus, c.idmotivo, s.descricao
  						  FROM coleta c, cliente k, fornecedor f, status s";
						  
						  /* Selecionando as tabelas que estiverem com filtro */
						  
						  if(!empty($contato)){
							$sqlStatus .= ", contato co";
						  }
						  
						  if(!empty($veiculo)){
							$sqlStatus .= ", veiculo v";
						  }
						  
						  if(!empty($usuario)){
							$sqlStatus .= ", usuario u";
						  }

  			$sqlStatus .= " WHERE c.idcliente = k.idcliente
  						  AND   c.idfornecedor = f.idfornecedor
						  AND   c.idstatus = s.idstatus";						  
						  
						  if(!empty($contato)){
							$sqlStatus .= " AND c.idcontato = co.idcontato";
						  }
						  
						  if(!empty($veiculo)){
							$sqlStatus .= " AND c.idveiculo = v.idveiculo";
						  }
						  
						  if(!empty($usuario)){
							$sqlStatus .= " AND c.idusuario = u.idusuario";
						  }
						  
						  /* Inserindo o filtro selecionado */
						  
						 if(!empty($cliente)){
							$sqlStatus .= " AND c.idcliente = ".$cliente;
						 }
						  
						 if(!empty($contato)){
							$sqlStatus .= " AND c.idcontato = ".$contato;
						 }
						  
						 if(!empty($veiculo)){
							$sqlStatus .= " AND c.idveiculo = ".$veiculo;
						 }
						  
						 if(!empty($fornecedor)){
							$sqlStatus .= " AND c.idfornecedor = ".$fornecedor;
						 }	
						 
						 if(!empty($usuario)){
							$sqlStatus .= " AND c.idusuario = ".$usuario;
						 }	
						  
						  
			$sqlStatus .= " AND s.descricao = '$tipoDetalhe'
  						  AND c.$dataCon BETWEEN '".$dataDe." 00:00:00' AND '".$dataAte." 23:59:59'
						  AND c.versao = (SELECT max(versao) from coleta t where t.codigo = c.codigo)";
						  
						  echo $sqlStatus;

			$template->setCurrentBlock("bloco_relatorio_detalhes_coletas");
			$db = new DataBase();
			$resultado = $db->query($sqlStatus);
			if(!DB::isError($resultado)){
				$template->setVariable("headerCadastroDetalhesColetas", "Cadastro");
				$template->setVariable("headerCodigoDetalhesColetas", "Cod.");
				$template->setVariable("headerClienteDetalhesColetas", "Cliente");
				$template->setVariable("headerFornecedorDetalhesColetas", "Fornecedor");
				$template->setVariable("headerNotasDetalhesColetas", "Notas");
				$template->setVariable("headerVolumesDetalhesColetas", "Vol's");
				$template->setVariable("headerPesoDetalhesColetas", "Peso");
				$template->setVariable("headerBaixaDetalhesColetas", "Baixa");
				while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
					/* Recuperando o motivo */
					if(!empty($dados['idmotivo'])){
						$motivo = $controlador['motivo'];
						$motivo->__toFillGeneric();
						$motivo->__get_db($dados['idmotivo']);
						$descricaoMotivo = $motivo->getDescricao();
					}				
					$template->setCurrentBlock("bloco_relatorio_content_detalhes_coletas");
						if(empty($dados['qtdadenotafiscal'])) $dados['qtdadenotafiscal'] = "N/A";
						if(empty($dados['qtdadevolumes'])) $dados['qtdadevolumes'] = "N/A";
						if(empty($dados['databaixa'])){
							$dados['databaixa'] = "N/A";
						}
						else{
							$dados['databaixa'] = substr(desconverteData($dados['databaixa']), 0, 10);
						}
						$template->setVariable("contentCadastroDetalhesColetas", substr(desconverteData($dados['datacadastro']), 0, 10));
						$template->setVariable("contentCodigoDetalhesColetas", $dados['codigo']);
						$template->setVariable("contentClienteDetalhesColetas", $dados['nome']);
						$descricaoTitle = "STATUS: ".$dados['descricao'];
						if(!empty($descricaoMotivo)){	
							$descricaoTitle .= " / MOTIVO: ".$descricaoMotivo.".";	
						}
						$template->setVariable("titleCliente", $descricaoTitle);
						$template->setVariable("contentFornecedorDetalhesColetas", $dados['nomefantasia']);
						$template->setVariable("contentNotasDetalhesColetas", $dados['qtdadenotafiscal']);
						$template->setVariable("contentVolumesDetalhesColetas", $dados['qtdadevolumes']);
						$template->setVariable("contentPesoDetalhesColetas", $dados['peso']);
						$template->setVariable("contentBaixaDetalhesColetas", $dados['databaixa']);
					$template->parseCurrentBlock("bloco_relatorio_content_detalhes_coletas");
				}
			}
			$template->parseCurrentBlock("bloco_relatorio_detalhes_coletas");
		}
		
	break;
}

/* debug: SQL */

if(!empty($sqlTotais)){
	$debug .= $sqlTotais."<br /><br />";
}
if(!empty($sqlColetas)){
	$debug .= $sqlColetas."<br /><br />";
}
if(!empty($sqlTotal)){
	$debug .= $sqlTotal."<br /><br />";
}
if(!empty($sqlStatus)){
	$debug .= $sqlStatus."<br /><br />";
}

//$template->setVariable("dbugSql", $debug);

$mostrar = $template->get();

/* Caso Ajax */
if($tipo == 'DETALHES_COLETA'){
	$mostrar = utf8_encode($mostrar);
}
else{
	$mostrar = rawurlencode($mostrar);
}

if($inside == 'TRUE'){

	/**
	/* diretório dos templates 
	*/
	$templateHtmlDir = '../html';
	
	$templateHtmlName = 'principal.html';
	
	/* setando template */
	$template = new HTML_Template_IT($templateHtmlDir);
	
	/* instanciando a classe */
	$template->loadTemplatefile($templateHtmlName, true, true);
	
	/* bloco do título */
	$template->setCurrentBlock("bloco_titulo");
		$template->setVariable("titulo", TITULO);
	$template->parseCurrentBlock("bloco_titulo");
	
		/* informações do usuário */
		$session = $controlador['session'];
		$nome    = $session->retornaSession('sessNome',  false);
		$nivel   = $session->retornaSession('sessNivel', false);
		$login   = $session->retornaSession('sessLogin', false);
		$id      = $session->retornaSession('sessId',    false);
		
		/* recuperando descrição do nível */	
		if(!empty($id)){
			$objNivel = $controlador['nivel'];
			$objNivel->__toFillGeneric();
			$objNivel->__get_db($id);
			$descricaoNivel = $objNivel->getDescricao();
		}
		
		// false, não retorna erro caso a sessão esteja vazia.
	
	if(!empty($id)){
		/* bloco topo */
		$template->setCurrentBlock("bloco_topo");
			$template->setVariable("login", "Bem vindo, $nome - <strong>$descricaoNivel</strong>");
			$inicio = "<a href=\"../index.php\" class=\"linkBranco\">Início</a>";
			$ajuda  = "<a href=\"ajuda.php\" class=\"linkBranco\">Ajuda</a>";
			$sair   = "<a href=\"sair.php\" class=\"linkBranco\">Sair</a>";
			$template->setVariable("sair",  $inicio.' - '.$ajuda.' - '.$sair);
		$template->parseCurrentBlock("bloco_topo");
		
		/* bloco menu */
		$template->setCurrentBlock("bloco_menu");
			$template->setVariable("menu", "MENU_".$nivel);
		$template->parseCurrentBlock("bloco_menu");
	}
	else{
		/* bloco topo */
		$template->setCurrentBlock("bloco_topo");
			$template->setVariable("login", "Sistema Sitrans ".date(Y));
			$inicio = "<a href=\"../index.php\" class=\"linkBranco\">Início</a>";
			$ajuda  = "<a href=\"ajuda.php\" class=\"linkBranco\">Ajuda</a>";
			$template->setVariable("sair",  $inicio.' - '.$ajuda);
		$template->parseCurrentBlock("bloco_topo");
		
		/* bloco login */
		$template->setCurrentBlock("bloco_login");
			$template->setVariable("login", TEXTO_LOGIN);
		$template->parseCurrentBlock("bloco_login");
	}
	
	$template->setVariable("js_sajax", '');
	
	/* bloco relatorio */
	$template->setCurrentBlock("bloco_conteudo_relatorio");
		$template->setVariable("conteudoRelatorio", $mostrar);
	$template->parseCurrentBlock("bloco_conteudo_relatorio");
	
	/* bloco footer */
	$template->setCurrentBlock("bloco_footer");
		$template->setVariable("creditos", CREDITOS);
	$template->parseCurrentBlock("bloco_footer");
	
	$template->show();
}
else{
	echo $mostrar;
}
?>