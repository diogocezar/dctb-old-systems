/**
* function call_addCategoria(ordem, nome, link)
*/
function call_addCategoria(nome, feed, ordem){
	var erro = false;
	if(nome == ""){
		alert('Digite o nome para o menu.');
		erro = true;
	}
	if(feed == ""){
		alert('Digite a url do rss.');
		erro = true;
	}
	if(ordem == ""){
		alert('Digite a ordem do menu.');
		erro = true;
	}
	if(!erro){
	x_addCategoria(nome, feed, ordem, return_addCategoria);
	}
}

function return_addCategoria(retorno){
	if(retorno){
	   window.location.reload();
	   nome.value = "";
	   feed.value = "";
	   ordem.value = "";
	}
	else{
	   alert('Não foi possível adicionar a categoria!');
	}
}

/**
* function call_login(login, senha)
*/
function call_login(login, senha){
	var erro = false;
	
	if(login == ""){
		alert('Digite o login.');
		erro = true;
	}
	if(senha == ""){
		alert('Digite a senha.');
		erro = true;
	}
	if(!erro){
		x_login(login, senha, return_login);
	}
}

function return_login(retorno){
	if(retorno){
		window.location.reload();
	}
	else{
		alert('Não foi possível autentica-lo.');
	}
}

/**
* function call_rmvCategoria(id)
*/
function call_rmvCategoria(id){
	x_rmvCategoria(id, return_rmvCategoria);
}

function return_rmvCategoria(resultado){
	if(resultado){
		window.location.href='../php/index.php';
	}
	else{
		alert('Essa categoria ainda possue sub-itens, remova-os!');
	}
}

/**
* function call_logout()
*/
function call_logout(login, senha){
	x_logout(return_logout);
}

function return_logout(retorno){
	window.location.reload();
}
