<?php
	include 'functions.php';
	$con = connecta();
?>
<!DOCTYPE html>
<html>
<head>
<?php printCssIncludes(); ?>
<link rel="shortcut icon" href="<?php echo $baseUrl; ?>/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Error 404 | Ràdio musical 24 hores en català</title>
<?php printGoogleAnalyticsCode(); ?>
</head>
<body>
<div id="wrapper">
	<p><a title="Ràdio en català" href="<?php echo $baseUrl; ?>">Torna a l'inici</a></p>
	<h1 class="page-title">Error 404</h1>
	<div id="content">
		<p>Sembla que la pàgina que estàs buscant ha desaparegut o es troba en un altre lloc.</p>
		<p>Si cercaves una cançó, potser la pots trobar a la nostra <a href="<?php echo $baseUrl; ?>/llista-cancons.php" title="Llista de cançons de Ràdio Gramola">llista de cançons</a> o cercar-la directament aquí:
		<form name="input" action="<?php echo $baseUrl; ?>/search.php" method="get">
			<p>
				<input name="s" placeholder="Nom de la cançó, artista o àlbum" size="30" type="text"/>
				<input type="submit" value="Cerca" />
			</p>
		</form>
		<p>També pots tornar a l'índex per veure <a href="<?php echo $baseUrl; ?>" title="Ràdio Gramola, la ràdio musical en català">Ràdio Gramola en directe</a>.</p>
		<?php
			$page_exploded = explode("/",$_SERVER['REQUEST_URI']);
			if(isset($page_exploded[2])) {
				$canco = $page_exploded[2];
			
				$query = "SELECT llista.uri, llista.nom, artistes.uri AS artistauri, artistes.nom AS artista
					FROM llista
					LEFT OUTER JOIN artistes
						ON llista.artistaid = artistes.id
					WHERE llista.uri LIKE '%".$canco."%'
					AND aprovada = 1";
				$infocancons = mysqli_query($con, $query);
				if (mysqli_num_rows($infocancons) == 1) {
					echo "<p>Potser buscàveu aquesta cançó: ";
					while($canco = mysqli_fetch_array($infocancons)) {
						echo "<strong><a href='". $baseUrl ."/d/".$canco['artistauri'].'/'.$canco['uri']."'>".$canco['nom'] ."</a> (<a href='". $baseUrl ."/d/".$canco['artistauri']."'>". $canco['artista']. "</a>)</strong></p>";
					}
				}
				elseif (mysqli_num_rows($infocancons) > 1) {
					echo "<p>Potser buscàveu aquesta cançó:";
					echo "<ul>";
					while($canco = mysqli_fetch_array($infocancons)) {
						echo "<li><strong><a href='". $baseUrl ."/d/".$canco['artistauri'].'/'.$canco['uri']."'>".$canco['nom'] ."</a> (<a href='". $baseUrl ."/d/".$canco['artistauri']."'>". $canco['artista']. "</a>)</strong></p></li>";
					}
					echo "</ul>";
				}
			}
		?>
	</div>
</div>
</body>
</html>
<?php
		mysqli_close($con);
?>
