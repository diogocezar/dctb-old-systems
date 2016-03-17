/**
* A J A X
*/

/**
* call_getExcluirFoto();
*/
function call_getExcluirFoto(tabela, foto, key, url){
	var tabela = url_encode(tabela);
	var foto   = url_encode(foto);
	var key    = url_encode(key);
	var url    = url_encode(url);
	var vDeleteRegister = confirm("Deseja realmente excluir a foto?");
	if(vDeleteRegister){
		x_excluirFoto(tabela, foto, key, url, return_getExcluirFoto);
	}
}

function return_getExcluirFoto(retorno){
	window.location.reload();
}