<?php
/** 
 * SpeceBrain
 *
 * Essa classe abstrata � respons�vel por realizar a importa��o dos XML's correspondente a configura��es do sistema
 * This abstract class is responsible to do XML's imports corresponding to system configurations
 *
 * @author Diogo Cezar <diogo@diogocezar.com>
 * @version 2.0.1
 * @copyright Copyright � 2007-2009
 * @package xml-imports
 * @abstract
 */
 
abstract class XMLImports{
	
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
	private function preparesXMLImports(){
		global $brain_controller;
		XMLImports::$xmlScanner = $brain_controller['xmlscanner'];
		XMLImports::$options    = array(XML_UNSERIALIZER_OPTION_ATTRIBUTES_PARSE    => true,
						                XML_UNSERIALIZER_OPTION_ATTRIBUTES_ARRAYKEY => false
						                );
	}
	
	/** 
	 * M�todo que importa um XML
	 * Method that imports a XML
	 * @access private
	 * @param String $url
	 * @return Array
	 */
	private function doImport($url){
		XMLImports::preparesXMLImports();
		XMLImports::$xmlScanner->setFileName($url);
		XMLImports::$xmlScanner->setOptionsOut(XMLImports::$options);
		XMLImports::$xmlScanner->setPrintResult(false);
		$arrayReturn = XMLImports::$xmlScanner->extractArray();
		unset($arrayReturn['lang']);
		unset($arrayReturn['xml:lang']);
		unset($arrayReturn['xmlns']);
		return $arrayReturn;
	}
	
	/** 
	 * M�todo que retorna um array de r�tulos dos erros do sistema
	 * Method that return an array of label of system errors
	 * @access public 
	 * @static
	 * @return Array
	 */
	public static function erro(){
		return XMLImports::doImport('../core/conf/errors.xml');
	}//erro
	
	/** 
	 * M�todo que retorna um array de neur�nios ativos no sistema
	 * Method that return an array of actived neurons in system
	 * @access public 
	 * @static
	 * @return Array
	*/
	public static function actived_neuron(){
		return XMLImports::doImport('../core/conf/actived-neuron.xml');
	}//actived_neuron
	
	/** 
	 * M�todo que retorna um array de configura��es do sistema
	 * Method that return an array of system configurations
	 * @access public 
	 * @static
	 * @return Array
	 */
	public static function conf(){
		return XMLImports::doImport('../core/conf/conf.xml');
	}//conf
	
	/** 
	 * M�todo que retorna um array de tabelas ativas no sistema
	 * Method that return an array of actived tables on system
	 * @access public 
	 * @static
	 * @return Array
	 */
	public static function actived_tables(){
		return XMLImports::doImport('../model/table-mapping/actived-tables.xml');
	}//table_mapping

	/** 
	 * M�todo que retorna um array com o mapeamento dos campos das tabelas do sistema
	 * Method that return an array with fild mapping of system tables
	 * @access public 
	 * @static
	 * @return Array
	 */	
	public static function table_mapping(){
		return XMLImports::doImport('../model/table-mapping/table-mapping.xml');
	}//table_mapping
}
?>