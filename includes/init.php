<?php

// Fuseau horaire
date_default_timezone_set('Europe/Paris');
// Définir la langue locale
setlocale(LC_ALL, 'fr_FR.utf8','fra.utf8');


// Nom et ouverture de session
session_name('SWAP'); // defaut : PHPSESSID
session_start();

// Connexion BDD
$pdo = new PDO(
     'mysql:host=localhost;charset=utf8;dbname=swap',
    'root',
    '', 
  /*   'mysql:host=cl1-sql11;charset=utf8;dbname=pso63331',
    'pso63331',
    'dRQl6SqtGu3L', */
    array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // fetch assoc par défaut
    )
);

// Inclusion des fonctions du site
require_once('functions.php');

// Constantes du site
define('URL','/swap/');
define('INDEX',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
define('LOGO_IMG',URL.'images/admin/logo-appareil.png' );

//titre du site / On laisse la possibilité à l'admin de le changer en toute autonomie
$recup_infos = sql("SELECT * FROM siteinfo");
if( $recup_infos->rowCount() > 0){

    while($siteinfo = $recup_infos->fetch()){
        switch($siteinfo['nom']){
            case 'title': define('SITETITLE',$siteinfo['valeur']); break;
           
        }
    }
}

//select categorie
$categories = sql("SELECT * FROM categorie")->fetchall();

//select membres
$membres = sql("SELECT `id_membre`,`id_membre`, `pseudo`,`nom`,`prenom`,`email`,`telephone`,`civilite`,`statut`,`date_enregistrement` FROM `membre` ORDER BY id_membre");

//selection des annonces
 $annonces = sql("SELECT * FROM annonce  ORDER BY date_enregistrement");