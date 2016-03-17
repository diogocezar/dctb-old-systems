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
								
$aliasMap['feromonio'] = array('identifica��o',
                               'identifica��o da p�gina de origem',
							   'identifica��o da p�gina de destino',
							   'identifica��o do grupo',
							   'quantidade de ferom�nio'
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
							 
$aliasMap['pagina'] = array('identifica��o',
                            '�ltimo acesso',
							'url da p�gina',
							'n�mero de visitas',
							);
							 
/**
* Grupo
******************************************************************/

$tabelaMap['grupo'] = 'grupo';

$camposMap['grupo'] = array('id',
						    'cont',
						    'nome'
						    );
							
$aliasMap['grupo'] = array('identifica��o',
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
						            'taxa de acr�cimo de ferom�nio',
						            'taxa de evapora��o',
						            'divisor'
						            );
?>