function checkCookies(){
	if (typeof window.checkCookie == 'function') {
		checkCookie();
	}
	checkCookieIntro();
}
function checkCookieIntro() {
	var valoracioaquestacanco = getCookie("index-intro");
	if (!(valoracioaquestacanco != null && valoracioaquestacanco != "")) { // Si existeix
		document.getElementById('radio-gramola-info').style.display='block';
	}
}
function deleteIntro() {
	setCookie("index-intro",1,365);
	document.getElementById('radio-gramola-info').style.display='none';
}
function getCookie(c_name) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name) {
			return unescape(y);
		}
	}
}
function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
