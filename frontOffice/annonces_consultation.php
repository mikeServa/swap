<?php
// phpinfo();

require_once('../includes/init.php');
require_once('../includes/functions.php');

if (!isConnected()) {

    redirect(URL . 'connexion.php');
}





?>

<?php $annonces = sql("SELECT * FROM annonce WHERE membre_id=:membre_id ORDER BY date_enregistrement", array(
    'membre_id' => $_SESSION['user']['id_membre']
));

?>
<?php if (isset($_GET['action']) && $_GET['action'] == 'view') : ?>

    <?php $annonce_description = sql("SELECT * FROM annonce WHERE id_annonce=:id_annonce", array(
        'id_annonce' => $_GET['id']
    ))->fetch();

    $req = sql("SELECT *   FROM annonce WHERE categorie_id=:categorie_id", array(
        'categorie_id' =>  $annonce_description['categorie_id']
    ));
    $annonces_similaires = $req->fetchAll()

    ?>

    <div class="container annonce border p-1">
        <div class="container-fluid row">
            <div class="col-12">
                <h2 class="text-center"><?= $annonce_description['titre'] ?></h2>
            </div>
            <div class="col-6"><img src="<?= '../images/site/' . $annonce_description['photo'] ?>" alt="" class="img-fluid w-75"></div>
            <div class="col-6"><?= $annonce_description['description_longue'] ?></div>
            <div class="col-3"><?= $annonce_description['date_enregistrement'] ?></div>
            <div class="col-3"><?= $annonce_description['note'] ??  'Soyez le premier à donner une note'  ?></div>
            <div class="col-3"><?= $annonce_description['prix'] ?>€</div>
            <div class="col-3"><?= $annonce_description['adresse'] ?></div>
            <div class="col-12">map</div>
            <div class="col-12">
                <h2 class="text-center">Autres annonces</h2>
            </div>
            <?php $i = 0;
            while ($i < $req->rowCount()) : ?>
                <div class="col-3"><img src="<?= ('../images/site/' . $annonces_similaires[$i]['photo']) ?? '../images/admin/logo-appareil.png' ?>" alt="" class="img-fluid w-75"></div>
            <?php $i++;
            endwhile ?>
            <a href="<?= URL . 'frontOffice/profil.php' ?>"><i class="bi bi-arrow-return-left container position-absolute end-0 mt-3 text-info">Retour à la liste des annonces</i></a>
        </div>

    </div>
<?php //var_dump($annonce_description);
endif ?>

<?php
$title = 'Gestion de mes annonces';
require_once('../includes/header.php'); ?>s

<div class="container-fluid">
    <a href="<?= URL . 'frontOffice/profil.php' ?>"><i class="bi bi-arrow-return-left container  ">Retour au profil</i></a>


    <?php if ($annonces->rowCount() > 0) : ?>



        <h2>Bonjour <?= $_SESSION['user']['civilite'] == 'm' ? 'Monsieur' : 'Madame'  ?> <?= $_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom'] ?> vous avez posté <?= $annonces->rowCount() ?><?= ($annonces->rowCount() > 1) ? ' annonces' : ' annonce' ?></h2>

        <div class="mt-5">
            <table class="table table-striped table-hover border table-bordered table-responsive ">
                <thead>
                    <tr>

                        <?php $i = 0;
                        foreach ($annonces->fetch() as $key => $value) : ?>
                            <?php if ($key != 'membre_id' && $key != 'id_annonce' && $key != 'photo_id' && $key != 'categorie_id') : ?>
                                <th scope="col"><?= $key ?></th>
                            <?php endif ?>
                        <?php endforeach ?>
        </div>

        </tr>
        </thead>
        <tbody>



            <?php $annonce = $annonces->fetchAll(); //var_dump($annonce) 
            ?>
            <?php $i = 0;

            while ($i < $annonces->rowCount() - 1) : ?>
                <?php  ?>


                <tr>
                    <th scope="row"><?= $annonce[$i]['titre'] ?></th>
                    <td><?= $annonce[$i]['description_courte'] ?></td>
                    <td><?= substr($annonce[$i]['description_longue'], 0, 200) ?></td>
                    <td><?= $annonce[$i]['prix'] ?> €</td>
                    <td><img style="width:80px;" src="../images/site/<?= $annonce[$i]['photo'] ?>"></td>
                    <td><?= $annonce[$i]['pays'] ?></td>
                    <td><?= $annonce[$i]['ville'] ?></td>
                    <td><?= $annonce[$i]['adresse'] ?></td>
                    <td><?= $annonce[$i]['cp'] ?></td>
                    <td><?= $annonce[$i]['date_enregistrement'] ?></td>

                    <td>



                        <a href="?action=view&id=<?= $annonce[$i]['id_annonce'] ?>" class="btn btn-info confirm">
                            <i class="bi bi-eyeglasses"></i>
                        </a>


                        <a href="?action=delete&id=<?= $annonce[$i]['id_annonce'] ?>" class="btn btn-danger confirm">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>

                </tr>

            <?php $i++;
            endwhile ?>

        <?php endif ?>