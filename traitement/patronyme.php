<?php
    if (empty($_POST['prenom']) || empty($_POST['nom'])) {
       $errors++;
       set_flash('Veuillez indiquer votre nom et votre prénom','danger');
    }elseif (trim(iconv_strlen($_POST['prenom'] )) > 19 || trim(iconv_strlen($_POST['nom'] )) > 19 ) {
        $errors++;
        set_flash( "Votre prénom et votre nom ne doivent pas dépasser 19 caractères!", "danger");
    }else {
        set_flash('Prenom ok');
    }