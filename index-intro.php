<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RàdioGramola.cat | Ràdio musical 24 hores en català</title>
<meta name="keywords" content="música, català, música català, cançons català, ràdio català, televisió musical català, llista cançons català, descobrir cançons català, rock català, pop català" />
<meta name="description" content="Ràdio musical 24 hores en català, música i cançons en català tot el dia: Els Pets, Els Amics de les Arts, Manel, Sopa de Cabra, Sau, Antònia Font, Élena, Brams, Obrint Pas, La Gossa Sorda, Lax 'n' Busto, Els Catarres, Teràpia de Xoc, Vuit, Beth..." />
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
</head>
<body onload="checkCookie()">
<!-- Facebook -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ca_ES/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- FI Facebook -->
<div id="wrapper">
<h4>Imagina una ràdio musical 24 hores en català</h4>
<h4>Imagina una ràdio on els usuaris influeixen en la programació amb les seves votacions</h4>
<h4>Imagina una ràdio que no només pots escoltar, sinó que pots mirar i hi pots participar</h4>
<h1>RàdioGramola.cat</h1>
<h2>el 6 de novembre neix un nou concepte de ràdio</h2>
<p><a href="http://www.twitter.com/radiogramola">@radiogramola</a></p>
<div class="fb-like-box" data-href="http://www.facebook.com/pages/R%C3%A0dio-Gramola/134222510016651" data-width="292" data-show-faces="false" data-stream="false" data-header="true"></div>
<p style="margin-right: 340px; padding: 0 100px;">
<?php 
	/* Posem l'hora en hora :D */
	date_default_timezone_set('Europe/Andorra');
	$segonsdesdemitjanit = intval(date("h") * 3600) + intval(date("i") * 60) + intval(date("s"));

	/* Connectem amb la BD i seleccionem la taula */
	$con = mysql_connect("localhost","myrad571","BO26a1Wz");
	if (!$con) die("S'ha produït un error, disculpeu les molèsties: " . mysql_error());
	mysql_select_db("psicoajuradio", $con);
	mysql_set_charset('utf8',$con);
	
	/* Comptem el número de cançons */
	$query = "SELECT * FROM llista WHERE aprovada = 1 AND artista NOT LIKE '3XL.Dance' GROUP BY artista";
	$result = mysql_query($query);
	
	$primer = true;
	
	while($row = mysql_fetch_array($result)) {
		if ($primer) {
			echo $row['artista'];
			$primer = false;
		}
		else echo ", ".str_replace(" ","&nbsp;",$row['artista']);
	}
	
	/* Comptem el número de cançons */
	$query = "SELECT COUNT(nom) FROM llista WHERE aprovada = 1";
	$result = mysql_query($query);
	$numcancons = mysql_fetch_array($result);
	
	mysql_close($con);
?>
 i molts altres
<!--Els Pets, Els Amics de les Arts, Manel, Sopa de Cabra, Sau, Antònia Font, Élena, Brams, Obrint Pas, La Gossa Sorda, Lax 'n' Busto, Els Catarres, Teràpia de Xoc, Vuit, Beth, Acció Festiva...-->
</p>
</body>
</html>
