<?php
if(empty($_POST['email'])){
        $errors++;
        

set_flash('Merci de saisir votre adresse mail','warning');
    }
    else{
        if( !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
            $errors++;
            
   set_flash('Adresse mail invalide','danger');
        }
    }