<?php 
if(empty($_POST['telephone'])){
        $errors++;
        
        set_flash('Merci d\'indiquer votre numéro de téléphone','warning');
   
      
        
    }elseif (is_numeric($_POST['telephone']) && trim(iconv_strlen($_POST['telephone'] )) < 10 ) {
        $errors++;
    set_flash(' Votre numéro doit être composé de 10 chiffres','danger');
    }