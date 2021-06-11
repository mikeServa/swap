<?php include_once('../includes/init.php') ?>
<?php require_once('../includes/functions.php') ?>
<?php require_once('../includes/flash.php') ?>

<?php

// indiqué le chemin de votre fichier JSON, il peut s'agir d'une URL







//var_dump($categories);

$categories = sql("SELECT * FROM categorie")->fetchall();



// insertion en bdd


if ($_POST) {
    //Au moins une photo doit être postée


    $errors = 0;
    
    if (!empty($_FILES['photos1']['name']) ) {

        $ext_autorisees = array('image/jpeg', 'image/png', 'image/gif');
        

        // in_array verifie la présence d'un élément dans le tableau
        if (!in_array($_FILES['photos1']['type'], $ext_autorisees)) {
            $errors++;
            //redirect(URL.'frontOffice/annonces.php');
            set_flash('Seules les images JPEG, PNG et GIF sont autorisées', 'danger');
        } else {

            // copie physique du fichier
            $i = 1;
            $nom_fichier = [];
            while ($i <= 5) {

                array_push($nom_fichier, $_SESSION['user']['id_membre'].$_FILES['photos' . $i]['name']/*  . $i . '.' . pathinfo($_FILES['photos' . $i]['name'] */);
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
            // var_dump($id_photo);

            //traitement du titre
            if (isset($_POST['titre'])) {
                if (iconv_strlen($_POST['titre'] < 3) && iconv_strlen($_POST['titre']) >= 19) {
                    $errors++;
                     redirect(URL.'frontOffice/annonces.php');
                    set_flash('Votre titre doit comporter entre 3 et 19 caractères', 'info');
                    //traitement des descriptions // seule la description courte est obligatoire
                }
            }
            else {
                $errors++;
                set_flash('Merci de compléter votre titre','warning');
            }
            //traitement des descriptions, seules la courte est obligatoire
       /*      if (!empty($_POST['description_courte']) && trim(iconv_strlen($_POST['description_courte']) > 15)) {

                if (trim(iconv_strlen($_POST['description_longue'])) > 250 && trim(iconv_strlen($_POST['description_courte'])) > 250) {
                    $errors++;
                    //redirect(URL.'frontOffice/annonces.php');
                    set_flash('Votre description ne doit pas dépasser 250 caractères', 'info');
                }
            }  */
            
            //traitement du prix (variable numerique obligatoirement)
            if (!trim(is_numeric($_POST['prix']))) {
                $errors++;
                redirect(URL.'frontOffice/annonces.php');
                set_flash('Le prix saisi n\'est pas valide', 'warning');
            }
            if (empty($_POST['categorie'])) {
                $errors++;
                 redirect(URL.'frontOffice/annonces.php');
                set_flash('Merci de choisir une catégorie', 'danger');
            }

            if ($errors == 0) {
                set_flash("L'annonce $_POST[titre] a bien été déposée", 'success');
                //redirect(URL);


                sql("INSERT INTO annonce 
           VALUES (NULL, :titre, :descsription_courte,:description_longue, :prix, :photo, :pays, :ville, :adresse, :cp, :membre_id, :photo_id, :categorie_id, NOW())", array(

                    'titre' => $_POST['titre'],
                    'descsription_courte' => $_POST['description_courte'],
                    'description_longue' => $_POST['description_longue'],
                    'prix' => $_POST['prix'],
                    'photo' => $_FILES['photos1']['name'],
                    'pays' => 'France',
                    'ville' => $_POST['ville'],
                    'adresse' => $_POST['adresse'],
                    'cp' => $_POST['code_postal'],
                    'membre_id' => $_SESSION['user']['id_membre'],
                    'photo_id' => $id_photo,
                    'categorie_id' => $_POST['categorie'],


                ));
            }else {
                set_flash('Veuillea compléter tous les champs obligatoires', 'warning');
            }
        }
    } else {
        
        set_flash('Vous devez au minimum ajouter une photo au bon format', 'warning');
        redirect(URL.'frontOffice/annonces.php');
    }
}

//Bonus quand j'aurais le temps

//define('URL','https://api-adresse.data.gouv.fr/search/?q=77100&type=municipality');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$reponse = curl_exec($ch);
$datas = json_decode($reponse, JSON_PRETTY_PRINT);

echo "<pre>";
print_r($datas);
echo "</pre>"; ?>

<!-- bonus -->
<?php $title = "Annonces";
include_once('../includes/header.php') ;var_dump($_FILES); var_dump($_POST);
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
                    <input type="text" class="form-control form-control-lg" name="titre" placeholder="<?= $_POST['titre'] ?? 'Votre titre' ?>" aria-label="Recipient's username" aria-describedby="basic-addon2">
                </div>

                <div class=" ">
                    <label for="">Déscription courte</label>
                    <div class="form-floating w-75 mb-3">

                        <textarea class="form-control" name="description_courte" id="floatingTextarea" cols="20"><?= $_POST['description_courte'] ?? '' ?></textarea>
                    </div>

                </div>


                <div class=" ">
                    <label for="">Déscription longue</label>
                    <div class="form-floating w-75 mb-3">

                        <textarea class="form-control" name="description_longue" id="floatingTextarea" cols="20"><?= $_POST['description_longue'] ?? '' ?></textarea>
                    </div>

                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon3">€</span>
                    <input type="text" class="form-control form-control-lg" name="prix" placeholder="<?= $_POST['prix'] ?? 'Prix figurant dans l\'annonce ' ?>" aria-label="Prix figurant dans l\'annonce " aria-describedby="basic-addon3">
                </div>
                <div class=" ">

                    <label for="" class=""></label>
                    <select class="f</div>orm-select form-select-md mb-3  " name="categorie" aria-label=".form-select-lg example">
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
                        <label class="btn btn-default btn-file heading d-flex " >
                            <i class="bi bi-camera-fill fs-1  mt-3"  id="photos<?=$i?>" ></i> <input name="photos<?=$i?>" id="input<?=$i?>" type="file" style="display: none;" >
                            <img id="preview<?=$i?>" src="../images/admin/success.png" style="width: 80px; display:none;" alt=" ">
                        </label>
                        
                    <?php $i++;
                    endwhile ?>





                </div>

                <!-- formulaire adresse postale avec API -->
                <div class="input-group mb-3 ">
                    <span class="input-group-text position-absolute" id="basic-addon2">Code Postal</span>
                    <input type="text" class="form-control form-control-lg" name="code_postal" id="code_postal" placeholder="<?= $_POST['code_postal'] ?? 'Votre Code postal' ?>" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <label style="display: none;" class="bg-danger position-relative " id="erreur_code_postal"></label>
                </div>

                <div class="mb-3">

                    <select class="form-select " aria-label="Default select example" name="ville" id="ville">

                        <option selected disabled class=""><?='Selectionner votre ville, après avoir saisi votre code postal'?></option>


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