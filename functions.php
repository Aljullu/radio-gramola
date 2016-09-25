<?php
	
$baseUrl = '';

function connecta() {
	$con = mysqli_connect("localhost","user","password");
	if (!$con) die("S'ha produït un error, disculpeu les molèsties: " . mysql_error());
	mysqli_select_db($con, "radiogramola");
	mysqli_set_charset($con, 'utf8');
	return $con;
}
	
function getPosicio($con, $posmes) {
	connecta();
	/* Busquem la posició de vots positius */
	$query = "SELECT COUNT(id) AS pos FROM llista WHERE aprovada = 1 AND posmes > ". $posmes ."";
	$infopos = mysqli_query($con, $query);
	$posicio = mysqli_fetch_array($infopos);
	$posicio = $posicio[0] + 1;
	return $posicio;
}

function nameToUri($nom) {
	$uri = trim($nom);
	$uri = strtolower($uri);
	$uri = str_replace(" ","-",$uri);
	$uri = str_replace("'","-",$uri);
	$uri = str_replace("·","",$uri);
	$uri = str_replace(",","",$uri);
	$uri = str_replace(".","",$uri);
	$uri = str_replace("(","",$uri);
	$uri = str_replace(")","",$uri);
	$uri = str_replace("!","",$uri);
	$uri = str_replace("?","",$uri);
	$uri = str_replace("&","",$uri);
	$uri = str_replace("º","",$uri);
	$uri = str_replace("*","",$uri);
	$uri = str_replace("à","a",$uri);
	$uri = str_replace("è","e",$uri);
	$uri = str_replace("é","e",$uri);
	$uri = str_replace("î","i",$uri);
	$uri = str_replace("í","i",$uri);
	$uri = str_replace("ò","o",$uri);
	$uri = str_replace("ó","o",$uri);
	$uri = str_replace("ú","u",$uri);
	$uri = str_replace("ï","i",$uri);
	$uri = str_replace("ü","u",$uri);
	$uri = str_replace("ç","c",$uri);
	$uri = str_replace("À","a",$uri);
	$uri = str_replace("È","e",$uri);
	$uri = str_replace("É","e",$uri);
	$uri = str_replace("Í","i",$uri);
	$uri = str_replace("Ò","o",$uri);
	$uri = str_replace("Ó","o",$uri);
	$uri = str_replace("Ú","u",$uri);
	$uri = str_replace("Ç","c",$uri);
	$uri = str_replace("Ï","i",$uri);
	$uri = str_replace("Ü","u",$uri);
	$uri = str_replace("ñ","n",$uri);
	$uri = str_replace("Ñ","n",$uri);
	$uri = str_replace("--","-",$uri);
	
	return $uri;
}

function printContextMenu($con, $id, $menuid) {
  global $baseUrl;
	/* Agafem la informació de l'artista */
	$query = "SELECT uri, nom FROM artistes WHERE id = ".$id;
	$infoartista = mysqli_query($con, $query);
	$artista = mysqli_fetch_array($infoartista);
	echo '<menu id="'.$menuid.'" type="context">';
		echo '<menu label="'.$artista['nom'].'">';
			echo '<menuitem label="Fitxa" onClick="window.open(\''. $baseUrl .'/d/'.$artista['uri'].'\',\'_newtab\');"></menuitem>';
			echo '<menu label="Cançons">';
				/* Agafem les cançons */
				$query = "SELECT uri, nom FROM llista WHERE artistaid = ".$id." AND aprovada = 1 ORDER BY nom";
				$infocancollista = mysqli_query($con, $query);
				while ($cancollista = mysqli_fetch_array($infocancollista)) {
						echo "<menuitem label=\"".$cancollista['nom']."\" onClick=\"window.open('". $baseUrl ."/d/".$artista['uri']."/".$cancollista['uri']."','_newtab');\"></menuitem>";
				}
			echo '</menu>';
		echo '</menu>';
	echo '</menu>';
}

function timeToSeconds($durada) {
	$duradasegons = explode(":",$durada);
	$duradasegons = $duradasegons[0]*3600 + $duradasegons[1]*60 + $duradasegons[2];
	return $duradasegons;
}

function formatTime($time) {
    $timeArray = explode(":", $time);
    
    if ($timeArray[0] != "00") return (int)$timeArray[0] . ":" . $timeArray[1] . ":" . $timeArray[2];
    
    return (int)$timeArray[1] . ":" . $timeArray[2];
}

function valoracio($con, $valoracio, $antvaloracio, $canco) {
	if ($valoracio == "1") {
		$noupos = intval($canco['pos']) + 1;
		$nouposmes = intval($canco['posmes']) + 1;
		if ($antvaloracio == "0") {
			$nouneg = intval($canco['neg']) - 1;
			$nounegmes = intval($canco['negmes']) - 1;
			$queryant = ", neg=".$nouneg.", negmes=".$nounegmes." ";
		}
		$query = "UPDATE llista SET pos=". $noupos .", posmes=". $nouposmes .$queryant." WHERE id='".$canco['id']."'";
		mysqli_query($con, $query);
	}
	elseif ($valoracio == "0") {
		$nouneg = intval($canco['neg']) + 1;
		$nounegmes = intval($canco['negmes']) + 1;
		if ($antvaloracio == "1") {
			$noupos = intval($canco['pos']) - 1;
			$nouposmes = intval($canco['posmes']) - 1;
			$queryant = ", pos=".$noupos.", posmes=".$nouposmes." ";
		}
		$query = "UPDATE llista SET neg=". $nouneg .", negmes=". $nounegmes .$queryant." WHERE id='".$canco['id']."'";
		mysqli_query($con, $query);
	}
}

function printCssIncludes($styles = array()) {
  global $baseUrl;
	echo '<link href="'. $baseUrl .'/style.css" rel="stylesheet"/>';
	
	foreach ($styles as $style) {
	    echo '<link href="'. $baseUrl . $style.'" rel="stylesheet"/>';
	}
}

function printJavascriptIncludes() {
  global $baseUrl;
	echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="'. $baseUrl .'/js/functions.js" type="text/javascript"></script>';
}

function printGoogleAnalyticsCode() {
	echo "<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-26277445-2', 'auto');
  ga('send', 'pageview');

</script>";
}

function printCollabora() {
  global $baseUrl;
  echo '<div class="horizontal-ad">
			<a href="'. $baseUrl .'/p/collabora" title="Col·labora amb Ràdio Gramola"><img src="'. $baseUrl .'/img/collabora/collabora728x90.png" alt="Col·labora amb Ràdio Gramola"/></a>
		</div>';
}

function printBanner() {
  return;
  global $baseUrl;
  echo '<div class="horizontal-ad">
			<a href="https://play.google.com/store/apps/details?id=com.t_estalvia" title="Tarifes TMB" target="_blank"><img src="'. $baseUrl .'/img/baners/t-estalvia-banner.png" alt="Baixa l\'aplicació T-Estalvia per a estalviar utilitzant el transport públic"/></a>
		</div>';
}

function printWebInfo($portada) {
  global $baseUrl;
	echo '<div id="radio-gramola-info" style="display: none;">
		<h3>Ràdio Gramola</h3>
		<h1>La ràdio de música en català</h1>
		<p>Ràdio Gramola és una ràdio-televisió musical per Internet que emet videoclips de grups i artistes que canten en català.</p>';
	if ($portada) {
		echo '<a class="mes-informacio" href="'. $baseUrl .'/p/pmf" rel="nofollow" target="_blank">més informació</a>';
	}
	else {
		echo '<a class="mes-informacio" href="'. $baseUrl .'" target="_blank" title="Ràdio en català">Vés a l\'inici</a>';
	}
	echo '<span class="amaga" onClick="deleteIntro();"><img alt="x" src="'. $baseUrl .'/img/close.png"/></span>
	</div>';
}

function printSocialButtons() {
			/* Twitter */
			echo '<a href="https://twitter.com/share" class="twitter-share-button" data-via="radiogramola" data-count="none">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';

			/* Facebook */
			echo '<a name="fb_share"></a> 
			<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" 
					type="text/javascript">
			</script>';
			
			/* Google+ */
			echo '<g:plusone size="medium"></g:plusone>

			<!-- Place this render call where appropriate -->
			<script type="text/javascript">
			  window.___gcfg = {lang: \'ca\'};

			  (function() {
				var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
				po.src = \'https://apis.google.com/js/plusone.js\';
				var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>';
}

function replaceLastCommaWithAnd($keyword) {
	$keyword = preg_replace('/,([^,]*)$/', ' i\1', $keyword);
	return $keyword; 
}

function performe404() { 
  global $baseUrl;   
  echo '<meta http-equiv="refresh" content="0;URL=' . $baseUrl . '/404">';
  die();
}
?>
