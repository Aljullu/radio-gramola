<?php
	/* Connectem amb la BD i seleccionem la taula */
	$con = mysql_connect("localhost","myrad571","BO26a1Wz");
	if (!$con) die("S'ha produït un error, disculpeu les molèsties: " . mysql_error());
	mysql_select_db("psicoajuradio", $con);
	mysql_set_charset('utf8',$con);
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/style.css" />
<script src="/js/sorttable.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Llista d'artistes | Administració de Ràdio Gramola</title>
</head>
<body>
<div id="wrapper">
	<a href="./albums.php">Àlbums</a> - <a href="./cancons.php">Cançons</a>
	<h1 class="page-title">Llista d'artistes</h1>
	<div id="content">
		<p>Si la data final és -1 significa que el grup segueix en actiu.</p>
		<table id="llista" class="sortable">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Any d'inici</th>
					<th>Any de retirada</th>
					<th>Web</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$query = "SELECT id, nom, inici, final, web, twitter, facebook, youtube, vimeo, flickr, myspace
					FROM artistes
					ORDER BY nom";
				$infoartista = mysql_query($query);
				while ($artista = mysql_fetch_array($infoartista)) {
						echo "<tr>";
						echo "<td><a href='/admin/modifica-artista.php?artista=".$artista['id']."'><img src='http://phpmyadmin.mi-alojamiento.com/themes/pmahomme/img/b_edit.png'/>".$artista['nom']."</a></td>";
						echo "<td>".$artista['inici']."</td>";
						echo "<td>".$artista['final']."</td>";
						echo "<td><a href='".$artista['web']."'>".$artista['web']."</a></td>";
						echo "</tr>";
				}
			?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>
