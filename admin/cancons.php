<?php
	/* Connectem amb la BD i seleccionem la taula */
	$con = mysql_connect("localhost","myrad571","BO26a1Wz");
	if (!$con) die("S'ha produït un error, disculpeu les molèsties: " . mysql_error());
	mysql_select_db("psicoajuradio", $con);
	mysql_set_charset('utf8',$con);
	
	/* Comptem el número de cançons */
	$query = "SELECT COUNT(nom) FROM llista WHERE aprovada = 1";
	$result = mysql_query($query);
	$numcanconsaprovadesArray = mysql_fetch_array($result);
	$numcanconsaprovades = $numcanconsaprovadesArray[0];
	
	/* Comptem el número de cançons */
	$query = "SELECT COUNT(nom) FROM llista WHERE aprovada = 0";
	$result = mysql_query($query);
	$numcanconspendentsArray = mysql_fetch_array($result);
	$numcanconspendents = $numcanconspendentsArray[0];
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/style.css" />
<script src="/js/sorttable.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Llista de cançons | Administració de Ràdio Gramola</title>
</head>
<body>
<div id="wrapper">
	<a href="./albums.php">Àlbums</a> - <a href="./artistes.php">Artistes</a>
	<h1 class="page-title">Llista de cançons</h1>
	<div id="content">
		<p>Hi ha <?php echo $numcanconsaprovades; ?> cançons aprovades i <?php echo $numcanconspendents; ?> pendents d'aprovar.</p>
		<table id="llista" class="sortable">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Àlbum</th>
					<th>Artista</th>
					<th>Durada</th>
					<th>Aprovada</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$query = "SELECT llista.id, llista.uri, llista.nom, durada, aprovada,
						artistes.uri AS artistauri, artistes.nom AS artista, albums.nom AS album
					FROM llista
					LEFT OUTER JOIN artistes
						ON llista.artistaid = artistes.id
					LEFT OUTER JOIN albums
						ON llista.albumid = albums.id
					ORDER BY artistes.uri";
				$infocanco = mysql_query($query);
				while ($canco = mysql_fetch_array($infocanco)) {
						echo "<tr ".$rowid."itemscope itemtype='http://schema.org/MusicRecording'>";
						echo "<td><a href='/admin/modifica.php?canco=".$canco['id']."'><img src='http://phpmyadmin.mi-alojamiento.com/themes/pmahomme/img/b_edit.png'/>".$canco['nom']."</a></td>";
						echo "<td>".$canco['album']."</td>";
						echo "<td>".$canco['artista']."</td>";
						echo "<td>".$canco['durada']."</td>";
						echo "<td class='pos'>".$canco['aprovada']."</td>";
						echo "</tr>";
				}
			?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>
