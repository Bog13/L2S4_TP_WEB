<?php

define('APP_PAGE_AGENDA',1);
define('APP_PAGE_RECHERCHE',2);
define('APP_PAGE_ABONNEMENTS',3);
define('APP_PAGE_PARAMETRES',4);

function bog_html_head($title='default', $css='default')
{
	echo 
	"<!doctype html>",
		"<head>",

		"<meta  charset=\"UTF-8\">",
		"<link rel='stylesheet' href=\"".$css."\" type='text/css' />",
		"<title> $title </title>",

		"<head>"
		;

}

function bog_html_bandeau($page)
{
	echo  
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


function bog_html_contenu()
{
	echo
	'<section id="bcContenu">',
		'<aside id="bcGauche">',
		'<section id="calendrier">';

	bog_html_calendrier(10,2,2015);
/*	bog_html_calendrier(3,'janvier',2015);
	bog_html_calendrier(0,2,2015);
	bog_html_calendrier(13,0,2013);
	bog_html_calendrier(0,10,2014);
	bog_html_calendrier();
	bog_html_calendrier(1,1,2013);*/

/*
    jour = 10, mois = 3, année = 2015
    jour = 3, mois = 'janvier', année = 2015
    jour = 0
    mois = 0
    jour = 0, mois = 10, année = 2014
    aucun paramètre
    jour = 1, mois = 1, année = 2013
*/


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


function bog_html_calendrier($jour=0, $mois=0, $annee = 0)
{

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
	if(!(($jour >= 0 && $jour < $nb_day_in_month)
		&& ($mois >= 0 && $mois <= 12)
			&& (($annee >= 2012 && $annee <= date('Y',time())) || $annee === 0)))
	{
		$jour = $current_day_in_month;
		$mois = $current_month;
		$annee = $current_year;
	}
	/* manage the value 0 */
	else
	{
		if($jour == 0){$jour=$current_day_in_month;}
		if($mois == 0){$mois=$current_month;}
		if($annee == 0){$annee=$current_year;}
	}


	/* selected date vars*/
	$selected_day_in_month = date('j',mktime(0,0,0,$mois,$jour,$annee));
	$selected_day_in_week = date('N',mktime(0,0,0,$mois,$jour,$annee));



	$first_day_in_month = date('N', mktime(0,0,0,$mois,1,$annee));
	$last_monday_of_last_month = date('j',mktime(0,0,0,$mois,1 - ($first_day_in_month - 1),$annee));

	$nb_week_in_month = date('W',mktime(0,0,0,$mois,$nb_day_in_month,$annee)) - date('W',mktime(0,0,0,$mois,1,$annee)) + 1 ;
	$selected_week_in_month = date('W',mktime(0,0,0,$mois,$jour,$annee)) - date('W',mktime(0,0,0,$mois,1,$annee)) + 1;

	
	/* DEBUGING VALUES */
	/*echo 'current day: ', $current_day_in_month ,'</br>';
	echo 'current month: ', $current_month,'</br>';
	echo 'day of the week: ', $current_day_in_week,'</br>';
	echo 'number of days in the month: ', $nb_day_in_month,'</br>';
	echo 'first day of the month: ', $first_day_in_month,'</br>'; 
	echo '</br></br>';
	echo 'selected day: ', $selected_day_in_month ,'</br>';
	echo 'selected month: ', $mois,'</br>';
	echo 'day of the week: ', $selected_day_in_week,'</br>';
	echo 'number of days in the month: ', $nb_day_in_month,'</br>';
	echo '</br>';
	echo 'number of week in the month: ', $nb_week_in_month,'</br>'; */

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

			/* détermination du jour sélectionné */
			if($day_counter == $jour && $in_the_month)
			{
				$day_modif = 'class="jourCourant"';				
			}

			/* détermination du jour courant*/
			
			else if($day_counter == $current_day_in_month && $mois == $current_month && $annee == $current_year && $in_the_month)
			{
				$day_modif = 'class="aujourdHui"';
				
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
