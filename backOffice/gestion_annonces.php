<?php
// phpinfo();

require_once('../includes/init.php');
require_once('../includes/functions.php');

if (!isAdmin()) {

    redirect(URL . 'connexion.php');
}
?>





<?php $title = 'Gestion des annonces';
require_once('../includes/header.php');
?>
<?php  ?>

<div class="container-fluid">


    <?php if ($annonces->rowCount() > 0) : ?>

    

        <h2>Liste des annonces</h2>


        <table class="table table-striped table-hover border table-bordered ">
            <thead>
                <tr>
                
                    <?php $i = 0; foreach ($annonces->fetch() as $key => $value) :?>
                    <th scope="col"><?=$key ?></th>
                    <?php ; endforeach ?>
                    
                </tr>
            </thead>
            <tbody>

               

                
            

<?php $annonces = sql("SELECT * FROM annonce  ORDER BY date_enregistrement"); ?>
<?php $annonce = $annonces->fetchAll() ?>
<?php $i = 0; while($i < $annonces->rowCount()) :?>
   

<tr>
<th scope="row"><?= $annonce[$i]['id_annonce'] ?></th>
<td><?= $annonce[$i]['titre'] ?></td>
<td><?= $annonce[$i]['description_courte'] ?></td>
<td><?= substr($annonce[$i]['description_longue'],0, 30) ?></td>
<td><?= $annonce[$i]['prix'] ?></td>
<td><img style="width:80px;" src="../images/site/<?=$annonce[$i]['photo']?>" ></td>
<td><?= $annonce[$i]['pays'] ?></td>
<td><?= $annonce[$i]['ville'] ?></td>
<td><?= $annonce[$i]['adresse'] ?></td>
<td><?= $annonce[$i]['cp'] ?></td>
<td><?= $annonce[$i]['membre_id'] ?></td>
<td><?= $annonce[$i]['photo_id'] ?></td>
<td><?= $annonce[$i]['categorie_id'] ?></td>
<td><?= $annonce[$i]['date_enregistrement'] ?></td>

 <td>
    <a href="?action=view&id=<?= $annonce[$i]['id_annonce']?>" class="btn btn-info confirm">
        <i class="bi bi-eyeglasses"></i>
    </a>
  
    <a href="?action=delete&id=<?= $annonce[$i]['id_annonce']?>" class="btn btn-danger confirm">
        <i class="bi bi-trash"></i>
    </a>
</td> 

</tr>

<?php $i++; endwhile ?>
<?php endif ?>







