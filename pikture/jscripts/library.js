/*
	Feito por : Diogo Cezar Teixeira Batista

	Biblioteca.js
	Conjunto de funções utilizadas em todo o site
*/


/*
 * Função para janela poup-up
 */
function abrir(url, largura, altura, scrool) {

   var width = largura;
   var height = altura;

   var left = 99;
   var top = 99;

   window.open(url, '', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars='+scrool+', status=yes, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');

}