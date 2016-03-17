<?php
/**
* Mapeamento das tabelas do sistema
*/
							
/**
* Servicos
******************************************************************/

$tabelaMap['servico'] = 'servico';

$camposMap['servico'] = array('id',
						      'titulo',
							  'descricao'
						      );
							  
$aliasMap['servico'] = array('identificaчуo',
                             'titulo',
							 'descriчуo'                             
						     );
							 
$nomeTab['servico'] = "Serviчos";
							  
						   
/**
* Informacoes
******************************************************************/

$tabelaMap['informacoes'] = 'informacoes';

$camposMap['informacoes'] = array('historico',
						          'arte',
						          'servicos',
						          'links',
								  'dicas',
								  'trabalhos'
						          );
								  
$aliasMap['informacoes'] = array('informaчѕes sobre o histѓrico',
                                 'informaчѕes sobre a arte da luthieria',
							     'informaчѕes sobre os serviчos',
							     'informaчѕes sobre os links',
								 'informaчѕes sobre as dicas',
								 'informaчѕes sobre os trabalhos'
						         );
								 
$nomeTab['informacoes'] = "Informaчѕes do Site";

/**
* Equipe
******************************************************************/

$tabelaMap['equipe'] = 'equipe';

$camposMap['equipe'] = array('id',
						     'nome',
						     'email',
						     'apresentacao'
						     );
							 
$aliasMap['equipe'] = array('identificaчуo',
                            'nome',
							'e-mail',
							'apresentaчуo'
						    );
							
$nomeTab['equipe'] = "Luthier";

/**
* Links
******************************************************************/

$tabelaMap['link'] = 'link';

$camposMap['link'] = array('id',
						   'titulo',
						   'link',
						   'descricao'
						   );
						   
$aliasMap['link'] = array('identificaчуo',
                          'tэtulo',
						  'url do link',
					      'descriчуo'
						  );
						  
$nomeTab['link'] = "Link";
						   
/**
* Dicas
******************************************************************/

$tabelaMap['dica'] = 'dica';

$camposMap['dica'] = array('id',
						   'titulo',
						   'descricao'
						   );
								  
$aliasMap['dica'] = array('identificaчуo',
                          'tэtulo',
						  'descricao'
						  );
								 
$nomeTab['dica'] = "Dicas";

/**
* Trbalhos
******************************************************************/

$tabelaMap['trabalho'] = 'trabalho';

$camposMap['trabalho'] = array('id',
						       'titulo',
							   'foto',
							   'descricao',
						       );
								  
$aliasMap['trabalho'] = array('identificaчуo',
                              'tэtulo',
						      'url da foto anexada',
							  'descriчуo'
						      );
								 
$nomeTab['trabalho'] = "Trabalhos";

/**
* Noticias
******************************************************************/

$tabelaMap['noticia'] = 'noticia';

$camposMap['noticia'] = array('id',
						      'titulo',
							  'autor',
							  'descricao',
							  'data'
						      );
								  
$aliasMap['noticia'] = array('identificaчуo',
                             'tэtulo',
						     'descricao',
							 'autor',
							 'data'
						     );
								 
$nomeTab['noticia'] = "Noticias";

/**
* Depoimentos
******************************************************************/

$tabelaMap['depoimento'] = 'depoimento';

$camposMap['depoimento'] = array('id',
						         'nome',
							     'email',
							     'depoimento'
						         );
								  
$aliasMap['depoimento'] = array('identificaчуo',
                                'nome',
						        'e-mail',
							    'depoimento'
						        );
								 
$nomeTab['depoimento'] = "Depoimentos";


?>