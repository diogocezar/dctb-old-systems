<?php
/** 
 * SpeceBrain
 *
 * Essa classe abstrata é responsável por realizar a exportação das classes do sistema
 * This abstract class is responsible to do system class exports
 *
 * @author Diogo Cezar <diogo@diogocezar.com>, <diogocezar.com>
 * @version 2.0.1
 * @copyright Copyright © 2007-2009
 * @package class-exports
 * @abstract
 */

abstract class ClassExports{
	/**
	 * Comentar
	 */
	public static function renameFile($file){
		if(eregi('_', $file)){
			$fileName = "";
			$words = explode('_', $file);
			foreach($words as $word){
				$fileName .= ucfirst($word);	
			}
			$fileName = $fileName.'.php';
		}
		else{
			$fileName = ucfirst($file).'.php';
		}
		return $fileName;
	}
	
	public static function doExport(){
		global $actived_tables;
		global $table_mapping;
		
		foreach($actived_tables as $name => $status){
			if($status == 'true'){
				$nameClass               = ClassExports::renameFile($name);
				$nameVariableMethods     = "methods-".$name.".php"; 
				$pathFileClass           = "../model/system-class/$nameClass";
				$pathFileVariableMethods = "../model/system-class/variable-methods/$nameVariableMethods";
				
				if(is_file($pathFile)){
					unlink($pathFileClass);
				}
				if(!is_file($pathFileVariableMethods)){
					$contentFile = "<?php\n// write your methods here\n?>";
					file_put_contents($pathFileVariableMethods, $contentFile);
				}
				else{
					$methods = file_get_contents($pathFileVariableMethods);
					if($methods == "<?php\n// write your methods here\n?>"){
						$methods = "";	
					}
					else{
						if(eregi('<\?php', $methods)){
							$methods = str_replace('<?php', '', $methods);	
						}
						if(eregi('<\?', $methods)){
							$methods = str_replace('<?', '', $methods);	
						}
						if(eregi('\?>', $methods)){
							$methods = str_replace('?>', '', $methods);	
						}
					}
				}
				/* Extraindo atributos do arquivo XML */
				/* Extracting attributes from XML archive */
				$attributes = "	protected\n";
				$i = 0;
				foreach($table_mapping[$name] as $value){
					if($i+1 == count($table_mapping[$name])){
						$sep = ";\n";	
					}
					else{
						$sep = ",\n";	
					}
					$attributes .= '		$'.$value['name'].$sep;
					$i++;
				}
				/* Criando a classe */
				/* Creating class */
				$baseFile = '../model/system-class/base-class/base-class.php';
				if(is_file($baseFile)){
					$classBase = file_get_contents($baseFile);
					/* Substituindo as tags */
					/* Replacing tags */
					$nameClass = substr($nameClass, 0, strlen($nameClass)-4);					
					$classSave = str_replace('{name-class}', $nameClass, $classBase);
					$classSave = str_replace('{atrributes}', $attributes,  $classSave);
					$classSave = str_replace('{variable-methods}', $methods, $classSave);
					file_put_contents($pathFileClass, $classSave);
				}
			}	
		}
	}
}
?>