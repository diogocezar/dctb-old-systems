<?php
/** 
 * SpeceBrain
 *
 * Essa classe abstrata é responsável por realizar a importação dos XML's correspondente a configurações do sistema
 * This abstract class is responsible to do XML's imports corresponding to system configurations
 *
 * @author Diogo Cezar <diogo@diogocezar.com>
 * @version 2.0.1
 * @copyright Copyright © 2007-2009
 * @package xml-imports
 * @abstract
 */
 
abstract class XMLImports{
	
	/** 
	 * Atributo que irá armazenar o objeto de manipulação do do XML
	 * Attribute that will store the XML manipulation object 
	 * @name $xmlScanner
	 * @var Object
	 */
	private static $xmlScanner;
	
	/** 
	 * Atributo que irá armazenar o array de opções utilizado no objeto de manipulação de XML
	 * Attribute that will store the options array used on XML manipulation object
	 * @name $xmlScanner
	 * @var Object
	 */
	private static $options;
	
	/** 
	 * Método que prepara as configurações dos XML's a serem importados
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
	 * Método que importa um XML
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
	 * Método que retorna um array de rótulos dos erros do sistema
	 * Method that return an array of label of system errors
	 * @access public 
	 * @static
	 * @return Array
	 */
	public static function erro(){
		return XMLImports::doImport('../core/conf/errors.xml');
	}//erro
	
	/** 
	 * Método que retorna um array de neurônios ativos no sistema
	 * Method that return an array of actived neurons in system
	 * @access public 
	 * @static
	 * @return Array
	*/
	public static function actived_neuron(){
		return XMLImports::doImport('../core/conf/actived-neuron.xml');
	}//actived_neuron
	
	/** 
	 * Método que retorna um array de configurações do sistema
	 * Method that return an array of system configurations
	 * @access public 
	 * @static
	 * @return Array
	 */
	public static function conf(){
		return XMLImports::doImport('../core/conf/conf.xml');
	}//conf
	
	/** 
	 * Método que retorna um array de tabelas ativas no sistema
	 * Method that return an array of actived tables on system
	 * @access public 
	 * @static
	 * @return Array
	 */
	public static function actived_tables(){
		return XMLImports::doImport('../model/table-mapping/actived-tables.xml');
	}//table_mapping

	/** 
	 * Método que retorna um array com o mapeamento dos campos das tabelas do sistema
	 * Method that return an array with fild mapping of system tables
	 * @access public 
	 * @static
	 * @return Array
	 */	
	public static function table_mapping(){
		return XMLImports::doImport('../model/table-mapping/table-mapping.xml');
	}//table_mapping
	
	/** 
	 * Método que retorna um array os rótulos dos campos da tabela do sistema
	 * Method that return an array with label of field table of system
	 * @access public 
	 * @static
	 * @return Array
	 */	
	public static function label_mapping(){
		return XMLImports::doImport('../model/table-mapping/label-mapping.xml');
	}//table_mapping

}
?>