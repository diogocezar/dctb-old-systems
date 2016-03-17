function getMozSelection(txtarea) {
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd==1 || selEnd==2) selEnd=selLength;
	return (txtarea.value).substring(selStart, selEnd);
}

function mozWrap(txtarea, lft, rgt) {
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd==1 || selEnd==2) selEnd=selLength;
	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + lft + s2 + rgt + s3;
}

function IEWrap(lft, rgt) {
	strSelection = document.selection.createRange().text;
	if (strSelection!="") {
	document.selection.createRange().text = lft + strSelection + rgt;
	}
}

function wrapSelection(txtarea, lft, rgt) {
	if (document.all) {IEWrap(lft, rgt);}
	else if (document.getElementById) {mozWrap(txtarea, lft, rgt);}
}
function wrapSelectionWithLink(txtarea) {
	var my_link = prompt("Adicione a url:","http://");
	if (my_link != null) {
		lft="[URL=" + my_link + ".FECHA]";
		rgt="[/URL]";
		wrapSelection(txtarea, lft, rgt);
	}
	return;
}

function wrapSelectionWithImg(txtarea) {
	var my_link = prompt("Adicione a imagem:","http://");
	if (my_link != null) {
		lft="[URL=" + my_link + ":FECHA]";
		txtarea.value += lft;
	}
	return;
}	

function mouseover(el) {
	el.className = "raise";
	}

function mouseout(el) {
	el.className = "buttons";
}

function mousedown(el) {
	el.className = "press";
}

function mouseup(el) {
	el.className = "raise";
}

function Limpa(txtarea){
	txtarea.value = '';
}