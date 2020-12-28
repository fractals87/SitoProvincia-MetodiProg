<?php
include('lib/startup.php'); 
$user = new users();
$user->setConnection($db);
if(!$user->CheckAutetication())
	header('Location: login.php?err='.$user->getLastError());

$gallery = new gallery();
$gallery->setConnection($db);

$news = new news();
$news->setConnection($db);

$dati = new dati();
$dati->setConnection($db);

try{
	if(isset($_REQUEST["funz"]))
	{
		/**********************************************************Gallery***************************************************/
		if($_REQUEST["funz"]=="UploadImgGallery"){
			$upload_max = 5242880;
			$target_dir = "images/gallery/";
			if ($_FILES["fileGallery"]["size"] > $upload_max)
				throw new Exception("Dimensione del file superata.");
			if($_POST["titleGallery"]=="")
				throw new Exception("Inserire un titolo all'immagine");
						
			$final_name = uniqid("f_",TRUE); 
			$final_name_lower = strtolower($final_name);
			$file_ext = strtolower(pathinfo($_FILES["fileGallery"]["name"],PATHINFO_EXTENSION));
			$final_name_ext = $final_name_lower.".".$file_ext; 
			$target_file = $target_dir . $final_name_ext ;

			if (move_uploaded_file($_FILES["fileGallery"]["tmp_name"], ROOT.$target_file)){
				$mess="Il file <b>". basename( $_FILES["fileGallery"]["name"]). "</b> &egrave; stato caricato correttamente";
			}else{
				throw new Exception("Errore in fase di upload del file. ".$_FILES['fileGallery']['error']);
			}
			$gallery->url = $target_file;
			$gallery->title = $_POST["titleGallery"];
			if(!$gallery->insertGallery())
				throw new Exception($gallery->getLastError());
		}
		if($_REQUEST["funz"]=="DeleteGallery"){
			if(!isset($_REQUEST["Id"]))
				throw new Exception("Riferimento immagine non corretto");
			if (!is_numeric($_REQUEST["Id"]))
				throw new Exception("Riferimento immagine non numerico");
			$gallery->id = $_REQUEST["Id"];
			if(!$gallery->deleteGallery())
				throw new Exception($gallery->getLastError());
		}
		
		/**********************************************************NEWS***************************************************/		
		if($_REQUEST["funz"]=="InsEditNews"){
			if($_REQUEST["titleNews"]=="")
				throw new Exception("Titolo obbligatorio.");
			if($_REQUEST["textNews"]=="")
				throw new Exception("Text obbligatorio.");			
			$news->title=$_REQUEST["titleNews"];
			$news->text=$_REQUEST["textNews"];

			if(Isset($_REQUEST["idNews"]) && $_REQUEST["idNews"]!="" &&is_numeric($_REQUEST["idNews"])){
				$news->id=$_REQUEST["idNews"];
				if(!$news->updateNews())
					throw new Exception($news->getLastError());
			}else{
				if(!$news->insertNews())
					throw new Exception($news->getLastError());				
			}
		}
		if($_REQUEST["funz"]=="DeleteNews"){
			if(!isset($_REQUEST["Id"]))
				throw new Exception("Riferimento news non corretto");
			if (!is_numeric($_REQUEST["Id"]))
				throw new Exception("Riferimento news non numerico");
			$news->id = $_REQUEST["Id"];
			if(!$news->deleteNews())
				throw new Exception($news->getLastError());
		}
		/**********************************************************DATI***************************************************/
		if($_REQUEST["funz"]=="InsEditDati"){
			if($_REQUEST["aggregatoreDati"]=="")
				throw new Exception("Aggregatore obbligatorio.");
			if($_REQUEST["datoDati"]=="")
				throw new Exception("Dato obbligatorio.");			
			if($_REQUEST["valoreDati"]=="")
				throw new Exception("Valore obbligatorio.");				
			$dati->aggregatore=$_REQUEST["aggregatoreDati"];
			$dati->dato=$_REQUEST["datoDati"];
			$dati->valore=$_REQUEST["valoreDati"];

			if(Isset($_REQUEST["idDati"]) && $_REQUEST["idDati"]!="" && is_numeric($_REQUEST["idDati"])){

				$dati->id=$_REQUEST["idDati"];
				if(!$dati->updateDati())
					throw new Exception($dati->getLastError());
			}else{
				if(!$dati->insertDati())
					throw new Exception($dati->getLastError());				
			}
		}
		if($_REQUEST["funz"]=="DeleteDati"){
			if(!isset($_REQUEST["Id"]))
				throw new Exception("Riferimento dato non corretto");
			if (!is_numeric($_REQUEST["Id"]))
				throw new Exception("Riferimento dato non numerico");
			$dati->id = $_REQUEST["Id"];
			if(!$dati->deleteDati())
				throw new Exception($dati->getLastError());
		}
	}
} catch (Exception $e) {
    $err.=$e->getMessage();
}
?>

<!doctype html>
<html lang="it">
	<head>
		<!--charset-->
		<meta charset="utf-8">
		<!--rende il sito responsive-->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="author" content="Paolo Franzini">
			
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

		<title>Gestione sito</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/slide.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
		<script src="js/jquery-3.3.1.min.js" ></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script>
			function GetNews(id){
				$.getJSON( "lib/AjaxNews.php?id="+id, function( data ) {
					if (data != null && !jQuery.isEmptyObject(data)) {
						$("#idNews").val(data.id);
						$("#titleNews").val(data.title);
						$("#textNews").val(data.text);
					}
				});
			}
			function GetDati(id){
				$.getJSON( "lib/AjaxDati.php?id="+id, function( data ) {
					if (data != null && !jQuery.isEmptyObject(data)) {
						$("#idDati").val(data.id);
						$("#aggregatoreDati").val(data.aggregatore);
						$("#datoDati").val(data.dato);
						$("#valoreDati").val(data.valore);						
					}
				});
			}
		</script>	
	</head>
	<body>

		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="index.php">Provincia di Vercelli</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="index.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="logout.php">Logout</a>
					</li>					
				</ul>
			</div>
		</nav>
		<div class="container-fluid">
			<h1>Amministrazione Sito</h1>
			

			<?php
				if($err!=="")
					echo '<div class="alert alert-danger" role="alert">'.$err.'</div>';
				if($mess!=="")
					echo '<div class="alert alert-success" role="alert">'.$mess.'</div>';
			?>
			<!--------------------------GALLERY------------------------->
			<div class="row">
				<div class="col">
					<fieldset>
						<legend>Gallery</legend>	
						<table class="table">
							<thead>
								<th>Title</th>
								<th></th>
							</thead>
							<tbody>
								<?php
								foreach ($gallery->getGallery() as $photo){
									echo '<tr>';
										echo '<td>'.$photo['title'].'</td>';
										echo '<td><a href="manage.php?funz=DeleteGallery&Id='.$photo['id'].'">Delete</a></td>';
									echo '</tr>';
								}							
								?>
							</tbody>
						</table>
					</fieldset>
				</div>
				<div class="col">
					<form method="POST" action="manage.php" enctype="multipart/form-data">
						<input type="hidden" name="funz" value="UploadImgGallery" />
						<fieldset>
							<legend>Aggiungi immagine</legend>	
							<div class="form-group">
								<label for="titleImg">Titolo</label>
								<input type="text" class="form-control" name="titleGallery" placeholder="Titolo">
							</div>
							<div class="form-group">
								<label for="imgFile">Immagine</label>
								<input type="file" class="form-control" name="fileGallery" placeholder="file">
							</div>	
							<button type="submit" class="btn btn-primary">Submit</button>							
						</fieldset>		
					</form>						
				</div>
			</div>
			
			<!--------------------------NEWS------------------------->
			<div class="row">
				<div class="col">
					<fieldset>
						<legend>News</legend>	
						<table class="table">
							<thead>
								<th>Title</th>
								<th>Testo</th>
								<th></th>
							</thead>
							<tbody>
								<?php
								foreach ($news->getNews() as $news){
									echo '<tr>';
										echo '<td>'.$news['title'].'</td>';
										echo '<td>'.$news['text'].'</td>';
										echo '<td><a href="manage.php?funz=DeleteNews&Id='.$news['id'].'">Delete</a></td>';
										echo '<td><span onclick="GetNews('.$news['id'].');" class="spnLink">Load</span></td>';
									echo '</tr>';
								}							
								?>
							</tbody>
						</table>
					</fieldset>
				</div>
				<div class="col">
					<form method="POST" action="manage.php">
						<input type="hidden" name="funz" value="InsEditNews" />
						<fieldset>
							<legend>News</legend>	
							<div class="form-group">
								<label for="idNews">Id (Se compilato si procede in modifica)</label>
								<input type="text" class="form-control" name="idNews" id="idNews" placeholder="Id">
							</div>
							<div class="form-group">
								<label for="titleNews">Titolo</label>
								<input type="text" class="form-control" name="titleNews" id="titleNews" placeholder="Titolo">
							</div>
							<div class="form-group">
								<label for="textNews">Testo</label>
								<textarea class="form-control" name="textNews" id="textNews" placeholder="Testo"></textarea>
							</div>	
							<button type="submit" class="btn btn-primary">Submit</button>							
						</fieldset>		
					</form>						
				</div>
			</div>
			
			<!--------------------------Dati Territorio------------------------->
			<div class="row">
				<div class="col">
					<fieldset>
						<legend>Dati Territorio</legend>	
						<table class="table">
							<thead>
								<th>Aggregatore</th>
								<th>Dato</th>
								<th>Valore</th>								
								<th></th>
							</thead>
							<tbody>
								<?php
								foreach ($dati->getDati() as $dati){
									echo '<tr>';
										echo '<td>'.$dati['aggregatore'].'</td>';
										echo '<td>'.$dati['dato'].'</td>';
										echo '<td>'.$dati['valore'].'</td>';										
										echo '<td><a href="manage.php?funz=DeleteDati&Id='.$dati['id'].'">Delete</a></td>';
										echo '<td><span onclick="GetDati('.$dati['id'].');" class="spnLink">Load</span></td>';
									echo '</tr>';
								}							
								?>
							</tbody>
						</table>
					</fieldset>
				</div>
				<div class="col">
					<form method="POST" action="manage.php">
						<input type="hidden" name="funz" value="InsEditDati" />
						<fieldset>
							<legend>Dato</legend>	
							<div class="form-group">
								<label for="idDati">Id (Se compilato si procede in modifica)</label>
								<input type="text" class="form-control" name="idDati" id="idDati" placeholder="Id">
							</div>
							<div class="form-group">
								<label for="aggregatoreDati">Aggregatore (I dati verranno raggruppati a parità di aggregatore)</label>
								<input type="text" class="form-control" name="aggregatoreDati" id="aggregatoreDati" placeholder="Aggregatore">
							</div>
							<div class="form-group">
								<label for="datoDati">Dato</label>
								<input type="text" class="form-control" name="datoDati" id="datoDati" placeholder="Dato">
							</div>
							<div class="form-group">
								<label for="valoreDati">Valore</label>
								<input type="text" class="form-control" name="valoreDati" id="valoreDati" placeholder="Valore">
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>							
						</fieldset>		
					</form>						
				</div>
			</div>
		</div>
	</body>
</html>