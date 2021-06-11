<?php
// phpinfo();

require_once('../includes/init.php');
require_once('../includes/functions.php');

if (!isAdmin()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

// Suppression ($_GET)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    sql("DELETE FROM categorie WHERE id_categorie=:id", array(
        'id' => $_GET['id']
    ));
    set_flash('La catégorie a été supprimée', 'success');
    redirect($_SERVER['PHP_SELF']);
}


// Traitement des formulaires
if (!empty($_POST)) {

    // Formulaire d'ajout soumis
    if (isset($_POST['add'])) {

        if (!empty(trim($_POST['categorie']))) {
            sql("INSERT INTO categorie VALUES(NULL,:titre,:motscles)", array(
                'titre' => $_POST['categorie'],
                'motscles' => $_POST['motscles']

            ));
            set_flash('La catégorie ' . $_POST['categorie'] . ' et le(s) ou les mots clés ' . $_POST['motscles'] . ' ont été ajouté(s)', 'success');
            header('location:' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            set_flash('La catégorie ne doit pas être vide', 'danger');
        }
    }

    // Formulaire d'update soumis
    if (isset($_POST['update'])) {
        if (!empty(trim($_POST['categorie']))) {
            sql("UPDATE categorie SET nom=:nouveaunom WHERE id_categorie=:id_categorie", array(
                'nouveaunom' => $_POST['categorie'],
                'id_categorie' => $_POST['id_categorie']
            ));
            set_flash("La catégorie a été mise à jour", 'success');
            header('location:' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            set_flash('La catégorie ne doit pas être vide', 'danger');
        }
    }
}



$categories = sql("SELECT * FROM categorie ORDER BY id_categorie");


$title = 'Gestion des catégories';
require_once('../includes/header.php');
?>


<div class="row justify-content-center p-5">
    <div class="col">

        <h1>Catégories d'article</h1>
        <hr class="my-3">
        <form method="post" class="row">

    
        
            <div class="col-4">
           
                <input type="text" id="categorie" name="categorie" class="form-control" placeholder="catégorie à ajouter" aria-describedby="basic-addon1">
            </div>

            <div class="col-4">
                <input type="text" id="motscles" name="motscles" class="form-control" placeholder="Mots clés associés">
            </div>

            <div class="col-4">
                <button type="submit" name="add" class="btn btn-primary">Ajouter</button>
            </div>
        </form>



        <?php if ($categories->rowCount() > 0) : ?>
            <hr class="pt-4">
            <h2>Liste des catégories</h2>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">id catégorie</th>
                        <th scope="col">Titre de l'annonce</th>
                        <th scope="col">Mots clés</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while ($categorie = $categories->fetch()) : ?>


                        <tr>
                            <th scope="row"><?= $categorie['id_categorie'] ?></th>
                            <td><?= $categorie['titre'] ?></td>
                            <td><?= $categorie['motscles'] ?></td>
                            <td>
                                <a href="?action=view&id=<?= $categorie['id_categorie'] ?>" class="btn btn-info confirm">
                                    <i class="bi bi-eyeglasses"></i>
                                </a>
                                <button type="submit" name="update" class="btn btn-primary">
                                    <i class="bi bi-pen"></i>
                                </button>
                                <a href="?action=delete&id=<?= $categorie['id_categorie'] ?>" class="btn btn-danger confirm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>


                    <?php endwhile; ?>
                </tbody>
            </table>

        <?php else : ?>
            <div class="mt-4 alert alert-info">Il n'y a pas encore de catégorie</div>
        <?php endif; ?>

    </div>
</div>

<?php
require_once('../includes/footer.php');
