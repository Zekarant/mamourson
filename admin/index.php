<?php
require('elements/base.php');
if (isset($_POST['delete'])) {
  unlink('../formulaires/' . $_POST['supprimer_fichier']);
}
if (isset($_POST['envoyer'])) {
  $req = $pdo->prepare('DELETE FROM utilisateurs WHERE email = ?');
  $req->execute(array($_POST['email']));
}
function str_random($length){
  $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
  return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}
if (isset($_POST['validermembre'])) {
  $access = str_random(10);
  $req = $pdo->prepare('INSERT INTO utilisateurs(email, code) VALUES(?, ?)');
  $req->execute(array($_POST['accesemail'], $access));
  $recuperer = $pdo->prepare('SELECT * FROM utilisateurs WHERE email = ?');
  $recuperer->execute(array($_POST['accesemail']));
  $code = $recuperer->fetch();
  $header="MIME-Version: 1.0\r\n";
  $header.='Content-Type:text/html; charset="utf-8"'."\n";
  $header.='Content-Transfer-Encoding: 8bit';
  mail($_POST['accesemail'], 'Code d\'accès - Mam Ourson', "Voici votre code d'accès : " . htmlspecialchars($code['code']), $header);
}
$req = $pdo->prepare('SELECT * FROM utilisateurs ORDER BY id_utilisateur');
$req->execute();
if ($req->rowCount() == 0) {
  $membresAccess = 0;
} else {
  $membres = $req->fetchAll();
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
          <h1 style="padding-top: 20px;">Panneau d'administration de Mam'Ourson</h1>
        </center>
        <div class="alert alert-info">
          <h4>Informations concernant le pannel</h4> 
          <hr>
          Vous trouverez sur ce panneau d'administration les outils suivants :
          <ul>
            <li>Possibilité de donner un accès à la page "Actualités" en rentrant une adresse mail. Ca enverra un code d'accès à la personne avec l'accès. Cet accès peut être révoqué à tout moment, mais la personne ne sera pas prévenue.</li>
            <li>Consulter les différents formulaires d'inscription qui ont été envoyés depuis la page "Inscription". Vous pourrez télécharger les inscriptions et les supprimer.</li>
          </ul>
        </div>
        <?php if (isset($_POST['validermembre'])) { ?>
          <div class="alert alert-success">
            <strong>Email :</strong> <?= htmlspecialchars($_POST['accesemail']) ?><br/>
            <strong>Code d'accès :</strong> <?= htmlspecialchars($code['code']) ?>
          </div>
        <?php } elseif(isset($_POST['envoyer'])){ ?>
          <div class="alert alert-danger">
            <strong>Information : </strong> Vous avez bien supprimé le compte.
          </div>
        <?php } ?>
        <h3>Donner un accès à un membre</h3>
        <hr>
        <form method="POST" action="">
          <div class="row">
            <div class="col-lg-2">
             <label>Adresse email du membre :</label>
           </div>
           <div class="col-lg-10">
            <input type="text" name="accesemail" class="form-control" placeholder="Saisir l'adresse mail du membre auquel vous souhaitez donner l'accès">
            <input type="submit" name="validermembre" class="btn btn-sm btn-outline-info" value="Offrir l'accès au membre">
          </div>
        </form>
      </div>
      <hr>
      <h3>Récapitulatif des membres ayant un accès</h3>
      <?php if (isset($membresAccess) && $membresAccess == 0) { ?>
        <div class="alert alert-primary">
          Aucun membre ne possède d'accès à la page "Actualité" !
        </div>
      <?php } else { ?>
        <table class="table">
          <thead>
            <th>Adresse mail</th>
            <th>Action</th>
          </thead>
          <tbody>
            <?php foreach ($membres as $membre) { ?>
              <tr>
                <td><?= htmlspecialchars($membre['email']) ?></td>
                <td>
                  <form method="POST" action="">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($membre['email']) ?>">
                    <input type="submit" name="envoyer" class="btn btn-outline-danger" onclick="return window.confirm(`Êtes vous sur de vouloir supprimer cet accès ?!`)" value="Supprimer l'accès à ce membre">
                  </form>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
      <h3>Formulaires d'inscription</h3>
      <?php if (isset($_POST['delete'])) { ?>
        <div class="alert alert-success">
          Vous avez bien supprimé le formulaire d'inscription.
        </div>
      <?php } 
      $nomRepertoire = "../formulaires";
      if (is_dir($nomRepertoire)){
        $dossier = opendir($nomRepertoire); ?>
        <div class="container-fluid">
          <div class="row justify-content-center">
            <?php while ($Fichier = readdir($dossier)){
              if ($Fichier != "." AND $Fichier != ".." AND (stristr($Fichier,'.pdf') OR stristr($Fichier,'.docx'))){ ?>
                  <div class="card" style="width: 18rem; margin-right: 20px;">
                    <div class="card-body">
                      <p><?= htmlspecialchars($Fichier) ?></p>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                      <a href="../formulaires/<?= htmlspecialchars($Fichier) ?>" download="<?= htmlspecialchars($Fichier) ?>" class="btn btn-sm btn-outline-info">Télécharger</a>
                      <form method="POST" action="">
                        <input type="hidden" name="supprimer_fichier" value="<?= htmlspecialchars($Fichier) ?>">
                        <input type="submit" name="delete" value="Supprimer" class="btn btn-sm btn-outline-danger" onclick="return window.confirm(`Êtes vous sûr de vouloir supprimer ce fichier ?`)">
                      </form>
                    </div>
                  </div>
              <?php } 
            } ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
</body>
</html>