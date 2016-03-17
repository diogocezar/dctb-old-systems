<?php

	 /** 
	 * Esta classe é responsavel por imprimir os eventuais erros ocorridos
	 * xC3 || xClasses 3.0 || 2005
	 *
	 * @author xg0rd0 <xgordo@kakitus.com> 
	 * @version 1.0
	 * @copyright Copyright © 2005, Kakitus.com LTDA. 
	 * @access public
	 * @package Errors
	 */
	  
	  
      /**
	  * Array global com os erros, para possível alteração futura caso necessário.
	  */
	   
	   $erro['CONNECT_TO_DATA'] = "Não foi possível estabelecer uma conexão com o banco de dados : ";
	   $erro['QUERY_GERA_ERRO'] = "A sentença escrita parece está com erro : ";
	   $erro['NENHUM_BANCO_SE'] = "Nenhum \"tipo\" de banco de dados foi selecionado.";
	   $erro['PARMS_INSUFICIE'] = "Parâmetros insuficientes para conectar ao banco de dados.";
	   $erro['ERRO_NA_CONEXÃO'] = "Não foi possível estabelecer uma conexão com o banco de dados : ";
	   $erro['ERRO_NA_SELECÃO'] = "Não foi possível selecionar o banco de dados indicado : ";
	   $erro['INSERT_ERRO_CAM'] = "Houve um erro inserir um novo registro no banco de dados.";
	   $erro['DELETE_ERRO_CAM'] = "Houve um erro excluir dados da tabela.";
	   $erro['DELETE_UPDA_CAM'] = "Houve um erro atualizar dados da tabela.";
	   $erro['QUERY_ERRO_CAMP'] = "Houve um erro ao se executar uma instrução sql";
	   $erro['CRIPT_STR_CRIPT'] = "A string já está criptografada.";
	   $erro['CRIPT_STR_VAZIA'] = "A string está vazia.";
	   $erro['CRIPT_STR_DESCR'] = "A string já está descriptografada.";
	   $erro['TEMPL_PARMS_VAZ'] = "Parâmtros necessários estão em branco.";
	   $erro['TEMPL_TAG_REPLA'] = "Número de tags e replaces incompativel.";
	   $erro['E-MAIL_NOT_SEND'] = "Erro ao enviar o e-mail.";
	   $erro['TEMPLATE_NAO_EN'] = "O arquivo de template não foi encontrado.";
	   $erro['SESSION_NOT_ARR'] = "A sessão passada como parâmetro não é um array.";
	   $erro['INDI_OR_VALUE_E'] = "O índice ou valor da session está em branco.";
	   $erro['SESSION_NOT_EXI'] = "Não é possivel retornar o valor indexado pelo índice passo como parâmetro.";
	   $erro['SE_INDICE_EMPTY'] = "O índice passado como parâmetro está vazio.";
	   $erro['INDI_OR_VALUE_C'] = "O índice ou valor da cookie está em branco.";
	   $erro['COOKIE_NOT_ARRA'] = "A cookie passada como parâmetro não é um array.";
	   $erro['DIRETORIO_INVAL'] = "O diretório passado não é válido";
	   $erro['ARQUI_INCOMPLET'] = "O arquivo não está completo, não foi possível obter todas suas informações.";
	   $erro['EXT_ARQUIV_INVA'] = "A extensão do arquivo enviado não é válida.";
	   $erro['TAMANHO_MAIOR_P'] = "O arquivo ultrapassou o tamanho limite para envio.";
	   $erro['LOCALIZA_INVALI'] = "A localização enviada para montar a imagem não é válida.";
	   $erro['ALTU_LARG_VAZIA'] = "A largura e/ou altura da imagem está(ão) vazia(s).";
	   $erro['LIB_TO_GIF_INVA'] = "A biblioteca para tratamento de imagens no formato GIF não foi encontrada.";
	   $erro['LIB_TO_JPG_INVA'] = "A biblioteca para tratamento de imagens no formato JPG não foi encontrada.";
	   $erro['LIB_TO_PNG_INVA'] = "A biblioteca para tratamento de imagens no formato PNG não foi encontrada.";

      /**
	  * Array local com as decorações das fontes ao se exibir um erro.
	  */
	  
	  $style['ERRO_OPEN'] = "<font face='Tahoma' size='1,7' color='#1F1A17'>";
	  $style['FECHA']     = "</font>";
	  	   
class Errors{
      /**
	  * Construtor
	  */
	   
	  /** 
	  * Método CONSTRUTOR Errors para parar o código e exibir o erro passado como parâmetro.
	  * @access public 
	  * @return void
	  * @param String $erro Erro ocorrido.
	  * @param integer $qtd Representa se o erro é de apenas uma linha ou de várias, caso seja de várias a instrução exit() não é executada.
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
	  * Método para exibição de um erro de conexão (NÃO É EXIBIDO EM JAVASCRIPT [ALERT]).
	  * @access public 
	  * @return void
	  * @param String $erro Erro ocorrido.
	  */  
	   
	   function erroConnection($erro){
	   		global $style; //Variavel de decoração.
	   		if(!empty($erro)){
				echo $style['ERRO_OPEN'].$erro.$style['FECHA'];
				exit();
			}
	   }
}
?>