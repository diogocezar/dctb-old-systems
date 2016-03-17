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
* Pessoa
******************************************************************/

$tabelaMap['pessoa'] = 'pessoa';

$camposMap['pessoa'] = array('idpessoa',
							 'rua',
							 'numero',
							 'complemento',
							 'bairro',
							 'cep',
							 'cidade',
							 'estado',
							 'telefone',
							 'fax',
							 'email'
						     );
								  
$aliasMap['pessoa'] = array('identifica��o',
							'rua',
							'n�mero',
							'complemento',
							'bairro',
							'cep',
							'cidade',
							'estado',
							'telefone',
							'fax',
							'email',
						    );
							
$hideMap['pessoa'] = array(0);
								 
$nomeTab['pessoa'] = "Pessoa";

/**
* Fornecedor
******************************************************************/

$tabelaMap['fornecedor'] = 'fornecedor';

$camposMap['fornecedor'] = array('idfornecedor',
							     'idpessoa',
							     'inscestadual',
							     'cnpj',
								 'nomefantasia',
							     'razaosocial',
								 'datacadastro',
								 'databaixa',
								 'situacao'
						         );
								  
$aliasMap['fornecedor'] = array('identifica��o',
						        'identifica��o da pessoa',
							    'inscri��o estadual',
							    'cnpj',
								'nome fantasia',
							    'raz�o social',
								'data cadastro',
								'data baixa',
								'situacao'
						        );
							
$hideMap['fornecedor'] = array(0,1,2,6,7,8);
								 
$nomeTab['fornecedor'] = "Fornecedor";

/**
* Cliente
******************************************************************/

$tabelaMap['cliente'] = 'cliente';

$camposMap['cliente'] = array('idcliente',
							  'idpessoa',
							  'idfrequenciacoleta',
							  'nome',
							  'cnpjcpf',
							  'inscestadualrg',
							  'datacadastro',
							  'databaixa',
							  'situacao'
						      );
								  
$aliasMap['cliente'] = array('identifica��o',
						     'identifica��o da pessoa',
							 'identifica��o da coleta',
							 'nome',
							 'cnpj / cpf',
							 'inscri��o estadual / rg',
							 'data cadastro',
							 'data baixa',
							 'situacao'
						        );
							
$hideMap['cliente'] = array(0,1,2,6,7,8);
								 
$nomeTab['cliente'] = "Cliente";

/**
* Freq�encia Coleta
******************************************************************/

$tabelaMap['frequenciacoleta'] = 'frequenciacoleta';

$camposMap['frequenciacoleta'] = array('idfrequenciacoleta',
							           'descricao',
									   'qtdadedias',
							           'datacadastro',
							           'databaixa',
							           'situacao'
						               );
								  
$aliasMap['frequenciacoleta'] = array('identifica��o',
									  'descri��o',
									  'quantidade de dias',
									  'data cadastro',
									  'data baixa',
									  'situacao'
						              );
							
$hideMap['frequenciacoleta'] = array(0,3,4,5);
								 
$nomeTab['frequenciacoleta'] = "Frequ�ncia de Coleta";

/**
* Contato
******************************************************************/

$tabelaMap['contato'] = 'contato';

$camposMap['contato'] = array('idcontato',
						      'idpessoa',
							  'nome',
							  'funcao',
							  'telefone',
							  'celular',
							  'ramal',
							  'email',
							  'datacadastro',
							  'databaixa',
							  'situacao',
							  'login',
							  'senha'
						      );
							  
$aliasMap['contato'] = array('identifica��o',
                             'identifica��o da pessoa',
							 'nome',
							 'fun��o',
							 'telefone',
							 'celular',
							 'ramal',
							 'email',
							 'data cadastro',
							 'data baixa',
							 'situacao',
							 'login',
							 'senha'
						     );
							 
$hideMap['contato'] = array(0,1,8,9,10,11,12); 
							 
$nomeTab['contato'] = "Contato";

/**
* Ve�culo
******************************************************************/

$tabelaMap['veiculo'] = 'veiculo';

$camposMap['veiculo'] = array('idveiculo',
						      'idcategoria',
							  'idagregado',
							  'placa',
							  'marca',
							  'modelo',
							  'prefixo',
							  'datacadastro',
							  'databaixa',
							  'situacao'
						      );
							  
$aliasMap['veiculo'] = array('identifica��o',
                             'identifica��o da categoria',
							 'identifica��o do agregado',
							 'placa',
							 'marca',
							 'modelo',
							 'prefixo',
							 'data cadastro',
							 'data baixa',
							 'situacao'
						     );
							 
$hideMap['veiculo'] = array(0,1,2,7,8,9); 
							 
$nomeTab['veiculo'] = "Ve�culo";

/**
* Categoria
******************************************************************/

$tabelaMap['categoria'] = 'categoria';

$camposMap['categoria'] = array('idcategoria',
						        'descricao',
							    'datacadastro',
							    'databaixa',
							    'situacao'
						        );
							  
$aliasMap['categoria'] = array('identifica��o',
							   'descri��o',
							   'data cadastro',
							   'data baixa',
							   'situacao'
						       );
							 
$hideMap['categoria'] = array(0,2,3,4); 
							 
$nomeTab['categoria'] = "Categoria";

/**
* Agregado
******************************************************************/

$tabelaMap['agregado'] = 'agregado';

$camposMap['agregado'] = array('idagregado',
						       'idpessoa',
							   'nome',
							   'cnpjcpf',
							   'inscestadualrg',
							   'datacadastro',
							   'databaixa',
							   'situacao'
						       );
							  
$aliasMap['agregado'] = array('identifica��o',
							  'identifica��o da pessoa',
							  'nome',
							  'cnpj / cpf',
							  'inscri��o estadual / rg',
					  	      'data cadastro',
							  'data baixa',
							  'situacao'
						      );
							 
$hideMap['agregado'] = array(0,1,5,6,7); 
							 
$nomeTab['agregado'] = "agregado";

/**
* Motivo
******************************************************************/

$tabelaMap['motivo'] = 'motivo';

$camposMap['motivo'] = array('idmotivo',
						     'descricao',
							 'datacadastro',
							 'databaixa',
							 'situacao'
						     );
							  
$aliasMap['motivo'] = array('identifica��o',
							'descri��o',
							'data cadastro',
							'data baixa',
							'situacao'
						    );
							 
$hideMap['motivo'] = array(0,2,3,4); 
							 
$nomeTab['motivo'] = "Motivo";

/**
* Status
******************************************************************/

$tabelaMap['status'] = 'status';

$camposMap['status'] = array('idstatus',
						     'descricao',
							 'datacadastro',
							 'databaixa',
							 'situacao'
						     );
							  
$aliasMap['status'] = array('identifica��o',
							'descricao',
							'data cadastro',
							'data baixa',
							'situacao'
						    );
							 
$hideMap['status'] = array(0,2,3,4); 
							 
$nomeTab['status'] = "Status";

/**
* Coleta
******************************************************************/

$tabelaMap['coleta'] = 'coleta';

$camposMap['coleta'] = array('idcoleta',
						     'versao',
							 'codigo',
							 'idcliente',
							 'idcontato',
							 'idveiculo',
							 'idfornecedor',
							 'idusuario',
							 'idusuariobaixa',
							 'idstatus',
							 'idmotivo',
							 'idembalagem',
							 'idrestricao',
							 'data',
							 'hora',
							 'qtdadenotafiscal',
							 'qtdadevolumes',
							 'peso',	
							 'obscoleta',		 
							 'datacadastro',
							 'databaixa',
						     );
							  
$aliasMap['coleta'] = array('identifica��o',
						    'vers�o',
							'c�digo da coleta',
							'identifica��o do cliente',
							'identifica��o do contato',
							'identifica��o do ve�culo',
							'identifica��o do fornecedor',
							'identifica��o do usu�rio',
							'identifica��o do usu�rio que baixou coleta',
							'identifica��o do status',
							'identifica��o do motivo',
							'identifica��o da embalagem',
							'identifica��o da restri��o',
							'data',
							'hora',
							'quantidade nota fiscal',
							'quantidade volumes',
							'peso',	
							'observa��o da coleta',
							'data cadastro',
							'data baixa',
						    );
							 
$hideMap['coleta'] = array(0,1,3,4,5,6,7,8,9,10,11,12,18,19,20); 
							 
$nomeTab['coleta'] = "Coleta";

/**
* Embalagem
******************************************************************/

$tabelaMap['embalagem'] = 'embalagem';

$camposMap['embalagem'] = array('idembalagem',
						        'descricao',
							    'datacadastro',
							    'databaixa',
							    'situacao'
						        );
							  
$aliasMap['embalagem'] = array('identifica��o',
							   'descricao',
							   'data cadastro',
							   'data baixa',
							   'situacao'
						       );
							 
$hideMap['embalagem'] = array(0,2,3,4); 
							 
$nomeTab['embalagem'] = "Status";

/**
* Restri��o
******************************************************************/

$tabelaMap['restricao'] = 'restricao';

$camposMap['restricao'] = array('idrestricao',
						        'descricao',
							    'datacadastro',
							    'databaixa',
							    'situacao'
						        );
							  
$aliasMap['restricao'] = array('identifica��o',
							   'descricao',
							   'data cadastro',
							   'data baixa',
							   'situacao'
						       );
							 
$hideMap['restricao'] = array(0,2,3,4); 
							 
$nomeTab['restricao'] = "Restri��o";

/**
* Status Manifesto
******************************************************************/

$tabelaMap['statusmanifesto'] = 'statusmanifesto';

$camposMap['statusmanifesto'] = array('idstatusmanifesto',
						              'descricao',
							          'datacadastro',
							          'databaixa',
							          'situacao'
						              );
							  
$aliasMap['statusmanifesto'] = array('identifica��o',
							         'descricao',
							         'data cadastro',
							         'data baixa',
							         'situacao'
						             );
							 
$hideMap['statusmanifesto'] = array(0,2,3,4); 
							 
$nomeTab['statusmanifesto'] = "Status do Manifesto";

/**
* Manifesto
******************************************************************/

$tabelaMap['manifesto'] = 'manifesto';

$camposMap['manifesto'] = array('idmanifesto',
						        'idfornecedor',
							    'idstatusmanifesto',
								'codigo',
							    'cidade',
							    'numero',
								'horariochegada',
								'totalctrc',
								'totalvolumes',
								'totalpeso',
								'valortotalnotafiscal',
								'valortotalfrete',
								'datacadastro',
							    'databaixa',
							    'situacao'
						        );
							  
$aliasMap['manifesto'] = array('identifica��o',
							   'identifica��o do fornecedor',
							   'identifica��o do status',
							   'codigo',
							   'cidade',
							   'n�mero',
							   'hor�rio de chegada',
							   'total ctrc',
							   'total volumes',
							   'total peso',
							   'valor total n.f.',
							   'valor total frete',
							   'data cadastro',
							   'data baixa',
							   'situacao'
						       );
							 
$hideMap['manifesto'] = array(0,1,2,10,11,12); 
							 
$nomeTab['manifesto'] = "Manifesto";

/**
* Conhecimento
******************************************************************/

$tabelaMap['conhecimento'] = 'conhecimento';

$camposMap['conhecimento'] = array('idconhecimento',
						           'idmanifesto',
							       'numero',
								   'dataemissao',
								   'idstatusconhecimento',
								   'idclienteremetente',
								   'idclientedestinatario',
								   'peso',
								   'volumes',
								   'valornotafiscal',
								   'valorfrete',
								   'datacadastro',
							       'databaixa',
							       'situacao'
						           );
							  
$aliasMap['conhecimento'] = array('identifica��o',
							      'identifica��o do manifesto',
							      'n�mero',
							      'data de emiss�o',
								  'identifica��o do status do conhecimento',
							      'identifia��o do cliente remetenta',
							      'identifica��o do cliente destinatario',
							      'peso',
							      'volumes',
							      'valor da nota fiscal',
								  'valor do frete',
							      'data cadastro',
							      'data baixa',
							      'situacao'
						          );
							 
$hideMap['conhecimento'] = array(0,1,4,5,10,11,12,13); 
							 
$nomeTab['conhecimento'] = "Conhecimento";

/**
* Status Conhecimento 
******************************************************************/

$tabelaMap['statusconhecimento'] = 'statusconhecimento';

$camposMap['statusconhecimento'] = array('idstatusconhecimento',
						                 'descricao',
							             'datacadastro',
							             'databaixa',
							             'situacao'
						                 );
							  
$aliasMap['statusconhecimento'] = array('identifica��o',
							            'descricao',
							            'data cadastro',
							            'data baixa',
							            'situacao'
						                );
							 
$hideMap['statusconhecimento'] = array(0,2,3,4); 
							 
$nomeTab['statusconhecimento'] = "Status do Conhecimento";

/**
* Sa�da Manifesto 
******************************************************************/
$tabelaMap['saidamanifesto'] = 'saidamanifesto';

$camposMap['saidamanifesto'] = array('idsaidamanifesto',
						              'idveiculo',
									  'data',
									  'hora',
							          'datacadastro',
							          'databaixa',
							          'situacao'
						              );
							  
$aliasMap['saidamanifesto'] = array('identifica��o',
							         'identifica��o do ve�culo',
									 'data',
									 'hora',
							         'data cadastro',
							         'data baixa',
							         'situacao'
						             );
							 
$hideMap['saidamanifesto'] = array(0,1,4,5,6); 
							 
$nomeTab['saidamanifesto'] = "Sa�da Manifesto";

/**
* Entregas N - N
******************************************************************/
$tabelaMap['entregas'] = 'NPN_entregas';

$camposMap['entregas'] = array('idsaidamanifesto',
						       'idconhecimento',
							   'datacadastro',
							   'databaixa',
							   'situacao'
						       );
							  
$aliasMap['entregas'] = array('identifica��o sa�da manifesto',
							  'identifica��o do conhecimento',
							  'data cadastro',
							  'data baixa',
							  'situacao'
						      );
							 
$hideMap['entregas'] = array(0,1,2,3,4); 
							 
$nomeTab['entregas'] = "Entregas";

/**
* BaixaConhecimento
******************************************************************/
$tabelaMap['baixaconhecimento'] = 'baixaconhecimento';

$camposMap['baixaconhecimento'] = array('idbaixaconhecimento',
						                'idconhecimento',
										'nome',
									    'data',
									    'hora',
							            'datacadastro',
							            'databaixa',
							            'situacao'
						                );
							  
$aliasMap['baixaconhecimento'] = array('identifica��o',
							           'identifica��o do conhecimento',
									   'nome',
									   'data',
									   'hora',
							           'data cadastro',
							           'data baixa',
							           'situacao'
						               );
							 
$hideMap['baixaconhecimento'] = array(0,1,5,6,7); 
							 
$nomeTab['baixaconhecimento'] = "Baixa de Conhecimento";
?>