<?php
session_start();
$ligne = file_get_contents('admin/fichiers-txt/actualites.txt', FILE_USE_INCLUDE_PATH);
require_once('elements/base.php');
if (isset($_POST['envoyer'])) {
	if (!empty($_POST['email']) OR !empty($_POST['access'])) {
		$req = $pdo->prepare('SELECT * FROM utilisateurs WHERE email = ?');
		$req->execute(array($_POST['email']));
		$mail = $req->fetch();
		if (!isset($mail['email'])) {
			$erreur = "Ce mail n'existe pas !";
		} else {
			if ($_POST['access'] == $mail['code']) {
				$_SESSION['auth'] = $mail;
			} else {
				$erreur = "Vous n'avez pas rentré le bon code d'accès !";
			}
		}
	}
} 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>MAM OURSONS - MAISON D'ASSISTANCE MATERNELLE</title>
	<link rel="icon" href="/images/logo.png"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css2?family=Vast+Shadow&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/css.css">
</head>
<body>
	<?php include('elements/barreNavigation.html'); ?>
	<div class="bg-white" style="padding: 15px; margin-top: 10px; min-height: 50vh;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-8">
					<h2>Photos</h2>
					<hr>
					<?php if (isset($erreur)) { ?>
						<div class="alert alert-warning">
							<strong>Erreur : </strong><?= htmlspecialchars($erreur) ?>
						</div>
					<?php } ?>
					<div class="alert alert-info">
						Pour accéder aux photos, veuillez vous connecter à l'aide du formulaire de connexion ci-contre.
					</div>
					<?php if(isset($_SESSION['auth'])){
						echo htmlspecialchars_decode($ligne);
					} ?>
				</div>
				<div class="col-lg-4">
					<?php if(!isset($_SESSION['auth'])) { ?>
						<div class="card">
							<div class="card-header">
								Me connecter à mon compte parent
							</div>
							<div class="card-body">
								<form method="POST" action="">
									<label>Votre adresse mail :</label>
									<input type="text" name="email" class="form-control" placeholder="Saisir votre adresse email">
									<br/>
									<label>Votre code d'accès :</label>
									<input type="type" name="access" class="form-control" placeholder="Saisir votre code d'accès">
									<hr>
									<input type="submit" name="envoyer" value="Me connecter" class="btn btn-outline-info">
								</form>
							</div>
						</div>
					<?php } else { ?>
						<div class="card">
							<div class="card-header">
								Mon compte parent
							</div>
							<div class="card-body">
								Votre mail : <?= htmlspecialchars($_SESSION['auth']['email']); ?>
							</div> 
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">       
		<div class="container">           
			<p class="pull-left">© 2020 - Tous droits réservés. MAM'OURSON</p>        
		</div>    
	</div>
</body>
</html>