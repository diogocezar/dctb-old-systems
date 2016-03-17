var Reports = {

	tipo: '',
	
	dataDe: '',
	
	dataAte:'',
	
	tipoData: '',
	
	inside: false,
	
	cliente: '',
	
	contato: '',
	
	veiculo: '',
	
	fornecedor: '',
	
	usuario: '',
		
	init: function(){
		jQuery("#conteudoRelatorio").hide();
		jQuery("#formAnalitico").hide();
		if(jQuery("#enviar")) jQuery("#enviar").click(Reports.loadReport);
		if(jQuery("#frm_opt_tipo")) jQuery("#frm_opt_tipo").change(Reports.changeType);
		if(jQuery("#frm_obg_cliente")) jQuery("#frm_obg_cliente").change(Contacts.getContacts);
	},
	
	changeType: function(){
		switch(jQuery("#frm_opt_tipo").attr("value")){
			case 'sintetico':
				jQuery("#formAnalitico").fadeOut("slow");
				jQuery("#formAnalitico").hide();
				jQuery("#formGeral").show();
			break;
			
			case 'analitico':
				jQuery("#formAnalitico").hide();
				jQuery("#formAnalitico").fadeIn("slow");
				jQuery("#formAnalitico").show();
				jQuery("#formGeral").show();
			break;
		}
	},
	
	loadReport: function(){
		Reports.tipo       = jQuery("#frm_opt_tipo").attr("value");
		Reports.dataDe     = jQuery("#frm_obg_datade").attr("value");
		Reports.dataAte    = jQuery("#frm_obg_dataate").attr("value");
		Reports.cliente    = jQuery("#frm_obg_cliente").attr("value");
		Reports.contato    = jQuery("#frm_obg_contato").attr("value");
		Reports.veiculo    = jQuery("#frm_opt_veiculo").attr("value");
		Reports.fornecedor = jQuery("#frm_obg_fornecedor").attr("value");
		Reports.usuario    = jQuery("#frm_obg_usuario").attr("value");
		
		if(jQuery("#datacadastro").attr("checked")){
			Reports.tipoData = jQuery("#datacadastro").attr("value");
		}
		if(jQuery("#datacoleta").attr("checked")){
			Reports.tipoData = jQuery("#datacoleta").attr("value");
		}
		
		jQuery("#conteudoRelatorio").empty().html("<img src=\"../images/loadingAnimation.gif\"> Aguarde, carregando...");
		jQuery("#conteudoRelatorio").show();
		jQuery.post("../php/frmGeraRelatorios.php", {tipo: Reports.tipo, 
					                                 data_de: Reports.dataDe, 
													 data_ate: Reports.dataAte, 
													 tipo_data: Reports.tipoData, 
													 inside: Reports.inside, 
													 cliente: Reports.cliente,
													 contato: Reports.contato,
													 veiculo: Reports.veiculo,
													 fornecedor: Reports.fornecedor,
													 usuario: Reports.usuario
													 }, 
		function(data){
			jQuery("#conteudoRelatorio").empty().html(url_decode(data));
			jQuery("#conteudoRelatorio").hide();
			jQuery("#conteudoRelatorio").fadeIn("slow");
			jQuery("#conteudoRelatorio").show();
		});
		if(jQuery("#enviar")) jQuery("#enviar").click(Reports.loadReport);
	}	
}

jQuery(document).ready(function(){
	Reports.init();
	Contacts.init();
});