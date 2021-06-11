<?php
// phpinfo();

require_once('../includes/init.php');
require_once('../includes/functions.php');




if (!isAdmin()) {

    redirect(URL . 'connexion.php');
}

// Suppression ($_GET)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    sql("DELETE FROM membre WHERE id_membre=:id", array(
        'id' => $_GET['id']
    ));
    set_flash('Le membre a été supprimé avec succès', 'success');
    redirect($_SERVER['PHP_SELF']);
}


// Traitement du formulaire
if (isset($_GET['action']) && $_GET['action'] == 'add') { // Formulaire soumis


    $errors = 0;

    if (empty($_POST['pseudo'])) {
        $errors++;

        set_flash('Merci de choisir un pseudo', 'warning');
    } elseif (iconv_strlen($_POST['pseudo']) > 19) {
        $errors++;
        set_flash(' Votre pseudo ne doit pas dépasser 19 caractères!', 'danger');
    } else {
        $membre = getUserByLogin($_POST['pseudo']);
        if ($membre) {
            $errors++;
            set_flash(' Ce pseudo n\'est pas disponible', 'info');
        }
    }

    if (empty($_POST['mdp'])) {
        $errors++;


        set_flash('Merci de saisir un mot de passe', 'warning');
    } else {
        $pattern = '#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[\S]{8,20}$#';
        if (!preg_match($pattern, $_POST['mdp'])) {
            $errors++;


            set_flash('  Le mot de passe doit être composé de 8 à 20 caractères comprenant au moins une minuscule, une majuscule et un chiffre', 'danger');
        }
    }


    if (empty($_POST['email'])) {
        $errors++;


        set_flash('Merci de saisir votre adresse mail', 'warning');
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors++;

            set_flash('Adresse mail invalide', 'danger');
        }
    }
    if(empty($_POST['telephone'])){
        $errors++;
        
        set_flash('Merci d\'indiquer votre numéro de téléphone','warning');
   
      
        
    }elseif (is_numeric($_POST['telephone']) && trim(iconv_strlen($_POST['telephone'] )) < 10 ) {
        $errors++;
    set_flash(' Votre numéro doit être composé de 10 chiffres','danger');
    }

    //Saisie  non obligatoire

    if (!empty($_POST['prenom']) && !empty($_POST['nom'])) {

        if (iconv_strlen($_POST['prenom']) > 19 || iconv_strlen($_POST['nom']) > 19) {
            $errors++;
            set_flash(' Votre prenom et votre nom ne doivent pas dépasser 19 caractères!', 'danger');
        }
    }

    // A ce stade si errors vaut toujours 0, c'est que c'est ok
    if ($errors == 0) {
        sql("INSERT INTO membre VALUES (NULL,:pseudo,:mdp, NULL, NULL, NULL,:email, NULL, 0, NOW())", array(
            'pseudo' => $_POST['pseudo'],
            'mdp' => password_hash($_POST['mdp'], PASSWORD_DEFAULT),
            'email' => $_POST['email']
        ));



        set_flash('Inscription réussie');


        redirect(URL . 'backoffice/gestion_membres');
    }
}



$membres = sql("SELECT `id_membre`,`id_membre`, `pseudo`,`nom`,`prenom`,`email`,`telephone`,`civilite`,`statut`,`date_enregistrement` FROM `membre` ORDER BY id_membre");


$title = 'Gestion des utilisateurs';
require_once('../includes/header.php');
?>


<div class="container-fluid">




    <?php if ($membres->rowCount() > 0) : ?>

        <h2>Liste des utilisateurs</h2>


        <table class="table table-striped table-hover border table-bordered display" id="example" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">id membre</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Civilité</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Date d'enregistrement</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($membre = $membres->fetch()) : ?>


                    <tr>
                        <th scope="row"><?= $membre['id_membre'] ?></th>
                        <td><?= $membre['pseudo'] ?></td>
                        <td><?= $membre['nom'] ?></td>
                        <td><?= $membre['prenom'] ?></td>
                        <td><?= $membre['email'] ?></td>
                        <td><?= $membre['telephone'] ?></td>
                        <td><?= $membre['civilite'] ?></td>
                        <td><?= ($membre['statut'] == 0) ?  'Membre' : 'Admin' ?></td>
                        <td><?= $membre['date_enregistrement'] ?></td>
                        <td>
                            <a href="?action=view&id=<?= $membre['id_membre'] ?>" class="btn btn-info confirm">
                                <i class="bi bi-eyeglasses"></i>
                            </a>
                          
                            <a href="?action=delete&id=<?= $membre['id_membre'] ?>" class="btn btn-danger confirm">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>

                    </tr>


                <?php endwhile; ?>
            </tbody>
        </table>

    <?php else : ?>
        <div class="mt-4 alert alert-info">Il n'y a aucun membre</div>
    <?php endif; ?>
    <hr class="pt-4">
    

<?php
require_once('../includes/footer.php');
