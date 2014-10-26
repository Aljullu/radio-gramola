<?php
	include 'functions.php';
	/* Connectem amb la BD i seleccionem la taula */
	$con = connecta();
	if (!$con) die("S'ha produït un error, disculpeu les molèsties: " . mysql_error());
	mysql_select_db("psicoajuradio", $con);
	mysql_set_charset('utf8',$con);
?>
<!DOCTYPE html>
<html>
<head>
<?php printCssIncludes(array('//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css')); ?>
<link rel="shortcut icon" href="/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php printGoogleAnalyticsCode(); ?>
<?php printJavascriptIncludes(); ?>
<?php
//****************************
//****************************
//***********CANÇÓ************
//****************************
//****************************
if($_GET['type'] == 1) { // és una cançó
	$page_exploded = explode("/",$_SERVER['REQUEST_URI']);
	$uriartista = $page_exploded[2];
	$uricanco = $page_exploded[3];
	$query = "SELECT llista.id, llista.uri, llista.nom, codi, durada, lletra, lletraviasona, posmes, negmes, artistes.uri AS artistauri, artistes.nom AS artista, albums.nom AS album, albums.any AS albumany
		FROM llista
		LEFT OUTER JOIN artistes
			ON llista.artistaid = artistes.id
		LEFT OUTER JOIN albums
			ON llista.albumid = albums.id
		WHERE llista.uri='".$uricanco."'
		AND artistes.uri='".$uriartista."'
		AND aprovada = 1";
	$infocancons = mysql_query($query);
	$canco = mysql_fetch_array($infocancons);
	
	if (isset($canco['album']) && $canco['album'] != "") $tealbum = true;
	else $tealbum = false;

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
<?php
    // Temes
	$query = "SELECT T.uri, T.nom
				FROM temes T, llista LL, canconstemes C
				WHERE T.id = C.idtema
					AND LL.id = C.idcanco
					AND LL.id = ".$canco['id']."
				GROUP BY T.id";
	
	$infotema = mysql_query($query);
	
    // Series
	$query = "SELECT S.uri, S.nom
				FROM series S, llista LL, canconsseries C
				WHERE S.id = C.idserie
					AND LL.id = C.idcanco
					AND LL.id = ".$canco['id']."
				GROUP BY S.id";
	
	$infoserie = mysql_query($query);
	
	if ($infoserie) {
	    if (mysql_num_rows($infoserie) > 0) {
		    $first = true;
		    while ($serie = mysql_fetch_array($infoserie)) {
			    if (!$first) {
				    $titleserie .= ', '. $serie['nom'];
				    $descriptionseries .= ", ". $serie['nom'];
			    }
			    else {
				    $first = false;
				    $titleserie = ', cançó de '. $serie['nom'];
				    $descriptionseries = ". Cançó de ". $serie['nom'];
			    }
			    $keywordsseries .= ", ". $serie['nom'];
		    }
		    $descriptionseries = replaceLastCommaWithAnd($descriptionseries);
	    }
    }
    else {
        performe404();
    }
?>
<title><?php echo $canco['nom']." — ".$canco['artista'].$titleserie; ?> | Ràdio musical 24 hores en català, la millor música en llengua catalana</title>
<?php
if ($tealbum) {
	if ($canco['albumany'] > 0) {
		$textdelalbum = " de l'àlbum ". $canco['album'] ." de l'any ". $canco['albumany'];
		$keywordsalbum = $canco['album'].", lletra ".$canco['album'].", ". $canco['albumany'] .", ";
	} else {
		$textdelalbum = " de l'àlbum ". $canco['album'];
		$keywordsalbum = $canco['album'].", lletra ".$canco['album'].", ";
	}
} ?>
<meta name="keywords" content="<?php echo $canco['nom'].", lletra ".$canco['nom'].", letra ".$canco['nom'].", ".$canco['nom']." lyrics, ".$canco['artista'].", lletra ".$canco['artista'].", video ".$canco['nom'].", ".$keywordsalbum."video ".$canco['artista']; ?><?php echo $keywordsseries; ?>" />
<meta name="description" content="Lletra i videoclip de la cançó <?php echo $canco['nom']; ?> de <?php echo $canco['artista']; ?><?php echo $textdelalbum; ?>. Inclou la lletra, el vídeo i informació de l'artista i l'àlbum<?php echo $descriptionseries; ?>." />
<script type="text/javascript">
function checkCookie() {
	// Agafem la cookie
	var valoracioaquestacanco=getCookie("valoracio-<?php echo date('m'); ?>-<?php echo $canco['id']; ?>");
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
	<h1 class="page-title"><?php echo $canco['nom'] ?></h1>
	<div id="content">
		<!-- AdSense -->
		<div style="float: right; margin-top: 10px;">
			<script type="text/javascript"><!--
            google_ad_client = "ca-pub-7541474864707154";
            /* Page big 2 */
            google_ad_slot = "9101701169";
            google_ad_width = 300;
            google_ad_height = 250;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
		</div>
		<!-- FI AdSense -->
		<div id="social-buttons">
			<?php printSocialButtons(); ?>
		</div>
		<section id="page-informacio" itemscope itemtype="http://schema.org/MusicRecording">
			<h2>Informació</h2>
			<ul>
				<li>Nom de la cançó: <span itemprop="name"><?php echo $canco['nom'] ?></span></li>
				<li>Artista: <a href="/d/<?php echo $canco['artistauri'] ?>"><?php echo $canco['artista'] ?></a></li>
				<?php
				if (isset($canco['album']) && $canco['album'] != "") {
				?>
				<li>Àlbum: <span itemprop="inAlbum"><?php echo $canco['album'] ?>
					<?php
					if ($canco['albumany'] > 0) {
					?>
						<?php echo " (". $canco['albumany'] .")" ?>
					<?php
					}
					?>
				</span></li>
				<?php
				}
				?>
				<li>Durada: <?php echo formatTime($canco['durada']); ?></li>
				<?php
					if (mysql_num_rows($infotema) > 0) {
				?>
						<li>Cançó sobre: 
				<?php
						$texttoprint = "";
						mysql_data_seek($infotema, 0);
						$first = true;
						while ($tema = mysql_fetch_array($infotema)) {
							if (!$first) $texttoprint .= ', ';
							else $first = false;
							$texttoprint .= '<a href="/cancons-sobre/'. $tema['uri'] .'" title="Cançons de '. $tema['nom'] .'">'. $tema['nom'] .'</a>';
						}
						echo replaceLastCommaWithAnd($texttoprint);
				?>
					</li>
				<?php
					}
				?>
				<?php
					if (mysql_num_rows($infoserie) > 0) {
				?>
						<li>Sèries on ha aparegut: 
				<?php
						$texttoprint = "";
						mysql_data_seek($infoserie, 0);
						$first = true;
						while ($serie = mysql_fetch_array($infoserie)) {
							if (!$first) $texttoprint .= ', ';
							else $first = false;
							$texttoprint .= '<a href="/serie/'. $serie['uri'] .'" title="Cançons de '. $serie['nom'] .'">'. $serie['nom'] .'</a>';
						}
						echo replaceLastCommaWithAnd($texttoprint);
				?>
					</li>
				<?php
					}
				?>
			</ul>
			
			<?php 
			echo "<meta itemprop='url' content='http://www.radiogramola.cat/canco/".$canco['uri']."'/>";
			$durada = explode(":",$canco['durada']);
			echo "<meta itemprop='duration' content='PT". $durada[1] ."M". $durada[2] ."S'/>";
			?>
			<div id="votacio">
				<div id="div-neg">
					<form id="form-neg" action="#" method="post" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $canco['id']; ?>"/>
						<input type="hidden" name="valoracio" value="0"/>
						<a href="#" title="No m'agrada" onclick="parentNode.submit()"><img alt="No m'agrada" src="/img/neg.png"/></a>
					</form>
					<img id="image-neg" title="No m'agrada" alt="No m'agrada" src="/img/neg.png" style="display: none;"/>
					<span class="vots"><?php echo $canco['negmes']; ?></span>
				</div>
				<div id="div-pos">
					<form id="form-pos" action="#" method="post" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $canco['id']; ?>"/>
						<input type="hidden" name="valoracio" value="1"/>
						<a href="#" title="M'agrada" onclick="parentNode.submit()"><img alt="M'agrada" src="/img/pos.png"/></a>
					</form>
					<img id="image-pos" title="M'agrada" alt="M'agrada" src="/img/pos.png" style="display: none;"/>
					<span class="vots"><?php echo $canco['posmes']; ?></span>
				</div>
			</div>
		</section>
		<section id="page-posicio">
			<h2>Classificació</h2>
			<?php
			/* Busquem la posició de vots positius */
			$posicio = getPosicio($canco['posmes']);
			?>
			<ol start="<?php echo  max(1,$posicio - 2) ?>">
			<?php
			/* Busquem les dues cançons millors */
			$query = "SELECT llista.uri, llista.nom, posmes, artistes.uri AS artistauri, artistes.nom AS artista
				FROM llista LEFT OUTER JOIN artistes
				ON llista.artistaid = artistes.id
				WHERE aprovada = 1 AND posmes > ". $canco['posmes']."
				ORDER BY posmes ASC
				LIMIT 2";
			$infocanco = mysql_query($query);
			while ($cancollista = mysql_fetch_array($infocanco)) {
				echo "<li>".$cancollista['nom']." (".$cancollista['artista']."): ".$cancollista['posmes']."</li>";
			}
			
			/* Imprimir la nostra cançó */
			echo "<li><strong>".$canco['nom']." (".$canco['artista']."): ".$canco['posmes']."</strong></li>";
			
			/* Busquem les dues cançons pitjors */
			$query = "SELECT llista.uri, llista.nom, posmes, artistes.uri AS artistauri, artistes.nom AS artista
				FROM llista LEFT OUTER JOIN artistes
				ON llista.artistaid = artistes.id
				WHERE aprovada = 1 AND posmes <= ". $canco['posmes']." AND llista.uri != '".$canco['uri'] ."'
				ORDER BY posmes DESC
				LIMIT 2";
			$infocanco = mysql_query($query);
			while ($cancollista = mysql_fetch_array($infocanco)) {
				echo "<li>".$cancollista['nom']." (".$cancollista['artista']."): ".$cancollista['posmes']."</li>";
			}
			?>
			</ol>
			<p><small><a href="http://www.radiogramola.cat/llista-cancons.php?ordre=classificacio&destaca=<?php echo $canco['uri']; ?>#destacat">Mostra la classificació sencera</a></small></p>
		</section>
		<section id="page-video">
			<h2>Vídeo</h2>
			<iframe width="640" height="360" src="http://www.youtube.com/embed/<?php echo $canco['codi']; ?>" frameborder="0" allowfullscreen></iframe>
		</section>
		<?php
		if (isset($canco['lletra']) && $canco['lletra'] != "") {
		?>
			<section id="page-lletra">
				<h2>Lletra</h2>
				<article id="lletra"><?php echo $canco['lletra'] ?><?php
					if (isset($canco['lletraviasona']) && $canco['lletraviasona'] != "" && $canco['lletraviasona'] != "0") {
					?><br/><a class="viasona-link" href="<?php echo $canco['lletraviasona'] ?>"><img src="http://www.viasona.cat/img/contingut/logo_petit.png" alt="Lletra de Viasona"/></a><?php
					}
					?></article>
			</section>
		<?php
		}
		?>
	</div>
</div>
<?php
} /* FI if si és una cançó*/

//****************************
//****************************
//***********GRUP*************
//****************************
//****************************
else if ($_GET['type'] == 2) { /* és un grup */
	$page_exploded = explode("/",$_SERVER['REQUEST_URI']);
	$uriartista = $page_exploded[2];
	$query = "SELECT * FROM artistes WHERE uri='".$uriartista."'";
	$infoartista = mysql_query($query);
	//if (!$infoartista) performe404();
    if (mysql_num_rows($infoartista) == 0) performe404();
    $artista = mysql_fetch_array($infoartista);
?>
<script src="/js/sorttable.js"></script>
<title><?php echo $artista['nom'] ?> | Ràdio musical 24 hores en català, la millor música en llengua catalana</title>
<meta name="keywords" content="<?php echo $artista['nom'].", lletra ".$artista['nom'].", letra ".$artista['nom'].", ".$artista['nom']." lyrics, cançons ".$artista['nom'].", àlbums ".$artista['nom'].", discs ".$artista['nom'].", discos ".$artista['nom'].", cd ".$artista['nom'].", vídeos ".$artista['nom'].", vídeo ".$artista['nom']; ?>" />
<meta name="description" content="Informació del grup <?php echo $artista['nom']; ?>. Inclou llista de cançons, àlbums, lletres, vídeos, web..." />
</head>
<body onload="checkCookie()">
<div id="wrapper" itemscope itemtype="http://schema.org/MusicRecording">
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
	<h1 class="page-title"><?php echo $artista['nom'] ?></h1>
	<div id="content">
		<!-- AdSense -->
		<div style="float: right; margin-top: 10px;">
			<script type="text/javascript"><!--
			google_ad_client = "ca-pub-7541474864707154";
			// Page big
			google_ad_slot = "9084157802";
			google_ad_width = 250;
			google_ad_height = 250;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
		<!-- FI AdSense -->
		<section id="page-artista-informacio">
			<h2>Informació</h2>
			<ul>
				<?php /*<li>Nom de l'artista: <?php echo $artista['nom'] ?></li>*/ ?>
				<?php
				if (isset($artista['inici']) && $artista['inici'] != 0) echo "<li>Any d'inici: ".$artista['inici']."</li>";
				if ($artista['final'] == -1) echo "<li>Any final: En actiu</li>";
				elseif (isset($artista['final']) && $artista['final'] != 0) echo "<li>Any final: ".$artista['final']."</li>";
				
				$socialnetworks = "";
				if (isset($artista['facebook']) && $artista['facebook'] != "") {
					$socialnetworks = $socialnetworks . " <a href='http://www.facebook.com/".$artista['facebook']."' rel='nofollow'><i class='icon-facebook'></i></a>";
				}
				if (isset($artista['twitter']) && $artista['twitter'] != "") {
					$socialnetworks = $socialnetworks . " <a href='http://www.twitter.com/".$artista['twitter']."' rel='nofollow'><i class='icon-twitter'></i></a>";
				}
				if (isset($artista['youtube']) && $artista['youtube'] != "") {
					$socialnetworks = $socialnetworks . " <a href='http://www.youtube.com/".$artista['youtube']."' rel='nofollow'><i class='icon-youtube'></i></a>";
				}
				if (isset($artista['vimeo']) && $artista['vimeo'] != "") {
					//$socialnetworks = $socialnetworks . " <a href='http://vimeo.com/".$artista['vimeo']."' rel='nofollow'>vimeo</a>";
				}
				if (isset($artista['flickr']) && $artista['flickr'] != "") {
					$socialnetworks = $socialnetworks . " <a href='http://www.flickr.com/photos/".$artista['flickr']."/' rel='nofollow'><i class='icon-flickr'></i></a>";
				}
				if (isset($artista['myspace']) && $artista['myspace'] != "") {
					//$socialnetworks = $socialnetworks . " <a href='http://www.myspace.com/".$artista['myspace']."' rel='nofollow'>m_</a>";
				}
				
				if (isset($artista['web']) && $artista['web'] != "") {
					$webbonica = explode("/",$artista['web']);
					echo "<li>";
					echo "Pàgina web: <a href='".$artista['web']."' rel='nofollow'>".$webbonica[2]."</a>";
					echo $socialnetworks;
					echo "</li>";
				}
				?>
			</ul>
			<?php
			if (isset($artista['twitter']) && $artista['twitter'] != "") {
			?>
			<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
			new TWTR.Widget({
			  version: 2,
			  type: 'profile',
			  rpp: 4,
			  interval: 30000,
			  width: 250,
			  height: 300,
			  theme: {
				shell: {
				  background: '#882222',
				  color: '#ffffff'
				},
				tweets: {
				  background: '#ffffff',
				  color: '#000000',
				  links: '#882222'
				}
			  },
			  features: {
				scrollbar: false,
				loop: false,
				live: false,
				behavior: 'all'
			  }
			}).render().setUser('<?php echo $artista['twitter']; ?>').start();
			</script>
			<?php
			}
			?>
		</section>
		
		<?php
			$query = "SELECT nom, any FROM albums WHERE artistaid = ".$artista['id']." ORDER BY any";
			$infoalbum = mysql_query($query);
			$i = 0;
			if ($infoalbum) {
			    while ($album = mysql_fetch_array($infoalbum)) {
				    if (!strpos($album['nom'], "enzills") == 1) {
				        $album_array[$i]['nom'] = $album['nom'];
				        $album_array[$i]['any'] = $album['any'];
				        $i++;
			        }
			    }
		    }
		if ($i > 0) { // hi ha àlbums
		?>
		<section id="page-artista-albums">
			<h2>Àlbums</h2>
			<ul>
				<?php
					$primerany = 9999;
					$ultimany = 0000;
					foreach ($album_array as $album) {
						if ($album['any'] > 0) {
							echo "<li>".$album['nom']." (".$album['any'].")</li>";
							if ($album['any'] < $primerany)
								$primerany = $album['any'];
							if ($album['any'] > $ultimany)
								$ultimany = $album['any'];
						}
						else {
							echo "<li>".$album['nom']."</li>";
						}
					}
					$totalanys = $ultimany - $primerany + 2;
					$timelinewidth = $totalanys * 120;
				?>
			</ul>
			<?php
			if ($primerany != 9999) {
			?>
			<script>
				function showAlbumsTimeline() {
					$('#albums-timeline').toggle();
					$('#albums-timeline-link-mostra').toggle();
					$('#albums-timeline-link-amaga').toggle();
				}
			</script>
			<p id="albums-timeline-link-mostra"><a href="javascript:void(0)" onClick="showAlbumsTimeline()">Mostra'ls en una línia temporal</a></p>
			<p id="albums-timeline-link-amaga" style="display: none;"><a href="javascript:void(0)" onClick="showAlbumsTimeline()">Amaga la línia temporal</a></p>
			<div id="albums-timeline" class="timeline-wrapper" style="display: none;">
				<div class="timeline" style="width: <?php echo $timelinewidth; ?>px;">
					<div class="mesos" style="width: <?php echo $timelinewidth; ?>px;">
					<?php
						$any = $primerany;
						for ($i = 0; $i < $totalanys; $i++) {
							echo '<span class="mes">'.$any.'</span>';
							$any++;
						}
					?>
					</div>
					<?php
						foreach ($album_array as $album) {
							if ($album['any'] > 0) {
								$leftposition = ($album['any'] - $primerany) * 120;
								echo "<div class='line-wrapper'><div class='line album' style='left: ".$leftposition."px;'>".$album['nom']."</div></div>";
							}
						}
					?>
				</div>
			</div>
			<?php
			}
			?>
		</section>
		<?php
		}
		?>
		<section id="page-artista-cancons">
			<h2>Cançons</h2>
			<table id="llista" class="sortable">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Durada</th>
						<th>Àlbum</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$query = "SELECT L.uri, L.nom, L.durada, A.nom AS nomalbum
							  FROM llista L, albums A
							  WHERE L.artistaid = ".$artista['id']."
									AND L.aprovada = 1
									AND L.albumid = A.id
							  ORDER BY A.nom, L.nom";
					$infocanco = mysql_query($query);
					if ($infocanco) {
					    while ($canco = mysql_fetch_array($infocanco)) {
							    echo "<tr itemscope itemtype='http://schema.org/MusicRecording'>";
							    echo "<td><a href='./".$artista['uri']."/".$canco['uri']."'><span itemprop='name'>".$canco['nom']."</span></a></td>";
							    /* Info per a Google */
							    echo "<meta itemprop='url' content='http://www.radiogramola.cat/canco/".$canco['uri']."'/>";
							    $durada = explode(":",$canco['durada']);
							    echo "<meta itemprop='duration' content='PT". $durada[1] ."M". $durada[2] ."S'/>";
							    /* Fi info per a Google */
							    echo "<td class='durada'>".formatTime($canco['durada'])."</td>";
							    echo "<td>".$canco['nomalbum']."</td>";
							    echo "</tr>";
					    }
				    }
				?>
				</tbody>
			</table>
		</section>
	</div>
	<script type="text/javascript"><!--
    google_ad_client = "ca-pub-7541474864707154";
    /* Bottom */
    google_ad_slot = "3055167560";
    google_ad_width = 728;
    google_ad_height = 90;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
</div>
<?php
}
?>
</body>
</html>
<?php
		mysql_close($con);
?>
