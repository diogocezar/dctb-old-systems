<?php
/**
* Mapeamento das tabelas do sistema
*/

/**
* Avalia��o
******************************************************************/
$tabelaMap['avaliacao'] = 'avaliacao';

$camposMap['avaliacao'] = array('id',
								'pg',
						        'total',
						        'votantes'
						        );
								
$aliasMap['avaliacao'] = array('Identifica��o',
							   'P�gina',
                               'Total de votos',
							   'Votantes'
							   );
/**
* Coment�rios
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
								  
$aliasMap['comentarios'] = array('Identifica��o',
								 'P�gina',
                                 'Nome',
							     'Email',
								 'Web Site',
								 'Coment�rio',
								 'Quando'
							     );
/**
* Not�ciasRSS
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
								  
$aliasMap['noticiasrss'] = array('Identifica��o',
                                 'Identifica��o do Pai',
							     'Ordem de Amostragem',
								 'Nome',
								 'Link do Rss',
								 'Conte�do (XML)',
								 'Quantidade de Not�cias',
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
							
$aliasMap['admin'] = array('Identifica��o',
                           'Nome',
						   'Login',
						   'Senha',
						   'Email'
						   );
?>