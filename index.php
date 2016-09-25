<?php 
	include 'functions.php';
	/* Posem l'hora en hora :D */
	date_default_timezone_set('Europe/Andorra');
	$segonsdesdemitjanit = intval(date("h") * 3600) + intval(date("i") * 60) + intval(date("s"));

	/* Connectem amb la BD i seleccionem la taula */
	$con = connecta();
	
	/* Mirem quina cançó toca reproduir */
	$query = "SELECT *, MIN(hora) FROM (SELECT * FROM programacio WHERE hora > ".$segonsdesdemitjanit.") AS T";
	$infocancoareproduir = mysqli_query($con, $query);
	$infocancoareproduir = mysqli_fetch_array($infocancoareproduir);
	
	/* La busquem */
	$query = "SELECT llista.id, llista.uri, llista.nom, codi, durada, lletra, posmes, negmes, pos, neg, artistes.uri AS artistauri, artistes.nom AS artista FROM llista LEFT OUTER JOIN artistes ON llista.artistaid = artistes.id WHERE llista.id='".$infocancoareproduir['idcanco']."'";
	$infocancons = mysqli_query($con, $query);
	$infocanco[] = mysqli_fetch_array($infocancons);
	$canco = $infocanco[0];
	
	/* Calculem la durada */
	$duradasegons = timeToSeconds($canco['durada']);
	
	/* Busquem la cançó següent */
	$idabuscar = $infocancoareproduir['id']+1;
	$query = "SELECT * FROM programacio WHERE id='".$idabuscar."'";
	$infoprog = mysqli_query($con, $query);
	$infoprogseguent[] = mysqli_fetch_array($infoprog);
	$query = "SELECT llista.uri AS uri, llista.nom, artistaid, artistes.nom AS artista, durada FROM llista LEFT OUTER JOIN artistes ON llista.artistaid = artistes.id WHERE llista.id='".$infoprogseguent[0]['idcanco']."'";
	$infocancons = mysqli_query($con, $query);
	$infocancoseguent[] = mysqli_fetch_array($infocancons);
	$cancoseg = $infocancoseguent[0];
	
	/* Busquem la cançó anterior */
	$idabuscar = $infocancoareproduir['id']-1;
	$query = "SELECT * FROM programacio WHERE id='".$idabuscar."'";
	$infoprog = mysqli_query($con, $query);
	$infoproganterior[] = mysqli_fetch_array($infoprog);
	$query = "SELECT llista.nom, durada, artistaid, artistes.nom AS artista FROM llista LEFT OUTER JOIN artistes ON llista.artistaid = artistes.id WHERE llista.id='".$infoproganterior[0]['idcanco']."'";
	$infocancons = mysqli_query($con, $query);
	$infocancoanterior[] = mysqli_fetch_array($infocancons);
	$cancoant = $infocancoanterior[0];
	
	/* Calculem la durada */
	$duradasegonsanterior = timeToSeconds($cancoant['durada']);
	
	/* Calculem a quin punt de la cançó ens hem de situar */
	$segonsqueportalacanco = $segonsdesdemitjanit - $infoproganterior[0]['hora']; /* Hora en que hem entrat - hora en que ha començat la cançó */
	$segonsquefaltenperqueacabi = $duradasegons - $segonsqueportalacanco;
	
	/* Comptem el número de cançons */
	$query = "SELECT COUNT(nom) FROM llista WHERE aprovada = 1";
	$result = mysqli_query($con, $query);
	$numcancons = mysqli_fetch_array($result);
	
	/* Si l'usuari ha afegit una valoració */
	valoracio($con, $_POST['valoracio'], $_POST['antvaloracio'], $canco);
	
	if ($_POST['valoracio'] == 1) $canco['posmes']++;
	elseif ($_POST['valoracio'] == 0) $canco['negmes']++;
	if ($_POST['antvaloracio'] == 1) {
		$canco['posmes']--;
	}
	elseif ($_POST['antvaloracio'] == 0 && $_POST['antvaloracio'] != "none") {
		$canco['negmes']--;
	}
	
	/* Mida del reproductor */
	$width = 640;
	$height = 360;
	$controls = 0;
	if (isset($_GET['w'])) $width = $_GET['w'];
	if (isset($_GET['h'])) $height = $_GET['h'];
	if (isset($_GET['controls'])) $controls = $_GET['controls'];
?>
<!DOCTYPE html>
<html>
<head>
<?php printCssIncludes(); ?>
<link rel="shortcut icon" href="<?php echo $baseUrl; ?>/favicon.ico">
<link rel="search" type="application/opensearchdescription+xml" href="<?php echo $baseUrl; ?>/opensearch.xml" title="Cerca de Ràdio Gramola">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Ràdio Gramola, la ràdio televisió musical 24 hores en català. Grups de música catalans i en català. Lletres i vídeos.</title>
<meta name="keywords" content="música, català, música català, cançons català, ràdio català, televisió musical català, llista cançons català, descobrir cançons català, rock català, pop català" />
<meta name="description" content="Ràdio musical 24 hores en català, música i cançons en català tot el dia: Els Pets, Els Amics de les Arts, Manel, Sopa de Cabra, Sau, Antònia Font, Élena, Brams, Obrint Pas, La Gossa Sorda, Lax 'n' Busto, Els Catarres, Teràpia de Xoc, Vuit, Beth..." />

<?php /* Browser update */ ?>
<script type="text/javascript"> 
var $buoop = {vs:{i:8,f:3.5,o:11,s:3.2,n:9}} 
$buoop.ol = window.onload; 
window.onload=function(){ 
 try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
 var e = document.createElement("script"); 
 e.setAttribute("type", "text/javascript"); 
 e.setAttribute("src", "http://browser-update.org/update.js"); 
 document.body.appendChild(e); 
} 
</script> 

<?php printJavascriptIncludes(); ?>
<script type="text/javascript">
function checkCookie() {
	var haVotatPositiu = false;
	var haVotatNegatiu = false;
	
	// Cookie antiga
	var valoracioaquestacanco = getCookie("valoracio-<?php echo date('m'); ?>-<?php echo $canco['id']; ?>");
	if (valoracioaquestacanco != null && valoracioaquestacanco != "") { // Si existeix
		if (valoracioaquestacanco=="1") {
			haVotatPositiu = true;
			haVotatNegatiu = false;
		}
		else if (valoracioaquestacanco=="0") {
			haVotatPositiu = false;
			haVotatNegatiu = true;
		}
	}
	// Nova valoració
	valoracioaquestacanco = "<?php echo $_POST['valoracio']; ?>";
	if (valoracioaquestacanco != null && valoracioaquestacanco != "") {
		//document.cookie = "valoracio-<?php echo date('m'); ?>-<?php echo $canco['id']; ?>=; expires=" + d.toGMTString() + ";";
		// Creem la cookie
		setCookie("valoracio-<?php echo date('m'); ?>-<?php echo $_POST['id']; ?>",valoracioaquestacanco,31);
	}
	if (valoracioaquestacanco == "1") {
		haVotatPositiu = true;
		haVotatNegatiu = false;
	}
	else if (valoracioaquestacanco == "0") {
		haVotatPositiu = false;
		haVotatNegatiu = true;
	}
	
	if (haVotatPositiu) {
		$('.antvaloracio').attr('value','1');
		document.getElementById('form-pos').style.display='none';
		document.getElementById('image-pos').style.display='inline-block';
	}
	else if (haVotatNegatiu) {
		$('.antvaloracio').attr('value','0');
		document.getElementById('form-neg').style.display='none';
		document.getElementById('image-neg').style.display='inline-block';
	}
	else {
		$('.antvaloracio').attr('value','none');
	}
}
</script>
<?php printGoogleAnalyticsCode(); ?>
<script>
var t = setTimeout("reloadPage()", <?php echo $segonsquefaltenperqueacabi*1000; ?>);
function reloadPage() {
	window.location.href=window.location.href
}
</script>
<script>
function mostraLletra() {
	document.getElementById('lletra').style.display='inline-block';
	document.getElementById('lletra-link').style.display='none';
	document.getElementById('lletra-link-amaga').style.display='inline-block';
}
function amagaLletra() {
	document.getElementById('lletra').style.display='none';
	document.getElementById('lletra-link').style.display='inline-block';
	document.getElementById('lletra-link-amaga').style.display='none';
}
</script>
<script type="text/javascript">
// Preferències
function togglePreferences() {
	$("#preferencies").slideToggle();
}
function updateForm (w,h) {
	formulari = document.forms['preferencies'];
	formulari.elements['w'].value = w;
	formularih = formulari.elements['h'].value = h;
	updateSizeButtons();
}
function updateSizeButtons() {
	var w = $('#w').val();
	var h = $('#h').val();
	$("#mides li").each(function() {
		$(this).children().removeClass('selected');
		console.log("entrem");
	});
	$("#mides li a."+w+h).addClass('selected');
}
$(document).ready(function() {
	$('#w,#h').change(function() {
		updateSizeButtons();
	});
    if (jQuery.browser.mozilla) {
        $("#firefox-add-on").show();
    }
});
</script>
</head>
<body onload="checkCookies()">
<div id="wrapper">
	<?php /*<div style="text-align:center;"><em>Estem fent canvis per millorar la pàgina.<br/>Potser els propers minuts algunes coses no funcionaran correctament. Disculpeu les molèsties.</em></div>*/ ?>
	<?php printWebInfo(true); ?>
	<?php printBanner(); ?>
	<div id="info-canco">
		<div class="canco">«<a href="<?php echo $baseUrl; ?>/d/<?php echo $canco['artistauri']; ?>/<?php echo $canco['uri']; ?>" target="_blank"><?php echo $canco['nom']; ?></a>» — <a href="<?php echo $baseUrl; ?>/d/<?php echo $canco['artistauri']; ?>" target="_blank"><?php echo $canco['artista']; ?></a></div>
		</div>
	<div id="video">
		<iframe width="<?php echo $width; ?>" height="<?php echo $height; ?>" src="http://www.youtube.com/embed/<?php echo $canco['codi']; ?>?autoplay=1&iv_load_policy=3&controls=<?php echo $controls; ?>&start=<?php echo $segonsqueportalacanco; ?>" frameborder="0" allowfullscreen></iframe>
	</div>
	<div>
	<?php if(isset($canco['lletra']) && $canco['lletra'] != "") { ?>
		<div id="lletra-link"><a title="Mostra la lletra" onClick="mostraLletra()" style="cursor:pointer;">Mostra'n la lletra</a></div>
	<?php } ?>
		<div id="firefox-add-on" class="box" style="display:none;"><a target="_blank" href="http://addons.mozilla.org/ca/firefox/addon/radiogramola/" title="Baixeu-vos l'extensió de Ràdio Gramola per al Firefox">Extensió per al Firefox</a></div>
	</div>
	<div id="lletra" style="display:none;"><p><a  style="cursor:pointer;" onClick="amagaLletra()">Amaga</a></p><?php echo $canco['lletra']; ?><?php
		if (isset($canco['lletraviasona']) && $canco['lletraviasona'] != "" && $canco['lletraviasona'] != "0") {
		?><br/><a class="viasona-link" href="<?php echo $canco['lletraviasona'] ?>"><img src="http://www.viasona.cat/img/contingut/logo_petit.png" alt="Lletra de Viasona"/></a><?php
		}
		?></div>
	<div id="votacio">
		<div id="anterior" contextmenu="menu-anterior">
			<p><?php echo $cancoant['nom']; ?></p>
			<p><?php echo $cancoant['artista']; ?></p>
		</div>
		<?php printContextMenu($con, $cancoant['artistaid'], "menu-anterior"); ?>
		<div id="div-neg">
			<form id="form-neg" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $canco['id']; ?>"/>
				<input class="antvaloracio" type="hidden" name="antvaloracio" value=""/>
				<input type="hidden" name="valoracio" value="0"/>
				<a href="#" title="No m'agrada" onclick="parentNode.submit()"><img alt="No m'agrada" src="<?php echo $baseUrl; ?>/img/neg.png"/></a>
			</form>
			<img id="image-neg" title="No m'agrada" alt="No m'agrada" src="<?php echo $baseUrl; ?>/img/neg.png" style="display: none;"/>
			<span class="vots"><?php echo $canco['negmes']; ?></span>
		</div>
		<div id="div-pos">
			<form id="form-pos" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $canco['id']; ?>"/>
				<input class="antvaloracio" type="hidden" name="antvaloracio" value=""/>
				<input type="hidden" name="valoracio" value="1"/>
				<a href="#" title="M'agrada" onclick="parentNode.submit()"><img alt="M'agrada" src="<?php echo $baseUrl; ?>/img/pos.png"/></a>
			</form>
			<img id="image-pos" title="M'agrada" alt="M'agrada" src="<?php echo $baseUrl; ?>/img/pos.png" style="display: none;"/>
			<span class="vots"><?php echo $canco['posmes']; ?></span>
		</div>
		<div id="seguent" contextmenu="menu-seguent">
			<p><?php echo $cancoseg['nom']; ?></p>
			<p><?php echo $cancoseg['artista']; ?></p>
		</div>
		<?php printContextMenu($con, $cancoseg['artistaid'], "menu-seguent"); ?>
	</div>
	<div id="connectatsara">
		<script id="_wau9cp">var _wau = _wau || []; _wau.push(["classic", "gwkltbss03ez", "9cp"]);(function() { var s=document.createElement("script"); s.async=true; s.src="http://widgets.amung.us/classic.js";document.getElementsByTagName("head")[0].appendChild(s);})();</script>
	</div>
	<nav>
		<ul id="menu">
			<li><a title="Llista de cançons" href="<?php echo $baseUrl; ?>/llista-cancons.php" target="_blank">Llista de cançons</a></li>
			<li><a title="Suggereix una cançó" href="<?php echo $baseUrl; ?>/suggereix-canco.php" target="_blank">Suggereix una cançó</a></li>
			<li><a title="Preferències" onClick="togglePreferences();" style="cursor:pointer">Preferències</a></li>
			<li><a title="Col·labora amb Ràdio Gramola" href="<?php echo $baseUrl; ?>/p/collabora" target="_blank">Col·labora</a></li>
			<li><a title="Preguntes més freqüents" href="<?php echo $baseUrl; ?>/p/pmf" target="_blank"><abbr title="Preguntes més freqüents">PMF</abbr></a></li>
		</ul>
	</nav>
	<!-- Preferències -->
	<form id="preferencies" action="<?php echo $baseUrl; ?>/index.php" method="get" enctype="multipart/form-data" style="display:none">
	<div id="preferencies-table">
		<div>
			Mides del reproductor suggerides:<br/>
			<ul id="mides">
				<li><a class="480270" onClick="updateForm(480,270)" style="cursor: pointer;">480x270</a></li>
				<li><a class="640360 selected" onClick="updateForm(640,360)" style="cursor: pointer;">640x360</a></li>
				<li><a class="960540" onClick="updateForm(960,540)" style="cursor: pointer;">960x540</a></li>
				<li><a class="1280720" onClick="updateForm(1280,720)" style="cursor: pointer;">1280x720</a></li>
			</ul>
		</div>
		<div>
			<label for="w">Amplada del reproductor</label>
			<div class="number-input"><input id="w" name="w" value="<?php echo $width; ?>" type="number" /></div>
		</div>
		<div>
			<label for="h">Alçada del reproductor</label>
			<div class="number-input"><input id="h" name="h" value="<?php echo $height; ?>" type="number" /></div>
		</div>
		<div>
			<?php if($controls == 1) { $checked = " checked"; } ?>
			<td colspan="2"><label><input id="controls" name="controls" type="checkbox" value="1" <?php echo $checked; ?> />Mostra els controls</label></td>
		</div>
		<div>
			<input type="submit" value="Aplica"/>
			<button type="button" onClick="togglePreferences();">Cancel·la</button>
		</div>
	</div>
	</form>
	<p>Ja tenim <?php echo $numcancons[0]; ?> <a href="<?php echo $baseUrl; ?>/llista-cancons.php" target="_blank">cançons en català</a> a la llista.</p>
	<?php /* Com que és poc important per al SEO i amb CSS ho podem posicionar on vulguem, ho posem al final */ ?>
	<div id="social-links">
		<a target="_blank" href="http://www.facebook.com/radiogramola" title="Trobeu-nos al Facebook"><img alt="Facebook" src="<?php echo $baseUrl; ?>/img/social/fb.png"/></a>
		<a target="_blank" href="http://www.twitter.com/radiogramola" title="Trobeu-nos al Twitter"><img alt="Facebook" src="<?php echo $baseUrl; ?>/img/social/twitter.png"/></a>
		<a target="_blank" href="https://plus.google.com/b/104411283361538424673/104411283361538424673/posts" title="Trobeu-nos al Google+"><img alt="Google+" src="<?php echo $baseUrl; ?>/img/social/google.png"/></a>
	</div>
</div>
</body>
</html>
