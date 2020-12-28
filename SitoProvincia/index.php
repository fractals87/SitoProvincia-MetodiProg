<?php
include('lib/startup.php'); 
?>
<!doctype html>
<html lang="it">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<meta name="keywords" content="Vercelli,Provincia di Vercelli,Conoscere Vercelli">
		<meta name="description" content="Promozione del territorio di Vercelli">
		<meta name="author" content="Paolo Franzini">
			
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

		<title>Provincia di vercelli</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/slide.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script>
			var slide_index = 1;
		    
			$( document ).ready(function() {
				displaySlides(slide_index);
			});			
			
			
			function nextSlide(n) {
				displaySlides(slide_index += n);
			}

			function currentSlide(n) {
				displaySlides(slide_index = n);
			}

			function displaySlides(n) {
				var i;
				var slides = document.getElementsByClassName("showSlide");
				if (n > slides.length) { slide_index = 1 }
				if (n < 1) { slide_index = slides.length }
				for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none";
				}
				slides[slide_index - 1].style.display = "block";
			}			
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
			<div class="conteiner-slide">
				<?php
				$gallery = new gallery();
				$gallery->setConnection($db);
				foreach ($gallery->getGallery() as $photo){
						echo '<div class="showSlide fade2">
									<img src="'.$photo['url'].'" alt="'.$photo['title'].'"/>
									<div class="content">'.$photo['title'].'</div>
								</div>';
				}
				?>
				
				<!-- Navigation arrows -->
				<a class="left" onclick="nextSlide(-1)"></a>
				<a class="right" onclick="nextSlide(1)"></a>
			</div>
				
			
			<div class="conteiner-news">
				<h2>News</h2>
				<?php
				$news = new news();
				$news->setConnection($db);
				$n = 0;
				foreach ($news->getIndexNews() as $news){
					if($n == 0 || $n==3){
						echo '<div class="row margin-news">';
						$n=0;
					}			
					echo '<div class="col">
							<div class="card margin-news">
								<div class="card-body">
								<h5 class="card-title">'.$news['title'].'</h5>
								<p class="card-text">'.$news['text'].'...</p>
								<a href="news.php?id='.$news['id'].'" class="card-link">Leggi tutto</a>
								</div>
							</div>
						  </div>';
					$n+=1;
					if($n==3)
						echo '</div>';
				}
				?>
			</div>
		</div>
		
		<div class="footer">
			<p>All Rights Reserved. &copy; 2019 Design By : Paolo Franzini </p>
		</div>
	</body>
</html>