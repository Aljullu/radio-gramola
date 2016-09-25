<?php
	include 'functions.php';

	/* Connectem amb la BD i seleccionem la taula */
	$con = connecta();
	
	$page_exploded = explode("/",$_SERVER['REQUEST_URI']);
	$uripage = $page_exploded[3];
?>
<!DOCTYPE html>
<html>
<head>
<?php printCssIncludes(); ?>
<link rel="shortcut icon" href="<?php echo $baseUrl; ?>/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php if ($uripage == "pmf") { ?>
<title>Preguntes més freqüents | Ràdio Gramola, la radio televisió musical 24 hores en català</title>
<?php } elseif ($uripage == "collabora") { ?>
<title>Col·labora amb Ràdio Gramola, la radio televisió musical 24 hores en català</title>
<?php } elseif ($uripage == "linia-temporal") { ?>
<title>Línia temporal | Ràdio Gramola, la radio televisió musical 24 hores en català</title>
<?php } elseif ($uripage == "qui-som") { ?>
<title>Qui som | Ràdio Gramola, la radio televisió musical 24 hores en català</title>
<?php /* Google+ badge */ ?>
<script type="text/javascript">
window.___gcfg = {lang: 'ca'};
(function() 
{var po = document.createElement("script");
po.type = "text/javascript"; po.async = true;po.src = "https://apis.google.com/js/plusone.js";
var s = document.getElementsByTagName("script")[0];
s.parentNode.insertBefore(po, s);
})();</script>
<?php } elseif ($uripage == "suggereix-canco") { ?>
<title>Suggereix una cançó | Ràdio musical 24 hores en català</title>
<?php } ?>
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>
<body>
<div id="wrapper">
<p><a title="Ràdio en català" href="<?php echo $baseUrl; ?>/index.php">Torna a l'inici</a></p>
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

/*********************************************
PMF
*********************************************/
if($uripage == "pmf") { ?>

<h1 class="page-title">Preguntes Més Freqüents</h1>
<div id="content">
<h2>Índex</h2>
<ul>
	<li><a href="#oferta-musical">Oferta musical</a></li>
	<li><a href="#votacions">Votacions</a></li>
	<li><a href="#suggereix">Suggereix una cançó</a></li>
	<li><a href="#aspectes-tecnics">Aspectes tècnics</a></li>
	<li><a href="#radiogramola">Sobre Ràdio Gramola</a></li>
	<li><a href="#discografiques">Informació per a discogràfiques i artistes</a></li>
</ul>
<h2 id="oferta-musical">Oferta musical</h2>
<strong>Quines cançons puc trobar aquí?</strong>
<p>Aquí pots trobar cançons en català de tots els estils musicals i de totes les èpoques.</p>
<strong>Qui decideix la programació?</strong>
<p>Tenim un sistema "intel·ligent" per fer la programació depenent dels gustos de la comunitat. Les cançons amb més «M'agrada» apareixen més freqüentment i les que tenen més «No m'agrada», menys.</p>
<p>De manera que són els mateixos usuaris qui, indicant les seves preferències, escullen la programació de l'endemà.</p>
<p>Vegeu l'apartat de <a href="#votacions">votacions</a> per a més informació.</p>
<!--<p>Intentem apostar per cançons que puguin agradar a un públic majoritari i sobretot jove. En un futur obrirem un sistema de votacions de manera que els usuaris puguin valorar ells mateixos les cançons de manera que sigui la mateixa comunitat qui faci la "selecció" de les millors cançons.</p>-->
<strong>Teniu permís per reproduir aquestes cançons?</strong>
<p>El nostre sistema reprodueix cançons directament del YouTube. Són cançons que es poden inserir a un web extern, de manera que sí, tenim permís.</p>
<h2 id="votacions">Votacions</h2>
<strong>Què és el polze cap amunt i cap avall que apareix sota cada el vídeo?</strong>
<p>Des del 22 d'octubre de 2011 oferim la possibilitat de votar positiva o negativament les cançons. Evidentment, el polze cap amunt significa «M'agrada» i el polze cap avall significa «No m'agrada». Els usuaris poden canviar el seu vot en qualsevol moment.</p>
<strong>Quants cops puc votar una cançó?</strong>
<p>Cada usuari només pot votar positiva o negativament cada cançó un cop al mes. El dia 1 del mes següent les votacions es reinicien i es pot tornar a votar.</p>
<strong>Per què s'utilitzen aquests vots?</strong>
<p>Els vots serveixen principalment per determinar la programació dels propers dies. No ho fan d'una manera directa sinó indirecta, el nostre sistema mira quines són les cançons que més agraden i els dóna més freqüència que les cançons que no agraden.</p>
<p>Els vots també es poden veure a la <a href="<?php echo $baseUrl; ?>/llista-cancons.php">llista de cançons</a>. A més, la taula permet ordenar per columnes, de manera que podeu ordenar les cançons per nombre de vots positius i nombre de vots negatius i així saber les cançons que més agraden i les que menys.</p>
<h2 id="suggereix">Suggereix una cançó</h2>
<strong>Què significa l'enllaç «Suggereix una cançó?»</strong>
<p>Estem al dia de la música en català i intentem tenir una <a href="<?php echo $baseUrl; ?>/llista-cancons.php">llista</a> on hi apareguin cançons de tots els gèneres i dels principals grups en català. Tot i això, segur que hi ha moltes cançons en la nostra llengua que no coneixem. Per això, us oferim la possibilitat (i us animem a fer-ho!) de suggerir noves cançons per incloure-les a la nostra llista.</p>
<strong>Si afegiu un cançó que us he suggerit a la llista, m'avisareu?</strong>
<p>No, en el formulari per a suggerir una cançó no agafem dades personals, de manera que no podem contactar amb qui ha fet el suggeriment. Si voleu saber si una cançó que heu suggerit s'ha afegit, el millor que podeu fer és cercar-la a la llista uns dies després.</p>
<strong>Us vaig enviar una cançó però no l'heu afegit a la llista, perquè?</strong>
<p>Si la vau enviar fa poc, pot ser que encara no hàgim tingut temps de mirar-nos-la.</p>
<p>Si ja fa dies que la vau enviar, potser és que la cançó no compleix els requisits per aparèixer-hi, que són:</p>
<ul>
	<li>Estar total o parcialment en català.</li>
	<li>Tenir un mínim de qualitat, tant la música com el videoclip.</li>
	<li>Les lletres i els vídeos no poden incitar a l'odi, discriminar col·lectius o persones, utilitzar imatges o llenguatge violent... en general, les cançons no han de ser ofensives per a ningú.</li>
</ul>
<strong>Puc suggerir una cançó que no tingui videoclip?</strong>
<p>Sí, moltes cançons ja acceptades no tenen videoclip. Sabem que molts grups en català per qüestions artístiques o econòmiques no fan videoclips de les seves cançons. De manera que si una cançó és bona, no la descartarem per no tenir videoclip.</p>
<strong>Puc enviar una cançó gravada en directe?</strong>
<p>Sí, però només si té la mateixa qualitat sonora que una cançó enregistrada en un estudi. En general, qualsevol «directe» gravat amb un mòbil o una càmara personal no compleix aquest requisit.</p>
<p>Ara bé, un directe gravat per alguna cadena de televisió o pel mateix grup, molt probablement sí que ho compleixi.</p>
<p>Per exemple, <a href="http://www.youtube.com/watch?v=0xTVVprYDNw">aquesta cançó</a> no podria ser inclosa. Però <a href="http://www.youtube.com/watch?v=NIZDfOGFcc4">aquesta</a> sí.</p>
<h2 id="aspectes-tecnics">Aspectes tècnics</h2>
<strong>Jo només vull escoltar música, realment és eficient estar baixant vídeos contínuament?</strong>
<p>El nostre sistema el que fa és agafar els vídeos del YouTube i inserir-los a la pàgina, amagant-ne la interfície i afegint-hi la capa social per votar les cançons i suggerir-ne de noves.</p>
<p>Des de fa anys, el YouTube aprofita la memòria cau (<em>cache memory</em>) del navegador. A efectes pràctics això significa que només cal baixar-se el vídeo el primer cop que el mires. A partir de llavors, el navegador l'emmagatzema als seus fitxers interns, de manera que quan miris el vídeo una altra vegada, aquest es reproduirà des de la versió emmagatzemada al teu disc dur i no generarà tràfic per la xarxa.</p>
<p>Evidentment, això només és aplicable si no heu bloquejat la memòria cau del navegador o navegueu amb la navegació privada (o navegació d'incògnit) activada.</p>
<strong>La pàgina se'm veu diferent si la miro amb el Firefox, el Chrome o l'Internet Explorer. És normal?</strong>
<p>Pensant en fer un web innovador i revolucionari, hem dissenyat la pàgina seguint el que seran els estàndards del futur: l'HTML 5 i les CSS 3. Avui en dia no hi ha cap navegador del mercat que sigui compatible al 100% amb aquests nous estàndards, de manera que és molt probable que hi hagi una cosa o altra que el vostre navegador no acabi de dibuixar correctament.</p>
<p>Tot i això, si utilitzeu les darreres versions del Firefox, el Chrome, el Safari o l'Opera, estareu exprimint les capacitats del web quasi al 100%.</p>
<p>Recomanem no utilitzar l'Internet Explorer ja que si ho feu us perdreu algunes funcionalitats. Ara bé, si no teniu més remei, intenteu tenir la versió més recent.</p>
<h2 id="radiogramola">Sobre Ràdio Gramola</h2>
<strong>Perquè Ràdio Gramola?</strong>
<p>Després d'un període on es podien enviar suggeriments hi va haver tres finalistes com a nom de la ràdio: «Ràdio Gralla», «Ràdio Llibertat» i «La Gramola».</p>
<p>Va guanyar aquesta darrera amb el 56% dels vots. El domini més semblant que hi havia lliure era radiogramola.cat i així s'ha quedat com a nom.</p>
<h2 id="discografiques">Informació per a discogràfiques i artistes</h2>
<p>Els continguts de Ràdio Gramola els proporcionen els mateixos usuaris, així que nosaltres no podem respondre sobre tot ell. El contingut prové del YouTube, així que en cas que s'estiguin violant els drets d'autor, el que hauríeu de fer és dirigir-vos a la pàgina del vídeo en qüestió i denunciar el vídeo.</p>
<p>Si no s'estan incomplint els drets d'autor però igualment no voleu aparèixer a Ràdio Gramola, el que podeu fer és <a href="mailto:radiogramolacat@gmail.com">contactar</a> amb nosaltres i intentarem esborrar el vostre contingut el més aviat possible.</p>
<p>Si, per contra, sou una discogràfica o artista i esteu interessats en veure els vostres continguts a Ràdio Gramola, podeu <a href="#suggereix">suggerir</a> les cançons que vulgueu. Si les vostres cançons no es troben al YouTube o d'alguna manera voleu col·laborar amb Ràdio Gramola per oferir més continguts o promocionar els vostres concerts o material, podeu posar-vos en <a href="mailto:radiogramolacat@gmail.com">contacte</a> amb nosaltres.</p>
<p>Per a qualsevol altre tema que no estigui contemplat ens aquestes PMF, us demanem que us poseu en <a href="mailto:radiogramolacat@gmail.com">contacte</a> via correu electrònic.</p>
</div>
<?php }

/*********************************************
COLLABORA
*********************************************/
elseif($uripage == "collabora") { ?>

<h1 class="page-title">Col·labora</h1>
<div id="content">
<h2>Vols col·laborar amb Radio Gramola?</h2>
<strong>Ets un apassionat de la música en català i voldries participar en un projecte que integra ràdio, televisió i xarxes socials en un mateix portal?</strong>
<p>Ràdio Gramola és un projecte que treballa per la difusió de la música en llengua catalana. En poc més d'un any hem superat les 27.000 visites i les 380.000 pàgines vistes però per continuar la nostra tasca necessitem nous col·laboradors.</p>
<p>No podem oferir diners a qui vulgui col·laborar ja que els beneficis de la publicitat no arriben a cobrir les despeses de servidor i domini, a canvi, sí que et podem oferir el reconeixement d'haver treballat en un projecte ambiciós de la música en català. Això et pot servir tant per al teu currículum com per aprendre noves experiències i mètodes de treball en un equip de voluntaris entusiastes.</p>
<p>A continuació oferim una llista dels perfils que manquen al nostre projecte:</p>
<ul>
	<li>Apassionat de la música en català disposat a mantenir una llista actualitzada de les darreres novetats. Serà l'encarregat d'afegir noves cançons a la llista i validar els suggeriments dels usuaris.</li>
	<li>Redactor de notícies i informació sobre grups, àlbums i cançons de la música en català.</li>
	<li>Social Manager o qualsevol persona familiaritzada amb les xarxes socials que es pugui encarregar d'un o dels diversos comptes a Facebook, Twitter, etc.</li>
	<li>Dissenyador gràfic que ens pugui donar un cop de mà amb idees per al logotip i el disseny de la pàgina.</li>
	<li>Creador de continguts audiovisuals per poder fer espots, vídeos sobre música o eventualment programes musicals.</li>
	<li>Qualsevol persona amb ganes de participar activament en el projecte tot i que no compleixi cap dels requisits anteriors. Estarem encantats d'escoltar les teves propostes!</li>
</ul>
<p>Si t'has decidit a col·laborar o si més no a conèixer-ne més informació, et pots posar en contacte amb nosaltres al correu <a href="mailto:radiogramolacat@gmail.com">radiogramolacat@gmail.com</a>.
<p>Si no et veus en cor de participar en cap d'aquest àmbits anteriors, encara pots seguir col·laborant amb nosaltres. Senzillament fes conèixer el lloc web entre els teus amics, difón la pàgina entre els teus contactes, si tens un bloc escriu sobre nosaltres i si tens un lloc web posa'ns un enllaç!</p>
<p>I per descomptat: segueix-nos al <a href="http://www.facebook.com/radiogramola">Facebook</a> i al <a href="http://www.twitter.com/radiogramola">Twitter</a>, al <a href="https://plus.google.com/b/104411283361538424673/104411283361538424673/posts">Google+</a>.</p>
<?php }


/*********************************************
Línia temporal
*********************************************/
elseif ($uripage == "linia-temporal") { ?>
	<h1 class="page-title">Línia temporal</h1>
	<div id="content">
	<?php
		$query = "	SELECT albums.uri AS uri, albums.nom AS nom, albums.any AS any, artistes.nom AS artista, artistes.uri AS artistauri
					FROM albums
					LEFT OUTER JOIN artistes
						ON albums.artistaid = artistes.id
					ORDER BY artistes.nom";
		$infoalbum = mysql_query($query);
		while ($album = mysql_fetch_array($infoalbum)) {
			/* Ho copiem per accedir a album_array */
			$album_array[$i]['nom'] = $album['nom'];
			$album_array[$i]['any'] = $album['any'];
			$album_array[$i]['uri'] = $album['uri'];
			$album_array[$i]['artista'] = $album['artista'];
			$album_array[$i]['artistauri'] = $album['artistauri'];
			$i++;
		}
		$i = 0;
	?>
	<h2>Àlbums</h2>
	<table id="llista" class="sortable">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Any</th>
				<th>Artista</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$primerany = 9999;
				$ultimany = 0000;
				foreach ($album_array as $album) {
					echo "<tr>";
					echo "<td>".$album['nom']."</td>";
					if ($album['any'] > 0) {
						echo "<td>".$album['any']."</td>";
						if ($album['any'] < $primerany)
							$primerany = $album['any'];
						if ($album['any'] > $ultimany)
							$ultimany = $album['any'];
					}
					else {
						echo "<td>-</td>";
					}
					echo "<td><a href='". $baseUrl ."/d/".$album['artistauri']."'>".$album['artista']."</a></td>";
					echo "</tr>";
				}
				$totalanys = $ultimany - $primerany + 2;
				$timelinewidth = $totalanys * 120;
			?>
		</tbody>
	</table>
	<?php
	if ($primerany != 9999) {
	?>
	<div class="timeline-wrapper big">
			<div class="mesos" style="width: <?php echo $timelinewidth; ?>px;">
			<?php
				$any = $primerany;
				for ($i = 0; $i < $totalanys; $i++) {
					echo '<span class="mes">'.$any.'</span>';
					$any++;
				}
			?>
			</div>
		<div class="timeline" style="width: <?php echo $timelinewidth; ?>px;">
			<?php
				foreach ($album_array as $album) {
					if ($album['any'] > 0) {
						$leftposition = ($album['any'] - $primerany) * 120;
						echo "<div class='line-wrapper'><div id='".$album['uri']."' class='line album' style='left: ".$leftposition."px;'>".$album['nom']."</div></div>";
					}
				}
			?>
		</div>
	</div>
	<?php
	}
	?>
	</div>
<?php }


/*********************************************
Qui som
*********************************************/
elseif ($uripage == "qui-som") { ?>
	<h1 class="page-title">Qui som</h1>
	<div id="content">
		<p>A continuació es llisten les persones que han fet possible Ràdio Gramola.</p>
		<h2>Equip</h2>
		<ul>
			<li><strong><a href="http://www.twitter.com/aljullu">Albert Juhé Lluveras</a></strong>: creador i programador.</li>
		</ul>
		<h2>Recursos utilitzats</h2>
		<ul>
			<li><strong><a rel="nofollow" href="http://www.kryogenix.org/code/browser/sorttable/">Sorttable</a></strong>: JavaScript per fer que les taules es puguin ordenar per columnes.</li>
			<li><strong><a rel="nofollow" href="http://lomalogue.com/jquery/quicksearch/">quickSearch</a></strong>: JavaScript per filtrar taules.</li>
		</ul>
		<h2>A les xarxes socials</h2>
		<!-- Facebook Badge START --><a href="https://www.facebook.com/radiogramola" target="_TOP" title="Ràdio Gramola"><img src="https://badge.facebook.com/badge/134222510016651.752.1323030244.png" style="border: 0px;" /></a><!-- Facebook Badge END -->
		<?php /* Twitter */ ?>
		<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
		<script>
		new TWTR.Widget({
		  version: 2,
		  type: 'profile',
		  rpp: 2,
		  interval: 30000,
		  width: 240,
		  height: 136,
		  theme: {
			shell: {
			  background: '#c99e9e',
			  color: '#882222'
			},
			tweets: {
			  background: '#000000',
			  color: '#ffffff',
			  links: '#cc3535'
			}
		  },
		  features: {
			scrollbar: false,
			loop: false,
			live: false,
			behavior: 'all'
		  }
		}).render().setUser('radiogramola').start();
		</script>
		<?php /* Google + */ ?>
		<div class="g-plus" data-href="https://plus.google.com/104411283361538424673?rel=publisher" data-width="240" data-height="131" data-theme="dark"></div>
	</div>
<?php }


/*********************************************
Suggereix cançó
*********************************************/
elseif ($uripage == "suggereix-canco") { ?>
	<?php
	if ($_POST['accio'] == "novacanco") {
		$frase = "";
		if ($_POST['nom'] == "") {
			$frase = "El nom de la cançó no pot quedar buit.";
			$frase = $frase."<br/>";
		}
		if ($_POST['artista'] == "") {
			$frase = $frase."El nom de l'artista no pot quedar buit.";
			$frase = $frase."<br/>";
		}
		if ($_POST['album'] == "") {
			$frase = $frase ."El nom de l'àlbum no pot quedar buit.";
			if ($_POST['artista'] != "") {
				$frase = $frase." Si no coneixeu l'àlbum, podeu escriure «Senzills de ". $_POST['artista']."»";
				$_POST['album'] = "Senzills de ". $_POST['artista'];
			}
			$frase = $frase."<br/>";
		}
		if ($frase == "") {
			/* Mirem la URI */
			$uri = nameToUri($_POST['nom']);
	
			/* Busquem l'artista */
			$query = "SELECT * FROM `artistes` WHERE `uri` LIKE '".nameToUri($_POST['artista'])."'";
			$infoartista = mysql_query($query);
			$artista = mysql_fetch_array($infoartista);
	
			/* Si no existeix, el creem */
			if(!isset($artista['id']) || $artista['id'] == "") {
				$nom = nameToUri($_POST['artista']);
				$query = "INSERT INTO artistes (uri,nom) VALUES ('".$nom."','".htmlspecialchars($_POST['artista'], ENT_QUOTES)."')";
				mysql_query($query);
			}
	
			/* Tornem a buscar l'artista */
			$query = "SELECT * FROM `artistes` WHERE `uri` LIKE '".nameToUri($_POST['artista'])."'";
			$infoartista = mysql_query($query);
			$artista = mysql_fetch_array($infoartista);
	
			/* Busquem l'àlbum */
			$query = "SELECT * FROM `albums` WHERE `uri` LIKE '".nameToUri($_POST['album'])."'";
			$infoalbum = mysql_query($query);
			if ($infoalbum) {
				$album = mysql_fetch_array($infoalbum);
			}
	
			/* Si no existeix, el creem */
			if(!isset($album['id']) || $album['id'] == "") {
				$nom = nameToUri($_POST['album']);
				$query = "INSERT INTO albums (uri,nom,artistaid) VALUES ('".$nom."','".htmlspecialchars($_POST['album'], ENT_QUOTES)."','".$artista['id']."')";
				mysql_query($query);
			}
	
			/* Tornem a buscar l'artista */
			$query = "SELECT * FROM `albums` WHERE `uri` LIKE '".nameToUri($_POST['album'])."'";
			$infoalbum = mysql_query($query);
			if ($infoalbum) {
				$album = mysql_fetch_array($infoalbum);
			}
	
			$query="INSERT INTO llista (uri,nom,artistaid,albumid,codi,durada,lletra,lletraviasona,aprovada,pos,neg) VALUES ('".$uri."','".htmlspecialchars(trim($_POST['nom']), ENT_QUOTES)."','".$artista['id']."','".$album['id']."','".$_POST['codi']."','".$_POST['durada']."','".htmlspecialchars($_POST['lletra'], ENT_QUOTES)."','".trim($_POST['lletraviasona'])."',0,0,0)";
			if (!mysql_query($query,$con)) die("S'ha produït un error en afegir la cançó: " . mysql_error());
			$frase = "La cançó s'ha enviat correctament. Si passa el procés de selecció, durant els propers dies s'afegirà a la <a href='". $baseUrl ."/llista-cancons.php'>llista de cançons</a> i començarà a sonar a la televisió 24 hores.";
		}
		else {
			$form_nom = $_POST['nom'];
			$form_artista = $_POST['artista'];
			$form_album = $_POST['album'];
			$form_codi = $_POST['codi'];
			$form_durada = $_POST['durada'];
			$form_lletra = $_POST['lletra'];
			$form_lletraviasona = $_POST['lletraviasona'];
		}
	}
	?>
	<script>
		function mostraLletra() {
			$("#tinc-lletra").hide();
			$("#lletra-form").slideDown(500);
		}
	</script>
	<div id="content">
		<p><strong><?php echo $frase; ?></strong></p>
		<p>Envia una cançó que t'agradi:</p>
		<form action="<?php echo $baseUrl; ?>/p/suggereix-canco" method="post" enctype="multipart/form-data">
		<span class="label">Cançó: </span><input type="text" name="nom" placeholder="Benvolgut" value="<?php echo $form_nom; ?>" required><br/>
		<span class="label">Artista: </span><input autocomplete="off" list="artistes" type="text" name="artista" placeholder="Manel" value="<?php echo $form_artista; ?>" required><br/>
		<?php /* Suggeriments */
			echo '<datalist id="artistes">';
			$query = "SELECT nom FROM artistes ORDER BY nom";
			$infoartista = mysql_query($query);
			while ($artista = mysql_fetch_array($infoartista)) {
				echo '<option label="'.$artista['nom'].'" value="'.$artista['nom'].'" />';
			}
			echo '</datalist>';
		?>
		<span class="label">Àlbum: </span><input autocomplete="off" list="albums" type="text" name="album" placeholder="10 milles per veure una bona armadura" value="<?php echo $form_album; ?>" required><br/>
		<?php /* Suggeriments */
	
			echo '<datalist id="albums">';
			$query = "SELECT nom FROM albums ORDER BY nom";
			$infoartista = mysql_query($query);
			while ($album = mysql_fetch_array($infoartista)) {
				echo '<option label="'.$album['nom'].'" value="'.$album['nom'].'" />';
			}
			echo '</datalist>';
		?>
		<span class="label">Codi: </span><input type="text" name="codi" placeholder="irrPUyetKoA" value="<?php echo $form_codi; ?>" required><br/>
		<small>El codi és el text identificador del vídeo al YouTube. Per exemple, de la cançó «Benvolgut» de Manel que es pot trobar aquí:<br/>
		http://www.youtube.com/watch?v=<strong>irrPUyetKoA</strong><br/>
		El codi seria: <strong>irrPUyetKoA</strong>.</small><br/><br/>
		<span class="label">Durada: </span><input type="text" name="durada" pattern="\d{2}:\d{2}:\d{2}" placeholder="00:04:16" value="<?php echo $form_durada; ?>" required><br/>
		<small>Ha de ser del format hh:mm:ss. En general, totes les cançons, com que duren menys de 10 minuts seran 00:0X:XX.</small><br/><br/>
		<a id="tinc-lletra" style="cursor:pointer;display:block;" onClick="mostraLletra()">Tinc la lletra</a>
		<div id="lletra-form" style="display:none;">Lletra (opcional):</br>
			<textarea id="textarea-lletra" cols="60" rows="30" name="lletra"><?php echo $form_lletra; ?></textarea><br/>
			<small>Si us plau, pugeu només lletres de les quals tingueu permís per a fer-ho.<br/>
			Les lletres les heu d'haver transcrit vosaltres o haver-les agafat de <a href="http://www.viasona.cat/">Viasona</a>, en aquest darrer cas heu d'especificar l'URL de la pàgina d'on l'heu agafat:<br>
			<input name="lletraviasona" pattern="http://www.viasona.cat/grup/.+" placeholder="http://www.viasona.cat/grup/manel/10-milles-per-veure-una-bona-armadura/benvolgut" size="70" type="url" value="<?php echo $form_lletraviasona; ?>"/></small>
		</div>
		<input value="novacanco" name="accio" type="hidden"><br/>
		<input id="suggereix-button" type="submit" name="submit" value="Envia" />
	</div>
<?php }


/*********************************************
Error 404
*********************************************/
else { ?>
	<script>
	window.location = '<?php echo $baseUrl; ?>/404.php'
	</script>
<?php } ?>
</div>
</body>
</html>
<?php
		mysqli_close($con);
?>
