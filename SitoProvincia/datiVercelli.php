<?php
include('lib/startup.php'); 
?>
<!doctype html>
<html lang="it">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<meta name="keywords" content="Vercelli,Provincia di Vercelli,Dati territorio">
		<meta name="description" content="Dati territorio di Vercelli">
		<meta name="author" content="Paolo Franzini">
			
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

		<title>Dati territorio vercelli</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/slide.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</head>
	<body>

		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="index.php">Provincia di Vercelli</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="slowfood.html">Food</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="passeggiate.html">Passeggiate</a>
					</li>						
					<li class="nav-item active">
						<a class="nav-link" href="datiVercelli.php">Dati territorio</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="contatti.php">Contatti</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="login.php">Login</a>
					</li>					
				</ul>
			</div>
		</nav>
				
		<div class="container-fluid">
			<h1>Dati Territorio</h1>
			<?php
				$dati = new dati();
				$dati->setConnection($db);
				$last = "";
				foreach ($dati->getdati() as $dati){		
					if($dati['aggregatore']!=$last || $last==""){
						if($last!="")
							echo'</tbody>
									</table>
								</fieldset>';
						echo'<fieldset>
								<legend>'.$dati['aggregatore'].'</legend>	
								<table class="table">
									<thead>
										<tr>
										<th>Dato</th>
										<th>Valore</th>								
										</tr>
									</thead>
									<tbody>';
					}
										echo '<tr>';
											echo '<td>'.$dati['dato'].'</td>';
											echo '<td>'.$dati['valore'].'</td>';										
										echo '</tr>';
					$last=$dati['aggregatore'];
				}
				if($last!="")
					echo'</tbody>
						</table>
						</fieldset>';
			?>
		</div>
		
		<div class="footer">
			<p>All Rights Reserved. &copy; 2019 Design By : Paolo Franzini </p>
		</div>
	</body>
</html>