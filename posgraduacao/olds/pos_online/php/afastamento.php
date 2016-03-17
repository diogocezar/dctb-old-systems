<?php
/* Incluindo classes */
include('../classes/DataBase.php');
include('../classes/HTML_Template_IT/IT.php');
include('../classes/Session.php');

/* Incluindo arquivo de configuração da página */
include('./configSite.php');

/* Incluindo arquivo de funções */
include('../lib/library.php');
include('../lib/util.php');

/* Diretório dos Templates */
$templateHtmlDir = '../html';

$templateHtmlName = 'templateInterna.html';

/* Setando template */
$template = new HTML_Template_IT($templateHtmlDir);

/* Instanciando a classe */
$template->loadTemplatefile($templateHtmlName, true, true);

/* Bloco de Contatos */
$template->setCurrentBlock("bloco_contatos");
	$template->setVariable('contatos', $contato[1]);
$template->parseCurrentBlock("bloco_contatos");

/* Bloco Saiba Mais */
$template->setCurrentBlock("bloco_saiba_mais");
	$template->setVariable("saibaMaisTitulo", "Maiores infromações ?");
	$template->setVariable("saibaMais", MAIORES_INFOS);
$template->parseCurrentBlock("bloco_saiba_mais");

/* Bloco do Titulo da Página Interna */
$template->setCurrentBlock("bloco_titulo_interna");
	$template->setVariable("titulo", "Sobre o DEPOG");
$template->parseCurrentBlock("bloco_titulo");

/* Bloco do conteúdo da página interna */
$template->setCurrentBlock("bloco_conteudo");
	$template->setVariable("conteudo", "
<br><h3 align=\"center\">INSTRU&Ccedil;&Otilde;ES  PARA O AFASTAMENTO E A AVALIA&Ccedil;&Atilde;O DE DOCENTES AFASTADOS PARA REALIZA&Ccedil;&Atilde;O DE  CURSOS DE P&Oacute;S-GRADUA&Ccedil;&Atilde;O<u></u></h3>
<p align=\"justify\">A Avalia&ccedil;&atilde;o peri&oacute;dica de docentes, feita atrav&eacute;s  da FICHA DE AVALIA&Ccedil;&Atilde;O DE DOCENTES, &eacute; obrigat&oacute;ria de acordo com a Delibera&ccedil;&atilde;o n&ordm;  05/90 de 30 de mar&ccedil;o de 1990.<br />
  Os docentes afastados para realiza&ccedil;&atilde;o dos cursos  de P&oacute;s-Gradua&ccedil;&atilde;o (Especializa&ccedil;&atilde;o, Mestrado e Doutorado) encontram-se numa  situa&ccedil;&atilde;o peculiar, j&aacute; que muitos dos itens constantes da Ficha de Avalia&ccedil;&atilde;o de  Docente n&atilde;o s&atilde;o devidamente aplic&aacute;veis &agrave; sua situa&ccedil;&atilde;o.<br />
  Esta norma visa uniformizar os procedimentos  adotados para o afastamento e a avalia&ccedil;&atilde;o docentes nestes casos, e baseia-se no  bom desempenho do docente no que se refere &agrave;s suas atividades de estudo e  pesquisa, bem como no cumprimento dos prazos estabelecidos para o  desenvolvimento do seu programa de p&oacute;s-gradua&ccedil;&atilde;o.</p>
<ul>
  <li>Projeto de  Afastamento para P&oacute;s-Gradua&ccedil;&atilde;o: </li>
</ul>
<p>Para a sa&iacute;da do docente, ser&aacute; necess&aacute;ria a  apresenta&ccedil;&atilde;o de <em>Projeto de  Afastamento para P&oacute;s-Gradua&ccedil;&atilde;o</em>, composto no m&iacute;nimo de:</p>
<ul>
  <li>Nome do bolsista; Departamento; Grupo de  Disciplinas de atua&ccedil;&atilde;o do professor; </li>
  <li>Situa&ccedil;&atilde;o funcional (estabilidade, carreira e  regime de trabalho); s&oacute; poder&atilde;o solicitar afastamento os professores que j&aacute;  tenham passado o per&iacute;odo de est&aacute;gio probat&oacute;rio; </li>
  <li>Tempo da UTFPR e tempo faltante para a  aposentadoria de acordo com o DERHU; </li>
  <li>Termo de Compromisso de perman&ecirc;ncia no regime  correspondente ao do afastamento por igual per&iacute;odo, conforme a Delibera&ccedil;&atilde;o n&ordm;  29/91 de 29/11/91; </li>
  <li>Curso de P&oacute;s-Gradua&ccedil;&atilde;o pretendido e respectiva  institui&ccedil;&atilde;o; </li>
  <li><em>Classifica&ccedil;&atilde;o  do Curso perante os crit&eacute;rios da CAPES</em>; </li>
  <li><em>Carta  de aceite no respectivo curso de P&oacute;s-Gradua&ccedil;&atilde;o</em>; </li>
  <li>Disciplinas previstas para realiza&ccedil;&atilde;o (n&uacute;mero de  cr&eacute;ditos e prazos previstos); </li>
  <li>Esbo&ccedil;o preliminar do trabalho final a realizar  (monografia, disserta&ccedil;&atilde;o ou tese); </li>
  <li>Orientador previsto e respectiva titula&ccedil;&atilde;o, ou  respons&aacute;vel pela &aacute;rea de interesse; </li>
  <li>Cronograma envolvendo todas as atividades  previstas; </li>
  <li>Descri&ccedil;&atilde;o da aplica&ccedil;&atilde;o dos conhecimentos  adquiridos na P&oacute;s-Gradua&ccedil;&atilde;o frente as aulas ministradas pelo Departamento, e/ou  em outras &aacute;reas de atua&ccedil;&atilde;o e pesquisa no Departamento e na Institui&ccedil;&atilde;o; </li>
  <li>Concord&acirc;ncia do Departamento correspondente no  que se refere ao afastamento do professor, quanto a: (1) a absor&ccedil;&atilde;o, pelo  Departamento, da carga hor&aacute;ria a cargo do professor, sem necessidade de novas  contrata&ccedil;&otilde;es; e (2) a linha de pesquisa indicada para os estudos de  P&oacute;s-Gradua&ccedil;&atilde;o, em particular destacando as atua&ccedil;&otilde;es previstas em rela&ccedil;&atilde;o &agrave;  estrutura j&aacute; existente no Departamento. </li>
  <li>Crit&eacute;rios para  o Afastamento : </li>
</ul>
<p align=\"justify\">O afastamento para a  realiza&ccedil;&atilde;o de P&oacute;s-Gradua&ccedil;&atilde;o deve ser feito de acordo com o <em>Projeto de Afastamento para P&oacute;s-Gradua&ccedil;&atilde;o</em>,  conforme descrito no item anterior, e de acordo com o Plano Institucional para  a Capacita&ccedil;&atilde;o de Docentes de cada Departamento da Institui&ccedil;&atilde;o. Dever&atilde;o ainda  ser obedecidos todos os requisitos constantes da Delibera&ccedil;&atilde;o n&ordm; 29/91 de  29/11/91, que trata do regulamento de afastamento de docentes para realiza&ccedil;&atilde;o  de cursos de P&oacute;s-Gradua&ccedil;&atilde;o.<br />
  Na an&aacute;lise, que ser&aacute; realizada  pela Diretoria de P&oacute;s-Gradua&ccedil;&atilde;o e Pesquisa, ser&atilde;o observados itens  correspondentes &agrave;s &uacute;ltimas avalia&ccedil;&otilde;es do docente, seu desempenho em atividades  de ensino e pesquisa, atendimento &agrave;s recomenda&ccedil;&otilde;es da CAPES, e qualidade do  Curso de P&oacute;s-Gradua&ccedil;&atilde;o pretendido.<br />
  Poder&atilde;o ser solicitadas  atrav&eacute;s da &nbsp;UTFPR bolsas de &oacute;rg&atilde;os de  fomento para docentes que atendam aos requisitos. Entretanto esta solicita&ccedil;&atilde;o  n&atilde;o &eacute; requisito para que o afastamento seja autorizado pelo UTFPR, desde que o  docente declare que aceita realizar o afastamento com &ocirc;nus limitado (sem  bolsa).</p>
<ul>
  <li>Tempo de  afastamento: </li>
</ul>
<p>Dever&aacute; ser atendido o constante na Delibera&ccedil;&atilde;o n&ordm;  29/91 de 29/11/91, que prev&ecirc; os seguintes passos:</p>
<ul>
  <li><em>Mestrado</em>:  afastamento inicial de 18 meses prorrog&aacute;veis por mais 6 meses; </li>
  <li><em>Doutorado</em>:  afastamento inicial de 24 meses prorrog&aacute;veis por mais 24 meses; </li>
</ul>
<p>Os tempos indicados devem ser considerados como  tempo m&aacute;ximo de afastamento. No caso de mudan&ccedil;a de (mestrado para doutorado)  durante a realiza&ccedil;&atilde;o do curso, o per&iacute;odo m&aacute;ximo de afastamento n&atilde;o poder&aacute;  exceder a 60 meses.</p>
<ul>
  <li>Avalia&ccedil;&atilde;o do  Docente Afastado para P&oacute;s-Gradua&ccedil;&atilde;o: </li>
</ul>
<p>A avalia&ccedil;&atilde;o do docente ser&aacute; feita de acordo com o  Projeto acima descrito e com informa&ccedil;&otilde;es fornecidas pelo docente, atrav&eacute;s de <em>relat&oacute;rios  semestrais</em> de acompanhamento a serem enviados &agrave; DIPOG.<br />
  Os relat&oacute;rios dever&atilde;o conter:<br />
  Para docentes cursando disciplinas:</p>
<ul>
  <li>Hist&oacute;rico Escolar emitido pelo curso  correspondente; </li>
  <li>Relat&oacute;rio de atividades </li>
</ul>
<p>Para docentes em fase de reda&ccedil;&atilde;o de trabalho;</p>
<ul>
  <li>Relat&oacute;rio de atividades; </li>
  <li>Relat&oacute;rio do orientador sobre o processo do  trabalho. </li>
</ul>
<p>Em ambos os casos:</p>
<ul>
  <li>Indica&ccedil;&atilde;o dos trabalhos realizados, participa&ccedil;&atilde;o  em congressos e outros eventos; </li>
  <li>Modifica&ccedil;&otilde;es e atualiza&ccedil;&otilde;es do projeto original. </li>
</ul>
<p>A avalia&ccedil;&atilde;o do docente ser&aacute; feita de acordo com  os seguintes crit&eacute;rios:<br />
  Item 7. Fator de Produ&ccedil;&atilde;o:</p>
<ul>
  <li>(a): Avaliado de acordo com o desempenho do  docente em rela&ccedil;&atilde;o &agrave;s disciplinas cursadas no programa de P&oacute;s-Gradua&ccedil;&atilde;o, de  acordo com uma m&eacute;dia ponderada em rela&ccedil;&atilde;o aos graus obtidos, considerando-se os  pesos A: 3,0; B: 2,0 e C: 0,0 em rela&ccedil;&atilde;o ao total de cr&eacute;ditos cursados, at&eacute; um  m&aacute;ximo de 40 pontos. No caso de per&iacute;odo de desenvolvimento de trabalho, a  avalia&ccedil;&atilde;o ser&aacute; feita de acordo com o relat&oacute;rio do orientador; </li>
  <li>(b) e (c): Avaliados de acordo com o relat&oacute;rio  t&eacute;cnico enviado pelo docente e sua adequa&ccedil;&atilde;o ao Cronograma previsto no projeto,  at&eacute; um m&aacute;ximo de 36 pontos; </li>
  <li>(d) e (e): Avaliados de acordo com as  publica&ccedil;&otilde;es em Congressos, etc. e outros trabalhos correlatos, com pontua&ccedil;&atilde;o  m&aacute;xima de 10 pontos por trabalho e at&eacute; um total de 30 pontos. </li>
  <li>A pontua&ccedil;&atilde;o m&aacute;xima do item &eacute; de 80 pontos. </li>
</ul>
<p>Item 8. Fator de Aperfei&ccedil;oamento:</p>
<ul>
  <li>(a), (b), (c), (d) e (e): Avaliados de acordo  com a participa&ccedil;&atilde;o do docente em eventos, com um m&aacute;ximo de 10 pontos por  participa&ccedil;&atilde;o e at&eacute; um total de 20 pontos. </li>
</ul>
<p><em>Observa&ccedil;&atilde;o</em>:  poder&atilde;o ter sua avalia&ccedil;&atilde;o penalizada os docentes que n&atilde;o cumprirem os prazos  estipulados no seu Projeto de Afastamento.</p>
<ul>
  <li>Disposi&ccedil;&atilde;o  Transit&oacute;ria: </li>
</ul>
<p>A partir de 1997 a avalia&ccedil;&atilde;o tem sido  feita de acordo com esta proposta.</p>
<p><strong>Prof. Luiz Nacamura Junior</strong><br />
DIRETOR DE P&Oacute;S-GRADUA&Ccedil;&Atilde;O E PESQUISA </p>
<p><strong>Prof. Carlos Eduardo Cantarelli</strong><br />
DIRETOR DE ENSINO</p>
<img src=\"../images/seta_preta.gif\"> <a href =\"../anexos/afastamento.doc\" class=\"link_escuro\"><b>Download do arquivo</b></a>
<br><br><div align=\"center\"><input name=\"btnVoltar\" type=\"button\" class=\"botao\" id=\"btnVoltar\" value=\"« Voltar\" onclick=\"javascript:history.go(-1)\"></div><br><br>
	");
$template->parseCurrentBlock("bloco_conteudo");

/* Bloco da Data */
$template->setCurrentBlock("bloco_data");
	$template->setVariable("data", getData(0));
$template->parseCurrentBlock("bloco_data");

/* Bloco Geral */
$template->setCurrentBlock("bloco_geral");
	/* Links Superiores */
	$template->setVariable("linkUtf", UTFPR);
	$template->setVariable("linkDepog", DEPOG);
	/* Menu */
	foreach($menu['principal'] as $menu => $cont){
		foreach($cont as $link => $titulo){
			$template->setVariable($menu, "<a href = \"$titulo\" class = \"link_claro\">$link</a>");
		}
	}
$template->parseCurrentBlock("bloco_geral");

/* Bloco do Título */
$template->setCurrentBlock("bloco_titulo");
	$template->setVariable("titulo", TITULO);
$template->parseCurrentBlock("bloco_titulo");

$template->show();
?>