<?php
include('lib/startup.php'); 

if(isset($_POST['Login'])){
    try{
        $user = new users();
        $user->setConnection($db);
       	$user->CheckLogin($_POST['username'], $_POST['password']);     
    }catch(Exception $e) {
    	$err.=$e->getMessage();
    }
}
else
{
    session_start();
	if(isset($_SESSION['idsession'])){
		$user = new users();
		$user->setConnection($db);
		if($user->CheckAutetication())
       	    header('Location: manage.php');
	}
}
?>
<!doctype html>
<html lang="it">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<meta name="description" content="">
		<meta name="author" content="Paolo Franzini">
			
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/slide.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<title>Login</title>
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
						<a class="nav-link" href="index.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="foot.html">Food</a>
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
					<li class="nav-item active">
						<a class="nav-link" href="login.php">Login</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container-fluid">
			<form method="POST" action="login.php">
				<?php
					if($err!=="")
						echo '<div class="alert alert-danger" role="alert">'.$err.'</div>';
					if($err!=="")
						echo '<div class="alert alert-success" role="alert">'.$err.'</div>';
				?>

				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" name="username" placeholder="username">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" placeholder="Password">
				</div>
				<button type="submit" name="Login" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</body>
</html>