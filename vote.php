<?php 
	include 'functions.php';
	/* Posem l'hora en hora :D */
	date_default_timezone_set('Europe/Andorra');
	$segonsdesdemitjanit = intval(date("h") * 3600) + intval(date("i") * 60) + intval(date("s"));

	/* Connectem amb la BD i seleccionem la taula */
	connecta();
	
	/* Mirem quina cançó toca reproduir */
	$query = "SELECT *, MIN(hora) FROM (SELECT * FROM programacio WHERE hora > ".$segonsdesdemitjanit.") AS T";
	$infocancoareproduir = mysql_query($query);
	$infocancoareproduir = mysql_fetch_array($infocancoareproduir);
	
	/* La busquem */
	$query = "SELECT llista.id, llista.uri, llista.nom, codi, durada, lletra, posmes, negmes, artistes.uri AS artistauri, artistes.nom AS artista FROM llista LEFT OUTER JOIN artistes ON llista.artistaid = artistes.id WHERE llista.id='".$infocancoareproduir['idcanco']."'";
	$infocancons = mysql_query($query);
	$infocanco[] = mysql_fetch_array($infocancons);
	$canco = $infocanco[0];
	
	/* Calculem la durada */
	$duradasegons = explode(":",$canco['durada']);
	$duradasegons = $duradasegons[0]*3600 + $duradasegons[1]*60 + $duradasegons[2];
	
	/* Busquem la cançó anterior */
	$idabuscar = $infocancoareproduir['id']-1;
	$query = "SELECT * FROM programacio WHERE id='".$idabuscar."'";
	$infoprog = mysql_query($query);
	$infoproganterior[] = mysql_fetch_array($infoprog);
	$query = "SELECT llista.nom, durada, artistaid, artistes.nom AS artista FROM llista LEFT OUTER JOIN artistes ON llista.artistaid = artistes.id WHERE llista.id='".$infoproganterior[0]['idcanco']."'";
	$infocancons = mysql_query($query);
	$infocancoanterior[] = mysql_fetch_array($infocancons);
	$cancoant = $infocancoanterior[0];
	
	/* Calculem la durada */
	$duradasegonsanterior = timeToSeconds($cancoant['durada']);
	
	/* Calculem a quin punt de la cançó ens hem de situar */
	$segonsqueportalacanco = $segonsdesdemitjanit - $infoproganterior[0]['hora']; /* Hora en que hem entrat - hora en que ha començat la cançó */
	$segonsquefaltenperqueacabi = $duradasegons - $segonsqueportalacanco;
	
	/* Si l'usuari ha afegit una valoració */
	if (isset($_POST['valoracio'])) {
		if ($_POST['valoracio'] == "1") {
			$noupos = intval($canco['pos']) + 1;
			$nouposmes = intval($canco['posmes']) + 1;
			$query = "UPDATE llista SET pos=". $noupos .", posmes=". $nouposmes ." WHERE id='".$canco['id']."'";
			mysql_query($query);
			$canco['posmes'] = $canco['posmes'] + 1;
		}
		elseif ($_POST['valoracio'] == "0") {
			$nouneg = intval($canco['neg']) + 1;
			$nounegmes = intval($canco['negmes']) + 1;
			$query = "UPDATE llista SET neg=". $nouneg .", negmes=". $nounegmes ." WHERE id='".$canco['id']."'";
			mysql_query($query);
			$canco['negmes'] = $canco['negmes'] + 1;
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26277445-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script>
var t = setTimeout("reloadPage()", <?php echo $segonsquefaltenperqueacabi*1000; ?>);
function reloadPage() {
	window.location.href=window.location.href
}
</script>
<script type="text/javascript">
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
function checkCookie() {
	// Agafem la cookie
	var valoracioaquestacanco=getCookie("valoracio-<?php echo date('m'); ?>-<?php echo $infocanco[0]['id']; ?>");
	if (valoracioaquestacanco!=null && valoracioaquestacanco!="") { // Si existeix
		document.getElementById('form-neg').style.display='none';
		document.getElementById('form-pos').style.display='none';
		if (valoracioaquestacanco=="1") {
			document.getElementById('image-pos').style.display='inline-block';
		}
		else if (valoracioaquestacanco=="0") {
			document.getElementById('image-neg').style.display='inline-block';
		}
	}
	else { // Si no existeix
		valoracioaquestacanco="<?php echo $_POST['valoracio']; ?>";
		if (valoracioaquestacanco!=null && valoracioaquestacanco!="") {
			// Creem la cookie
			setCookie("valoracio-<?php echo date('m'); ?>-<?php echo $_POST['id']; ?>",valoracioaquestacanco,30);
		}
		if ("<?php echo $_POST['valoracio']; ?>"=="1") {
			document.getElementById('form-neg').style.display='none';
			document.getElementById('form-pos').style.display='none';
			document.getElementById('image-pos').style.display='inline-block';
			document.getElementById('image-neg').style.display='inline-block';
		}
		else if ("<?php echo $_POST['valoracio']; ?>"=="0") {
			document.getElementById('form-neg').style.display='none';
			document.getElementById('form-pos').style.display='none';
			document.getElementById('image-pos').style.display='inline-block';
			document.getElementById('image-neg').style.display='inline-block';
		}
	}
}
</script>
<meta name="robots" content="noindex, nofollow">
</head>
<body onload="checkCookie()">
<div id="votacio">
	<div id="div-pos">
		<form id="form-pos" action="index-lite.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $infocanco[0]['id']; ?>"/>
			<input type="hidden" name="valoracio" value="1"/>
			<a href="#" title="M'agrada" onclick="parentNode.submit()"><img alt="M'agrada" src="<?php echo $baseUrl; ?>/img/pos.png"/></a>
		</form>
		<img id="image-pos" title="M'agrada" alt="M'agrada" src="<?php echo $baseUrl; ?>/img/pos.png" style="display: none;"/>
		<span class="vots"><?php echo $canco['posmes']; ?></span>
	</div>
	<div id="div-neg">
		<form id="form-neg" action="index-lite.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $infocanco[0]['id']; ?>"/>
			<input type="hidden" name="valoracio" value="0"/>
			<a href="#" title="No m'agrada" onclick="parentNode.submit()"><img alt="No m'agrada" src="<?php echo $baseUrl; ?>/img/neg.png"/></a>
		</form>
		<img id="image-neg" title="No m'agrada" alt="No m'agrada" src="<?php echo $baseUrl; ?>/img/neg.png" style="display: none;"/>
		<span class="vots"><?php echo $canco['negmes']; ?></span>
	</div>
</div>
</div>
</body>
</html>
