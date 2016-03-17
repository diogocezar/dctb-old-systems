function clickRadio(radioObj, newValue){
	if(!radioObj)
		return;
	var radioLength = radioObj.length;
	if(radioLength == undefined) {
		radioObj.checked = (radioObj.value == newValue.toString());
		return;
	}
	for(var i = 0; i < radioLength; i++) {
		radioObj[i].checked = false;
		radioObj[i].disabled = true;
		if(radioObj[i].value == newValue.toString()) {
			radioObj[i].checked = true;
			radioObj[i].disabled = false;
		}
	}
	if(newValue == 'pessoa_fornecedor'){
		makeDisable('frm_opt_agregado');
		makeDisable('frm_opt_cliente');
		makeEnable ('frm_opt_fornecedor');
		
		
		makeDisable('frm_opt_agregado');
		makeDisable('frm_opt_cliente');
		makeEnable ('frm_opt_fornecedor');
	}
	else if(newValue == 'pessoa_cliente'){
		makeDisable('frm_opt_agregado');
		makeDisable('frm_opt_fornecedor');
		makeEnable ('frm_opt_cliente');
	}
	else{
		makeDisable('frm_opt_cliente');
		makeDisable('frm_opt_fornecedor');
		makeEnable ('frm_opt_agregado');
	}
}

function makeDisable(op){
    var x=document.getElementById(op)
    x.disabled=true
}
function makeEnable(op){
    var x=document.getElementById(op)
    x.disabled=false
}

function makeChecked(op){
    var x=document.getElementById(op)
    x.checked=true
}

function makeUnChecked(op){
    var x=document.getElementById(op)
    x.checked=false
}

/**
* JQuery
* Script que seleciona um status automaticamente a partir das
* opções selecionados no formulário de coleta
*/

var Status = {
	
	statusInicialVeiculo:0,
	
	statusInicialData:'',
	
	statusAlteradoVeiculo:0,
	
	statusAlteradoData:'',
	
	atribuiVeiculo:true,
	
	init: function(){
		if(jQuery("#frm_opt_veiculo") && jQuery("#frm_obg_data")){
			Status.statusInicialVeiculo = jQuery("#frm_opt_veiculo").attr("value");
			jQuery("#frm_opt_veiculo").change(Status.getStatus);
			
			Status.statusInicialData = jQuery("#frm_obg_data").attr("value");
			jQuery("#frm_obg_data").change(Status.getStatus);
		}
	},
	
	getStatus: function(){
		if(Status.statusInicialData == jQuery("#frm_obg_data").attr("value")){
			if(Status.statusInicialVeiculo == "NULL" && jQuery("#frm_opt_veiculo").attr("value") != "NULL"){
				jQuery("#frm_obg_status").val("EM ANDAMENTO");
			}
			if(Status.statusInicialVeiculo != "NULL" && jQuery("#frm_opt_veiculo").attr("value") != "NULL"){
				jQuery("#frm_obg_status").val("REMANEJADO");
			}
			Status.statusAlteradoVeiculo = jQuery("#frm_opt_veiculo").attr("value");
		}
		else{
			jQuery("#frm_obg_status").val("REAGENDADO");
			if(Status.statusAlteradoData == ''){
				jQuery("#frm_opt_veiculo").val("NULL");
			}
		    Status.statusAlteradoData = jQuery("#frm_obg_data").attr("value");
		}
		Contacts.init();
	}	
}

/**
* JQuery
* Script que aciona o filtro de contatos por cliente
* ao se escolher um cliente a lista de contatos é alterada,
* exibindo apenas os contatos do cliente selecionado.
*/

var Contacts = {
	
	init: function(){
		if(jQuery("#frm_obg_cliente")) jQuery("#frm_obg_cliente").change(Contacts.getContacts);
	},
	
	getContacts: function(){
		var id  = jQuery("#frm_obg_cliente").attr("value");
		x_getContacts(id, Contacts.return_getContacts);
	},
	
	return_getContacts: function(result){
		jQuery("#contatosFiltrados").html(url_decode(result));
		Status.init();
	}
	
}

/**
* JQuery
* Script que verifica os campos ao aterar a senha de um usuário
*/

var AlterarSenha = {
	
	send: function(option){
		var senhaAtual = jQuery("#frm_obg_senhaAtual").attr("value");
		var novaSenha  = jQuery("#frm_obg_novaSenha").attr("value");
		var confirma   = jQuery("#frm_obg_confirmaSenha").attr("value");
		
		var trava = false;
		if(senhaAtual == "" || novaSenha == "" || confirma == ""){
			alert('Existem campos em branco.');	
			trava = true;
		}
		if(novaSenha != confirma){
			alert('As senhas digitadas não conferem.');	
			trava = true;
		}
		if(senhaAtual == novaSenha){
			alert('A nova senha deve ser diferente da senha antiga.');	
			trava = true;
		}
		if(!trava){
			switch(option){
				default: case 'sitrans': x_alterarSenha(senhaAtual, novaSenha,  AlterarSenha.return_alterarSenha); break;
				case 'contato': x_alterarSenhaContato(senhaAtual, novaSenha,  AlterarSenha.return_alterarSenha); break;
			}
		}
	},
	
	return_alterarSenha: function(result){
		alert(url_decode(result));
	}
}

/**
* JQuery
* Script que verifica atravéz de AJAX se o cliente já solicitou uma coleta em uma determinada data
*/

var CheckColeta = {
	
	init: function(option){
		if(jQuery("#frm_obg_cliente")) jQuery("#frm_obg_cliente").change(CheckColeta.getCheckColeta);
	},
	
	getCheckColeta: function(){
		var idCliente  = jQuery("#frm_obg_cliente").attr("value");
		var data       = jQuery("#frm_obg_data").attr("value");
		x_getCheckColeta(idCliente, data, CheckColeta.return_getCheckColeta);
	},
	
	return_getCheckColeta: function(result){
		if(result == 1){
			alert('Atenção: Uma coleta já foi cadastrada para esse cliente na data selecionada.');	
		}
	}	
}

/**
* JQuery
* Script que verifica atravéz de AJAX o status do manifesto a ser cadastrado
*/
var StatusManifesto = {
	
	conhecimentos:false,
	peso:false,
	volume:false,
	nota_fiscal:false,
	frete:false,
	
	getStatusManifesto: function(){
		var codigo  = jQuery("#frm_opt_codigo").attr("value");
		x_getStatusManifesto(codigo, 'ctrc', StatusManifesto.return_getStatusManifesto);
	},
	
	return_getStatusManifesto: function(result){
		if(result != ""){
			var conteudo = jQuery("#msg").html();
			jQuery("#msg").html(conteudo + url_decode(result));
		}
		else{
			StatusManifesto.conhecimentos = true;
		}
	},
	
	getStatusManifestoPeso: function(){
		var codigo  = jQuery("#frm_opt_codigo").attr("value");
		x_getStatusManifesto(codigo, 'peso', StatusManifesto.return_getStatusManifestoPeso);
	},
	
	return_getStatusManifestoPeso: function(result){
		if(result != ""){
			var conteudo = jQuery("#msg").html();
			jQuery("#msg").html(conteudo + url_decode(result));
		}
		else{
			StatusManifesto.peso = true;
		}
	},
	
	getStatusManifestoVol: function(){
		var codigo  = jQuery("#frm_opt_codigo").attr("value");
		x_getStatusManifesto(codigo, 'vol', StatusManifesto.return_getStatusManifestoVol);
	},
	
	return_getStatusManifestoVol: function(result){
		if(result != ""){
			var conteudo = jQuery("#msg").html();
			jQuery("#msg").html(conteudo + url_decode(result));
		}
		else{
			StatusManifesto.volume = true;
		}
	},	
	
	getStatusManifestoNf: function(){
		var codigo  = jQuery("#frm_opt_codigo").attr("value");
		x_getStatusManifesto(codigo, 'nf', StatusManifesto.return_getStatusManifestoNf);
	},
	
	return_getStatusManifestoNf: function(result){
		if(result != ""){
			var conteudo = jQuery("#msg").html();
			jQuery("#msg").html(conteudo + url_decode(result));
		}
		else{
			StatusManifesto.nota_fiscal = true;
		}
	},	
	
	getStatusManifestoFrete: function(){
		var codigo  = jQuery("#frm_opt_codigo").attr("value");
		x_getStatusManifesto(codigo, 'frete', StatusManifesto.return_getStatusManifestoFrete);
	},
	
	
	return_getStatusManifestoFrete: function(result){
		if(result != ""){
			var conteudo = jQuery("#msg").html();
			jQuery("#msg").html(conteudo + url_decode(result));
		}
		else{
			StatusManifesto.frete = true;
		}
		StatusManifesto.selectStatus();
	},	
	
	verificaItens: function(){
		jQuery("#loading").show();
		jQuery("#loading").html("Aguarde... processando conhecimentos.");
		StatusManifesto.getStatusManifestoPeso();
		StatusManifesto.getStatusManifestoVol();
		StatusManifesto.getStatusManifestoNf();
		StatusManifesto.getStatusManifestoFrete();
	},
		
	selectStatus: function(){
		if(StatusManifesto.frete && StatusManifesto.nota_fiscal && StatusManifesto.volume && StatusManifesto.peso && StatusManifesto.conhecimentos){
			jQuery("#msg").hide();
			StatusManifesto.selectFechado();
		}
		else{
			jQuery("#msg").show();
			StatusManifesto.selectAberto();
		}
		jQuery("#loading").hide();
	},
	
	selectAberto: function(){
		jQuery("#frm_obg_statusmanifesto").val("EM ABERTO");	
	},
	selectFechado: function(){
		jQuery("#frm_obg_statusmanifesto").val("FECHADO");	
	}
}

/**
* JQuery
* Script que cria uma sessão, armazenando um código de manifesto para cadastrar os conhecimentos
*/
var SessionManifesto = {
	
	init: function(option){
		if(jQuery("#frm_obg_manifesto")) jQuery("#frm_obg_manifesto").change(SessionManifesto.getSession);
	},
	
	getSession: function(){
		var codigo  = jQuery("#frm_obg_manifesto").attr("value");
		if(codigo != "NULL"){
			x_sessionManifesto(codigo, SessionManifesto.return_getSession);
		}
	},
	
	checkSession: function(){
		var codigo  = jQuery("#frm_obg_manifesto").attr("value");
		x_checkSession(codigo, SessionManifesto.return_checkSession);
	},
	
	return_getSession: function(result){
		if(result != ""){
			alert(url_decode(result));
			jQuery("#frm_obg_manifesto").val("");
		}
	},
	
	return_checkSession: function(result){
		if(result == "NULL"){
			alert("Todos os conhecimentos foram cadastrados com sucesso.");	
		}
		jQuery("#frm_obg_manifesto").val(result);		
	}
}

/**
* JQuery
* Script que cria altera o status de um Status do Conhecimento
*/
var StatusConhecimento = {
	changeStatusConhecimento: function(id, status){
		x_changeStatusConhecimento(id, status, StatusConhecimento.return_changeStatusConhecimento);
	},
	
	return_changeStatusConhecimento: function(result){
		document.location.reload();
	}
}

/**
* JQuery
* Script que gerencia as buscas de clientes no conhecimento
*/
var BuscaCliente = {

	init: function(){
		if(jQuery("#frm_obg_cnpf_remetente")) jQuery("#frm_obg_cnpf_remetente").blur(BuscaCliente.goBuscaRemetente);
		if(jQuery("#frm_obg_cnpf_destinatario")) jQuery("#frm_obg_cnpf_destinatario").blur(BuscaCliente.goBuscaDestinatario);
	},
	
	start: function(){
		var cnpf_remetente    = jQuery("#frm_obg_cnpf_remetente").attr('value');
		var cnpf_destinatario = jQuery("#frm_obg_cnpf_destinatario").attr('value');
		
		if(cnpf_remetente != ""){
			BuscaCliente.goBuscaRemetente();	
		}
		if(cnpf_destinatario != ""){
			BuscaCliente.goBuscaDestinatario();
		}
	},
	
	goBuscaRemetente: function(){
		var cnpf = jQuery("#frm_obg_cnpf_remetente").attr('value');
		if(cnpf != ""){
			jQuery("#div_remetente").fadeOut("slow");
			jQuery("#div_remetente").hide();
			jQuery("#loading_remetente").fadeIn("slow");
			jQuery("#loading_remetente").show();
			x_returnDataCnpf(cnpf, BuscaCliente.return_buscaRemetente);
		}
	},
	
	return_buscaRemetente: function(result){
		jQuery("#frm_obg_inscestadualrg_remetente").val(result['inscestadualrg']);
		jQuery("#frm_obg_nome_remetente").val(result['nome']);
		jQuery("#frm_opt_cep_remetente").val(result['cep']);
		jQuery("#frm_obg_rua_remetente").val(result['rua']);
		jQuery("#frm_obg_numero_remetente").val(result['numero']);
		jQuery("#frm_opt_complemento_remetente").val(result['complemento']);
		jQuery("#frm_obg_bairro_remetente").val(result['bairro']);
		jQuery("#frm_obg_cidade_remetente").val(result['cidade']);
		jQuery("#frm_obg_estado_remetente").val(result['estado']);
		jQuery("#frm_obg_telefone_remetente").val(result['telefone']);
		jQuery("#frm_opt_fax_remetente").val(result['fax']);
		jQuery("#frm_ema_email_remetente").val(result['email']);
		
		jQuery("#loading_remetente").fadeOut("slow");
		jQuery("#loading_remetente").hide();
		jQuery("#div_remetente").fadeIn("slow");
		jQuery("#div_remetente").show();
		
		jQuery("#frm_obg_inscestadualrg_remetente").focus();
	},
	
	goBuscaDestinatario: function(){
		var cnpf = jQuery("#frm_obg_cnpf_destinatario").attr('value');
		if(cnpf != ""){
			jQuery("#div_destinatario").fadeOut("slow");
			jQuery("#div_destinatario").hide();
			jQuery("#loading_destinatario").fadeIn("slow");
			jQuery("#loading_destinatario").show();
			x_returnDataCnpf(cnpf, BuscaCliente.return_buscaDestinatario);
		}
	},
	
	return_buscaDestinatario: function(result){
		jQuery("#frm_obg_inscestadualrg_destinatario").val(result['inscestadualrg']);
		jQuery("#frm_obg_nome_destinatario").val(result['nome']);
		jQuery("#frm_opt_cep_destinatario").val(result['cep']);
		jQuery("#frm_obg_rua_destinatario").val(result['rua']);
		jQuery("#frm_obg_numero_destinatario").val(result['numero']);
		jQuery("#frm_opt_complemento_destinatario").val(result['complemento']);
		jQuery("#frm_obg_bairro_destinatario").val(result['bairro']);
		jQuery("#frm_obg_cidade_destinatario").val(result['cidade']);
		jQuery("#frm_obg_estado_destinatario").val(result['estado']);
		jQuery("#frm_obg_telefone_destinatario").val(result['telefone']);
		jQuery("#frm_opt_fax_destinatario").val(result['fax']);
		jQuery("#frm_ema_email_destinatario").val(result['email']);
		
		jQuery("#loading_destinatario").fadeOut("slow");
		jQuery("#loading_destinatario").hide();
		jQuery("#div_destinatario").fadeIn("slow");
		jQuery("#div_destinatario").show();
		
		jQuery("#frm_obg_inscestadualrg_destinatario").focus();
	},
}


jQuery(document).ready(function(){
	Contacts.init();
	Status.init();
	CheckColeta.init();
	SessionManifesto.init();
	BuscaCliente.init();
});