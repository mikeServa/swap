<?php include_once('../includes/init.php') ?>
<?php require_once('../includes/functions.php') ?>
<?php require_once('../includes/flash.php') ?>


<?php if ($_POST) {
    $errors = 0;

    /*    if (empty($_POST['titre']) || iconv_strlen(trim(($_POST['titre']))) <= 3) {
        $errors++;
        set_flash('Votre titre doit comporter un minimum de 3 caractères', 'warning');
        redirect(URL . 'frontOffice/annonces.php');
    } */

    /*    if (empty($_POST['description_courte']) || iconv_strlen(trim(($_POST['description_courte']))) <= 5) {
        $errors++;
        set_flash('Votre Description doit comporter un minimum de 5 caractères', 'warning');
        redirect(URL . 'frontOffice/annonces.php');
    } */

    /*   if (empty($_POST['description_longue']) || iconv_strlen(trim(($_POST['description_longue']))) <= 5) {
        $errors++;
        set_flash('Votre Description doit comporter un minimum de 30 caractères', 'warning');
        redirect(URL . 'frontOffice/annonces.php');
    } */

    /* if (!is_numeric (getfloat ($_POST['prix']))) {
        $$errors++;
        set_flash('Votre prix doit avoir une valeur numérique', 'warning');
        redirect(URL . 'frontOffice/annonces.php');

    } */
    /*  if (empty($_POST['categorie'])) {
        $errors++;
        set_flash('Veuillez choisir une catégorie', 'warning');
        redirect(URL . 'frontOffice/annonces.php');

    } */


   /*  if (empty($_POST['code_postal']) || iconv_strlen(trim(($_POST['code_postal']))) != 5 ) {
        $errors++;
        set_flash('Votre code postal doit comporter un minimum de 5 caractères et doit être numérique', 'warning');
        redirect(URL . 'frontOffice/annonces.php');
    } */

 /*    if (empty($_POST['ville'])) {
        $errors++;
        set_flash('Veuillez selectionner votre ville', 'warning');
        redirect(URL . 'frontOffice/annonces.php');
    } */

    //On vérifie la présence d'au moins une photo

    if (!empty($_FILES['photos1']['name'])) {

        $ext_autorisees = array('image/jpeg', 'image/png', 'image/gif');


        // in_array verifie la présence d'un élément dans le tableau
        if (!in_array($_FILES['photos1']['type'], $ext_autorisees)) {
            $errors++;
            set_flash('Seules les images JPEG, PNG et GIF sont autorisées', 'danger');
            redirect(URL.'frontOffice/annonces.php');
        } else {

            // copie physique du fichier
            $i = 1;
            $nom_fichier = [];
            while ($i <= 5) {

                array_push($nom_fichier, uniqid() . $_FILES['photos' . $i]['name']/*  . $i . '.' . pathinfo($_FILES['photos' . $i]['name'] */);
                $i++;
            }


            // Chemin réel du fichier ( ex: c:/wamp64/www + /swag/ + images/site/)
            $chemin = $_SERVER['DOCUMENT_ROOT'] . URL . 'images/site/';
            $i = 0;
            $j = 1;
            while ($i < 5) {


                move_uploaded_file($_FILES['photos' . $j]['tmp_name'], $chemin . $nom_fichier[$i]);
                // copy();
                $i++;
                $j++;
            }

            //insertion en BDD

            sql(
                "INSERT INTO photo VALUES (NULL, :photo1, :photo2, :photo3, :photo4, :photo5)",
                array(
                    'photo1' => $_FILES['photos1']['name'],
                    'photo2' => $_FILES['photos2']['name'],
                    'photo3' => $_FILES['photos3']['name'],
                    'photo4' => $_FILES['photos4']['name'],
                    'photo5' => $_FILES['photos5']['name']

                )

            );

            $id_photo =  $pdo->lastInsertId();
            
        }



    }else {
        set_flash('Veuillez ajouter une photo', 'warning');
        redirect(URL.'frontOffice/annonces.php');


    }



    //fin du post
} ?>









<?php var_dump($_POST);
$title = 'Annonces';
include_once('../includes/header.php');
?>
<a href="<?= URL . 'frontOffice/profil.php' ?>"><i class="bi bi-arrow-return-left container ms-5 ">Retour au profil</i></a>

<div class="container-fluid bg-light m-3">
    <form action="" method="post" name="annonces" class=" m-5" class="border  " enctype="multipart/form-data">
        <h2 class="text-center p-3">Déposer une annonce <i class="bi bi-layout-text-window-reverse"></i></h2>
        <div class="d-flex ">
            <!-- premiere colonne -->
            <div class="border flex-fill me-5">

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon2">Titre</span>
                    <input type="text" class="form-control form-control-lg" name="titre" id="titre" value="<?= $_POST['titre'] ?? '' ?>" aria-label="Recipient's username" aria-describedby="basic-addon2">
                </div>

                <div class=" ">
                    <label for="">Déscription courte</label>
                    <div class="form-floating w-75 mb-3">

                        <textarea class="form-control" name="description_courte" id="description_courte" cols="20"><?= $_POST['description_courte'] ?? '' ?></textarea>
                    </div>

                </div>


                <div class=" ">
                    <label for="">Déscription longue</label>
                    <div class="form-floating w-75 mb-3">

                        <textarea class="form-control" name="description_longue" id="description_longue" cols="20"><?= $_POST['description_longue'] ?? '' ?></textarea>
                    </div>

                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon3"><i class="bi bi-currency-euro"></i></span>
                    <input type="text" class="form-control form-control-lg" name="prix" placeholder="<?= $_POST['prix'] ?? 'Prix figurant dans l\'annonce ' ?>" aria-label="Prix figurant dans l\'annonce " aria-describedby="basic-addon3">
                </div>
                <div class=" ">

                    <label for="" class=""></label>
                    <select class="f</div>orm-select form-select-md mb-3 " id="categorie" name="categorie" aria-label=".form-select-lg example">
                        <option disabled selected>Catégorie de l'annonce</option>
                        <?php foreach ($categories as $key => $categorie) : ?>

                            <option value="<?= $key ?>"><?= $categorie['titre'] ?></option>

                        <?php endforeach ?>
                    </select>

                </div>

            </div>
            <!-- Seconde colonne -->
            <!-- traitement du depot d'image -->
            <div class="border flex-fill">
                <div class="d-flex mb-3 ms-5">

                    <?php $i = 1;
                    while ($i <= 5) : ?>
                        <label class="btn btn-default btn-file heading d-flex ">
                            <i class="bi bi-camera-fill fs-1  mt-3" id="photos<?= $i ?>"></i> <input name="photos<?= $i ?>" id="input<?= $i ?>" type="file" style="display: none;">
                            <img id="preview<?= $i ?>" src="../images/admin/success.png" style="width: 80px; display:none;" alt=" ">
                        </label>

                    <?php $i++;
                    endwhile ?>





                </div>

                <!-- formulaire adresse postale avec API -->
                <div class="input-group mb-3 ">
                    <span class="input-group-text " id="basic-addon">Code Postal</span>
                    <input type="text" class="form-control form-control-lg" name="code_postal" id="code_postal" placeholder="<?= $_POST['code_postal'] ?? 'Votre Code postal' ?>" aria-label="Recipient's username" aria-describedby="basic-addon">
                    <label style="display: none;" class="bg-danger position-relative " id="erreur_code_postal"></label>
                </div>


                <div class="mb-3">

                    <select class="form-select " aria-label="Default select example" name="ville" id="ville">

                        <option selected disabled class=""><?= 'Veuillez Selectionner votre ville, après avoir saisi votre code postal' ?></option>


                    </select>


                </div>



                <div class="mb-3 ">
                    <label for="">Adresse</label>
                    <div class="form-floating w-75 mb-3">

                        <textarea class="form-control" name="adresse" id="floatingTextarea" cols="20"><?= $_POST['adresse'] ?? '' ?></textarea>
                    </div>

                </div>

            </div>
        </div>
</div>

<button type="submit" class=" mt-3">Deposer une annonce</button>

</form>


<?php include_once('../includes/footer.php') ?>