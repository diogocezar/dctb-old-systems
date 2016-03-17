<?php
/**
* Mapeamento das tabelas do sistema
*/

/**
* Usu�rio
******************************************************************/

$tabelaMap['usuario'] = 'usuario';

$camposMap['usuario'] = array('id_usuario',
							  'nome',
						      'telefone',
							  'data_cadastro',
							  'data_baixa',
							  'situacao'					  						   
						      );
						   
$aliasMap['usuario'] = array('identifica��o',
						     'nome',
					         'telefone',
							 'data cadastro',
							 'data baixa',
							 'situa��o'
						     );
							 
$hideMap['usuario'] = array(0,3,4,5); 
						  
$nomeTab['usuario'] = "Usu�rio";

/**
* Tipo do �tem no Acervo
******************************************************************/

$tabelaMap['tipoacervo'] = 'tipo_acervo';

$camposMap['tipoacervo'] = array('id_tipo_acervo',
						         'nome',
							     'data_cadastro',
							     'data_baixa',
							     'situacao'	
							     );
								  
$aliasMap['tipoacervo'] = array('identifica��o',
						        'nome',
						        'data cadastro',
						        'data baixa',
						        'situa��o'
						        );
						   
$hideMap['tipoacervo'] = array(0,2,3,4); 
								 
$nomeTab['tipoacervo'] = "Tipo do �tem no Acervo";

/**
* Loca��o
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
						   
$aliasMap['locacao'] = array('identifica��o',
                             'identifica��o do usu�rio',
							 'identifica��o do administrador',
							 'data da loca��o',
						     'data da devolucao',
							 'data em que foi devolvido',
							 'status da loca��o',
						     'data cadastro',
						     'data baixa',
						     'situa��o'
						     );
							 
$hideMap['locacao'] = array(0,1,2,7,8,9); 
						  
$nomeTab['locacao'] = "Loca��o";

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
								  
$aliasMap['administrador'] = array('identifica��o',
						           'nome',
						           'login',
						           'senha',
						           'data cadastro',
						           'data baixa',
						           'situa��o'
						           );
						   
$hideMap['administrador'] = array(0,3,4,5,6); 
								 
$nomeTab['administrador'] = "Administrador";

/**
* Acervo_Loca��o N - N
******************************************************************/

$tabelaMap['acervolocacao'] = 'NPN_acervo_locacao';

$camposMap['acervolocacao'] = array('id_locacao',
						            'id_acervo',
							        'data_cadastro',
							        'data_baixa',
							        'situacao'	
						            );
								  
$aliasMap['acervolocacao'] = array('identifica��o do acervo',
						           'identifica��o da loca��o',
						           'data cadastro',
						           'data baixa',
						           'situa��o'
						           );
						   
$hideMap['acervolocacao'] = array(0,1,2,3,4,5); 
								 
$nomeTab['acervolocacao'] = "Acervo_Loca��o";

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
						   
$aliasMap['acervo'] = array('identifica��o do acervo',
                            'identifica��o do tipo de acervo',
							'identifica��o do autor',
							'identifica��o da editora',
							'numero',
							'volume',
							't�tulo',
							'qtd. volumes',
							'status',
						    'data cadastro',
						    'data baixa',
						    'situa��o'
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
						   
$aliasMap['autor'] = array('identifica��o',
						   'nome',
						   'data cadastro',
						   'data baixa',
						   'situa��o'
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
						   
$aliasMap['editora'] = array('identifica��o',
						     'nome',
						     'data cadastro',
						     'data baixa',
						     'situa��o'
						     );
							 
$hideMap['editora'] = array(0,2,3,4); 
						  
$nomeTab['editora'] = "Editora";
?>