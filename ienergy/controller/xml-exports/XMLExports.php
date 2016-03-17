<?php
/** 
 * SpeceBrain
 *
 * Essa classe abstrata � respons�vel por realizar a exporta��o dos XML's correspondente a configura��es do sistema
 * This abstract class is responsible to do XML's exports corresponding to system configuration
 *
 * @author Diogo Cezar <diogo@diogocezar.com>
 * @version 2.0.1
 * @copyright Copyright � 2007-2009
 * @package xml-exports
 * @abstract
 */
 
abstract class XMLExports{
	
	/** 
	 * Atributo que ir� armazenar o objeto de manipula��o do do XML
	 * Attribute that will store the XML manipulation object 
	 * @name $xmlScanner
	 * @var Object
	 */
	private static $xmlScanner;
	
	/** 
	 * Atributo que ir� armazenar o array de op��es utilizado no objeto de manipula��o de XML
	 * Attribute that will store the options array used on XML manipulation object
	 * @name $xmlScanner
	 * @var Object
	 */
	private static $options;
	
	/** 
	 * M�todo que prepara as configura��es dos XML's a serem importados
	 * Method that prepares XML's configurations to be imported
	 * @access private
	 * @return Array
	 */
	private function preparesXMLExports($rootName){
		global $brain_controller;
		XMLExports::$xmlScanner = $brain_controller['xmlscanner'];
	    XMLExports::$options    = array('addDecl'        => TRUE,
										'encoding'       => 'ISO-8859-1',
										'indent'         => '  ',
										'rootName'       => $rootName,
										'rootAttributes' => array ('xmlns'    => 'http://www.w3.org/1999/xhtml',
											                       'lang'     => 'en',
											                       'xml:lang' => 'en'
																   ),
										 'addDoctype'    => TRUE,
										 'doctype'       => array ('id' => '-//W3C//DTD XHTML 1.0 Strict//EN',
											                       'uri' => 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'
															       )
	                                     ); 
	}
	
	/** 
	 * M�todo que exporta um XML
	 * Method that export a XML
	 * @access private
	 * @param String $rootName
	 * @param Array $array
	 * @param String $url
	 * @return Array
	 */
	private function doExport($rootName, $array, $url){
		XMLExports::preparesXMLExports($rootName);
		XMLExports::$xmlScanner->setFileName($url);
		XMLExports::$xmlScanner->setArray($array);
		XMLExports::$xmlScanner->setOptionsIn(XMLExports::$options);
		XMLExports::$xmlScanner->setPrintResult(false);
		XMLExports::$xmlScanner->saveArray();
	}
	
	/** 
	 * M�todo que retorna um array de r�tulos dos erros do sistema
	 * Method that return an array of label of system errors
	 * @access public
	 * @static
	 * @return Array
	 */
	public static function erro(){
		/* Array com indexadores para mensagens de erros do sistema */
		/* Array with indexs to system errors messages */
		$erro['CONNECT_TO_DATA'] = "N�o foi poss�vel conectar no banco de dados";
		$erro['QUERY_GERA_ERRO'] = "A senten�a escrita parece est� com erro";
		$erro['NENHUM_BANCO_SE'] = "Nenhum \"tipo\" de banco de dados foi selecionado";
		$erro['PARMS_INSUFICIE'] = "Par�metros insuficientes para conectar ao banco de dados";
		$erro['ERRO_NA_CONEX�O'] = "N�o foi poss�vel estabelecer uma conex�o com o banco de dados";
		$erro['ERRO_NA_SELEC�O'] = "N�o foi poss�vel selecionar o banco de dados indicado";
		$erro['INSERT_ERRO_CAM'] = "Houve um erro inserir um novo registro no banco de dados";
		$erro['DELETE_ERRO_CAM'] = "Houve um erro excluir dados da tabela";
		$erro['DELETE_UPDA_CAM'] = "Houve um erro atualizar dados da tabela";
		$erro['QUERY_ERRO_CAMP'] = "Houve um erro ao se executar uma instru��o sql";
		$erro['CRIPT_STR_CRIPT'] = "A string j� est� criptografada";
		$erro['CRIPT_STR_VAZIA'] = "A string est� vazia";
		$erro['CRIPT_STR_DESCR'] = "A string j� est� descriptografada";
		$erro['TEMPL_PARMS_VAZ'] = "Par�mtros necess�rios est�o em branco";
		$erro['TEMPL_TAG_REPLA'] = "N�mero de tags e replaces incompativel";
		$erro['E-MAIL_NOT_SEND'] = "Erro ao enviar o e-mail";
		$erro['TEMPLATE_NAO_EN'] = "O arquivo de template n�o foi encontrado";
		$erro['SESSION_NOT_ARR'] = "A sess�o passada como par�metro n�o � um array";
		$erro['INDI_OR_VALUE_E'] = "O �ndice ou valor da session est� em branco";
		$erro['SESSION_NOT_EXI'] = "N�o � possivel retornar o valor indexado pelo �ndice passo como par�metro";
		$erro['SE_INDICE_EMPTY'] = "O �ndice passado como par�metro est� vazio";
		$erro['INDI_OR_VALUE_C'] = "O �ndice ou valor da cookie est� em branco";
		$erro['COOKIE_NOT_ARRA'] = "A cookie passada como par�metro n�o � um array";
		$erro['DIRETORIO_INVAL'] = "O diret�rio passado n�o � v�lido";
		$erro['ARQUI_INCOMPLET'] = "O arquivo n�o est� completo, n�o foi poss�vel obter todas suas informa��es";
		$erro['EXT_ARQUIV_INVA'] = "A extens�o do arquivo enviado n�o � v�lida";
		$erro['TAMANHO_MAIOR_P'] = "O arquivo ultrapassou o tamanho limite para envio";
		$erro['LOCALIZA_INVALI'] = "A localiza��o enviada para montar a imagem n�o � v�lida";
		$erro['ALTU_LARG_VAZIA'] = "A largura e/ou altura da imagem est�(�o) vazia(s)";
		$erro['LIB_TO_GIF_INVA'] = "A biblioteca para tratamento de imagens no formato GIF n�o foi encontrada";
		$erro['LIB_TO_JPG_INVA'] = "A biblioteca para tratamento de imagens no formato JPG n�o foi encontrada";
		$erro['LIB_TO_PNG_INVA'] = "A biblioteca para tratamento de imagens no formato PNG n�o foi encontrada";
		$erro['INI_FILE_NOT_FI'] = "N�o foi poss�vel recuperar as informa��es do arquivo ini";
		$erro['CAMINHO_NOT_DEF'] = "O caminho para gerar o arquivo RSS n�o est� definido";
		$erro['CANAL_INSE_VAZI'] = "O canal inserido est� vazio";
		$erro['CANAL_JAH_INSER'] = "Um canal j� foi inserido";
		$erro['IMAGEM_ES_VAZIA'] = "A imagem inserida est� vazia";
		$erro['IMAGEM_JAH_INSE'] = "Uma imagem j� fopi inserida";
		$erro['ITEM_CAMPOS_VAZ'] = "O �tem inserido est� com seus campos vazios";
		$erro['ERRO_COUNT_REGS'] = "Houve um erro ao contar os registros de uma tabela";
		$erro['ERRO_G_MAX_REGS'] = "Houve um erro ao gerar o registro m�ximo de uma tabela";
		$erro['ERRO_GETIN_ROWS'] = "Houve um erro recuperar os dados de uma tabela";
		$erro['SALVANDO_XML_FI'] = "Houve um erro salvar um arquivo xml";
		$erro['EXTRAINDO_XML_F'] = "Houve um erro recuperar um arquivo xml";
		$erro['ERRO_AO_CARREGA'] = "Erro ao carregar imagem";
		$erro['GENERATING_TABL'] = "Houve um erro ao gerar din�micamente as tabelas do sistema";
		
		$rootName  = 'system_errors';
		$urlExport = '../core/conf/errors.xml';
		
		if(is_file($urlExport)){
			unlink($urlExport);
		}
		XMLExports::doExport($rootName, $erro, $urlExport);
	}//erro
	
	/** 
	 * M�todo que retorna um array de neur�nios ativos no sistema
	 * Method that return an array of actived neurons in system
	 * @access public 
	 * @static
	 * @return Array
	 */
	public static function actived_neuron(){
		/* Scaneando todos os neuronios */
		/* Scanning all neurons */
		$actived_neuron = array();
		$arrayNeurons = scandir('../core/neurons/');
		/* Removendo elementos "." e ".." */
		/* Removing elements "." and ".." */
		unset($arrayNeurons[0]);
		unset($arrayNeurons[1]);
		foreach($arrayNeurons as $item){
			$actived_neuron[$item] = "true";
		}
		/* Desabilitando alguns neur�nios manualmente */
		/* Disabling some neurons manually*/
		$actived_neuron['xml-scanner']  = "false";
		$actived_neuron['cookie']       = "false";
		$actived_neuron['cryptography'] = "false";
		$actived_neuron['freight']      = "false";
		$actived_neuron['imggen']       = "false";
		$actived_neuron['inifile']      = "false";
		$actived_neuron['pagination']   = "false";
		$actived_neuron['photo']        = "false";
		$actived_neuron['pikture']      = "false";
		$actived_neuron['rss']          = "false";
		$actived_neuron['sendfile']     = "false";
		$actived_neuron['sendmail']     = "false";
		$actived_neuron['session']      = "true";
		
		$rootName  = 'actived_neuron';
		$urlExport = '../core/conf/actived-neuron.xml';
		
		if(is_file($urlExport)){
			unlink($urlExport);
		}
		XMLExports::doExport($rootName, $actived_neuron, $urlExport);
	}//actived_neuron
	
	/** 
	 * M�todo que retorna um array de configura��es do sistema
	 * Method that return an array of system configurations
	 * @access public 
	 * @static
	 * @return Array
	 */
	public static function conf(){
		
		/* Banco de Dados / DataBase */
		$conf['data_base'] = array(
			'base_type' => "mysql",
			'base'      => "ienergydatabase",
			'host'      => "localhost",
			'user'      => "root",
			'pass'      => "",
			'path'      => ""
		);
		
		/* Template */
		$conf['template'] = array(
			'template_html_dir' => '../view/html/'
		);
		
		/* Files of Log */
		$conf['files'] = array(
			'log' => '../log/log.txt'					 
		);
		
		/* Site Info */
		$conf['info'] = array(
			'label'      => "Sistema iEnergy ".date(Y),
			'title'      => "iEnergy",
			'login_text' => "Caro Colaborador seja bem vindo(a)! <br><br> <p align=\"justify\">Visando uma melhoria no processo da empresa, estamos colocando no ar uma nova forma de controle, caso tenha alguma d�vida, por favor entre em contato conosco.</p><br> Att.<br> Ger�ncia.",
			'credits'    => "iEnergy ".date('Y')." ~ Equipe de desenvolvimento"
		);
		
		/* Cookies */
		$conf['cookies'] = array(
			'expire' => '3600',
			'path_cookie' => '/',
			'domain' => 'http://www.essesite.com.br',
			'secure' => 0
		);
		
		/* Envio de Arquivos / File Sends */
		$conf['upload_files'] = array(
			'limit_exts' => 'true',
			'allowed_extensions' => array('.doc', '.pdf', '.xls', '.docx', '.xlsx'),
			'mime_ext' => array('gif' => 'image/gif',
								'jpg' => 'image/pjpeg',
								'png' => 'image/x-png',
								'swf' => 'application/x-shockwave-flash',
								'zip' => 'application/x-zip-compressed',
								'rar' => 'application/x-rar-compressed'),
			'limit_size' => 'true',
			'max_size' => 50000000,
			'change_quality' => 'true',
			'quality_reduce' => 90
		);
		
		/* Gera��o de Fotos / Photos Generation */
		$conf['photo_generation'] = array(
			'height_mini' => 90,
			'width_mini' => 70,
			'height' => 400,
			'width' => 380
		);
		
		/* Gera��o de Frete / Freight Generation */
		$conf['freight'] = array(
			'root_freight' => '86300000',
			'time_limit' => '500'
		);
		
		$rootName  = 'system_configurations';
		$urlExport = '../core/conf/conf.xml';
		
		if(is_file($urlExport)){
			unlink($urlExport);
		}
		XMLExports::doExport($rootName, $conf, $urlExport);
	}//conf
	
	/** 
	 * M�todo que retorna um array de tabelas ativas no sistema
	 * Method that return an array of actived tables on system
	 * @access public 
	 * @static
	 * @return Array
	 */	
	public static function actived_tables(){
		global $conf;
		if(!empty($conf)){
			$data_base_type = $conf['data_base']['base_type'];
			
			switch($data_base_type){
				case 'mysql' :
				case 'mysqli':
					$sql = "SHOW TABLES";
				break;
				case 'pgsql':
					$sql = "SELECT relname FROM pg_stat_user_tables";
				break;		
			}
			
			$tables = Brain::$data_base->getCol($sql);
			if(DB::isError($actived_tables)){
				$this->erro($db->getMessage());		
			}
			
			sort($tables);
			
			foreach($tables as $table){
				$actived_tables[$table] = "true";	
			}
	
			$rootName  = 'actived_tables';
			$urlExport = '../model/table-mapping/actived-tables.xml';
			
			if(is_file($urlExport)){
				unlink($urlExport);
			}
			XMLExports::doExport($rootName, $actived_tables, $urlExport);
		}
	}//actived_tables

	/** 
	 * M�todo que retorna um array com o mapeamento dos campos das tabelas do sistema
	 * Method that return an array with fild mapping of system tables
	 * @access public 
	 * @static
	 * @return Array
	 */	
	public static function table_mapping(){
		global $actived_tables;
		if(!empty($actived_tables)){
			foreach($actived_tables as $name => $status){
				if($status == 'true'){
					$tableInfo = Brain::$data_base->tableInfo($name);
					if(DB::isError($actived_tables)){
						$this->erro($db->getMessage());		
					}
					else{
						foreach($tableInfo as $table){
							$arrayTableMapping['name']                        = $table['name'];
							$arrayTableMapping['type']                        = $table['type'];
							$arrayTableMapping['len']                         = $table['len'];
							$arrayTableMapping['flags']                       = $table['flags'];
							$table_mapping[$name][$arrayTableMapping['name']] = $arrayTableMapping;	
						}
					}
				}	
			}
			
			$rootName  = 'table_mapping';
			$urlExport = '../model/table-mapping/table-mapping.xml';
			
			if(is_file($urlExport)){
				unlink($urlExport);
			}
			XMLExports::doExport($rootName, $table_mapping, $urlExport);
		}
	}//table_mapping
	
	/** 
	 * M�todo que retorna um array com os r�tulos dos campos da tabela do sistema
	 * Method that return an array with label of field table of system
	 * @access public 
	 * @static
	 * @return Array
	 */	
	public static function label_mapping(){
		$label_mapping['potential'] = array(
			'idpotential' => 'identifica��o do potencial',
			'type'        => 'tipo',
			'value'       => 'valor',
			'phaseid'     => 'identifica��o da fase',
			'datetime'    => 'quando',
			'iddevices'   => 'identifica��o dos dispositivos'
		);
				
		$rootName  = 'label_mapping';
		$urlExport = '../model/table-mapping/label-mapping.xml';
		
		if(is_file($urlExport)){
			unlink($urlExport);
		}
		XMLExports::doExport($rootName, $label_mapping, $urlExport);
	}//label_mapping
}//XMLExports
?>