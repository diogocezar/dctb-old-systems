<?php
/**
* Mapeamento das tabelas do sistema
*/

/**
* Usuбrio
******************************************************************/

$tabelaMap['usuario'] = 'usuario';

$camposMap['usuario'] = array('id_usuario',
							  'nome',
						      'telefone',
							  'data_cadastro',
							  'data_baixa',
							  'situacao'					  						   
						      );
						   
$aliasMap['usuario'] = array('identificaзгo',
						     'nome',
					         'telefone',
							 'data cadastro',
							 'data baixa',
							 'situaзгo'
						     );
							 
$hideMap['usuario'] = array(0,3,4,5); 
						  
$nomeTab['usuario'] = "Usuбrio";

/**
* Tipo do Нtem no Acervo
******************************************************************/

$tabelaMap['tipoacervo'] = 'tipo_acervo';

$camposMap['tipoacervo'] = array('id_tipo_acervo',
						         'nome',
							     'data_cadastro',
							     'data_baixa',
							     'situacao'	
							     );
								  
$aliasMap['tipoacervo'] = array('identificaзгo',
						        'nome',
						        'data cadastro',
						        'data baixa',
						        'situaзгo'
						        );
						   
$hideMap['tipoacervo'] = array(0,2,3,4); 
								 
$nomeTab['tipoacervo'] = "Tipo do Нtem no Acervo";

/**
* Locaзгo
******************************************************************/

$tabelaMap['locacao'] = 'locacao';

$camposMap['locacao'] = array('id_locacao',
							  'id_usuario',
							  'id_administrador',
						      'data_locacao',
						      'data_devolucao',
							  'data_devolvido',
							  'status',
							  'data_cadastro',
							  'data_baixa',
							  'situacao'	
						      );
						   
$aliasMap['locacao'] = array('identificaзгo',
                             'identificaзгo do usuбrio',
							 'identificaзгo do administrador',
							 'data da locaзгo',
						     'data da devolucao',
							 'data em que foi devolvido',
							 'status da locaзгo',
						     'data cadastro',
						     'data baixa',
						     'situaзгo'
						     );
							 
$hideMap['locacao'] = array(0,1,2,7,8,9); 
						  
$nomeTab['locacao'] = "Locaзгo";

/**
* Administrador
******************************************************************/

$tabelaMap['administrador'] = 'administrador';

$camposMap['administrador'] = array('id_administrador',
						    	    'nome',
									'login',
									'senha',
							        'data_cadastro',
							        'data_baixa',
							        'situacao'	
						            );
								  
$aliasMap['administrador'] = array('identificaзгo',
						           'nome',
						           'login',
						           'senha',
						           'data cadastro',
						           'data baixa',
						           'situaзгo'
						           );
						   
$hideMap['administrador'] = array(0,3,4,5,6); 
								 
$nomeTab['administrador'] = "Administrador";

/**
* Acervo_Locaзгo N - N
******************************************************************/

$tabelaMap['acervolocacao'] = 'NPN_acervo_locacao';

$camposMap['acervolocacao'] = array('id_locacao',
						            'id_acervo',
							        'data_cadastro',
							        'data_baixa',
							        'situacao'	
						            );
								  
$aliasMap['acervolocacao'] = array('identificaзгo do acervo',
						           'identificaзгo da locaзгo',
						           'data cadastro',
						           'data baixa',
						           'situaзгo'
						           );
						   
$hideMap['acervolocacao'] = array(0,1,2,3,4,5); 
								 
$nomeTab['acervolocacao'] = "Acervo_Locaзгo";

/**
* Acervo
******************************************************************/

$tabelaMap['acervo'] = 'acervo';

$camposMap['acervo'] = array('id_acervo',
							 'id_tipo_acervo',
							 'id_autor',
							 'id_editora',
							 'numero',
							 'volume',
						     'titulo',
							 'qtd_volumes',
							 'status',
							 'data_cadastro',
							 'data_baixa',
							 'situacao'	
						     );
						   
$aliasMap['acervo'] = array('identificaзгo do acervo',
                            'identificaзгo do tipo de acervo',
							'identificaзгo do autor',
							'identificaзгo da editora',
							'numero',
							'volume',
							'tнtulo',
							'qtd. volumes',
							'status',
						    'data cadastro',
						    'data baixa',
						    'situaзгo'
						    );
							 
$hideMap['acervo'] = array(0,1,2,3,9,10,11); 
						  
$nomeTab['acervo'] = "Acervo";

/**
* Autor
******************************************************************/

$tabelaMap['autor'] = 'autor';

$camposMap['autor'] = array('id_autor',
							'nome',
							'data_cadastro',
							'data_baixa',
							'situacao'	
						    );
						   
$aliasMap['autor'] = array('identificaзгo',
						   'nome',
						   'data cadastro',
						   'data baixa',
						   'situaзгo'
						   );
							 
$hideMap['autor'] = array(0,2,3,4); 
						  
$nomeTab['autor'] = "Autor";

/**
* Editora
******************************************************************/

$tabelaMap['editora'] = 'editora';

$camposMap['editora'] = array('id_editora',
							  'nome',
							  'data_cadastro',
							  'data_baixa',
							  'situacao'	
						      );
						   
$aliasMap['editora'] = array('identificaзгo',
						     'nome',
						     'data cadastro',
						     'data baixa',
						     'situaзгo'
						     );
							 
$hideMap['editora'] = array(0,2,3,4); 
						  
$nomeTab['editora'] = "Editora";
?>