<?php
require_once('includes/init.php');
require_once('includes/flash.php');


// Gestion de la déconnexion
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    unset($_SESSION['user']);
     
    set_flash('Vous vous êtes bien déconnecté!','info');
   redirect(URL.'connexion.php');
}


if (isConnected()) {
   redirect(URL.'profil.php');
}


// Traitement du formulaire

if (!empty($_POST)) { // Formulaire soumis


    $errors = 0;

    if (empty($_POST['pseudo'])) {
        $errors++;

        set_flash("Merci d'indiquer votre pseudo", 'warning');
        redirect(URL.'connexion.php');
        
    }


    if (empty($_POST['mdp'])) {
        $errors++;


set_flash("Veuillez saisir votre mot de passe", "warning");

    }

    if ($errors == 0) {
        $user = getUserByLogin($_POST['pseudo']);
        if ($user) {

            if (password_verify($_POST['mdp'], $user['mdp'])) {
                $_SESSION['user'] = $user;

           set_flash('Vous êtes bien connecté');

           redirect(URL.'frontOffice/profil.php');

            } else {
                set_flash('La combinaison mot de passe et pseudo n\'est pas reconnue', 'warning');
                
            }
        } else {
            set_flash('Erreur sur vos identifiants', 'warning');
            
        }
    }
}








$title = 'Connexion';
require_once('includes/header.php');


?>


<div class="row justify-content-center">

    <div class="col-md-8 col-xl-4 border border-dark p-5 rounded mt-5">
        <h1 class="text-center">Connexion <i class="bi bi-server"></i></h1>
        <hr class="mb-3">
        <form method="post">

            <div class="mb-3">
                <label for="pseudo" class="form-label">Votre pseudo <i class="bi bi-file-earmark-person-fill"></i></label>
                <input type="text" id="pseudo" name="pseudo" class="form-control" value="<?php echo $_POST['pseudo'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="mdp" class="form-label">Votre Mot de passe <i class="bi bi-file-earmark-lock-fill"></i></label>
                <input type="password" id="mdp" name="mdp" class="form-control">
            </div>

            <div class="mb-3 text-end">
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col text-center mt-4">
        <p>Pas encore inscrit? Créer votre compte très simplement en <a href="<?php echo URL ?>inscription.php">cliquant ici</a></p>

    </div>
</div>


<?php

require_once('includes/footer.php');

require_once('includes//footer.php');
