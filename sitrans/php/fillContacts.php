<?php
set_time_limit(0);
/**
* arquivo de configuração
*/
include("../conf/config.php");

/**
* cerebro do sistema
*/
include("../cerebro/includeCerebro.php");

$contato = $controlador['contato'];
$contato->__toFillGeneric();
$resultado = $contato->rows(false, false, 0, 'ASC', false);
while($dados = $resultado->fetchRow(DB_FETCHMODE_ASSOC)){
	$contato->__get_db($dados['idcontato']);
	$nome  = $contato->getNome();
	$id    = $contato->getId();
	$login = $nome.$id;
	$senha = substr(md5(date('i:s:u')), 0, 6);

	$contato->setLogin($login);
	$contato->setSenha($senha);
	$contato->setDatacadastro('NOW()');
	$contato->setDatabaixa   ('NULL');
	
	$contato->update();
	
	echo "Atualizado a senha de $nome; Login: <b>$login</b> / Senha <b>$senha</b> <br><br>";
	
	sleep(1);
}
?>