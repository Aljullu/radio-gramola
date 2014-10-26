<?php
	include 'functions.php';

	/* Connectem amb la BD i seleccionem la taula */
	$con = connecta();
	
	/* Calculem la durada total */
	$query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(durada))) FROM llista WHERE aprovada = 1";
	$result = mysql_query($query);
	$tempscancons = mysql_fetch_array($result);
	/* Els vots positius totals */
	$query = "SELECT SUM(posmes) FROM llista WHERE aprovada = 1";
	$result = mysql_query($query);
	$totalpos = mysql_fetch_array($result);
	/* i els vots negatius */
	$query = "SELECT SUM(negmes) FROM llista WHERE aprovada = 1";
	$result = mysql_query($query);
	$totalneg = mysql_fetch_array($result);
	
?>
<!DOCTYPE html>
<html>
<head>
<?php printCssIncludes(); ?>
<link rel="shortcut icon" href="/favicon.ico">
<link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="Cerca de Ràdio Gramola">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?php
		$page_exploded = explode("/",$_SERVER['REQUEST_URI']);
		if ($page_exploded[1] == "serie") {
			$serie = $page_exploded[2];
		}
		else if ($page_exploded[1] == "cancons-sobre") {
		    $tema = $page_exploded[2];
		}
		if (isset($serie)) {
		$query = "SELECT nom, title, text
					FROM series
					WHERE uri LIKE '".$serie."'";
		$infoserie = mysql_query($query);
		$arrayserie = mysql_fetch_array($infoserie)
	?>
<title>Llista de cançons de <?php echo $arrayserie['nom']; ?> | Ràdio musical 24 hores en català, la millor música en llengua catalana</title>
<meta name="keywords" content="cançons <?php echo $arrayserie['nom']; ?>, música <?php echo $arrayserie['nom']; ?>, bso <?php echo $arrayserie['nom']; ?>, llista de cançons de <?php echo $arrayserie['nom']; ?>, <?php echo $arrayserie['nom']; ?>, cançó <?php echo $arrayserie['nom']; ?>" />
<meta name="description" content="Llista de cançons de <?php echo $arrayserie['nom']; ?> amb les lletres, videoclips, informació dels grups, artistes i àlbums." />
	<?php
		}
		else if (isset($tema)) {
		$query = "SELECT nom, description
					FROM temes
					WHERE uri LIKE '".$tema."'";
		$infotema = mysql_query($query);
		$arraytema = mysql_fetch_array($infotema)
	?>
<title>Llista de cançons de <?php echo $arraytema['nom']; ?> en català | Ràdio musical 24 hores en català, la millor música en llengua catalana</title>
<meta name="keywords" content="cançons de <?php echo $arraytema['nom']; ?>, cançons sobre <?php echo $arraytema['nom']; ?>, cançons de <?php echo $arraytema['nom']; ?> en català, música <?php echo $arraytema['nom']; ?> en català, llista de cançons sobre <?php echo $arraytema['nom']; ?>, <?php echo $arraytema['nom']; ?>" />
<meta name="description" content="Llista de cançons de <?php echo $arrayserie['nom']; ?> en català amb les lletres, videoclips, informació dels grups, artistes i àlbums." />
	<?php
		}
		else {
	?>
<title>Llista de cançons | Ràdio musical 24 hores en català, la millor música en llengua catalana</title>
<meta name="keywords" content="llista de cançons en català, cançons en català, música en català, millors cançons en català, top 10 cançons en català, grups en català, grups de música en català, canciones en catalán, música en catalán, catalan songs, catalan music" />
<meta name="description" content="Llista de cançons en català, informació de grups, artistes, àlbums, lletres i vídeos de música en llengua catalana." />
	<?php
		}
	?>
<?php printGoogleAnalyticsCode(); ?>
<?php printJavascriptIncludes(); ?>
<script src="/js/sorttable.js"></script>
<script src="/js/jquery.quicksearch.js"></script>
<script>
$(document).ready(function() {
	$('input#cercador').quicksearch('table#llista tbody tr');
	if (window.external.IsSearchProviderInstalled('http://www.radiogramola.cat/opensearch.xml') == 0) {
		$('#opensearch').show();
	}
});
</script>
</head>
<body onload="checkCookies()">
<div id="wrapper">
	<?php printWebInfo(false); ?>
<!-- AdSense -->
<script type="text/javascript"><!--
google_ad_client = "ca-pub-7541474864707154";
// Top
google_ad_slot = "0560773860";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<!-- FI AdSense -->
	<?php
		if (!isset($serie) && !isset($tema)) {
	?>
<h1 class="page-title">La llista de cançons</h1>
<div id="content">
	<p>A continuació apareix una llista amb les cançons en català que sonen a Ràdio Gramola, amb informació sobre l'artista i la durada.</p>
	<p>Feu clic sobre els títols de les columnes per ordenar la taula segons diferents criteris.</p>
	<p>Podeu veure, també, la <a href="http://www.radiogramola.cat/llista-cancons.php?mes=novembre-2011" title="Llista de cançons en català" rel="nofollow">llista de cançons amb els vots del novembre</a>, el <a href="http://www.radiogramola.cat/llista-cancons.php?mes=desembre-2011" rel="nofollow">desembre</a>, el <a href="http://www.radiogramola.cat/llista-cancons.php?mes=gener-2012" rel="nofollow">gener</a>, el <a href="http://www.radiogramola.cat/llista-cancons.php?mes=febrer-2012" rel="nofollow">febrer</a>, el <a href="http://www.radiogramola.cat/llista-cancons.php?mes=marc-2012" rel="nofollow">març</a> i l'<a href="http://www.radiogramola.cat/llista-cancons.php?mes=abril-2012" rel="nofollow">abril</a>.</p>
	<form name="input" action="#" method="get">
		<h2>Cercador</h2>
		<p>
			<input id="cercador" name="s" placeholder="Nom de la cançó, artista o àlbum" size="30" type="search" value="<?php echo $_GET['s']; ?>"/>
			<input type="submit" value="Cerca" onclick="return false;" />
		</p>
		<p id="opensearch" style="display:none;" ><small><a href="javascript:void(0)" onClick="window.external.AddSearchProvider('http://www.radiogramola.cat/opensearch.xml');">Instal·leu-vos aquest cercador al navegador.</a></small></p>
	</form>
	<?php
		} elseif (isset($tema)) {
        // Temes
	    $query = "SELECT T.uri, T.nom
				    FROM temes T, llista LL, canconstemes C
				    WHERE T.id = C.idtema
					    AND LL.id = C.idcanco
					    AND T.uri NOT LIKE '".$tema."'
				    GROUP BY T.id
				    ORDER BY COUNT(*) DESC";

	    $infopopulartemes = mysql_query($query); 
		$texttoprint = "";
		$first = true;
		while ($populartema = mysql_fetch_array($infopopulartemes)) {
			if (!$first) $texttoprint .= ', ';
			else $first = false;
			$texttoprint .= '<a href="/cancons-sobre/'. $populartema['uri'] .'" title="Cançons de '. $populartema['nom'] .'">'. $populartema['nom'] .'</a>';
		}
	?>
<h1 class="page-title">Cançons de <?php echo $tema; ?></h1>
<div id="content">
	    <p>A continuació es mostren cançons en català sobre «<strong><?php echo $tema; ?>»</strong>.</p>
	    
	    <p>Podeu cercar altres temes populars: <?php echo replaceLastCommaWithAnd($texttoprint); ?>.</p>
	<?php
		} elseif (!$arrayserie['text'] || !$arrayserie['title']) {
	?>
<h1 class="page-title">Cançons de <?php echo $arrayserie['nom']; ?></h1>
<div id="content">
	<p>A continuació es llisten les cançons en català que apareixen a la sèrie de televisió <?php echo $arrayserie['nom']; ?>.</p>
	<?php
		} else {
	?>
<h1 class="page-title"><?php echo $arrayserie['title']; ?></h1>
<div id="content">
		<?php /*
		<div class="right-ad">
			<!-- Begin: adBrite, Generated: 2013-01-13 13:47:45  -->
			<script type="text/javascript">
			var AdBrite_Title_Color = '882222';
			var AdBrite_Text_Color = 'CC3535';
			var AdBrite_Background_Color = 'FFFFFF';
			var AdBrite_Border_Color = 'FFFFFF';
			var AdBrite_URL_Color = '1122CC';
			var AdBrite_Page_Url = '';
			try{var AdBrite_Iframe=window.top!=window.self?2:1;var AdBrite_Referrer=document.referrer==''?document.location:document.referrer;AdBrite_Referrer=encodeURIComponent(AdBrite_Referrer);}catch(e){var AdBrite_Iframe='';var AdBrite_Referrer='';}
			</script>
			<script type="text/javascript">document.write(String.fromCharCode(60,83,67,82,73,80,84));document.write(' src="http://ads.adbrite.com/mb/text_group.php?sid=2273673&zs=3330305f323530&ifr='+AdBrite_Iframe+'&ref='+AdBrite_Referrer+'&purl='+encodeURIComponent(AdBrite_Page_Url)+'" type="text/javascript">');document.write(String.fromCharCode(60,47,83,67,82,73,80,84,62));</script>
			<!-- End: adBrite -->
		</div>
		*/ ?>
	<?php echo $arrayserie['text']; ?>
	<?php
		}
	?>
</div>
<?php /*
<script type="text/javascript"><!--
google_ad_client = "ca-pub-7541474864707154";
// Intro
google_ad_slot = "2888749030";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<div class="horizontal-ad">
	<!-- Begin: adBrite, Generated: 2013-01-13 13:53:38  -->
	<script type="text/javascript">
	var AdBrite_Title_Color = '882222';
	var AdBrite_Text_Color = 'CC3535';
	var AdBrite_Background_Color = 'FFFFFF';
	var AdBrite_Border_Color = 'FFFFFF';
	var AdBrite_URL_Color = '008000';
	var AdBrite_Page_Url = '';
	try{var AdBrite_Iframe=window.top!=window.self?2:1;var AdBrite_Referrer=document.referrer==''?document.location:document.referrer;AdBrite_Referrer=encodeURIComponent(AdBrite_Referrer);}catch(e){var AdBrite_Iframe='';var AdBrite_Referrer='';}
	</script>
	<span style="white-space:nowrap;"><script type="text/javascript">document.write(String.fromCharCode(60,83,67,82,73,80,84));document.write(' src="http://ads.adbrite.com/mb/text_group.php?sid=2273678&zs=3732385f3930&ifr='+AdBrite_Iframe+'&ref='+AdBrite_Referrer+'&purl='+encodeURIComponent(AdBrite_Page_Url)+'" type="text/javascript">');document.write(String.fromCharCode(60,47,83,67,82,73,80,84,62));</script>
	<!-- End: adBrite -->
</div>
*/ ?>
<table id="llista" class="sortable">
	<thead>
		<tr>
			<th>Nom</th>
			<th>Àlbum</th>
			<th>Artista</th>
			<th>Durada</th>
	<?php if (!isset($serie)) { ?>
			<th>Vots positius</th>
			<th>Vots negatius</th>
	<?php } else { ?>
			<th>Temporada</th>
			<th>Capítol</th>
	<?php } ?>
		</tr>
	</thead>
	<?php if (!isset($serie) && !isset($tema)) { ?>
	<tfoot>
		<tr>
			<td colspan="3">Total</td>
			<td><?php echo formatTime($tempscancons[0]); ?></td>
			<td class="pos"><?php echo $totalpos[0]; ?></td>
			<td class="neg"><?php echo $totalneg[0]; ?></td>
		</tr>
	</tfoot>
	<?php } ?>
	<tbody>
	<?php
		$ordre = "artistes.nom";
		if ($_GET["ordre"] == "classificacio") {
			$ordre = "llista.posmes DESC";
		}
		if ($_GET['mes'] == "novembre-2011") $mes = "pos112011 AS posmes, neg112011 AS negmes, ";
		elseif ($_GET['mes'] == "desembre-2011") $mes = "pos122011 AS posmes, neg122011 AS negmes, ";
		elseif ($_GET['mes'] == "gener-2012") $mes = "pos012012 AS posmes, neg012012 AS negmes, ";
		elseif ($_GET['mes'] == "febrer-2012") $mes = "pos022012 AS posmes, neg022012 AS negmes, ";
		elseif ($_GET['mes'] == "marc-2012") $mes = "pos032012 AS posmes, neg032012 AS negmes, ";
		elseif ($_GET['mes'] == "abril-2012") $mes = "pos042012 AS posmes, neg042012 AS negmes, ";
		elseif ($_GET['mes'] == "maig-2012") $mes = "pos052012 AS posmes, neg052012 AS negmes, ";
		else $mes = "posmes, negmes, ";
		if($serie) {
			$select = $select.", canconsseries.temporada AS temporada, canconsseries.capitol AS capitol";
			$join = $join.", series, canconsseries";
			$where = $where."AND series.id = canconsseries.idserie
				AND llista.id = canconsseries.idcanco
				AND series.uri LIKE '".$serie."'";
			$ordre = "canconsseries.temporada, canconsseries.capitol";
		}
		else if($tema) {
			$join = $join.", temes, canconstemes";
			$where = $where."AND temes.id = canconstemes.idtema
				AND llista.id = canconstemes.idcanco
				AND temes.uri LIKE '".$tema."'";
		}
		$query = "SELECT llista.uri, llista.nom, durada, ". $mes ."
				artistes.uri AS artistauri, artistes.nom AS artista, albums.nom AS album". $select ."
			FROM llista, artistes, albums".$join."
			WHERE llista.artistaid = artistes.id
				AND llista.albumid = albums.id
				AND aprovada = 1
				".$where."
			ORDER BY ". $ordre;
		$infocanco = mysql_query($query);
		$cancoadestacar = $_GET["destaca"];
		$i = 1;
		while ($canco = mysql_fetch_array($infocanco)) {
				$rowid = "";
				if($cancoadestacar == $canco['uri']) $rowid = "id='destacat' ";
				echo "<tr ".$rowid."itemscope itemtype='http://schema.org/MusicRecording'>";
				echo "<td><a href='/d/".$canco['artistauri']."/".$canco['uri']."'>";
				echo "<meta itemprop='url' content='http://www.radiogramola.cat/d/".$canco['artistauri']."/".$canco['uri']."'>";
				echo "<span itemprop='name'>".$canco['nom']."</span></a></td>";
				if (isset($canco['album']) && $canco['album'] != "") {
					echo "<td><span itemprop='inAlbum'>".$canco['album']."</span></td>";
				}
				else {
					echo "<td><span itemprop='inAlbum'>-</span></td>";
				}
				echo "<td><a href='/d/".$canco['artistauri']."'>".$canco['artista']."</a></td>";
				echo "<td class='durada'>";
				$durada = explode(":",$canco['durada']);
				echo "<meta itemprop='duration' content='PT". $durada[1] ."M". $durada[2] ."S'>";
				echo formatTime($canco['durada'])."</td>";
				if (!isset($serie)) {
					echo "<td class='pos'>".$canco['posmes']."</td>";
					echo "<td class='neg'>".$canco['negmes']."</td>";
				} else {
					switch ($canco['temporada']) {
						case 0:
							$temporada = "sd";
							break;
						default:
							$temporada = $canco['temporada'];
					}
					echo "<td class='serie-number'>".$temporada."</td>";
					switch ($canco['capitol']) {
						case -1:
							$capitol = "anunci";
							break;
						case 0:
							$capitol = "sd";
							break;
						default:
							$capitol = $canco['capitol'];
					}
					echo "<td class='serie-number'>".$capitol."</td>";
				}
				echo "</tr>";
				$i++;
		}
	?>
	</tbody>
</table>
</div>
</body>
</html>
<?php
		mysql_close($con);
?>
