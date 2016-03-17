<?php
/**
* A seguir s�o colocados os arquivos incluidos e suas respectivas descri��es.
*/

/**
* Incluindo arquivo de configura��o com as constantes definidas
*/
require_once("Config.php");

/**
* Incluindo impress�o de erros.
*/
require_once("Errors.php");

/**
* Incluindo HTML_Template_IT (pear) para tratamento do template.
*/
require_once("HTML_Template_IT/IT.php");

	 /** 
	 * Esta classe � responsavel por enviar e-mails.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright � 2005, Kakitus.com LTDA. 
	 * @access public
	 * @package SendMail
	 */
	 
class SendMail{

	  /** 
      * Atributo que ir� armazenar o t�tulo do email a ser enviado.
      * @access private  
      * @name $titulo
	  * @var String
      */		
	var $titulo;
	
	  /** 
      * Atributo que ir� armazenar o conte�do do email a ser enviado.
      * @access private  
      * @name $conteudo
	  * @var String
      */		
	var $conteudo;
	
	  /** 
      * Atributo que ir� armazenar o destino do email a ser enviado.
      * @access private  
      * @name $destino
	  * @var String
      */		
	var $destino;
	
	  /** 
      * Atributo que ir� armazenar a origem do email a ser enviado.
      * @access private  
      * @name $origem
	  * @var String
      */		
	var $origem;
	
	  /** 
      * Atributo que ir� armazenar Empresa/Autor do email a ser enviado.
      * @access private  
      * @name $origem
	  * @var String
      */		
	var $autor;

	  /** 
      * Atributo que ir� armazenar a a mensagem do rodap� do email.
      * @access private  
      * @name $origem
	  * @var String
      */		
	var $msgFinal;

	  /** 
      * Atributo que ir� armazenar o cabe�alho do email a ser enviado.
      * @access private  
      * @name $header
	  * @var String
      */		
	var $header;
	
	  /** 
      * Atributo que ir� armazenar o diret�rio do arquivo de template.
      * @name $templateHtmlDir
	  * @var String
      */		
	var $templateHtmlDir;
	
	  /** 
      * Atributo que ir� armazenar o nome do arquivo de template.
      * @name $templateHtmlName
	  * @var String
      */		
	var $templateHtmlName;
	
	 /** 
	  * M�todo CONSTRUTOR que inicializa os atributos passados como par�metro.
	  * @access public 
	  * @param String $titulo
	  * @param String $conteudo
	  * @param String $destino
	  * @param String $origem
	  * @param String $templateHtml
	  * @return void
	  */  
	function SendMail($titulo, $conteudo, $destino, $origem=ORIGEM, $autor=AUTOR, $msgFinal=MSG_FINAL, $templateHtmlDir=TEMPLATE_HTML_DIR, $templateHtmlName=TEMPLATE_HTML_NAME){
		if(!empty($titulo) && !empty($conteudo) && !empty($destino)){
		
			/* Vari�veis Obrigat�rias */
			$this->titulo           = $titulo;
			$this->conteudo         = $conteudo;
			$this->destino          = $destino;
			$this->origem           = ORIGEM;
		    $this->autor            = AUTOR;
			$this->msgFinal         = MSG_FINAL;
			$this->templateHtmlDir  = TEMPLATE_HTML_DIR;
			$this->templateHtmlName = TEMPLATE_HTML_NAME;
			
			/* Vari�veis Opcionais */
			if($origem != ORIGEM){
				$this->origem = $origem;
			}
			
			if($autor != AUTOR){
				$this->autor = $autor;
			}
			
			if($msgFinal != MSG_FINAL){
				$this->msgFinal = $msgFinal;
			}

			if($templateHtmlDir != TEMPLATE_HTML_DIR){
				$this->templateHtmlDir = $templateHtmlDir;
			}
			
			if($templateHtmlName != TEMPLATE_HTML_NAME){
				$this->templateHtmlName = $templateHtmlName;
			}
		}
	}//SendMail
	
	  /** 
	  * M�todo que envia o email.
	  * @access public 
	  * @return void
	  */  
	function goMail(){
	 	global $erro; // Reconhecendo variavel global para os erros.
		
		if(file_exists($this->templateHtmlDir.$this->templateHtmlName)){
		
			$template = new HTML_Template_IT($this->templateHtmlDir);
	
			$template->loadTemplatefile($this->templateHtmlName, true, true);
			
			$template->setCurrentBlock("bloco_mail");
			
				$template->setVariable("tituloEmail", $this->titulo);
				
				$template->setVariable("destino", $this->destino);
				
				$template->setVariable("origem", $this->origem);
				
				$template->setVariable("conteudo", $this->conteudo);
				
				$template->setVariable("msgFinal", $this->msgFinal);
		
				$template->setVariable("autor", $this->autor);
				
				$template->setVariable("dataHora", getData(4).", ".getHora(":", 1));
			
				$template->parseCurrentBlock("bloco_mail");
	
			$this->conteudo = $template->get();

			$this->header = "From:".$this->origem."\nContent-type: text/html\n";
			
			if (!@mail($this->destino, $this->titulo, $this->conteudo, $this->header)){
				$erroMail = new Errors($erro['E-MAIL_NOT_SEND']);
			}
		}
		else{
			$erroMail = new Errors($erro['TEMPLATE_NAO_EN']);
		}
	}//goMail
}//SendMail

?>