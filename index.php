<?php
require_once('includes/init.php');

require_once('includes/functions.php');
include_once('includes/flash.php');
?>
<?php
$annonces = sql("SELECT `annonce`.*, `membre`.`pseudo`
FROM `membre`
    LEFT JOIN `annonce` ON `annonce`.`membre_id` = `membre`.`id_membre`");
$annonce_fetch = $annonces->fetchAll();

$req =sql("SELECT id_annonce FROM annonce");



?>




<?php $title = 'Accueil';
require_once('includes/header.php');
?>
<?php


?>
<select class="form-select w-25 mb-5  m-auto" aria-label="Default select example">
    <option selected>Trier par prix</option>
</select>


<div class="container-fluid row  ">
    <form class="col-4 me-2">


        <label for="" class=""></label>
        <select class="form-select form-select-md mb-5  " name="categorie" aria-label=".form-select-lg example">
            <option disabled selected>Catégorie de l'annonce</option>
            <?php foreach ($categories as $key => $categorie) : ?>

                <option value="<?= $key ?>"><?= $categorie['titre'] ?></option>

            <?php endforeach ?>
        </select>


        <!-- formulaire adresse postale avec API => region -->
        <div class="input-group mb-3 ">
            <span class="input-group-text position-absolute" id="basic-addon2">Code Postal</span>
            <input type="text" class="form-control form-control-lg" name="code_postal" id="code_postal" placeholder="<?= $_POST['code_postal'] ?? 'Votre Code postal' ?>" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <label style="display: none;" class="bg-danger position-relative " id="erreur_code_postal"></label>
        </div>

        <div class="mb-3">

            <select class="form-select " aria-label="Default select example" name="region" id="region">

                <option selected disabled class=""><?= 'Votre région' ?></option>


            </select>


        </div>

        <select class="form-select w-50 mb-5" aria-label="Default select example">
            <option disabled selected>Membres</option>
            <?php foreach ($membres_fetch as $key => $membre_fetch) : ?>

                <option value="<?= $key ?>"><?= $membre_fetch['pseudo'] ?></option>

            <?php endforeach ?>
        </select>
        <label for="customRange1" class="form-label">Prix</label>
        <input type="range" class="form-range" id="customRange1">
    </form>




    <div class="  row col-8 ">


        <!-- Affichage en fonction de la catégorie -->
        <?php //$i = 0;
        //while ($i < $annonces->rowCount() - 1) : 


        ?>

        <table class="table table-striped">
            <thead>

            </thead>
            <tbody>

                <?php $i = 0;
                while ($i < $req->rowCount()) : ?>
                    <tr>
                        <th scope="row"><img class="w-100" src="images/site/<?= $annonce_fetch[$i]['photo'] ?>" alt="">
                            <div><?= $annonce_fetch[$i]['pseudo'] ?> - <?= '<i class="bi bi-star-fill">' ?></i></div>
                        </th>
                        <td>
                            <h3><?= $annonce_fetch[$i]['titre'] ?></h3>
                            <div><?=substr($annonce_fetch[$i]['description_longue'], 0,300)  ?></div>

                        </td>
                        <td class="mt-auto" ><?= $annonce_fetch[$i]['prix'] ?>€</td>

                    </tr>
                <?php $i++; endwhile ?>


            </tbody>
        </table>

        <?php //$i++; endwhile 
        ?>


        </thead>
        <tbody>

    </div>

</div>





<?php

require_once('includes/footer.php');
