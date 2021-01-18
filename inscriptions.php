<?php if (isset($_POST['envoyer'])) {
	$erreur = "";
	if (empty($_POST['nom'])) {
		$couleur = "warning";
		$message = "Vous n'avez pas renseigné votre nom.";
		$erreur = "Nom";
	}
	if (empty($_POST['prenom'])) {
		$couleur = "warning";
		$message = "Vous n'avez pas renseigné votre prénom.";
		$erreur = "Prénom";
	}
	if (empty($_POST['email']) AND preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $_POST['email'])){
		$couleur = "warning";
		$message = "Vous n'avez pas renseigné votre email.";
		$erreur = "Email";
	}
	if(isset($_FILES['inscription']) && $_FILES['inscription']['error'] == 0){ 
		if ($_FILES['inscription']['type'] != 'application/pdf' && $_FILES['inscription']['type'] != 'application/octet-stream'){
			$couleur = "warning";
			$message = "Votre fichier n'est pas au format PDF ou Word.";
			$erreur = "type";
		} 
	} else {
		$couleur = "warning";
		$message = "Vous n'avez envoyé aucun fichier.";
		$erreur = "fichier";
	}
	if (!$erreur) {
		$nom_fichier = "";
		$url = "";
		$repertoire = "formulaires/"; 
		if (!file_exists($repertoire)){ 
			$message = "Le répertoire qui stocke vos belles images n'existe pas, merci de contacter un administrateur pour ce problème."; 
			$couleur = "warning";
		} else {
			if ($_FILES['inscription']['type'] == 'application/pdf'){ 
				$extention = '.pdf'; 
			} if ($_FILES['inscription']['type'] == 'application/octet-stream'){ 
				$extention = '.docx'; 
			}
			$nom_fichier = $_POST['nom'] . " " . $_POST['prenom'] . " - Inscription" . $extention; 
			if (move_uploaded_file($_FILES['inscription']['tmp_name'], $repertoire.$nom_fichier)){ 
				$url = 'https://projetstage.nexgate.ch/'.$repertoire.''.$nom_fichier.'';		
			}
		}
		$header="MIME-Version: 1.0\r\n";
		$header.="From: MAM'Oursons <mamoursons42@gmail.com>\n";
		$header.='Content-Type:text/html; charset="utf-8"'."\n";
		$header.="Content-Transfer-Encoding: 8bit";
		$sujet ="Formulaire d'inscription - " . htmlspecialchars($_POST['nom']) . " " . htmlspecialchars($_POST['prenom']);
		$demande = 'Content-Type:text/html; charset="utf-8"'."\n";
		$demande = "<p>Bonjour,<br/>
		Vous avez reçu un mail de <strong>" . htmlspecialchars($_POST['nom']) . " " . htmlspecialchars($_POST['prenom']) . "</strong> concernant une demande d'inscription.</p>
		<p>Voici le fichier d'inscription qu'il vous a envoyé : <a href='" . htmlspecialchars($url) ."' download='" . htmlspecialchars($url) . "'>Télécharger le fichier</a></p>
		<p>Vous pouvez recontacter la personne au mail suivant : <a href='mailto:" . htmlspecialchars($_POST['email']) . "'>" . htmlspecialchars($_POST['email']) . "</a></p>
		<p>Autres informations (facultatif) : " . htmlspecialchars($_POST['demande']) . "</p>";
		mail('mamoursons42@gmail.com', $sujet, $demande, $header);
		$couleur = "success";
		$message = "Votre message a bien été envoyé ! Nous vous recontacterons par mail très prochainement !";
	}
	
	
} ?>
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
	<div class="container-fluid bg-white">
		<h1 class="text-center" id="inscription">Inscription</h1>
		<hr>
		<p>Si vous souhaitez nous confier votre enfant, c'est très simple : téléchargez l'un des deux formulaires ci-dessous et veuillez à tout remplir. Vous retrouverez deux versions de notre formulaire : <strong>Word et PDF</strong>.</p>
		<div class="d-flex justify-content-center">
			<a href="inscription.docx" class="btn btn-primary" tabindex="-1" role="button" download="inscription.docx">Télécharger le formulaire d'inscription (Word)</a>
			<a href="inscription.pdf" class="btn btn-danger" tabindex="-1" role="button" download="inscription.pdf">Télécharger le formulaire d'inscription (PDF)</a>
		</div>
		<hr>
		<h2>Renvoyer le formulaire d'inscription</h2>
		<?php if (isset($_POST['envoyer'])) { ?>
			<div class="alert alert-<?= htmlspecialchars($couleur) ?>">
				<?= htmlspecialchars($message) ?>
			</div>
		<?php } ?>
		<div class="alert alert-info">
			Dans le but d'inscrire votre enfant, merci de renvoyer votre formulaire d'inscription à l'aide du formulaire ci-dessous !
		</div>
		<div class="container-fluid">
			<form method="POST" action="" enctype="multipart/form-data">
				<div class="row">
					<div class="col-lg-6">
						<label>Nom :</label>
						<input type="text" name="nom" class="form-control" placeholder="Saisir votre nom">
						<br/>
						<label>Prénom :</label>
						<input type="text" name="prenom" class="form-control" placeholder="Saisir votre prénom">
						<br/>
						<label>Adresse mail :</label>
						<input type="email" name="email" class="form-control" placeholder="Saisir votre adresse mail">
						<br/>
						<label>Mon fichier d'inscription : </label>
						<input type="file" name="inscription" class="file btn btn-info"/>
					</div>
					<div class="col-lg-6">
						<label>Autres informations susceptibles de nous aider :</label>
						<textarea class="form-control" rows="12" name="demande" placeholder="Dans ce cadre, veuillez citer toutes les choses importantes que nous aurions pu oublier dans le formulaire d'inscription"></textarea>
						<input class="btn btn-sm btn-info" type="submit" name="envoyer" value="Envoyer mon inscription">
						<br/><br/>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="footer-bottom">       
		<div class="container">           
			<p class="pull-left">© 2020 - Tous droits réservés. MAM'OURSON</p>        
		</div>    
	</div>
</body>
</html>