<?php
include('lib/startup.php'); 

if(isset($_POST['SendEmail'])){
    try{
		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		  throw new Exception("Email non valida");
		}
		if($_POST["oggetto"]=="" && $_POST["richiesta"]==""){
		  throw new Exception("Oggetto e richiesta sono obbligatori");			
		}
		$nome_mittente = "Sito";
		$mail_mittente = "test@test.it";
		$mail_destinatario = "test@test.it";

		$mail_oggetto = "Richiesta contatti da sito";
		$mail_corpo = "Oggetto:".$_POST["oggetto"]."\n"."Richiesta:".$_POST["richiesta"];

		$mail_headers = "From: " .  $nome_mittente . " <" .  $mail_mittente . ">\r\n";

		//TEST la funzione mail() non è configurata
		if (1==1)//mail($mail_destinatario, $mail_oggetto, $mail_corpo, $mail_headers))
			$mess="Messaggio inviato con successo.";
		else
			throw new Exception("Errore. Nessun messaggio inviato.");
    }catch(Exception $e) {
    	$err.=$e->getMessage();
    }
}
?>
<!doctype html>
<html lang="it">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<meta name="keywords" content="Vercelli,Provincia di Vercelli,Contatti associazione">
		<meta name="description" content="Contatti associazione">
		<meta name="author" content="Paolo Franzini">
			
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

		<title>Contatti associazione</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
		<link rel="stylesheet" type="text/css" href="css/slide.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="js/leaflet/leaflet.js"></script>
		
		<script>
			$(document).ready(function () {
				var mymap = L.map('mapid').setView([45.330332, 8.421571], 9);
				L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
					maxZoom: 18,
					attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
						'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
						'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
					id: 'mapbox.streets'
				}).addTo(mymap);
				
				L.marker([45.330332, 8.421571]).addTo(mymap);	
			});
		</script>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="index.php">Provincia di Vercelli</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="slowfood.html">Food</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="passeggiate.html">Passeggiate</a>
					</li>							
					<li class="nav-item">
						<a class="nav-link" href="datiVercelli.php">Dati territorio</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="contatti.php">Contatti</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="login.php">Login</a>
					</li>					
				</ul>
			</div>
		</nav>
				
		<div class="container-fluid">
			<div class="row conteiner-map">
				<div id="mapid" style="height: 300px; width:100%;"></div>
			</div>
			<div class="row">
				<div class="col text-center">
					<fieldset class="txtContact">
						<legend>Contatti</legend>
						<p><span>Indirizzo:</span> Via del Duomo, 6, 13100 Vercelli VC</p>
						<p><span>Orari:</span> lun-ven dalle 9:00 alle 18:00</p>
						<p><span>Telefono:</span> 0161999999 <span>Fax:</span> 016199998</p>
					</fieldset>
				</div>
				<div class="col">
					<form method="POST" action="contatti.php">
						<?php
							if($err!=="")
								echo '<div class="alert alert-danger" role="alert">'.$err.'</div>';
							if($mess!=="")
								echo '<div class="alert alert-success" role="alert">'.$mess.'</div>';
						?>

						<div class="form-group">
							<label for="email">Email</label>
							<input type="text" class="form-control" name="email" placeholder="Email">
						</div>
						<div class="form-group">
							<label for="oggetto">Oggetto</label>
							<input type="text" class="form-control" name="oggetto" placeholder="Oggetto">
						</div>
						<div class="form-group">
							<label for="richiesta">Rchiesta</label>
							<textarea class="form-control" name="richiesta" placeholder="Richiesta"></textarea>
						</div>
						<button type="submit" name="SendEmail" class="btn btn-primary">Invia Mail</button>
					</form>
				</div>
			</div>
		</div>
		
		<div class="footer">
			<p>All Rights Reserved. &copy; 2019 Design By : Paolo Franzini </p>
		</div>
	</body>
</html>