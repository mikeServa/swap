<?php require_once('../includes/init.php') ?>
<?php require_once('../includes/functions.php') ?>
<?php require_once('../includes/flash.php') ?>

<?php //$annonces = sql("SELECT * FROM annonce WHERE id_annonce=:id_annonce",array(

//)) 
var_dump($_POST);
var_dump($_GET);
var_dump($_SESSION);




?>










<?php $title = 'Fiche annonce';
require_once('../includes/header.php') ?>

<div class="container-fluid row">
    <div class="col-12">Titre</div>
    <div class="col-6">photo</div>
    <div class="col-6">description</div>
    <div class="col-3">Date</div>
    <div class="col-3">note</div>
    <div class="col-3">prix</div>
    <div class="col-3">adresse</div>
    <div class="col-12">map</div>
    <div class="col-12">Autres annonces</div>
    <div class="col-3">annonce1</div>
    <div class="col-3">annonce2</div>
    <div class="col-3"></div>
    <div class="col-3"></div>
</div>






<?php require_once('../includes/footer.php') ?>