<?php
/**
* Mapeamento das tabelas do sistema
*/

/**
* Download
******************************************************************/

$tabelaMap['download'] = 'download';

$camposMap['download'] = array('id',
						       'titulo',
							   'url'
						       );
								  
$aliasMap['download']  = array('identifica��o',
                               't�tulo',
							   'url arquivo'
						       );
							 
$hideMap['download']   = array(0);
								 
$nomeTab['download']   = "Downloads";

/**
* Empresa
******************************************************************/

$tabelaMap['empresa'] = 'empresa';

$camposMap['empresa'] = array('id',
						      'nome',
							  'descricao',
							  'logo',
							  'foto1',
							  'foto2',
							  'foto3',
							  'foto4',
							  'foto5',
							  'foto6'
						      );
								  
$aliasMap['empresa']  = array('identifica��o',
                              'nome',
							  'descri��o',
							  'logotipo',
							  'foto 1',
							  'foto 2',
							  'foto 3',
							  'foto 4',
							  'foto 5',
							  'foto 6'
						      );
							 
$hideMap['empresa']   = array(0);
								 
$nomeTab['empresa']   = "Empresas";

/**
* Evento
******************************************************************/

$tabelaMap['evento'] = 'evento';

$camposMap['evento'] = array('id',
						     'titulo',
							 'descricao',
							 'data',
							 'foto1',
							 'foto2',
							 'foto3',
							 'foto4',
							 'foto5',
							 'foto6',
							 'foto7',
							 'foto8',
						     );
								  
$aliasMap['evento']  = array('identifica��o',
                             't�tulo',
							 'descri��o',
							 'data',
							 'foto 1',
							 'foto 2',
							 'foto 3',
							 'foto 4',
							 'foto 5',
							 'foto 6',
							 'foto 7',
							 'foto 8'
						     );
							 
$hideMap['evento']   = array(0);
								 
$nomeTab['evento']   = "Eventos";

/**
* Link
******************************************************************/

$tabelaMap['link'] = 'link';

$camposMap['link'] = array('id',
						   'titulo',
						   'link',
						   'descricao'
						   );
						   
$aliasMap['link']  = array('identifica��o',
                           't�tulo',
						   'url do link',
					       'descri��o'
						   );
						  
$hideMap['link']   = array(0);
						  
$nomeTab['link']   = "Links";

/**
* Noticia
******************************************************************/

$tabelaMap['noticia'] = 'noticia';

$camposMap['noticia'] = array('id',
						      'titulo',
							  'descricao',
							  'data',
							  'foto'
						      );
								  
$aliasMap['noticia']  = array('identifica��o',
                              't�tulo',
						      'descricao',
							  'data',
							  'foto'
						      );
							 
$hideMap['noticia']   = array(0);
								 
$nomeTab['noticia']   = "Noticias";

/**
* Parceiro
******************************************************************/

$tabelaMap['parceiro'] = 'parceiro';

$camposMap['parceiro'] = array('id',
						       'foto',
							   'nome',
							   'link',
						       );
								  
$aliasMap['parceiro']  = array('identifica��o',
                               'foto',
						       'nome',
							   'link',
						       );
							 
$hideMap['parceiro']   = array(0);
								 
$nomeTab['parceiro']   = "Parceiros";
?>