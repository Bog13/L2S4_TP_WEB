<?php
/*
cas d'erreur connu: si le jour courant marche, il y a un risque de ralentissement.
 */

define('APP_PAGE_AGENDA',1);
define('APP_PAGE_RECHERCHE',2);
define('APP_PAGE_ABONNEMENTS',3);
define('APP_PAGE_PARAMETRES',4);

/**
 * Génère l'entête de la page
 *
 * @author  bog
 * @param 	string 	$title 	titre de la fenetre
 * @param 	string 	$css	chemin vers la feuille de style 
 */
function bog_html_head($title='default', $css='default')
{

    echo
        '<!DOCTYPE HTML>',
        '<html>',
        '<head>',
        '<meta charset="UTF-8">',
        '<title>'.$title.'| Votre agenda</title>',
        '<link rel="stylesheet" href="'.$css.'" type="text/css">',
        '<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">',
	'</head>';
  
}

/**
 * Génère le bandeau de la page
 *
 * @author  bog
 * @param 	integer  $page	onglet selectionné
 */
function bog_html_bandeau($page)
{
	echo
        '<main id="bcPage">',
        '<header id="bcEntete">',
		'<div id="bcLogo"></div>',
		
		'<nav id="bcOnglets">';
	

	switch($page)
        {
		case APP_PAGE_AGENDA:
            echo
                '<h2>Agenda</h2>',
                '<a href="#">Recherche</a>',
                '<a href="#">Abonnements</a>',
                '<a href="#">Param&egrave;tres</a>';
            break;

		case APP_PAGE_RECHERCHE:
            echo
                '<a href="#">Agenda</a>',
                '<h2>Recherche</h2>',
                '<a href="#">Abonnements</a>',
                '<a href="#">Param&egrave;tres</a>';
            break;

		case APP_PAGE_ABONNEMENTS:
            echo
                '<a href="#">Agenda</a>',
                '<a href="#">Recherche</a>',
                '<h2>Abonnements</h2>',
                '<a href="#">Param&egrave;tres</a>';
            break;

		case APP_PAGE_PARAMETRES:
            echo
                '<a href="#">Agenda</a>',
                '<a href="#">Recherche</a>',
                '<a href="#">Abonnements</a>',
                '<h2>Param&egrave;tres</h2>';
            break;
		
        }

	echo
        '</nav>',
		
		'<a href="#" id="btnDeconnexion" title="Se d&eacute;connecter"></a>',
		'</header>';

}

/**
 * Génère le pied de page
 *
 * @author  bog
 */
function bog_html_pied()
{
	echo 
        '<footer id="bcPied">',
		'<a id="apropos" href="#">A propos</a>',
		'<a id="confident" href="#">Confidentialit&eacute;</a>',
		'<a id="conditions" href="#">Conditions</a>',
		'<p id="copyright">24sur7 &amp; Partners &copy; 2012</p>',
		'</footer>',
		'</main>',
		'</body>',
		'</html>';
	
}


/**
 * Génère le contenu de la page
 *
 * @author  bog
 */
function bog_html_contenu()
{
	echo
        '<section id="bcContenu">',
		'<aside id="bcGauche">',
		'<section id="calendrier">';

	bog_html_calendrier(16,'janvier',2015);

	echo 
        '</section>',
		'<section id="categories">';

	echo
        '</section>',
		'</aside>',
		'<section id="bcCentre">';


	echo
        '</section>',
		'</section>';
}

/**
 * Convertie un mois sous forme de chaine de caractère vers un integer
 *
 * @author  bog
 * @param   string 	$month 	mois à convertir en integer
 */
function bog_month_to_integer($month)
{
    if(gettype($month) != 'integer')
        {
            $m = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
            $i = 0;
            
            while( $month != $m[$i] && $i <= 12)
                {
                    $i++;
                }
            if($i <= 12 )
                {
                    return $i+1;
                }
            else
                {
                    return 0;
                }
        }
    
}

/**
 * Génère le calendrier
 *
 * @author  bog
 * @param 	integer	$jour 	 numéro du jour sélectionné dans le calendrier. Si $jour est égal à 0, on affiche le calendrier du mois courant de l'année courante, avec le jour courant sélectionné.
 *
 * @param 	integer	$mois   numéro du mois du calendrier. Si $mois est égal à 0, on affiche le calendrier du mois courant de l'année courante.
 *
 * @param 	integer	$année	 numéro de l'année du calendrier. Si $annee est égal à 0, on affiche le calendrier du mois courant de l'année courante.
 */
function bog_html_calendrier($jour=0, $mois=0, $annee = 0)
{

    //transtypages
    if(gettype($jour) != 'integer')
    {
        $jour = 0;
    }
    if(gettype($mois) != 'integer')
    {
        $mois = bog_month_to_integer($mois);
    }
    if(gettype($annee) != 'integer')
    {
        $annee = 0;
    }

	/*
      selected_xxx = selected by the user ( $jour $mois and $annee )
      current_xxx = true date
    */

	/*current date vars*/
	$french_month = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

	$current_month = date('n',time());
	$current_year = date('Y',time());

	$current_day_in_month = date('j',time());
	$current_day_in_week = date('N',time());


    $nb_day_in_month = date('t', mktime(0,0,0,$mois,$jour,$annee));
	$nb_day_in_last_month = date('t', mktime(0,0,0,$mois-1,$jour,$annee));
    
	/* parameter management*/
	/* errors management*/
    $need_to_recompute = false;
	if(!(($jour >= 0 && $jour < $nb_day_in_month)
    && ($mois >= 0 && $mois <= 12)
    && (($annee >= 2012 && $annee <= date('Y',time())) || $annee === 0)))
        {
            $jour = $current_day_in_month;
            $mois = $current_month;
            $annee = $current_year;
            $need_to_recompute = true;
        }
	/* manage the value 0 */
	else
        {
            
            if($jour == 0){$jour=$current_day_in_month;$need_to_recompute = true;}
            if($mois == 0){$mois=$current_month;$need_to_recompute = true;}
            if($annee == 0){$annee=$current_year;$need_to_recompute = true;}
        }

    if( $need_to_recompute === true )
        {
            $nb_day_in_month = date('t', mktime(0,0,0,$mois,$jour,$annee));
            $nb_day_in_last_month = date('t', mktime(0,0,0,$mois-1,$jour,$annee));
        }
    
    
	/* selected date vars*/
	$selected_day_in_month = date('j',mktime(0,0,0,$mois,$jour,$annee));
	$selected_day_in_week = date('N',mktime(0,0,0,$mois,$jour,$annee));



	$first_day_in_month = date('N', mktime(0,0,0,$mois,1,$annee));
	$last_monday_of_last_month = date('j',mktime(0,0,0,$mois,1 - ($first_day_in_month - 1),$annee));

	$nb_week_in_month = date('W',mktime(0,0,0,$mois,$nb_day_in_month,$annee)) - date('W',mktime(0,0,0,$mois,1,$annee)) + 1 ;
	$selected_week_in_month = date('W',mktime(0,0,0,$mois,$jour,$annee)) - date('W',mktime(0,0,0,$mois,1,$annee)) + 1;


	/*entete*/
	echo 	'<a href="#" class="flechegauche"><img src="../images/fleche_gauche.png" alt="picto fleche gauche"></a>',
		$french_month[abs($mois - 1)],
		' ',
		$annee,
		'<a href="#" class="flechedroite"><img src="../images/fleche_droite.png" alt="picto fleche droite"></a>',
		'</p>';

	
	echo '<table>',
		'<tr>',
		'<th>Lu</th><th>Ma</th><th>Me</th><th>Je</th><th>Ve</th><th>Sa</th><th>Di</th>',
		'</tr>';


	/*affichage jours*/
	
	$day_counter = $last_monday_of_last_month;
	$switched_to_current_month = false;
	$switched_to_next_month = false;
	$day_modif = '';
	$day_out_of_month_modif = '';
	$in_the_month = false;

	for($semaine=1;$semaine <= $nb_week_in_month;$semaine++)
        {
            echo '<tr>';

            for($jour_semaine = 1; $jour_semaine <= 7; $jour_semaine++)
                {
			
                    /* reinitialisation des day_modif */
                    $day_modif= '';

                    /* détermination des jours en dehors du mois */
                    if($in_the_month == false)
                        {
                            $day_out_of_month_modif = 'class="lienJourHorsMois"';
                        }
                    else
                        {
                            $day_out_of_month_modif = '';
                        }


                    /* détermination du jour courant*/
                    if($day_counter == $current_day_in_month && $mois == $current_month && $annee == $current_year && $in_the_month)
                        {
                            $day_modif = 'class="aujourdHui"';
				
                        }
                    /* détermination du jour sélectionné */
                    else if($day_counter == $jour && $in_the_month)
                        {
                            $day_modif = 'class="jourCourant"';				
                        }


			
                   
                    else if( $semaine == $selected_week_in_month )
                        {
                            $day_modif = 'class="semaineCourante"';
                        }

			
                    /* génération du code html par rapport à day_modif et day_out_of_month_modif */

                    echo '<td '.$day_modif.'><a '.$day_out_of_month_modif.' href="#">';

                    echo $day_counter;

                    echo '</a></td>';
			

                    /* Choix de day_counter */
                    $day_counter++;

                    /*on entre dans le mois courant*/
                    if( $day_counter > $nb_day_in_last_month && $switched_to_current_month === false)
                        {
                            $day_counter = 1;
                            $switched_to_current_month = true;
                        }

                    /*on sort du mois courant*/
                    if( $day_counter > $nb_day_in_month && $switched_to_current_month === true && $switched_to_next_month === false )
                        {
                            $day_counter = 1;
                            $switched_to_next_month = true;
                        }

                    /* maj de in_the_month */
                    $in_the_month = ($switched_to_next_month === false && $switched_to_current_month === true);


                }

            echo '</tr>';
		
        }

	echo '</table>';
	
	
}


?>
