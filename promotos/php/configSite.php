<?php
/**
* Arquivo de configuração da página.
*
* Definindo constantes de configuração
*/

/**
* I N C L U I N D O  C O N F I G U R A Ç Ã O   D O   K O M P R E 
*/

include('../kompre/php/configSite.php');

/**
* D I R E T Ó R I O S    P A R A   A L O C A Ç  Ã O   D E   A R Q U I V O S
*/

$diretorio['lojas'] = "../images/fotos";

/**
* N Ú M E R O   D E   Í T E N S   P O R   P A G I N A Ç Ã O 
*/

define(PP_LOJAS, 10);

/**
* E - M A I L   D E S T I N O   C O N T A T O
*/

define(EMAIL, 'falecom@promotos.com.br');

/**
* D E F I N I Ç Ã O   D A S   C O N S  T A N T E S 
*/

define(HISTORICO, "Tudo se inicia na caixa de login. Inicia-se digitando-se um apóstrofo e clicando-se no botão para seguir adiante. As reações podem ser as mais diversas : Uma mensagem de erro gerada pelo próprio site: Essa é a melhor reação possível, quando bem utilizada, quando não fica inútil. O fato da própria aplicação no site gerar a mensagem de erro significa que, se é que houve um erro ocorreu um tratamento e o pretenso hacker ficará sem saber o que ocorreu em consequencia da entrada dele na caixa de login. Mas a alegria do administrador do site pode durar pouco: Alguns sites tem o costume de dar mensagens diferenciadas de acordo com o erro, tal como \"usuario inválido\", \"senha inválida\" ou \"erro desconhecido\". Neste caso o procedimento de tratar o erro é inútil, pois a mensagem de erro personalizada de acordo com o erro está informando ao hacker que a tentativa dele gerou algum resultado. O ideal é dar uma mensagem padrão do tipo \"Login inválido\" para qualquer erro que porventura ocorra durante o processo de login, desta forma o hacker, a princípio, não saberá se as tentativas dele geraram algum resultado ou não, dificultando (não impedindo) a ação do pretenso hacker. Vale mencionar que o tratamento padrão dos apóstrofos faz com que o apóstrofo digitado na caixa de login seja visto como um usuário. Assim sendo se o site está usando mensagens diferenciadas e, como resposta ao apóstrofo, o pretenso hacker recebe alguma mensagem diferente de \"usuário inválido\", ele está na verdade recebendo um convite do tipo \"continue, você está no caminho certo e vai conseguir\". Mensagem do servidor: Caracteres inválidos no login: Pode ser vista como a solução do problema. Se disparada a partir do servidor significa que o algorítimo de login testou o login e identificou que haviam caracteres inválidos, não indo ao banco. Isso fará com que o hacker de imediato desista do seu site. Desista, mas espalhe a todos que seu site é mal programado, já que esta não é a forma correta de se tratar os apóstrofos, apesar de funcionar. Esteja atento para o fato de que a mensagem deve partir do servidor, não do cliente. Infelizmente muitos programadores WEB tem dificuldades em diferenciar isso, mas esteja certo que um hacker o faz de olhos fechados e mãos nas costas. Mensagem do Cliente: Caracteres inválidos no login: Nesta hora o hacker dá um risinho e arregaça as mangas: isso é um desafio, ele foi desafiado por um mal programador! Que audácia! Em menos de 5 minutos o hacker edita o código fonte, elimina a validação e invade o site. Manter validação apenas no cliente é o mesmo que não manter validação nenhuma.");

define(DICAS, "Tudo se inicia na caixa de login. Inicia-se digitando-se um apóstrofo e clicando-se no botão para seguir adiante. As reações podem ser as mais diversas : Uma mensagem de erro gerada pelo próprio site: Essa é a melhor reação possível, quando bem utilizada, quando não fica inútil. O fato da própria aplicação no site gerar a mensagem de erro significa que, se é que houve um erro ocorreu um tratamento e o pretenso hacker ficará sem saber o que ocorreu em consequencia da entrada dele na caixa de login. Mas a alegria do administrador do site pode durar pouco: Alguns sites tem o costume de dar mensagens diferenciadas de acordo com o erro, tal como \"usuario inválido\", \"senha inválida\" ou \"erro desconhecido\". Neste caso o procedimento de tratar o erro é inútil, pois a mensagem de erro personalizada de acordo com o erro está informando ao hacker que a tentativa dele gerou algum resultado. O ideal é dar uma mensagem padrão do tipo \"Login inválido\" para qualquer erro que porventura ocorra durante o processo de login, desta forma o hacker, a princípio, não saberá se as tentativas dele geraram algum resultado ou não, dificultando (não impedindo) a ação do pretenso hacker. Vale mencionar que o tratamento padrão dos apóstrofos faz com que o apóstrofo digitado na caixa de login seja visto como um usuário. Assim sendo se o site está usando mensagens diferenciadas e, como resposta ao apóstrofo, o pretenso hacker recebe alguma mensagem diferente de \"usuário inválido\", ele está na verdade recebendo um convite do tipo \"continue, você está no caminho certo e vai conseguir\". Mensagem do servidor: Caracteres inválidos no login: Pode ser vista como a solução do problema. Se disparada a partir do servidor significa que o algorítimo de login testou o login e identificou que haviam caracteres inválidos, não indo ao banco. Isso fará com que o hacker de imediato desista do seu site. Desista, mas espalhe a todos que seu site é mal programado, já que esta não é a forma correta de se tratar os apóstrofos, apesar de funcionar. Esteja atento para o fato de que a mensagem deve partir do servidor, não do cliente. Infelizmente muitos programadores WEB tem dificuldades em diferenciar isso, mas esteja certo que um hacker o faz de olhos fechados e mãos nas costas. Mensagem do Cliente: Caracteres inválidos no login: Nesta hora o hacker dá um risinho e arregaça as mangas: isso é um desafio, ele foi desafiado por um mal programador! Que audácia! Em menos de 5 minutos o hacker edita o código fonte, elimina a validação e invade o site. Manter validação apenas no cliente é o mesmo que não manter validação nenhuma.");

define(SERVICOS, "Tudo se inicia na caixa de login. Inicia-se digitando-se um apóstrofo e clicando-se no botão para seguir adiante. As reações podem ser as mais diversas : Uma mensagem de erro gerada pelo próprio site: Essa é a melhor reação possível, quando bem utilizada, quando não fica inútil. O fato da própria aplicação no site gerar a mensagem de erro significa que, se é que houve um erro ocorreu um tratamento e o pretenso hacker ficará sem saber o que ocorreu em consequencia da entrada dele na caixa de login. Mas a alegria do administrador do site pode durar pouco: Alguns sites tem o costume de dar mensagens diferenciadas de acordo com o erro, tal como \"usuario inválido\", \"senha inválida\" ou \"erro desconhecido\". Neste caso o procedimento de tratar o erro é inútil, pois a mensagem de erro personalizada de acordo com o erro está informando ao hacker que a tentativa dele gerou algum resultado. O ideal é dar uma mensagem padrão do tipo \"Login inválido\" para qualquer erro que porventura ocorra durante o processo de login, desta forma o hacker, a princípio, não saberá se as tentativas dele geraram algum resultado ou não, dificultando (não impedindo) a ação do pretenso hacker. Vale mencionar que o tratamento padrão dos apóstrofos faz com que o apóstrofo digitado na caixa de login seja visto como um usuário. Assim sendo se o site está usando mensagens diferenciadas e, como resposta ao apóstrofo, o pretenso hacker recebe alguma mensagem diferente de \"usuário inválido\", ele está na verdade recebendo um convite do tipo \"continue, você está no caminho certo e vai conseguir\". Mensagem do servidor: Caracteres inválidos no login: Pode ser vista como a solução do problema. Se disparada a partir do servidor significa que o algorítimo de login testou o login e identificou que haviam caracteres inválidos, não indo ao banco. Isso fará com que o hacker de imediato desista do seu site. Desista, mas espalhe a todos que seu site é mal programado, já que esta não é a forma correta de se tratar os apóstrofos, apesar de funcionar. Esteja atento para o fato de que a mensagem deve partir do servidor, não do cliente. Infelizmente muitos programadores WEB tem dificuldades em diferenciar isso, mas esteja certo que um hacker o faz de olhos fechados e mãos nas costas. Mensagem do Cliente: Caracteres inválidos no login: Nesta hora o hacker dá um risinho e arregaça as mangas: isso é um desafio, ele foi desafiado por um mal programador! Que audácia! Em menos de 5 minutos o hacker edita o código fonte, elimina a validação e invade o site. Manter validação apenas no cliente é o mesmo que não manter validação nenhuma.");

/**
* M E N U
*/

$menu  = array("onClickM1"  => "index.php",
               "onClickM2"  => "promotos.php",
		       "onClickM3"  => "servicos.php",
		       "onClickM4"  => "dicas.php",
			   "onClickM5"  => "http://kompre.promotos.com.br/",
			   "onClickM6"  => "contato.php"
			   );
			   
/**
* M E N U  A D M I N I S T R A Ç Ã O 
*/

$menuAdm = array(
                   "Lojas" => array(
					   "Inserir loja"     => "admLoja.php?acao=adicionar",
					   "Gerenciar lojas"  => "admLojas.php",
				   ),
				   "Dicas" => array(
					   "Inserir dica"    => "admDica.php?acao=adicionar",
					   "Gerenciar dicas" => "admDicas.php",
				   ),
				   "Serviços" => array(
					   "Inserir serviço"    => "admServico.php?acao=adicionar",
					   "Gerenciar serviços" => "admServicos.php",
				   ),
				   "Loja Virtual" => array(
					   "Kompre !" => "http://kompre.promotos.com.br/php/login.php!",
				   ),
				   "Relatórios" => array(
					   "Estatisticas do site" => "http://67.19.228.7/awstats.pl?config=promotos.com.br&lang=br!",
				   ),				   
				   "Logout" => array(
					   "Sair do sistema" => "admLogOut.php"
				   )
		     );

			   
/**
* T A B E L A S   E   S E U S   R E S P E C T I V O S   C A M P O S
*/
			   
/******************************************************************/


$tabela['dicas'] = "pro_dicas";

$campos['dicas'] = array("dic_id",
						 "dic_titulo",
                         "dic_descricao"
					     );
// PK -> dic_cod

/******************************************************************/

$tabela['lojas'] = "pro_lojas";

$campos['lojas'] = array("loj_id",
					     "loj_titulo",
						 "loj_endereco",
						 "loj_telefone",
						 "loj_email",
						 "loj_contatos",
						 "loj_descricao",
						 "loj_foto_url"
					     );
// PK -> loj_cod

/******************************************************************/

$tabela['servicos'] = "pro_servicos";

$campos['servicos'] = array("ser_id",
							"ser_titulo",
						    "ser_descricao"
					        );
// PK -> ser_cod
?>
