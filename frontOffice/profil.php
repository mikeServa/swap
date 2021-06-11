<?php
// phpinfo();

require_once('../includes/init.php');

//On s'assure que l'utilisateur est bien sur cette page après s'être identifié
if (!isConnected()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

require_once('../includes/functions.php');
//Mise à jour du profil
//traitement du pseudo et de sa longueur
if (isset($_POST['update_perso'])) {
  

    $errors = 0;

    include('../traitement/pseudo.php');

    //traitement du password
    if (empty($_POST['mdp'])) {
        $errors++;
        set_flash("Veuillez saisir votre mot de passe", "warning");
        redirect(URL . 'frontOffice/profil.php');
    }

    if ($errors == 0) {

        $user = getUserByLogin($_POST['pseudo']);
        if ($user) {

            if (password_verify($_POST['mdp'], $user['mdp'])) {
                $_SESSION['user'] = $user;
            } else {
                set_flash('La combinaison mot de passe et pseudo n\'est pas reconnue', 'warning');
                redirect(URL . 'frontOffice/profil.php');
            }
        } else {
            set_flash('Erreur sur vos identifiants', 'warning');
            redirect(URL . 'frontOffice/profil.php');
        }
    }

    //traitement de l'adresse mail
    include('../traitement/email.php');

    //traitement du téléphone
    include('../traitement/telephone.php');

    //traitement du nom et du prenom
    include('../traitement/patronyme.php');

    if ($errors == 0) {

        sql("UPDATE membre SET nom =:nom, prenom=:prenom, email =:email, telephone=:telephone, civilite =:civilite WHERE id_membre =:id_membre", array(
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'telephone' => $_POST['telephone'],
            'civilite' => $_POST['civilite'],
            'id_membre' => intval($_SESSION['user']['id_membre'])

        ));

        $_SESSION['user']['nom'] = $_POST['nom'];
        $_SESSION['user']['prenom'] = $_POST['prenom'];
        $_SESSION['user']['email'] = $_POST['email'];
        $_SESSION['user']['telephone'] = $_POST['telephone'];
        $_SESSION['user']['civilite'] = $_POST['civilite'];

        set_flash('Votre compte a bien été mis à jour, vous pouvez desormais deposer une annonce');
        redirect(URL);

    }
} //fin du traitement du formulaire update_perso




//Traitement du mot de passe 
// Formulaire mot de passe
if (isset($_POST['update_password'])) {
  

    $errors = 0;


    if (empty($_POST['password'])) {
        $errors++;
        set_flash('Merci de saisir votre mot de passe actuel', 'danger');
        redirect(URL . 'frontOffice/profil.php');
    } else {
        if (!password_verify($_POST['password'], $_SESSION['user']['mdp'])) {
            $errors++;
            set_flash('Mot de passe incorrect', 'danger');
            redirect(URL . 'frontOffice/profil.php');
        }
    }

    if (empty($_POST['newpassword'])) {
        $errors++;
        set_flash('Merci de saisir un nouveau mot de passe', 'danger');
        redirect(URL . 'frontOffice/profil.php');
    } else {
        $pattern = '#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[\S]{8,20}$#';
        if (!preg_match($pattern, $_POST['newpassword'])) {
            $errors++;
            set_flash('Le nouveau mot de passe doit être composé de 8 à 20 caractères comprenant au moins une minuscule, une majuscule et un chiffre', 'danger');
            redirect(URL . 'frontOffice/profil.php');
        }
    }


    if (empty($_POST['confirmation'])) {
        $errors++;
        set_flash('Merci de confirmer votre mot de passe', 'danger');
        redirect(URL . 'frontOffice/profil.php');
    } else {
        if (!empty($_POST['newpassword']) && ($_POST['confirmation'] !== $_POST['newpassword'])) {
            $errors++;
            set_flash('La confirmation ne concorde pas avec le mot de passe', 'danger');
            redirect(URL . 'frontOffice/profil.php');
        }
    }

    if ($errors == 0) {

        $password_crypte = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);

        sql("UPDATE membre SET mdp=:password  WHERE id_membre=:id_membre", array(
            'password' => $password_crypte,
            'id_membre' => $_SESSION['user']['id_membre']
        ));
        $_SESSION['user']['password']  =  $password_crypte;
        set_flash('Votre mot de passe a été mise à jour', 'success');
        redirect(URL );
    }
}


$title = 'profil';
require_once('../includes/header.php');


?>

<div class="row">
    <div class="col-4">
        <div class="list-group " id="list-tab" role="tablist">

            <a class="list-group-item list-group-item-action" id="list-profile-list1" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Modifier mon profil</a>

                <a class="list-group-item list-group-item-action " id="list-messages-list" data-bs-toggle="list" href="#list-messages" role="tab" aria-controls="list-messages">Modifier mon mot de passe</a>

            <?php  if (!empty($_SESSION['user']['prenom']) && !empty($_SESSION['user']['nom']) && !empty($_SESSION['user']['telephone'])) : ?>
            
            <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="" href="<?= URL.'frontOffice/annonces.php' ?>" role="" aria-controls="">Déposer une annonce</a>
            <a class="list-group-item list-group-item-action" id="list-settings-list1" data-bs-toggle="" href="<?= URL.'frontOffice/annonces_consultation.php' ?>" role="" aria-controls="">Consulter mes annonces</a>
          

            <?php endif ?>
        </div>
    </div>
    <div class="col-8">
        <div class="tab-content bg-light" id="nav-tabContent">
            <div class="tab-pane fade show active bg-light" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
               

                <div class="col">

                    <div class="container-fluid">
                    </div>

                </div>
            </div>
        </div>
        <!-- Modification du profil -->
        <div class="tab-pane fade bg-light border" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
            <h1 class="text-center">Modifier mon profil</h1>
            <hr class="my-3">
            <!-- Debut du formulaire -->
            <form method="post" id="update_perso" class="form-control" name="update_perso">
                <!-- pseudo -->
                <div class="d-flex justify-content-evenly">
                    <div class="  input-group mb-3 w-25 ">
                        <span class="input-group-text " id="basic-addon1"><i class="bi bi-person-fill"></i></span>
                        <input type="text" class="form-control" placeholder="<?= $_POST['pseudo'] ?? 'Votre pseudo'  ?>" aria-label="pseudo" aria-describedby="basic-addon1" id="pseudo" name="pseudo">
                    </div>
                    <!-- mdp -->
                    <div class="  input-group mb-3 w-25">
                        <span class="input-group-text " id="mdp"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" aria-label="mdp" aria-describedby="basic-addon2" id="mdp" name="mdp">
                    </div>
                </div>
                <!-- email -->
                <div class="d-flex justify-content-evenly">
                    <div class="  input-group mb-3  w-25">
                        <span class="input-group-text " id="basic-addon2"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" class="form-control" placeholder="<?= $_SESSION['user']['email'] ?>" aria-label="email" aria-describedby="basic-addon2" id="email" name="email">
                    </div>
                    <!-- telephone -->
                    <div class="input-group mb-3  w-25">
                        <span class="input-group-text " id="basic-addon3"><i class="bi bi-telephone-fill"></i></span>
                        <input type="text" class="form-control" placeholder="<?= $_SESSION['user']['telephone'] ?: '06 xx xx xx xx' ?>" aria-label="phone" aria-describedby="basic-addon3" id="telephone" name="telephone">
                    </div>
                </div>
                <!-- nom -->
                <div class="d-flex justify-content-evenly">
                    <div class="  input-group mb-3  w-25">
                        <span class="input-group-text " id="basic-addon4"><i class="bi bi-person-fill"></i></span>
                        <input type="text" class="form-control" placeholder="<?= $_SESSION['user']['nom']  ?: 'Votre nom' ?>" aria-label="nom" aria-describedby="basic-addon4" id="nom" name="nom">
                    </div>
                    <!-- prenom -->

                    <div class="  input-group mb-3  w-25">
                        <span class="input-group-text " id="prenom"><i class="bi bi-person-lines-fill"></i></span>
                        <input type="prenom" class="form-control" aria-label="prenom" aria-describedby="basic-addon5" id="prenom" name="prenom" placeholder="<?= $_SESSION['user']['prenom']  ?: 'Votre prénom' ?>">
                    </div>
                </div>

                <div class="d-flex justify-content-evenly">
                    <!-- civilite -->

                    <select class="form-select w-25" aria-label="Default select example" name="civilite">

                        <option disabled>Civilité</option>
                        <option value="m">Homme</option>
                        <option selected value="f">Femme</option>

                    </select>



                </div>
                <div class="text-end">
                    <button type="submit" name="update_perso">

                        <i class="bi bi-person-plus info"></i>
                    </button>
                </div>
            </form> <!-- fin du formulaire -->
        </div>
        <div class="tab-pane fade bg-light  d-flex justify-content-center" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
            <div class="col-md-6">
                <h2>Modifier mon mot de passe</h2>
                <hr class="mb-3">

                <form method="post">

                    <div class="mb-3">
                        <label for="password">Mot de passe actuel</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="newpassword">Nouveau mot de passe</label>
                        <input type="password" id="newpassword" name="newpassword" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="confirmation">Confirmation</label>
                        <input type="password" id="confirmation" name="confirmation" class="form-control">
                    </div>
                    <button class="btn btn-primary" name="update_password">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
    <div class="tab-pane fade bg-light" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
    


    </div>
</div>
</div>
</div>
<?php
require_once('../includes/footer.php');
