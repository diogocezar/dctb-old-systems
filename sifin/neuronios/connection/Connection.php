<?php
/** 
* SpeceBraid
*
* Esta classe é responsavel por fazer a conexão com o banco de dados.
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright © 2007
* @access public
* @package connection
*/
	 
class Connection{
	/**
	* Construtor
	* __construct_Connection()
	*/	  
	public function __construct_Connection(){
		$this->__go_Connection(BASE, HOST, USER, PASS, PATH);
	}
	   
	/** 
	* Método que invoca a conexão do framework PEAR.
	* @access public
	* @param String  $banco
	* @param String  $host
	* @param String  $user
	* @param String  $pass
	* @param String  $path	  
	* @return void
	*/
	 private function __go_Connection($banco, $host, $user, $pass, $path){
	 	global $erro; // Reconhecendo variavel global para os erros.
		global $dataBase; // Objeto que receberá a conexão.
			if(!empty($banco) && !empty($host) && !empty($user) && !empty($pass)){
				($pass == '[empty]') ? $pass = '' : $pass = $pass;
				if(PATH == ''){
					$dns = BASE_TYPE.'://'.$user.':'.$pass.'@'.$host.'/'.$banco;
				}
				else{
					$dns = BASE_TYPE.'://'.$user.':'.$pass.'@'.$host.'/'.$path;
				}
				$dataBase = DB::connect($dns);
				if(DB::isError($dataBase)){
					$this->erro($erro['CONNECT_TO_DATA'].$dataBase->getMessage());		
				}
			}
			else{
				$this->erro($erro['PARMS_INSUFICIE']);	
			}
	 }//__go_Connection
}//Connection
?>