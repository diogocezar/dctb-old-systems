<?php
/**
* Mapeamento das tabelas do sistema
*/

/**
* Usuбrio
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
						   
$aliasMap['usuario'] = array('identificaзгo',
                             'identificaзгo do nнvel',
						     'nome',
					         'login',
							 'senha',
							 'data cadastro',
							 'data baixa',
							 'situaзгo do usuбrio'
						     );
							 
$hideMap['usuario'] = array(0,1,4,5,6,7); 
						  
$nomeTab['usuario'] = "Usuбrio";

/**
* Nнvel
******************************************************************/

$tabelaMap['nivel'] = 'nivel';

$camposMap['nivel'] = array('idnivel',
						    'descricao',
							'datacadastro',
							'databaixa',
							'situacao'													   
						    );
								  
$aliasMap['nivel'] = array('identificaзгo',
						   'descriзгo',
						   'data cadastro',
						   'data baixa',
						   'situaзгo do nнvel'
						   );
						   
$hideMap['nivel'] = array(0,2,3,4); 
								 
$nomeTab['nivel'] = "Nнvel";

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
						   
$aliasMap['cliente'] = array('identificaзгo',
                             'identificaзгo do grupo',
							 'identificaзгo do usuбrio',
						     'nome',
							 'data de nascimento',
							 'bairro',
							 'cidade',
							 'endereзo',
							 'cep',
							 'estado',
							 'telefone1',
							 'telefone2',
							 'celular',
							 'nъmero de beneficio',
							 'nit',
							 'observaзгo',
						     'data cadastro',
						     'data baixa',
						     'situaзгo do cliente'
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
								  
$aliasMap['grupo'] = array('identificaзгo',
						   'descriзгo',
						   'data cadastro',
						   'data baixa',
						   'situaзгo do grupo'
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
								  
$aliasMap['tipo'] = array('identificaзгo',
						  'descriзгo',
						  'data cadastro',
						  'data baixa',
						  'situaзгo do tipo'
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
						   
$aliasMap['agenda'] = array('identificaзгo',
							'identificaзгo do tipo',
                            'identificaзгo do cliente',
							'identificaзгo do usuбrio',
						    'data da solicitaзгo',
							'data agendada',
							'hora agendada',
							'descriзгo',
						    'data cadastro',
						    'data baixa',
						    'situaзгo da agenda'
						    );
							 
$hideMap['agenda'] = array(0,1,2,3,8,9,10); 
						  
$nomeTab['agenda'] = "Agenda";


?>