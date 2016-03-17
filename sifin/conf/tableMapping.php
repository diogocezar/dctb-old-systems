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
							  
$aliasMap['contato'] = array('identifica��o',
                             'identifica��o da pessoa',
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
								  
$aliasMap['parcela'] = array('identifica��o',
                             'identifica��o da conta',
							 'valor da parcela',
							 'data do vencimento da parcela',
						     'data do pagamento',
						     'situa��o da parcela',
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
							 
$aliasMap['conta'] = array('identifica��o',
						   'identifica��o do usu�rio',
						   'identifica��o do usu�rio que baixou a conta',
					       'identifica��o do tipo de documento',
						   'identifica��o da periodicidade',
						   'identifica��o do banco',
						   'identifica��o da pessoa',
						   'documento',
						   'data do cadastro',
						   'descricao',
						   'n�mero de parcelas',
						   'valor total',
						   'tipo da conta',
						   'situa��o da conta',
						   'data da baixa da conta'
						   );
						   
$hideMap['conta'] = array(0,1,2,3,4,5,6,13,14); 
							
$nomeTab['conta'] = "Conta";

/**
* Usu�rio
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
						   
$aliasMap['usuario'] = array('identifica��o',
                             'identifica��o do n�vel',
						     'nome',
					         'login',
							 'senha',
							 'situa��o do usu�rio',
							 'data da baixa do usu�rio'
						     );
							 
$hideMap['usuario'] = array(0,1,4,5,6); 
						  
$nomeTab['usuario'] = "Usu�rio";

/**
* N�vel
******************************************************************/

$tabelaMap['nivel'] = 'nivel';

$camposMap['nivel'] = array('idnivel',
						    'descricao',
							'situacao',
							'databaixa'						   
						    );
								  
$aliasMap['nivel'] = array('identifica��o',
						   'descricao',
						   'situa��o do n�vel',
						   'data da baixa do n�vel'
						   );
						   
$hideMap['nivel'] = array(0,2,3); 
								 
$nomeTab['nivel'] = "N�vel";

/**
* Tipo de documento
******************************************************************/

$tabelaMap['tipodocumento'] = 'tipodocumento';

$camposMap['tipodocumento'] = array('idtipodocumento',
							        'descricao',
								    'situacao',
							        'databaixa'						   
						            );
								  
$aliasMap['tipodocumento'] = array('identifica��o',
							       'descri��o',
								   'situa��o do tipo de documento',
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
								  
$aliasMap['periodicidade'] = array('identifica��o',
							       'descri��o',
								   'quantidade num�rica',
								   'tipo do per�odo',
								   'situa��o da periodicidade',
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
								  
$aliasMap['banco'] = array('identifica��o',
						   'descri��o',
						   'situa��o do banco',
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
								  
$aliasMap['pessoa'] = array('identifica��o',
						    'identifica��o pessoa jur�dica',
							'identifica��o pessoa f�sica',
							'endereco',
							'bairro',
							'cidade',
							'uf',
							'cep',
							'fone',
							'fax',
							'site',
							'obs',
							'compra m�nima',
							'situacao da pessoa',
							'data da baixa da pessoa'
						    );
							
$hideMap['pessoa'] = array(0,1,2,13,14);
								 
$nomeTab['pessoa'] = "Pessoa";

/**
* Pessoa jur�dica
******************************************************************/

$tabelaMap['pessoajuridica'] = 'pessoajuridica';

$camposMap['pessoajuridica'] = array('idpessoajuridica',
						             'cnpj',
							         'inscricaoestadual',
							         'inscricaomunicipal',
									 'razaosocial',
									 'nomefantasia'
						             );
								  
$aliasMap['pessoajuridica'] = array('identifica��o',
                                    'cnpj',
						            'inscri��o estadual',
							        'inscri��o municipal',
									'raz�o social',
									'nome fantasia'
						            );
									
$hideMap['pessoajuridica'] = array(0);
								 
$nomeTab['pessoajuridica'] = "Pessoa jur�dica";

/**
* Pessoa f�sica
******************************************************************/

$tabelaMap['pessoafisica'] = 'pessoafisica';

$camposMap['pessoafisica'] = array('idpessoafisica',
						           'cpf',
							       'rg',
							       'nome',
								   'sobrenome'
						           );
								  
$aliasMap['pessoafisica'] = array('identifica��o',
						          'cpf',
							      'rg',
							      'nome',
								  'sobrenome'
						           );
								   
$hideMap['pessoafisica'] = array(0);
								 
$nomeTab['pessoafisica'] = "Pessoa f�sica";
?>