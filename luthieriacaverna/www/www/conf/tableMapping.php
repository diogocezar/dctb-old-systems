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
							  
$aliasMap['servico'] = array('identificação',
                             'titulo',
							 'descrição'                             
						     );
							 
$nomeTab['servico'] = "Servico";
							  
						   
/**
* Informacoes
******************************************************************/

$tabelaMap['informacoes'] = 'informacoes';

$camposMap['informacoes'] = array('historico',
						          'equipe',
						          'servicos',
						          'links',
								  'dicas',
								  'trabalhos'
						          );
								  
$aliasMap['informacoes'] = array('informações sobre o histórico',
                                 'informações sobre a equipe',
							     'informações sobre os serviços',
							     'informações sobre os links',
								 'informações sobre as dicas',
								 'informações sobre os trabalhos'
						         );
								 
$nomeTab['informacoes'] = "Informações do Site";

/**
* Equipe
******************************************************************/

$tabelaMap['equipe'] = 'equipe';

$camposMap['equipe'] = array('id',
						     'nome',
						     'email',
						     'apresentacao'
						     );
							 
$aliasMap['equipe'] = array('identificação',
                            'nome',
							'e-mail',
							'apresentação'
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
						   
$aliasMap['link'] = array('identificação',
                          'título',
						  'url do link',
					      'descrição'
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
								  
$aliasMap['dica'] = array('identificação',
                          'título',
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
								  
$aliasMap['trabalho'] = array('identificação',
                              'título',
						      'url da foto anexada',
							  'descrição'
						      );
								 
$nomeTab['trabalho'] = "Trabalhos";

/**
* Noticias
******************************************************************/

$tabelaMap['noticia'] = 'noticia';

$camposMap['noticia'] = array('id',
						      'titulo',
							  'descricao',
							  'autor'
						      );
								  
$aliasMap['noticia'] = array('identificação',
                             'título',
						     'descricao',
							 'autor'
						     );
								 
$nomeTab['noticia'] = "Noticias";

?>