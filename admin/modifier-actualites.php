<?php if (isset($_POST['modifier'])) {
	file_put_contents('../admin/fichiers-txt/actualites.txt', $_POST['texte']);
} 
$ligne = file_get_contents('../admin/fichiers-txt/actualites.txt', FILE_USE_INCLUDE_PATH);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Modification de la page "Actualités" - Mam'Ourson</title>
	<link rel="icon" href="/images/logo.png"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css2?family=Vast+Shadow&display=swap" rel="stylesheet">
	<script type="text/javascript" src="/tinymce/js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="/tinymce/js/tinymce/tinymce.js"></script>
	<script>
		tinymce.init({
			selector: 'textarea',
			height: 500,
			language: 'fr_FR',
			force_br_newlines : true,
			force_p_newlines : false,
			entity_encoding : "raw",
			browser_spellcheck: true,
			contextmenu: false,
			plugins: ['autolink visualblocks visualchars image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern autosave'],
			toolbar: 'undo redo |  formatselect | tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | removeformat | restoredraft',
		});
	</script>
	<link rel="stylesheet" type="text/css" href="css/css.css">
</head>
<body>
	<?php include('elements/navigationAdmin.html'); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-2 bg-light border-right border-bottom" style="min-height: 100vh;">
				<center>
					<h3 style="padding-top: 20px;">Bienvenue !</h3>
				</center>
				<hr>
				<?php include('elements/navigationSecondaire.html'); ?>
			</div>
			<div class="col-lg-10">
				<center>
					<h1 style="padding-top: 20px;">Modification de la page "Actualité"</h1>
				</center>
				<hr>
				<form method="POST" action="">
					<textarea name="texte"><?= htmlspecialchars($ligne) ?></textarea>
					<input type="submit" name="modifier" class="btn btn-info">
				</form>

			</div>
		</div>
	</div>
</body>
</html>