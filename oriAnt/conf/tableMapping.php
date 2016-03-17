<?php
/**
* Mapeamento das tabelas do sistema
*/



/**
* Feromonio
******************************************************************/

$tabelaMap['feromonio'] = 'feromonio';

$camposMap['feromonio'] = array('id',
						        'id_origem',
								'id_destino',
								'id_grupo',
								'qtd_feromonio'
						        );
								
$aliasMap['feromonio'] = array('identificaзгo',
                               'identificaзгo da pбgina de origem',
							   'identificaзгo da pбgina de destino',
							   'identificaзгo do grupo',
							   'quantidade de feromфnio'
							   );
								
/**
* Pagina
******************************************************************/

$tabelaMap['pagina'] = 'pagina';

$camposMap['pagina'] = array('id',
						     'ultimo_acesso',
							 'url',
							 'cont'
                             );
							 
$aliasMap['pagina'] = array('identificaзгo',
                            'ъltimo acesso',
							'url da pбgina',
							'nъmero de visitas',
							);
							 
/**
* Grupo
******************************************************************/

$tabelaMap['grupo'] = 'grupo';

$camposMap['grupo'] = array('id',
						    'cont',
						    'nome'
						    );
							
$aliasMap['grupo'] = array('identificaзгo',
                           'contador',
						   'nome do grupo'
						   );
							
/**
* ParametrosAdm
******************************************************************/

$tabelaMap['parametros_adm'] = 'parametrosadm';

$camposMap['parametros_adm'] = array('login',
						             'senha',
						             'acrescimo_feromonio',
									 'tx_evaporacao',
									 'div_diferenca' 
						             );
									 
$aliasMap['parametros_adm'] = array('login do administrador',
                                    'senha do administrador',
						            'taxa de acrйcimo de feromфnio',
						            'taxa de evaporaзгo',
						            'divisor'
						            );
?>