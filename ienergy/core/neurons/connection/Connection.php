<?php
/** 
* SpeceBrain
*
* Esta neurônio é responsavel por fazer a conexão com o banco de dados
* This neuron is responsible to make a conection with the data base
*
* @author Diogo Cezar <diogo@diogocezar.com>
* @version 2.0.1
* @copyright Copyright © 2007-2009
* @access public
* @package neuron
*/

	 
class Connection{
	/**
	* Construtor
	* Constructor
	* __construct_Connection()
	*/	  
	public function __construct_Connection(){
		global $conf;
		$base      = $conf['data_base']['base'];
		$host      = $conf['data_base']['host'];
		$user      = $conf['data_base']['user'];
		$pass      = $conf['data_base']['pass'];
		$path      = $conf['data_base']['path'];
		$base_type = $conf['data_base']['base_type'];
		$this->__go_Connection($base, $host, $user, $pass, $path, $base_type);
	}
	   
	/** 
	* Método que invoca a conexão do framework PEAR
	* Method that raises PEAR framework connection
	* @access public
	* @param String $base
	* @param String $host
	* @param String $user
	* @param String $pass
	* @param String $path	
	* @param String $base_type
	* @return void
	*/
	 private function __go_Connection($base, $host, $user, $pass, $path, $base_type){
	 	global $erro; // Global variable destined to report errors
		              // Variável global para reportar erros
			if(!empty($base) && !empty($host) && !empty($user) && !empty($pass)){
				($pass == '[empty]') ? $pass = '' : $pass = $pass;
				if($path == ''){
					$dns = $base_type.'://'.$user.':'.$pass.'@'.$host.'/'.$base;
				}
				else{
					$dns = $base_type.'://'.$user.':'.$pass.'@'.$host.'/'.$path;
				}
				$db = DB::connect($dns);
				if(DB::isError($db)){
					$this->error($error['CONNECT_TO_DATA'].$db->getMessage());		
				}
				else{
					Brain::$data_base = $db;
				}
			}
			else{
				$this->error($error['PARMS_INSUFICIE']);	
			}
	 }//__go_Connection
}//Connection
?>