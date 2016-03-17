<?php
/**
* Mapeamento das tabelas do sistema
*/

/**
* Avaliação
******************************************************************/
$tabelaMap['avaliacao'] = 'avaliacao';

$camposMap['avaliacao'] = array('id',
								'pg',
						        'total',
						        'votantes'
						        );
								
$aliasMap['avaliacao'] = array('Identificação',
							   'Página',
                               'Total de votos',
							   'Votantes'
							   );
/**
* Comentários
******************************************************************/
$tabelaMap['comentarios'] = 'comentarios';

$camposMap['comentarios'] = array('id',
								  'pg',
						          'nome',
						          'email',
								  'url',
								  'comentario',
								  'timestamp'
						          );
								  
$aliasMap['comentarios'] = array('Identificação',
								 'Página',
                                 'Nome',
							     'Email',
								 'Web Site',
								 'Comentário',
								 'Quando'
							     );
/**
* NotíciasRSS
******************************************************************/
$tabelaMap['noticiasrss'] = 'noticiasrss';

$camposMap['noticiasrss'] = array('id',
						          'id_pai',
						          'ordem',
								  'nome',
								  'link',
								  'xml',
								  'qtd',
								  'quando'
						          );
								  
$aliasMap['noticiasrss'] = array('Identificação',
                                 'Identificação do Pai',
							     'Ordem de Amostragem',
								 'Nome',
								 'Link do Rss',
								 'Conteúdo (XML)',
								 'Quantidade de Notícias',
								 'Quando'
							     );
								 
/**
* Admin
******************************************************************/
$tabelaMap['admin'] = 'admin';

$camposMap['admin'] = array('id',
						    'nome',
						    'login',
							'senha',
							'email'
						    );
							
$aliasMap['admin'] = array('Identificação',
                           'Nome',
						   'Login',
						   'Senha',
						   'Email'
						   );
?>