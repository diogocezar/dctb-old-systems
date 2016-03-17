<?php
/**
* Mapeamento das tabelas do sistema
*/

/**
* Contato
******************************************************************/

$tabelaMap['contato'] = 'contato';

$camposMap['contato'] = array('idcontato',
						      'idpessoa',
							  'nome',
							  'email',
							  'msn',
							  'skype',
							  'fone',
							  'fax',
							  'celular',
							  'ramal',
							  'departamento',
							  'situacao',
							  'databaixa'
						      );
							  
$aliasMap['contato'] = array('identificaзгo',
                             'identificaзгo da pessoa',
							 'nome',
							 'email',
							 'msn',
							 'skype',
							 'fone',
							 'fax',
							 'celular',
							 'ramal',
							 'departamento',
							 'situacao do contato',
							 'data da baixa no sistema'                          
						     );
							 
$hideMap['contato'] = array(0,1,11,12); 
							 
$nomeTab['contato'] = "Contato";

/**
* Parcela
******************************************************************/

$tabelaMap['parcela'] = 'parcela';

$camposMap['parcela'] = array('idparcela',
						      'idconta',
						      'valor',
						      'datavencimento',
							  'datapagamento',
							  'situacao',
							  'databaixa'
						      );
								  
$aliasMap['parcela'] = array('identificaзгo',
                             'identificaзгo da conta',
							 'valor da parcela',
							 'data do vencimento da parcela',
						     'data do pagamento',
						     'situaзгo da parcela',
							 'data da baixa da parcela'
						     );
							 
$hideMap['parcela'] = array(0,1,5,6); 
								 
$nomeTab['parcela'] = "Parcelas das contas";

/**
* Conta
******************************************************************/

$tabelaMap['conta'] = 'conta';

$camposMap['conta'] = array('idconta',
						    'idusuario',
						    'idusuariobaixa',
						    'idtipodocumento',
							'idperiodicidade',
							'idbanco',
							'idpessoa',
							'documento',
							'datacadastro',
							'descricao',
							'numparcelas',
							'valortotal',
							'tipoconta',
							'situacao',
							'databaixa'
						     );
							 
$aliasMap['conta'] = array('identificaзгo',
						   'identificaзгo do usuбrio',
						   'identificaзгo do usuбrio que baixou a conta',
					       'identificaзгo do tipo de documento',
						   'identificaзгo da periodicidade',
						   'identificaзгo do banco',
						   'identificaзгo da pessoa',
						   'documento',
						   'data do cadastro',
						   'descricao',
						   'nъmero de parcelas',
						   'valor total',
						   'tipo da conta',
						   'situaзгo da conta',
						   'data da baixa da conta'
						   );
						   
$hideMap['conta'] = array(0,1,2,3,4,5,6,13,14); 
							
$nomeTab['conta'] = "Conta";

/**
* Usuбrio
******************************************************************/

$tabelaMap['usuario'] = 'usuario';

$camposMap['usuario'] = array('idusuario',
							  'idnivel',
						      'nome',
						      'login',
						      'senha',
							  'situacao',
							  'databaixa'						   
						      );
						   
$aliasMap['usuario'] = array('identificaзгo',
                             'identificaзгo do nнvel',
						     'nome',
					         'login',
							 'senha',
							 'situaзгo do usuбrio',
							 'data da baixa do usuбrio'
						     );
							 
$hideMap['usuario'] = array(0,1,4,5,6); 
						  
$nomeTab['usuario'] = "Usuбrio";

/**
* Nнvel
******************************************************************/

$tabelaMap['nivel'] = 'nivel';

$camposMap['nivel'] = array('idnivel',
						    'descricao',
							'situacao',
							'databaixa'						   
						    );
								  
$aliasMap['nivel'] = array('identificaзгo',
						   'descricao',
						   'situaзгo do nнvel',
						   'data da baixa do nнvel'
						   );
						   
$hideMap['nivel'] = array(0,2,3); 
								 
$nomeTab['nivel'] = "Nнvel";

/**
* Tipo de documento
******************************************************************/

$tabelaMap['tipodocumento'] = 'tipodocumento';

$camposMap['tipodocumento'] = array('idtipodocumento',
							        'descricao',
								    'situacao',
							        'databaixa'						   
						            );
								  
$aliasMap['tipodocumento'] = array('identificaзгo',
							       'descriзгo',
								   'situaзгo do tipo de documento',
								   'data da baixa do tipo de documento'
						           );
								   
$hideMap['tipodocumento'] = array(0,2,3); 
								 
$nomeTab['tipodocumento'] = "Tipo de documento";

/**
* Periodicidade
******************************************************************/

$tabelaMap['periodicidade'] = 'periodicidade';

$camposMap['periodicidade'] = array('idperiodicidade',
							        'descricao',
									'qtdnumerico',
									'tipoperiodo',
								    'situacao',
							        'databaixa'						   									
						            );
								  
$aliasMap['periodicidade'] = array('identificaзгo',
							       'descriзгo',
								   'quantidade numйrica',
								   'tipo do perнodo',
								   'situaзгo da periodicidade',
								   'data da baixa da periodicidade'
						           );
								  
$hideMap['periodicidade'] = array(0,4,5); 
								 
$nomeTab['periodicidade'] = "Periodicidade";

/**
* Banco
******************************************************************/

$tabelaMap['banco'] = 'banco';

$camposMap['banco'] = array('idbanco',
							'descricao',
						    'situacao',
							'databaixa'						   									
						    );
								  
$aliasMap['banco'] = array('identificaзгo',
						   'descriзгo',
						   'situaзгo do banco',
						   'data da baixa do banco'
						   );
						   
$hideMap['banco'] = array(0,2,3);
								 
$nomeTab['banco'] = "Banco";

/**
* Pessoa
******************************************************************/

$tabelaMap['pessoa'] = 'pessoa';

$camposMap['pessoa'] = array('idpessoa',
						     'idpessoajuridica',
							 'idpessoafisica',
							 'endereco',
							 'bairro',
							 'cidade',
							 'uf',
							 'cep',
							 'fone',
							 'fax',
							 'site',
							 'obs',
							 'compraminima',
							 'situacao',
							 'databaixa'
						     );
								  
$aliasMap['pessoa'] = array('identificaзгo',
						    'identificaзгo pessoa jurнdica',
							'identificaзгo pessoa fнsica',
							'endereco',
							'bairro',
							'cidade',
							'uf',
							'cep',
							'fone',
							'fax',
							'site',
							'obs',
							'compra mнnima',
							'situacao da pessoa',
							'data da baixa da pessoa'
						    );
							
$hideMap['pessoa'] = array(0,1,2,13,14);
								 
$nomeTab['pessoa'] = "Pessoa";

/**
* Pessoa jurнdica
******************************************************************/

$tabelaMap['pessoajuridica'] = 'pessoajuridica';

$camposMap['pessoajuridica'] = array('idpessoajuridica',
						             'cnpj',
							         'inscricaoestadual',
							         'inscricaomunicipal',
									 'razaosocial',
									 'nomefantasia'
						             );
								  
$aliasMap['pessoajuridica'] = array('identificaзгo',
                                    'cnpj',
						            'inscriзгo estadual',
							        'inscriзгo municipal',
									'razгo social',
									'nome fantasia'
						            );
									
$hideMap['pessoajuridica'] = array(0);
								 
$nomeTab['pessoajuridica'] = "Pessoa jurнdica";

/**
* Pessoa fнsica
******************************************************************/

$tabelaMap['pessoafisica'] = 'pessoafisica';

$camposMap['pessoafisica'] = array('idpessoafisica',
						           'cpf',
							       'rg',
							       'nome',
								   'sobrenome'
						           );
								  
$aliasMap['pessoafisica'] = array('identificaзгo',
						          'cpf',
							      'rg',
							      'nome',
								  'sobrenome'
						           );
								   
$hideMap['pessoafisica'] = array(0);
								 
$nomeTab['pessoafisica'] = "Pessoa fнsica";
?>