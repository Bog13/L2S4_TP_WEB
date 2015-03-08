<?php


//____________________________________________________________________________

define('APP_BD_URL','localhost');
define('APP_BD_NOM','24sur7');
define('APP_BD_USER','u_24sur7');
define('APP_BD_PASS','p_24sur7');

//____________________________________________________________________________
/**
 * Traitement erreur mysql, affichage et exit.
 *
 * @param string	$sql	Requête SQL ou message
 */
function fd_bd_erreur($sql) {
    $errNum = mysqli_errno($GLOBALS['bd']);
    $errTxt = mysqli_error($GLOBALS['bd']);
		
    // Collecte des informations facilitant le debugage
    $msg = '<h4>Erreur de requ&ecirc;te</h4>'
        ."<pre><b>Erreur mysql :</b> $errNum"
        ."<br> $errTxt"
	        ."<br><br><b>Requ&ecirc;te :</b><br> $sql"
        .'<br><br><b>Pile des appels de fonction</b>';

    // Récupération de la pile des appels de fonction
    $msg .= '<table border="1" cellspacing="0" cellpadding="2">'
                .'<tr><td>Fonction</td><td>Appel&eacute;e ligne</td>'
                .'<td>Fichier</td></tr>';
			
    // http://www.php.net/manual/fr/function.debug-backtrace.php
    $appels = debug_backtrace();
    for ($i = 0, $iMax = count($appels); $i < $iMax; $i++) {
        $msg .= '<tr align="center"><td>'
                    .$appels[$i]['function'].'</td><td>'
                    .$appels[$i]['line'].'</td><td>'
                    .$appels[$i]['file'].'</td></tr>';
    }
	
    $msg .= '</table></pre>';

    fd_bd_erreurExit($msg);
}
//___________________________________________________________________
/**
 * Arrêt du script si erreur base de données.
 * Affichage d'un message d'erreur si on est en phase de
 * développement, sinon stockage dans un fichier log.
 *
 * @param string	$msg	Message affiché ou stocké.
 */
function fd_bd_erreurExit($msg) {
    ob_end_clean();		// Supression de tout ce qui a pu être déja généré
	
    // Si on est en phase de développement, on affiche le message
    if (APP_TEST) {
        echo '<!DOCTYPE html><html><head><meta charset="ISO-8859-1"><title>',
                'Erreur base de données</title></head><body>',
                $msg,
                '</body></html>';
        exit();
    }
		
    // Si on est en phase de production on stocke les
    // informations de débuggage dans un fichier d'erreurs
    // et on affiche un message sibyllin.
    $buffer = date('d/m/Y H:i:s')."\n$msg\n";
    error_log($buffer, 3, 'erreurs_bd.txt');
	
    // Génération d'une page spéciale erreur
    fd_html_head('24sur7');
		
    echo '<h1>24sur7 est overbook&eacute;</h1>',
        '<div id="bcDescription">',
            '<h3 class="gauche">Merci de r&eacute;essayez dans un moment</h3>',
        '</div>';
	
    fd_html_pied();
	
    exit();
}

/**
 * Se connecte à la base de donnée
 *
 */
function bog_db_connect()
{
    $bd = mysqli_connect(APP_BD_URL,APP_BD_USER,APP_BD_PASS,APP_BD_NOM);

    if( $bd !== FALSE )
        {
            return $bd;
        }

    echo "E: Can't connect to the database</br>";
    exit();
}

/**
 * Convertie une date du format aaaammjj au format jj mm aa
 * @param $amj string date au format aaaammjj
 * @return une date au format jj mm aa
 */
function bog_date_claire($amj)
{
    if( gettype('amj') != 'string' )
        {
            return 'E: bad type !';
        }

    $j = substr($amj,6,7);
    $m = substr($amj,4,2);
    $a = substr($amj,0,4);


    $mois = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];

    if($m-1 < 0 or $m-1 > 11)
        {
            return 'E: bad date: '.$amj.' not in the format AAAAMMJJ';
        }
    
    return $j.' '.$mois[$m-1].' '.$a;
    
}

/**
 * Convertie une heure du format HHMM au format HH h MM
 * @param $h    string    une heure au format HHMM
 * @return une heure au format HH h MM
 */
function bog_heure_claire($h)
{

    $heure = substr($h,0,strlen($h)/2);
    $minute = substr($h,strlen($h)/2,strlen($h));
    
    if( (int)($minute) === 0 )
        {
            $minute = '';
        }
    
    return $heure.'h'.$minute;
}

/**
 * Permet d'obtenir le nom d'un utilisateur
 *
 * @param $id string numero d'identification de l'utilisateur
 * @return une chaine contenant le nom de l'utilisateur numero $id
 */
function bog_get_name($id)
{
    global $bd;
    
    $S = 'SELECT utiNom
        FROM utilisateur
        WHERE utiID ='.$id;

    $R = mysqli_query($bd,$S) or db_error($bd,$S);
    $T = mysqli_fetch_assoc($R);
    
    return $T['utiNom'];
}
?>