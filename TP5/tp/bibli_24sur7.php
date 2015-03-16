<?php
/** @file
 * Bibliothèque générale de fonctions
 *
 * @author : Frederic Dadeau - frederic.dadeau@univ-fcomte.fr
 * @author : Bérenger OSSETE GOMBE - berenger.ossete_gombe@edu.univ-fcomte.fr
 */

//____________________________________________________________________________
//
// Défintion des constantes de l'application
//____________________________________________________________________________

define('APP_TEST', TRUE);

// Gestion des infos base de données
define('APP_BD_URL', 'localhost');
define('APP_BD_USER', 'u_24sur7');
define('APP_BD_PASS', 'p_24sur7');
define('APP_BD_NOM', '24sur7');

define('APP_NOM_APPLICATION','24sur7');

// Gestion des pages de l'application
define('APP_PAGE_AGENDA', 'agenda.php');
define('APP_PAGE_RECHERCHE', 'recherche.php');
define('APP_PAGE_ABONNEMENTS', 'abonnements.php');
define('APP_PAGE_PARAMETRES', 'parametres.php');


//____________________________________________________________________________


/**
 * Connexion à la base de données.
 * Le connecteur obtenu par la connexion est stocké dans une
 * variable global : $GLOBALS['bd']
 * Le connecteur sera ainsi accessible partout.
 */
function fd_bd_connexion() {
	$bd = mysqli_connect(APP_BD_URL, APP_BD_USER, APP_BD_PASS, APP_BD_NOM);

	if ($bd !== FALSE) {
		$GLOBALS['bd'] = $bd;
		return;					// Sortie connexion OK
	}

	// Erreur de connexion
	// Collecte des informations facilitant le debugage
	$msg = '<h4>Erreur de connexion base MySQL</h4>'
			.'<div style="margin: 20px auto; width: 350px;">'
				.'APP_BD_URL : '.APP_BD_URL
				.'<br>APP_BD_USER : '.APP_BD_USER
				.'<br>APP_BD_PASS : '.APP_BD_PASS
				.'<br>APP_BD_NOM : '.APP_BD_NOM
				.'<p>Erreur MySQL num&eacute;ro : '.mysqli_connect_errno($bd)
				.'<br>'.mysqli_connect_error($bd)
			.'</div>';

	fd_bd_erreurExit($msg);
}

//____________________________________________________________________________

/**
 * Traitement erreur mysql, affichage et exit.
 *
 * @param string		$sql	Requête SQL ou message
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
		echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>',
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
//____________________________________________________________________________

/**
 * Génère le code HTML du début des pages.
 *
 * @param string	$titre		Titre de la page
 * @param string	$css		url de la feuille de styles liée
 */
function fd_html_head($titre, $css = '../styles/style.css') {
	if ($css == '-') {
		$css = '';
	} else {
		$css = "<link rel='stylesheet' href='$css'>";
	}

	echo '<!DOCTYPE HTML>',
		'<html>',
			'<head>',
				'<meta charset="UTF-8">',
				'<title>', $titre, '</title>',
				'<link rel="stylesheet" href="', $css, '">',
				'<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">',
			'</head>',
			'<body>',
				'<main id="bcPage">';
}

//____________________________________________________________________________

/**
 * Génère le code HTML du bandeau des pages.
 *
 * @param string	$page		Constante APP_PAGE_xxx
 */
function fd_html_bandeau($page) {
	echo '<header id="bcEntete">',
			'<nav id="bcOnglets">',
				($page == APP_PAGE_AGENDA) ? '<h2>Agenda</h2>' : '<a href="'.APP_PAGE_AGENDA.'">Agenda</a>',
				($page == APP_PAGE_RECHERCHE) ? '<h2>Recherche</h2>' : '<a href="'.APP_PAGE_RECHERCHE.'">Recherche</a>',
				($page == APP_PAGE_ABONNEMENTS) ? '<h2>Abonnements</h2>' : '<a href="'.APP_PAGE_ABONNEMENTS.'">Abonnements</a>',
				($page == APP_PAGE_PARAMETRES) ? '<h2>Paramètres</h2>' : '<a href="'.APP_PAGE_PARAMETRES.'">Paramètres</a>',
			'</nav>',
			'<div id="bcLogo"></div>',
			'<a href="deconnexion.php" id="btnDeconnexion" title="Se déconnecter"></a>',
		 '</header>';
}

//____________________________________________________________________________

/**
 * Génère le code HTML du pied des pages.
 */
function fd_html_pied() {
	echo '<footer id="bcPied">',
			'<a id="apropos" href="#">A propos</a>',
			'<a id="confident" href="#">Confidentialité</a>',
			'<a id="conditions" href="#">Conditions</a>',
			'<p id="copyright">24sur7 &amp; Partners &copy; 2012</p>',
		'</footer>';

	echo '</main>',	// fin du bloc bcPage
		'</body></html>';
}

//____________________________________________________________________________

/**
 * Génère le code HTML d'un calendrier.
 *
 * @param integer	$jour		Numéro du jour à afficher
 * @param integer	$mois		Numéro du mois à afficher
 * @param integer	$annee		Année à afficher
 */
function fd_html_calendrier($jour = 0, $mois = 0, $annee = 0) {
	list($JJ, $MM, $AA) = explode('-', date('j-n-Y'));

	// Vérification des paramètres
	$jour = (int) $jour;
	($jour < 1 || $jour > 31) && $jour = $JJ;

	$mois = (int) $mois;
	($mois < 1 || $mois > 12) && $mois = $MM;

	$annee = (int) $annee;
	($annee < 2014) && $annee = $AA;

	if (!checkdate($mois, $jour, $annee)) {
		$jour = $JJ;
		$mois = $MM;
		$annee = $AA;
	}

	// Initialisations diverses
	$aujourdHui = mktime(0, 0, 0, $MM, $JJ, $AA);
	$jourDebut = mktime(0, 0, 0, $mois, 1, $annee);
	$jourFin = mktime(0, 0, 0, ($mois + 1), 0, $annee);
	$nbJoursMois = date('j', $jourFin);	// nombre de jours dans le mois

	// Pour signaler le jour en cours dans l'affichage
	$aujourdHui = ($aujourdHui < $jourDebut || $aujourdHui > $jourFin) ? 0 : $JJ;

	// Pour signaler la semaine du jour demandé
	$semaine = date('W', mktime(0, 0, 0, $mois, $jour, $annee));

	// Quel est le nom du jour du début du mois (lundi, mardi, etc.)
	$jourDebut = date('w', $jourDebut);
	($jourDebut == 0) && $jourDebut = 7;

	// Si le mois ne commence pas un lundi, il faut
	// rechercher le nombre de jours du mois précédent
	// pour faire l'affichage de la fin de ce mois
	if ($jourDebut == 1) {
		$nbJoursAvant = 0;
	} else {
		$nbJoursAvant = mktime(0, 0, 0, $mois, 0, $annee);
		$nbJoursAvant = date('j', $nbJoursAvant);
	}

	// Affichage du titre du calendrier
	echo '<section id="calendrier">',
			'<p>',
				'<a href="#" class="flechegauche"><img src="../images/fleche_gauche.png"></a>',
				fd_get_mois($mois), ' ', $annee,
				'<a href="#" class="flechedroite"><img src="../images/fleche_droite.png"></a>',
			'</p>';

	// Affichage des jours du calendrier
	echo '<table>',
			'<tr>',
				'<th>Lu</th><th>Ma</th><th>Me</th><th>Je</th><th>Ve</th><th>Sa</th><th>Di</th>',
			'</tr>';

	// On vérifie si le jour demandé est dans la 1ere semaine affichée
	if (date('W', mktime(0, 0, 0, $mois, 2 - $jourDebut, $annee)) == $semaine) {
		echo '<tr class="semaineCourante">';
	} else {
		echo '<tr>';
	}


	// Jours du mois précédent
	for ($i = $case = 1; $i < $jourDebut; $i++, $case++) {
		echo '<td><a class="lienJourHorsMois" href="#">',
				($nbJoursAvant - $jourDebut + $i + 1),
				'</a></td>';
	}

	// Jours du mois
	for ($i = 1; $i <= $nbJoursMois; $i++, $case++) {
		if ($i == $aujourdHui) {
			echo '<td class="aujourdHui">';
		} elseif ($i == $jour) {
			echo '<td class="jourCourant">';
		} else {
			echo '<td>';
		}

		echo '<a href="#">', $i, '</a></td>';

		if ($case < 7) {
			continue;	// ==>> la semaine n'est pas terminée
		}

		// Quand une semaine est complétement affichée il faut
		// créer une nouvelle rangée dans le tableau et signaler
		// éventuellement la semaine du jour demandé.
		echo '</tr>';

		if ($i == $nbJoursMois) {
			break;		// ==>> BREAK : l'affichage du calendrier est fini
		}

		$case = 0;
		if (date('W', mktime(0, 0, 0, $mois, $i + 1, $annee)) == $semaine) {
			echo '<tr class="semaineCourante">';
		} else {
			echo '<tr>';
		}
	}

	// Premiers jours du mois suivant
	if ($case > 1) {
		for ($i = 1; $case < 8; $i++, $case++) {
			echo '<td><a class="lienJourHorsMois" href="#">', $i, '</a></td>';
		}

		echo '</tr>';
	}

	echo '</table></section>';
}

//_______________________________________________________________

/**
 * Renvoie le nom d'un mois.
 *
 * @param integer	$numero		Numéro du mois (entre 1 et 12)
 *
 * @return string 	Nom du mois correspondant
 */
function fd_get_mois($numero) {
	$numero = (int) $numero;
	($numero < 1 || $numero > 12) && $numero = 0;

	$mois = array('Erreur', 'Janvier', 'Février', 'Mars',
				'Avril', 'Mai', 'Juin', 'Juillet', 'Août',
				'Septembre', 'Octobre', 'Novembre', 'Décembre');

	return $mois[$numero];
}

//____________________________________________________________________________

/**
 * Formatte une date AAAAMMJJ en format lisible
 *
 * @param integer	$amj		Date au format AAAAMMJJ
 *
 * @return string	Date formattée JJ nomMois AAAA
 */
function fd_date_claire($amj) {
	$a = (int) substr($amj, 0, 4);
	$m = (int) substr($amj, 4, 2);
	$m = fd_get_mois($m);
	$j = (int) substr($amj, -2);

	return "$j $m $a";
}

//____________________________________________________________________________

/**
* Formatte une heure HHMM en format lisible
*
* @param integer	$h		Heure au format HHMM
*
* @return string	Heure formattée HH h SS
*/
function fd_heure_claire($h) {
	$m = (int) substr($h, -2);
	($m == 0) && $m = '';
	$h = (int) ($h / 100);

	return "{$h}h{$m}";
}

//____________________________________________________________________________

/**
 * Redirige l'utilisateur sur une page
 *
 * @param string	$page		Page où rediriger
 */
function fd_redirige($page) {
	header("Location: $page");
	exit();
}

/**
 * Créer une ligne de la table
 * @param string $gauche contenu gauche de la table 
 * @param string $droite contenu droite de la table
 */
function bog_form_ligne($gauche, $droite)
{
    return '
    <tr>
    <td>'.$gauche.'</td>
    <td>'.$droite.'</td>
    </tr>';
}

/**
 * génère le code HTML pour des zones de saisie de type text, password et submit
 * @param constante $type type de la zone
 * @param string $name nom de la zone
 * @param string $value valeur par défaut de la zone
 * @param integer $size taille de la zone
 */
function bog_form_input($type, $name, $value, $size = '0' )
{
    return '<input type="'.$type.'" name="'.$name.'" value="'.$value.'" size= "'.$size.'"/>';
}

/**
 * Génère le code HTML pour trois listes déroulantes permettant de saisir une date
 * @param  string $nom est le nom de la zone
 * @param  string $jour est le jour pré-sélectionné
 * @param  string $mois est le mois pré-sélectionné
 * @param  string $annee est l'année pré-sélectionnée
 * @param  integer  $size est la taille de la zone
 */
function bog_form_date($nom, $jour=0, $mois=0, $annee=0, $size=0)
{
    //jour
    if( $jour == 0 )
        {
            $j_selected = date('d',time());
        }
    else
        {
            $j_selected = $jour;
        }

    
    $res = '<select name=\''.$nom.'_j\'>';

    for( $i = 1; $i <= 31; $i++ )
        {
            $res .= '<option value=\''.$i.'\' ';
            if( $i == $j_selected )
                {
                    $res .= ' selected>';
                }
            else
                {
                    $res .= '>';
                }
            $res .= $i;
        }
    
    $res .= '</select>';

    //mois
    if( $mois == 0 )
        {
            $m_selected = date('n',time());
        }
    else
        {
            $m_selected = $mois;
        }

    $mois_nom = array('Erreur', 'Janvier', 'Février', 'Mars',
				'Avril', 'Mai', 'Juin', 'Juillet', 'Août',
				'Septembre', 'Octobre', 'Novembre', 'Décembre');
    
    $res .= '<select name=\''.$nom.'_m\'>';

    for( $i = 1; $i <= 12; $i++ )
        {
            $res .= '<option value=\''.$i.'\' ';
            if( $i == $m_selected )
                {
                    $res .= ' selected>';
                }
            else
                {
                    $res .= '>';
                }
            $res .= $mois_nom[$i];
        }
    
    $res .= '</select>';

    //année
    $current_y = date('o',time());
    if( $annee == 0 )
        {
            $a_selected = $current_y;
        }
    else
        {
            $a_selected = $annee;
        }

    
    $res .= '<select name=\''.$nom.'_a\'>';


    for( $i = $current_y; $i > $current_y - 30; $i-- )
        {
            $res .= '<option value=\''.$i.'\' ';
            if( $i == $a_selected )
                {
                    $res .= ' selected>';
                }
            else
                {
                    $res .= '>';
                }
            $res .= $i;
        }
    
    $res .= '</select>';

    return $res;
}

/**
 * Vérifie que l'utilisateur en cours s'est correctement authentifié.
 * Sinon redirige vers la page d'inscription
 *
 */
function bog_verifie_session()
{
    if( isset($_SESSION['nom']) && isset($_SESSION['id']) )
        {
            echo '<h1>Utilisateur Authentifié</h1>';
            echo '<p>Nom: '.$_SESSION['nom'].'</p>';
            echo '<p>ID: '.$_SESSION['id'].'</p>';
        }
    else
        {
            fd_redirige('inscription.php');
        }
}

?>
