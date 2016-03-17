<?php

include("../cerebro/Cerebro.php");
include("../lib/library.php");
include("../lang/lang.php");


$cerebro = new Cerebro();

$cerebro->neuronio("../neuronios/connection/" , "Connection");
$cerebro->neuronio("../neuronios/database/"   , "DataBase");
$cerebro->neuronio("../neuronios/cookie/"     , "Cookie");
$cerebro->neuronio("../classes/oriant/"       , "Grupo");
$cerebro->neuronio("../classes/oriant/"       , "Feromonio");
$cerebro->neuronio("../classes/oriant/"       , "Pagina");
$cerebro->neuronio("../classes/oriant/"       , "OriAnt");
$cerebro->neuronio("../classes/oriant/"       , "ParametrosAdm");

$controlador = $cerebro->getFrameWork();

$pagina = 'http://localhost:8090/oriant/php/joias.php';
$grupo = 2;
$controlador['oriant']->setFeromonio($controlador['feromonio']);
$controlador['oriant']->setPagina($controlador['pagina']);
$controlador['oriant']->setParametros_adm($controlador['parametrosadm']);

$resultado = $controlador['oriant']->getRelevance('ori$null', $pagina, $grupo);

echo $resultado;


/*
$controlador['oriant']->setFeromonio($controlador['feromonio']);
$controlador['oriant']->setParametros_adm($controlador['parametrosadm']);
$controlador['oriant']->setPagina($controlador['pagina']);

$grupo = 1;

$matriz = $controlador['oriant']->getMtzRelevanceAll($grupo);

print_r($matriz);
*/

/*
$controlador['parametrosadm']->__get_db();
$controlador['parametrosadm']->setLogin('xg0rd0');
$controlador['parametrosadm']->setSenha('panaca');
$controlador['parametrosadm']->setAcrescimo_feromonio(10);
$controlador['parametrosadm']->setTx_evaporacao(10);
$controlador['parametrosadm']->save();
*/

/*
$controlador['oriant']->setOrigem('index1.php');
$controlador['oriant']->setDestino('index2.php');
$controlador['oriant']->setGrupo(4);
$controlador['oriant']->setFeromonio($controlador['feromonio']);
$controlador['oriant']->setPagina($controlador['pagina']);
$controlador['oriant']->setParametros_adm($controlador['parametrosadm']);

$controlador['oriant']->atualizaFeromonio();
*/

function imprimeString($arrayValores){
	if(!empty($arrayValores)){	
		foreach($arrayValores as $indice => $valor){
			if(!empty($valor) || !empty($indice)){
				echo ucfirst($indice).' : '.'<b>'.$valor.'</b><br>';
			}
		}
		echo '<hr>';
	}
}
?>