/**
* JQuery
* Script gerenciar os checkbox da saída de manifesto
*/

var CheckConhecimentos = {
	
	init: function(option){
		if(jQuery("#checkAllConhecimentos")) jQuery("#checkAllConhecimentos").click(CheckConhecimentos.check);
	},
	
	check: function(){
		var checked_status = jQuery("#checkAllConhecimentos").attr("checked");
		jQuery("input[@name='conhecimentos[]']").each(function()
		{
			jQuery(this).attr("checked", checked_status);
		});
	}
}


jQuery(document).ready(function(){
	CheckConhecimentos.init();
});