function setCookie(name, value){
	var argv = setCookie.arguments;
	var argc = setCookie.arguments.length;
	var expires = new Date();
	expires.setTime(expires.getTime() + (24 * 60 * 60 * 1000 * 31)); 
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	document.cookie = name + "=" + escape (value) +
	((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
	((path == null) ? "" : ("; path=" + path)) +
	((domain == null) ? "" : ("; domain=" + domain)) +
	((secure == true) ? "; secure" : "");
}