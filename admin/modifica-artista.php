<?php
	include '../functions.php';
	/* Connectem amb la BD i seleccionem la taula */
	$con = mysql_connect("localhost","myrad571","BO26a1Wz");
	if (!$con) die("S'ha produït un error, disculpeu les molèsties: " . mysql_error());
	mysql_select_db("psicoajuradio", $con);
	mysql_set_charset('utf8',$con);
	
	if (isset($_POST['nom']) && ($_POST['nom'] != "")) {
	
		/* Mirem la URI */
		$uri = nameToUri($_POST['nom']);
	
		$query="UPDATE  artistes SET uri = '".$uri."',
						nom = '".trim($_POST['nom'])."',
						inici = '".$_POST['inici']."',
						final = '".$_POST['final']."',
						web = '".$_POST['web']."',
						twitter = '".$_POST['twitter']."',
						facebook = '".$_POST['facebook']."',
						youtube = '".$_POST['youtube']."',
						vimeo = '".$_POST['vimeo']."',
						flickr = '".$_POST['flickr']."',
						myspace = '".$_POST['myspace']."'
				WHERE id = ". $_POST['id'];
		if (!mysql_query($query,$con)) die("S'ha produït un error en afegir la cançó: " . mysql_error());
		$frase = "S'ha actualitzat correctament.";
	}
	
	$idartista = $_GET['artista'];
	$query = "SELECT id, uri, nom, inici, final, web, twitter, facebook, youtube, vimeo, flickr, myspace
		FROM artistes
		WHERE id=".$idartista;
	$infoartistes = mysql_query($query);
	$artista = mysql_fetch_array($infoartistes);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Modifica l'artista | Administració de Ràdio Gramola</title>
</head>
<body>
<div id="wrapper">
	<a href="./artistes.php">Torna a la llista</a>
	<h1 class="page-title">Modifica l'artista</h1>
	<div id="content">
		<?php echo "<p>".$frase."</p>" ?>
		<h2>Informació</h2>
		<form action="#" method="post" enctype="multipart/form-data">
		<input name="id" type="hidden" value="<?php echo $artista['id'] ?>"/>
		<table>
			<tr>
				<td>Nom de l'artista:</td>
				<td><input name="nom" type="text" value="<?php echo $artista['nom'] ?>"/></td>
			</tr>
			<tr>
				<td>Any d'inici:</td>
				<td><input name="inici" type="text" value="<?php echo $artista['inici'] ?>"/></td>
			</tr>
			<tr>
				<td>Any de retirada:</td>
				<td><input name="final" type="text" value="<?php echo $artista['final'] ?>"/></td>
			</tr>
			<tr>
				<td>Web de l'artista:</td>
				<td><input name="web" placeholder="http://www.elspets.cat/" type="text" value="<?php echo $artista['web'] ?>"/></td>
			</tr>
			<tr>
				<td>Facebook:</td>
				<td><input name="facebook" placeholder="elspets" type="text" value="<?php echo $artista['facebook'] ?>"/></td>
			</tr>
			<tr>
				<td>Twitter:</td>
				<td>@<input name="twitter" placeholder="elspetsoficial" type="text" value="<?php echo $artista['twitter'] ?>"/></td>
			</tr>
			<tr>
				<td>YouTube:</td>
				<td><input name="youtube" placeholder="elspetsoficial" type="text" value="<?php echo $artista['youtube'] ?>"/></td>
			</tr>
			<tr>
				<td>Vimeo:</td>
				<td><input name="vimeo" placeholder="elspets" type="text" value="<?php echo $artista['vimeo'] ?>"/></td>
			</tr>
			<tr>
				<td>flickr:</td>
				<td><input name="flickr" placeholder="elspets" type="text" value="<?php echo $artista['flickr'] ?>"/></td>
			</tr>
			<tr>
				<td>myspace:</td>
				<td><input name="myspace" placeholder="elspets" type="text" value="<?php echo $artista['myspace'] ?>"/></td>
			</tr>
		</table>
		<input type="submit" value="Desa"/>
		</form>
	</div>
</div>
</body>
</html>
