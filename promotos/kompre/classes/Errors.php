<?php

	 /** 
	 * Esta classe � responsavel por imprimir os eventuais erros ocorridos
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright � 2005, Kakitus.com LTDA. 
	 * @access public
	 * @package Errors
	 */
	  
	  
      /**
	  * Array global com os erros, para poss�vel altera��o futura caso necess�rio.
	  */
	   
	   $erro['CONNECT_TO_DATA'] = "N�o foi poss�vel estabelecer uma conex�o com o banco de dados : ";
	   $erro['QUERY_GERA_ERRO'] = "A senten�a escrita parece est� com erro : ";
	   $erro['NENHUM_BANCO_SE'] = "Nenhum \"tipo\" de banco de dados foi selecionado.";
	   $erro['PARMS_INSUFICIE'] = "Par�metros insuficientes para conectar ao banco de dados.";
	   $erro['ERRO_NA_CONEX�O'] = "N�o foi poss�vel estabelecer uma conex�o com o banco de dados : ";
	   $erro['ERRO_NA_SELEC�O'] = "N�o foi poss�vel selecionar o banco de dados indicado : ";
	   $erro['INSERT_ERRO_CAM'] = "Houve um erro inserir um novo registro no banco de dados.";
	   $erro['DELETE_ERRO_CAM'] = "Houve um erro excluir dados da tabela.";
	   $erro['DELETE_UPDA_CAM'] = "Houve um erro atualizar dados da tabela.";
	   $erro['QUERY_ERRO_CAMP'] = "Houve um erro ao se executar uma instru��o sql";
	   $erro['CRIPT_STR_CRIPT'] = "A string j� est� criptografada.";
	   $erro['CRIPT_STR_VAZIA'] = "A string est� vazia.";
	   $erro['CRIPT_STR_DESCR'] = "A string j� est� descriptografada.";
	   $erro['TEMPL_PARMS_VAZ'] = "Par�mtros necess�rios est�o em branco.";
	   $erro['TEMPL_TAG_REPLA'] = "N�mero de tags e replaces incompativel.";
	   $erro['E-MAIL_NOT_SEND'] = "Erro ao enviar o e-mail.";
	   $erro['TEMPLATE_NAO_EN'] = "O arquivo de template n�o foi encontrado.";
	   $erro['SESSION_NOT_ARR'] = "A sess�o passada como par�metro n�o � um array.";
	   $erro['INDI_OR_VALUE_E'] = "O �ndice ou valor da session est� em branco.";
	   $erro['SESSION_NOT_EXI'] = "N�o � possivel retornar o valor indexado pelo �ndice passo como par�metro.";
	   $erro['SE_INDICE_EMPTY'] = "O �ndice passado como par�metro est� vazio.";
	   $erro['INDI_OR_VALUE_C'] = "O �ndice ou valor da cookie est� em branco.";
	   $erro['COOKIE_NOT_ARRA'] = "A cookie passada como par�metro n�o � um array.";
	   $erro['DIRETORIO_INVAL'] = "O diret�rio passado n�o � v�lido";
	   $erro['ARQUI_INCOMPLET'] = "O arquivo n�o est� completo, n�o foi poss�vel obter todas suas informa��es.";
	   $erro['EXT_ARQUIV_INVA'] = "A extens�o do arquivo enviado n�o � v�lida.";
	   $erro['TAMANHO_MAIOR_P'] = "O arquivo ultrapassou o tamanho limite para envio.";
	   $erro['LOCALIZA_INVALI'] = "A localiza��o enviada para montar a imagem n�o � v�lida.";
	   $erro['ALTU_LARG_VAZIA'] = "A largura e/ou altura da imagem est�(�o) vazia(s).";
	   $erro['LIB_TO_GIF_INVA'] = "A biblioteca para tratamento de imagens no formato GIF n�o foi encontrada.";
	   $erro['LIB_TO_JPG_INVA'] = "A biblioteca para tratamento de imagens no formato JPG n�o foi encontrada.";
	   $erro['LIB_TO_PNG_INVA'] = "A biblioteca para tratamento de imagens no formato PNG n�o foi encontrada.";
	   $erro['INI_FILE_NOT_FI'] = "N�o foi poss�vel recuperar as informa��es do arquivo ini.";

      /**
	  * Array local com as decora��es das fontes ao se exibir um erro.
	  */
	  
	  $style['ERRO_OPEN'] = "<font face='Tahoma' size='1,7' color='#1F1A17'>";
	  $style['FECHA']     = "</font>";
	  	   
class Errors{
      /**
	  * Construtor
	  */
	   
	  /** 
	  * M�todo CONSTRUTOR Errors para parar o c�digo e exibir o erro passado como par�metro.
	  * @access public 
	  * @return void
	  * @param String $erro Erro ocorrido.
	  * @param integer $qtd Representa se o erro � de apenas uma linha ou de v�rias, caso seja de v�rias a instru��o exit() n�o � executada.
	  */  
	   
	   function Errors($erro, $qtd=1){
	   		static $contLinhas; // Conta as linhas inseridas.
			if(!empty($erro)){
				echo "
				<script language = javascript>
				alert('".$erro."');
				</script>		
				";
				if($contLinhas+1 == $qtd){
					exit();
				}
				else{
					$contLinhas++;
				}
			}
	   }
	   
	  /** 
	  * M�todo para exibi��o de um erro de conex�o (N�O � EXIBIDO EM JAVASCRIPT [ALERT]).
	  * @access public 
	  * @return void
	  * @param String $erro Erro ocorrido.
	  */  
	   
	   function erroConnection($erro){
	   		global $style; //Variavel de decora��o.
	   		if(!empty($erro)){
				echo $style['ERRO_OPEN'].$erro.$style['FECHA'];
				exit();
			}
	   }
}
?>