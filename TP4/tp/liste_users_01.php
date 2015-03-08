<?php

include('bibli_24sur7_06.php');
include('bibli_24sur7.php');

$bd = bog_db_connect();

/**
 * Affiche le nom, le mail, la date d'inscription, le jour, l'heure min et max de l'utilisateur d'ID $id dans la bdd $bd
 * @param $bd base de donnée 
 * @param $id string identifiant de l'utilisateur
 */
function bog_display_usr($bd,$id)
{
    
    $S = '
SELECT utiNom, utiMail, utiDateInscription, utiJours, utiHeureMin, utiHeureMax
FROM utilisateur
WHERE utiID='.$id.'
';
    
    $R = mysqli_query($bd, $S) or erreur_bd($bd,$S);
    $T = mysqli_fetch_row($R);


    $nom =  mysqli_real_escape_string($bd,$T[0]);
    $mail =  mysqli_real_escape_string($bd,$T[1]);
    $inscription = bog_date_claire( mysqli_real_escape_string($bd,$T[2]));
    $jour =  mysqli_real_escape_string($bd,$T[3]);
    $debut =  mysqli_real_escape_string($bd,$T[4]);
    $fin =  mysqli_real_escape_string($bd,$T[5]);

    //Sécurisation données
   //$nom =$nom);
   //$mail = mysqli_real_escape_string($bd,$mail);
   //$inscription = mysqli_real_escape_string($bd,$inscription);
   //$jour = mysqli_real_escape_string($bd,$jour);
   //$debut = mysqli_real_escape_string($bd,$debut);
   //$fin = mysqli_real_escape_string($bd,$fin);
    
    //

    
    echo '<h1> Utilisateur '.$id.'</h1>';

    echo
        '<ul>',
        '<li>Nom: '.$nom.'</li>',
        '<li>Mail: '.$mail.'</li>',
        '<li>Inscription: '.$inscription.'</li>',
        '<li>Jour à afficher: '.$jour.'</li>',
        '<li>Heure début: '.$debut.'</li>',
        '<li>Heure fin: '.$fin.'</li>',

        '</ul>';

}





?>