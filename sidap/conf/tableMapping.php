<?php
/**
* Mapeamento das tabelas do sistema
*/

/**
* Usu�rio
******************************************************************/

$tabelaMap['usuario'] = 'usuario';

$camposMap['usuario'] = array('idusuario',
							  'idnivel',
						      'nome',
						      'login',
						      'senha',
							  'datacadastro',
							  'databaixa',
							  'situacao'							  						   
						      );
						   
$aliasMap['usuario'] = array('identifica��o',
                             'identifica��o do n�vel',
						     'nome',
					         'login',
							 'senha',
							 'data cadastro',
							 'data baixa',
							 'situa��o do usu�rio'
						     );
							 
$hideMap['usuario'] = array(0,1,4,5,6,7); 
						  
$nomeTab['usuario'] = "Usu�rio";

/**
* N�vel
******************************************************************/

$tabelaMap['nivel'] = 'nivel';

$camposMap['nivel'] = array('idnivel',
						    'descricao',
							'datacadastro',
							'databaixa',
							'situacao'													   
						    );
								  
$aliasMap['nivel'] = array('identifica��o',
						   'descri��o',
						   'data cadastro',
						   'data baixa',
						   'situa��o do n�vel'
						   );
						   
$hideMap['nivel'] = array(0,2,3,4); 
								 
$nomeTab['nivel'] = "N�vel";

/**
* Cliente
******************************************************************/

$tabelaMap['cliente'] = 'cliente';

$camposMap['cliente'] = array('idcliente',
							  'idgrupo',
						      'idusuario',
						      'nome',
							  'datanascimento',
							  'bairro',
							  'cidade',
							  'endereco',
							  'cep',
							  'estado',
							  'telefone1',
							  'telefone2',
							  'celular',
							  'numbeneficio',
							  'nit',
							  'observacao',
							  'datacadastro',
							  'databaixa',
							  'situacao'						  						   
						      );
						   
$aliasMap['cliente'] = array('identifica��o',
                             'identifica��o do grupo',
							 'identifica��o do usu�rio',
						     'nome',
							 'data de nascimento',
							 'bairro',
							 'cidade',
							 'endere�o',
							 'cep',
							 'estado',
							 'telefone1',
							 'telefone2',
							 'celular',
							 'n�mero de beneficio',
							 'nit',
							 'observa��o',
						     'data cadastro',
						     'data baixa',
						     'situa��o do cliente'
						     );
							 
$hideMap['cliente'] = array(0,1,2,16,17,18); 
						  
$nomeTab['cliente'] = "Cliente";

/**
* Grupo
******************************************************************/

$tabelaMap['grupo'] = 'grupo';

$camposMap['grupo'] = array('idgrupo',
						    'descricao',
							'datacadastro',
							'databaixa',
							'situacao'													   
						    );
								  
$aliasMap['grupo'] = array('identifica��o',
						   'descri��o',
						   'data cadastro',
						   'data baixa',
						   'situa��o do grupo'
						   );
						   
$hideMap['grupo'] = array(0,2,3,4); 
								 
$nomeTab['grupo'] = "Grupo";

/**
* Tipo
******************************************************************/

$tabelaMap['tipo'] = 'tipo';

$camposMap['tipo'] = array('idtipo',
						   'descricao',
						   'datacadastro',
						   'databaixa',
						   'situacao'													   
						   );
								  
$aliasMap['tipo'] = array('identifica��o',
						  'descri��o',
						  'data cadastro',
						  'data baixa',
						  'situa��o do tipo'
						  );
						   
$hideMap['tipo'] = array(0,2,3,4); 
								 
$nomeTab['tipo'] = "Tipo";

/**
* Agenda
******************************************************************/

$tabelaMap['agenda'] = 'agenda';

$camposMap['agenda'] = array('idagenda',
							 'idtipo',
							 'idcliente',
						     'idusuario',
						     'datasolicitacao',
							 'dataagenda',
							 'horaagenda',
							 'descricao',
							 'datacadastro',
							 'databaixa',
							 'situacao'						  						   
						     );
						   
$aliasMap['agenda'] = array('identifica��o',
							'identifica��o do tipo',
                            'identifica��o do cliente',
							'identifica��o do usu�rio',
						    'data da solicita��o',
							'data agendada',
							'hora agendada',
							'descri��o',
						    'data cadastro',
						    'data baixa',
						    'situa��o da agenda'
						    );
							 
$hideMap['agenda'] = array(0,1,2,3,8,9,10); 
						  
$nomeTab['agenda'] = "Agenda";


?>