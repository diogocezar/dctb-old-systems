/*
	Feito por : Diogo Cezar Teixeira Batista

	file.js
	Função para adicionar inputs do tipo file
*/

/* Qtd de fotos */
var qtdFiles = 0;
/* Variavel que armazena a imagem ou null */
var escondido = 0;
/* Variavel de controle para mostrar/ocultar miniatura */
var mostra = true;
/* Variavel temporária para remover uma foto ao ocorrer algum erro */
var tempRemover;

/*
 * Insere n inputs do tipo file
 * @param String div Nome do div que está o input
 * @param String prefix Nome do prefixo gerado antes da numeração sequencial
 * @param String remover O que será exibido no remover
 * @param String arquivo Nome do arquivo
 * @param String linkAnc Link do remover
 */
function addInputFile(div, prefix, remover, arquivo, linkAnc){
	qtdFiles++;
	document.getElementById(div).innerHTML += '<div id="'+prefix+qtdFiles+'"><input type="file" name="arquivos[]" size="40" class="form" id="fotoId_'+qtdFiles+'" onChange="verificaFoto(\'fotoId_'+qtdFiles+'\', \''+prefix+qtdFiles+'\')"> <a href="'+linkAnc+'" onClick="document.all.'+prefix+qtdFiles+'.style.display=\'none\';document.all.mE1.style.display=\'none\';document.all.mE2.style.display=\'none\';document.getElementById(\'imgP\').src=\'\'">'+remover+'</a></div>';
	document.all.mE1.style.display='none';
	document.all.mE2.style.display='none';
}

/*
 * Esconde a miniatura da imagem
 */
function esconder(){
	document.all.mE2.style.display='none';
	document.all.mE1.style.display='';
	document.getElementById('preVM').innerHTML = '<a href="javascript:;" onclick="mostrar()" class="link_claro">Mostrar miniatura</a>';
}

/*
 * Mostra a miniatura da imagem
 */
function mostrar(){
	document.all.mE1.style.display='none';
	document.all.mE2.style.display='';
	document.getElementById('preV').innerHTML = '<a href="javascript:;" onclick="esconder()" class="link_claro"><br>Esconder miniatura<br></a><br><img onload="getSize()" width="200" src="'+escondido+'" name="imgP" id="imgP">';
	document.getElementById('preVM').innerHTML = '';
}

/*
 * Gera a miniatura da imagem
 */
function preview(){
	var img = document.getElementById('imgP');
	if(mostra)	mostrar();
	else		esconder();
}

/*
 * Verifica a foto antes de envia-la
 * @param String nome Nome do input atual
 * @param String remover Nome da foto a ser removida, caso algum erro ocorra
 */
function verificaFoto(nome, remover){
	var obj = document.getElementById(nome);
	var v = obj.value;
	var extencao=v.substr(v.length - 4).toLowerCase();
	var extPerm = new Array(".gif",".jpg",".png","jpeg",".GIF",".JPG",".PNG","JPEG");
	tempRemover = remover;
	if(!findArray(extPerm,extencao)){ 
		alert("Só são permitidas fotos nos formatos GIF, PNG e JPG/JPEG");
		var panel = eval('document.all.'+remover+'.style.display=\'none\'');
		document.all.mE.style.display='none';
		return 0;
	}
	var img = document.getElementById('imgP');
	var esc = document.getElementById('preV');
	img.src = "file://"+obj.value;
	img.heigth = 180;
	escondido = img.src;
}

/*
 * Verifica o tamanho da foto
 */
function getSize(){
	if(document.getElementById('imgP').fileSize > 509600){
		alert("A foto não pode ter mais de 500 KB.");
		var panel = eval('document.all.'+tempRemover+'.style.display=\'none\'');
		tempRemover = null;
		document.all.mE1.style.display='none';
		document.all.mE2.style.display='none';
		return 0;
	}
	return 1;
}

/*
 * Procura o valor em um array
 * @param Array arr Array a ser procurado
 * @param String str Valor a ser procurado
 */
function findArray(arr,str){
	for(i=0; arr.length>i; i++){
		if(arr[i] == str) return 1;
	}
	return 0;
}
