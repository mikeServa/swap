<?php

// Fonction pour les requetes SQL

function sql(string $requete, array $params = array()): PDOStatement
{

    global $pdo;
    $statement = $pdo->prepare($requete);

    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
        }
    }
    $statement->execute();

    return $statement;
}

// Fonctions utilisateur
function isConnected()
{
    return isset($_SESSION['user']); // indicateur d'une connexion réussie
}

function isAdmin()
{
    return (isConnected() && $_SESSION['user']['statut'] == 1);
}

function isRedacteur()
{
    return (isConnected() && $_SESSION['user']['statut'] == 2);
}


function getUserByLogin(string $pseudo)
{

    $requete = sql("SELECT * FROM membre WHERE pseudo=:pseudo", array(
        'pseudo' => $pseudo
    ));
    if ($requete->rowCount() > 0) {
        return $requete->fetch();
    } else {
        return false;
    }
}



// Redirection

if (!function_exists('redirect')) {
    function redirect($page)
    {
        header('location: ' . $page);
        exit();
    }
}

//Fonction pour la saisie du prix 
//Gestion des virgules et des points
function getfloat($str) {
    if(strstr($str, ",")) {
      $str = str_replace(".", "", $str); // replace dots (thousand seps) with blancs
      $str = str_replace(",", ".", $str); // replace ',' with '.'
    }
   
    if(preg_match("#([0-9\.]+)#", $str, $match)) { // search for number that may contain '.'
      return floatval($match[0]);
    } else {
      return floatval($str); // take some last chances with floatval
    }
  }
  
 
  ?>
