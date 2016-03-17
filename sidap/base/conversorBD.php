<HTML>
<HEAD>
<TITLE> Convertendo DBF para MySQL </TITLE>
</HEAD>
<BODY>
<?php
/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

set_time_limit(0);
//Arquivo DBF
$dbname = './bancosDBF/PESSOA.DBF';

//Abre o banco de dados Dbase
//0 - somente leitura
//1 - somente escrita
//2 - leitura / escrita
$con = dbase_open($dbname,0) or die('Erro na Conexão com o arquivo DBF');
//Lista os dados da Tabela
$rows = dbase_numrecords($con);
//$rows = 5;
echo 'Numero de registros ... >>> <b> ' . $rows . ' </b>';

$cliente = $controlador['cliente'];
$cliente->__toFillGeneric();

function clearRegister($register){
	$register = strtoupper($register);
	$register = str_replace('\'', '', $register);
	return $register;
}


for($i=1;$i<=$rows;$i++) {
$registro = dbase_get_record_with_names($con,$i); //Pega o registro do arquivo DBF

$pessoaId   = clearRegister($registro['PESSOAID']);
$anonas     = clearRegister($registro['ANONASC']);
$mesnas     = clearRegister($registro['MESNASC']);
$dianas     = clearRegister($registro['DIANASC']);
$pessoaNome = clearRegister($registro['PESSOANOME']);
$endereco   = clearRegister($registro['ENDERECO']);
$bairro     = clearRegister($registro['BAIRRO']);
$cidade     = clearRegister($registro['CIDADE']);
$telefone1  = clearRegister($registro['TELEFONE1']);
$telefone2  = clearRegister($registro['TELEFONE2']);
$celular    = clearRegister($registro['CELULAR']);
$estado     = clearRegister($registro['ESTADO']);
$cep        = clearRegister($registro['CEP']);

if($anonas == '  ' || $mesna == '  ' || $dianas == '  '){
	$dataNas = 'NULL';
}
else{
	$dataNas = $anonas.'-'.$mesnas.'-'.$dianas;
}
$dataNas = str_replace('- -', 'NULL', $dataNas);

$cliente->setIdcliente($pessoaId);
$cliente->setIdgrupo('NULL');
$cliente->setIdusuario('NULL');
$cliente->setNome($pessoaNome);
$cliente->setDatanascimento($dataNas);
$cliente->setBairro($bairro);
$cliente->setCidade($cidade);
$cliente->setEndereco($endereco);
$cliente->setCep($cep);
$cliente->setEstado($estado);
$cliente->setTelefone1($telefone1);
$cliente->setTelefone2($telefone2);
$cliente->setCelular($celular);
$cliente->setNumbeneficio('NULL');
$cliente->setNit('NULL');
$cliente->setObservacao('NULL');
$cliente->setDatacadastro('NOW()');
$cliente->setDatabaixa('NULL');
$cliente->setSituacao('TRUE');

$cliente->save();

}

echo 'Sucesso! Arquivos gravados';
?>
</BODY>
</HTML>