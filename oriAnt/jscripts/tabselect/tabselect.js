/*
 * Função para mostrar e ocultar as opções do menu
 */
function tabSelect(num){
	for(i=1; i<=5; i++){
		panel=eval('document.getElementById("tabela' + i + '").style;');
		if(i==num){
			if(panel.display == ''){
				panel.display='none';	
			}
			else{
				panel.display='';
			}
		}
		else{
			panel.display='none';
		}
	}
}