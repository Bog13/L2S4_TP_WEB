<?php

include('bibli_24sur7.php');

$bd = bog_db_connect();

/**
 * @param $date string date du rendez vous
 * @param $hdebut string heure du debut du rendez vous
 * @param $hfin string heure de fin du rendez vous
 * @param $libelle string libelle du rendez vous
 * @return une chaine contenant un rendez vous au format jj mm aa - hhmm à hhmm - libelle 
 */
function bog_display_format_rdv($date, $hdebut, $hfin, $libelle)
{
    $hours = bog_heure_claire($hdebut)." à ".bog_heure_claire($hfin);
    
    if( $hdebut == $hfin && $hdebut == -1 )
        {
            $hours = 'journée entière';
        }
    
    return bog_date_claire($date).' - '.$hours.' - '.$libelle;
}

/**
 * Affiche les rendez vous de l'utilisateur $id
 * @param $id numero d'identification de l'utilisateur
 */
function bog_display_rdv($id)
{
    global $bd;
    $S = 'SELECT *
        FROM utilisateur, rendezvous
        WHERE rdvIDUtilisateur = utiID
        AND utiID = '.$id.' ORDER BY rdvDate ASC,rdvHeureDebut ASC';

    $R = mysqli_query($bd,$S) or fd_bd_erreur($bd, $S);

    echo '<h3>';
    echo 'UTILISATEUR '.$id.': '.bog_get_name($id);
    echo '</h3>';
    echo '<ul>';
    
    while( $T = mysqli_fetch_assoc($R) )
        {
            echo '<li>';
            echo bog_display_format_rdv($T['rdvDate'],$T['rdvHeureDebut'],$T['rdvHeureFin'],$T['rdvLibelle']);
            echo '</li>';
        }
    
    echo '</ul';

}


bog_display_rdv(2);
?>
    