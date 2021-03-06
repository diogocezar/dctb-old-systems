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
								
$aliasMap['feromonio'] = array('identificação',
                               'identificação da página de origem',
							   'identificação da página de destino',
							   'identificação do grupo',
							   'quantidade de feromônio'
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
							 
$aliasMap['pagina'] = array('identificação',
                            'último acesso',
							'url da página',
							'número de visitas',
							);
							 
/**
* Grupo
******************************************************************/

$tabelaMap['grupo'] = 'grupo';

$camposMap['grupo'] = array('id',
						    'cont',
						    'nome'
						    );
							
$aliasMap['grupo'] = array('identificação',
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
						            'taxa de acrécimo de feromônio',
						            'taxa de evaporação',
						            'divisor'
						            );
?>