<?php
// phpinfo();
require_once('includes/init.php');
$title = 'Incription';
require_once('includes/functions.php');
include_once('includes/flash.php');

// Si je suis connecté et que je tente de rentrer l'url de la page d'inscription, je suis redirigé vers ma page profil
if(isConnected()){
    // avant la fonction header, aucun echo, aucune balise html
   redirect(URL.'profile.php');
}


// Traitement du formulaire
if(!empty($_POST)){ // Formulaire soumis

   
    $errors = 0;

    if(empty($_POST['pseudo'])){
        $errors++;
        
        set_flash('Merci de choisir un pseudo','warning');
   
      
        
    }elseif (iconv_strlen($_POST['pseudo']) > 19 ) {
        $errors++;
    set_flash(' Votre pseudo ne doit pas dépasser 19 caractères!','danger');
    }
   else{
        $membre = getUserByLogin($_POST['pseudo']);
        if( $membre ){
            $errors++;
           set_flash(' Ce pseudo n\'est pas disponible','info');
            
        }
    } 

    if(empty($_POST['mdp'])){
        $errors++;
        

  set_flash('Merci de saisir un mot de passe','warning');

    }
    else{
        $pattern = '#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[\S]{8,20}$#';
        if( !preg_match($pattern,$_POST['mdp'])){
            $errors++;
            

    set_flash('  Le mot de passe doit être composé de 8 à 20 caractères comprenant au moins une minuscule, une majuscule et un chiffre', 'danger');
        }
    }

    if(empty($_POST['confirmation'])){
        $errors++;
    

        set_flash(' Merci de confirmer votre mot de passe','warning');

    }
    else{
        if( !empty($_POST['mdp']) && ($_POST['confirmation'] !== $_POST['mdp'])){
            $errors++;
     set_flash('La confirmation ne concorde pas avec le mot de passe','danger');
        }
    }

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
    if(empty($_POST['telephone'])){
        $errors++;
        
        set_flash('Merci d\'indiquer votre numéro de téléphone','warning');
   
      
        
    }elseif (is_numeric($_POST['telephone']) && trim(iconv_strlen($_POST['telephone'] )) < 10 ) {
        $errors++;
    set_flash(' Votre numéro doit être composé de 10 chiffres','danger');
    }


    // A ce stade si errors vaut toujours 0, c'est que c'est ok
    if($errors == 0){
        sql("INSERT INTO membre VALUES (NULL,:pseudo,:mdp, NULL, NULL, :telephone,:email, NULL, 0, NOW())",array(
            'pseudo' => $_POST['pseudo'],
            'mdp' => password_hash($_POST['mdp'],PASSWORD_DEFAULT),
            'email' => $_POST['email'],
            'telephone' => $_POST['telephone']
        ));
        
        
            
set_flash('Inscription réussie');


     redirect(URL.'connexion.php');
    }

}


require_once('includes/header.php');

$title = 'Inscription';





?>

<div class="row justify-content-center">

    <div class="col-md-8 col-xl-4 border border-dark p-5 rounded mt-5">
        <h1 class="text-center">Inscription <i class="bi bi-ui-checks-grid"></i></h1>
        <hr class="mb-3">
        <form method="post">

            <div class="mb-3">
                <label for="pseudo" class="form-label">Votre pseudo <i class="bi bi-file-earmark-person-fill"></i></label>
                
                <input type="text" id="pseudo" name="pseudo" class="form-control" value="<?php echo $_POST['pseudo'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Courriel <i class="bi bi-envelope-fill"></i></label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $_POST['email'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone <i class="bi bi-telephone-fill"></i></label>
                <input type="telephone" id="telephone" name="telephone" class="form-control" value="<?php echo $_POST['telephone'] ?? '' ?>">
            </div>
            
            <div class="mb-3">
                <label for="mdp" class="form-label">Votre Mot de passe <i class="bi bi-file-earmark-lock-fill"></i></label>
                <input type="password" id="mdp" name="mdp" class="form-control">
            </div>
            <div class="mb-3">
                <label for="confirmation" class="form-label">Confirmation du mot de passe <i class="bi bi-check-all"></i></label>
                <input type="password" id="confirmation" name="confirmation" class="form-control">
            </div>
            <div class="mb-3 text-end">
                <button type="submit" class="btn btn-primary">S'incrire</button>
            </div>

          
        </form>
    </div>
</div>
<div class="row">
    <div class="col text-center mt-2">
        <p>Déjà inscrit ? Vous pouvez vous connecter en <a href="<?php echo URL ?>connexion.php">cliquant ici</a></p>
      
    </div>
</div>


<?php
 
require_once('includes/footer.php');