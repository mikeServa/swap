<?php
    if (empty($_POST['pseudo'])) {
       $errors++;
       set_flash('Veuillez indiquer votre pseudo','danger');
    }elseif (trim(iconv_strlen($_POST['pseudo'] )) > 19) {
        $errors++;
        set_flash( "Votre pseudo ne doit pas dépasser 19 caractères!", "danger");
    }