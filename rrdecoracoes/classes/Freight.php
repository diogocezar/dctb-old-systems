<?
/**
* A seguir sуo colocados os arquivos incluidos e suas respectivas descriчѕes.
*/

/**
* Incluindo arquivo de configuraчуo com as constantes definidas
*/
require_once("Config.php");

/**
* Incluindo impressуo de erros.
*/
require_once("Errors.php");
	  /** 
	  * Esta classe щ responsavel por calcular o frete de uma encomenda.
	  *
	  * @author xg0rd0 <xgordo@kakitus.com> 
	  * @version 1.0
	  * @copyright Copyright Љ 2005, Kakirus.com LTDA. 
	  * @access public
	  * @package Freight
	  */
	  
class Freight{

	  /** 
      * Atributo que irс armazenar o serviчo selecionado.
	  *
	  *	SEDEX          -> "40010"
	  * SEDEX Hoje     -> "40290"
	  * SEDEX 10       -> "40215"
	  * SEDEX a Cobrar -> "40045"
	  *
      * @access private  
      * @name $servico
	  * @var integer
      */
	  var $servico;
	  
	  /** 
      * Atributo que irс armazenar o cep de origem da encomenda.
      * @access private  
      * @name $cepOrigem
	  * @var String
      */
	  var $cepOrigem;
	  
	  /** 
      * Atributo que irс armazenar o cep de destino da encomenda.
      * @access private  
      * @name $cepDestino
	  * @var String
      */
	  var $cepDestino;
	  
	  /** 
      * Atributo que irс armazenar o peso da encomenda.
      * @access private  
      * @name $peso
	  * @var integer
      */
	  var $peso;
	  
	 /** 
	  * Mщtodo CONSTRUTOR que inicializa os atributos passados como parтmetros.
	  * @access public 
	  * @param integer $servico
	  * @param String  $cepOrigem
	  * @param String  $cepDestino
	  * @param integer $peso
	  * @return void
	  */  
	function Frete($servico, $cepDestino, $peso, $cepOrigem=FRETE_ORIGEM){
		$this->servico = $servico;
		$this->cepDestino = $cepDestino;
		$this->peso = $peso;
		if($cepOrigem != FRETE_ORIGEM){
			$this->cepOrigem = $cepOrigem;
		}
		else{
			$this->cepOrigem = FRETE_ORIGEM;
		}
	}
	
	  /** 
	  * Mщtodo que calcula o frete.
	  * @access public 
	  * @return String
	  */ 
	function goFrete(){
	    $correioFile = "http://www.correios.com.br/encomendas/precos/calculo.cfm?servico=". $this->servico . "&CepOrigem=".$this->cepOrigem."&CepDestino=".$this->cepDestino."&Peso=".$this->peso; 
        $resultado = join("", file($correioFile)); 
        $procura   = strpos($resultado,'Tarifa=') + strlen('Tarifa='); 
        $resultado = trim(substr($resultado, $procura)); 
        $fim = strpos($resultado,"&erro="); 
        return trim(substr($resultado,0,$fim));
	} 
}
?>