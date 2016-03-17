<?php
/**
* A seguir sуo colocados os arquivos incluidos e suas respectivas descriчѕes.
*/

/**
* Incluindo arquivo de configuraчуo com as constantes definidas
*/
require_once("Configuracao.php");

/**
* Incluindo impressуo de erros.
*/
require_once("Errors.php");

/**
* Incluindo classes PEAR
*/
require_once("mail_mime/mime.php");

require_once("mail/Mail.php");

/**
* Incluindo HTML_Template_IT (pear) para tratamento do template.
*/
require_once("HTML_Template_IT/IT.php");

	 /** 
	 * Esta classe щ responsavel por enviar e-mails.
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright Љ 2005, Kakitus.com LTDA. 
	 * @access public
	 * @package SendMail
	 */
	 
class SendMail{

	  /** 
      * Atributo que irс armazenar o tэtulo do email a ser enviado.
      * @access private  
      * @name $titulo
	  * @var String
      */		
	var $titulo;
	
	  /** 
      * Atributo que irс armazenar o conteњdo do email a ser enviado.
      * @access private  
      * @name $conteudo
	  * @var String
      */		
	var $conteudo;
	
	  /** 
      * Atributo que irс armazenar o destino do email a ser enviado.
      * @access private  
      * @name $destino
	  * @var String
      */		
	var $destino;
	
	  /** 
      * Atributo que irс armazenar a origem do email a ser enviado.
      * @access private  
      * @name $origem
	  * @var String
      */		
	var $origem;
	
	  /** 
      * Atributo que irс armazenar Empresa/Autor do email a ser enviado.
      * @access private  
      * @name $origem
	  * @var String
      */		
	var $autor;

	  /** 
      * Atributo que irс armazenar a a mensagem do rodapщ do email.
      * @access private  
      * @name $origem
	  * @var String
      */		
	var $msgFinal;
	
	  /** 
      * Atributo que irс armazenar o diretѓrio do arquivo de template.
      * @name $templateHtmlDir
	  * @var String
      */		
	var $templateHtmlDir;
	
	  /** 
      * Atributo que irс armazenar o nome do arquivo de template.
      * @name $templateHtmlName
	  * @var String
      */		
	var $templateHtmlName;
	
     /** 
      * Atributo que irс armazenar os parтmetros de conexуo.
      * @name $params
	  * @var Array
      */			
	var $params;
	
     /** 
      * Atributo que irс armazenar os dados do e-mail.
      * @name $dados
	  * @var Array
      */	
    var $dados;
	
     /** 
      * Atributo que irс armazenar o e-mail de origem.
      * @name $dados
	  * @var Array
      */		
    var $email = 'assinfdsv-cp@utfpr.edu.br';
	
	 /** 
	  * Mщtodo CONSTRUTOR que inicializa os atributos passados como parтmetro.
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
	
			/* Variсveis Obrigatѓrias */
			$this->titulo           = $titulo;
			$this->conteudo         = $conteudo;
			$this->destino          = $destino;
			$this->origem           = ORIGEM;
		    $this->autor            = AUTOR;
			$this->msgFinal         = MSG_FINAL;
			$this->templateHtmlDir  = TEMPLATE_HTML_DIR;
			$this->templateHtmlName = TEMPLATE_HTML_NAME;
			
			/* Variсveis Opcionais */
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
			
			$this->params = array('host'     => "smtp.utfpr.edu.br",
                                  'username' => "assinfdsv-cp@utfpr.edu.br",
                                  'password' => "developers",
                                  'port'     => 25,
                                  'debug'    => 0,
                                  'auth'     => ""
								  );
		}
	}//SendMail
	
	  /** 
	  * Mщtodo prepara as informaчѕes para o envio do e-mail.
	  * @access public 
	  * @return void
	  */  
	function goMail(){
	 	global $erro; // Reconhecendo variavel global para os erros.
		
		if(file_exists($this->templateHtmlDir.$this->templateHtmlName)){
		
			$template = new HTML_Template_IT($this->templateHtmlDir);
	
			$template->loadTemplatefile($this->templateHtmlName, true, true);
			
			$template->setCurrentBlock("mail");
			
				$template->setVariable("tituloEmail", $this->titulo);
				
				$template->setVariable("destino", $this->destino);
				
				$template->setVariable("origem", $this->origem);
				
				$template->setVariable("conteudo", $this->conteudo);
				
				$template->setVariable("msgFinal", $this->msgFinal);
		
				$template->setVariable("autor", $this->autor);
			
			$template->parseCurrentBlock("mail") ;
	
			$this->conteudo = $template->get();
			
											  
			$this->dados    = array('to'      => $this->destino,
                                    'ccs'     => $this->origem,
                                    'subject' => $this->titulo,
                                    'content' => $this->conteudo,
                                    'html'    => true
								    );
			
			if (!$this->send()){
				$erroMail = new Errors($erro['E-MAIL_NOT_SEND']);
			}
		}
		else{
			$erroMail = new Errors($erro['TEMPLATE_NAO_EN']);
		}
	}//prepareMail
	
	     /** 
	  * Mщtodo prepara envia o e-mail.
	  * @access public 
	  * @return void
	  */ 	
    function send(){
        $mime = new Mail_mime("\r\n");
        if(empty($this->dados['to'])) $p1 = false;
        else{
            $p1 = true; 
            $header['To'] = $this->dados['to'];
            if(is_array($this->dados['to']))
                 $recipients = implode(",",$this->dados['to']);
            else
                 $recipients = $this->dados['to'];
        }

        if(!empty($this->dados['ccs'])){
            $header['Cc'] = $this->dados['ccs'];
            if(is_array($this->dados['ccs']))
                 $recipients = $recipients.",".implode(",",$this->dados['ccs']);
            else
                 $recipients = $recipients.",".$this->dados['ccs'];
        }

        if(empty($this->dados['subject'])) $p2 = false;
        else{$p2 = true; $header['Subject'] = $this->dados['subject'];}

        if(empty($this->dados['content'])) $p3 = false;
        else {$p3 = true; $body = $this->dados['content'];}

        if(!empty($this->dados['annex']))
            $mime->addAttachment($this->dados['annex'],'application/octet-stream');

        if(!empty($this->dados['html'])){
            if($this->dados['html']==true)
                $mime->setHTMLBody($body);
            else
                $mime->setTXTBody($body);
        }else
            $mime->setTXTBody($body);

        if($p1 && $p2 && $p3){
            $recipients = explode(",",$recipients);
            $header['From']    = $this->email;
            $header['Reply-To'] = $this->email; 
            $header['Errors-To'] = $this->email; 
            $header['X-Priority'] = '1';
            $body = $mime->get();
            $header = $mime->headers($header);
            $mail =& Mail::factory('smtp', $this->params);
            $ene =& $mail->send($recipients, $header, $body);
            if(Pear::isError($ene))$r = false;
            else $r = true;
            unset($mime);
        }
        else $r = false;
        return $r;
    }//goMail
	
}//SendMail

?>