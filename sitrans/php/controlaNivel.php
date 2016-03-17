<?php
/* extraindo nível do usuário */
$session   = $controlador['session'];
$sessNivel = $session->retornaSession('sessNivel', false);

$objNivel = $controlador['nivel'];
$objNivel->__toFillGeneric();
$objNivel->__get_db($sessNivel);
$descricaoNivel = $objNivel->getDescricao();

switch($sessNivel){
	case 1:
	case 2:
	case 3:
		$nivel['id']        = $sessNivel;
		$nivel['nome']      = $descricaoNivel;
		$nivel['permissao'] = array('veiculo'       => true,
		                            'status'        => true,
									'gerenciar'     => true,
									'roteirizar'    => true,
									'excluirColeta' => true,
									);
	break;

	case 4:
		$nivel['id']        = $sessNivel;
		$nivel['nome']      = $descricaoNivel;
		$nivel['permissao'] = array('veiculo'       => false,
		                            'status'        => false,
									'gerenciar'     => array('status' => 'cadastrado'),
									'roteirizar'    => false,
									'excluirColeta' => false,
									);
	break;
}
?>