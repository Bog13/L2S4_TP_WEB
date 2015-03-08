<?php

include('liste_users_01.php');

function bog_display_all_usr($bd)
{
    $S = 'SELECT utiID FROM utilisateur';
    $R = mysqli_query($bd, $S) or erreur_bd($bd, $S);

    
    while( $T = mysqli_fetch_assoc( $R ) )
        {
            bog_display_usr($bd, $T['utiID']);
        }

    
}

bog_display_all_usr($bd);


?>