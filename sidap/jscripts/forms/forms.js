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
		if(radioObj[i].value == newValue.toString()) {
			radioObj[i].checked = true;
		}
	}
	if(newValue == 'pessoa_fornecedor'){
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

/**
* JQuery
* Script que aciona o filtro de contatos por cliente
* ao se escolher um cliente a lista de contatos é alterada,
* exibindo apenas os contatos do cliente selecionado.
*/

var Agenda = {
	
	getAgendaByDateHour: function(date){
		if(!date){
			date = jQuery("#data").attr("value");
		}
		date = url_encode(date);
		x_agendaByDateHour(date,  Agenda.return_getAgendaByDateHour);
	},
	
	return_getAgendaByDateHour: function(result){
		jQuery("#container").html(url_decode(result));
	}
	
}