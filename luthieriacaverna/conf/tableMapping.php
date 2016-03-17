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
							  
$aliasMap['servico'] = array('identifica��o',
                             'titulo',
							 'descri��o'                             
						     );
							 
$nomeTab['servico'] = "Servi�os";
							  
						   
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
								  
$aliasMap['informacoes'] = array('informa��es sobre o hist�rico',
                                 'informa��es sobre a arte da luthieria',
							     'informa��es sobre os servi�os',
							     'informa��es sobre os links',
								 'informa��es sobre as dicas',
								 'informa��es sobre os trabalhos'
						         );
								 
$nomeTab['informacoes'] = "Informa��es do Site";

/**
* Equipe
******************************************************************/

$tabelaMap['equipe'] = 'equipe';

$camposMap['equipe'] = array('id',
						     'nome',
						     'email',
						     'apresentacao'
						     );
							 
$aliasMap['equipe'] = array('identifica��o',
                            'nome',
							'e-mail',
							'apresenta��o'
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
						   
$aliasMap['link'] = array('identifica��o',
                          't�tulo',
						  'url do link',
					      'descri��o'
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
								  
$aliasMap['dica'] = array('identifica��o',
                          't�tulo',
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
								  
$aliasMap['trabalho'] = array('identifica��o',
                              't�tulo',
						      'url da foto anexada',
							  'descri��o'
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
								  
$aliasMap['noticia'] = array('identifica��o',
                             't�tulo',
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
								  
$aliasMap['depoimento'] = array('identifica��o',
                                'nome',
						        'e-mail',
							    'depoimento'
						        );
								 
$nomeTab['depoimento'] = "Depoimentos";


?>