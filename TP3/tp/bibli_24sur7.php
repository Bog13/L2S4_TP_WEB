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

    bog_html_calendrier();

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

    if(!(($jour >= 0 && $jour <= date('t',time()))
       && ($mois >= 0 && $mois <= 12)
       && (($annee >= 2012 && $annee <= date('Y',time())) || $annee === 0)))
    {
	echo "erreur è_é ";
	return;
    }


    

    echo
	'<p>',
	'<a href="#" class="flechegauche"><img src="../images/fleche_gauche.png" alt="picto fleche gauche"></a>',
	'F&eacute;vrier&nbsp;2012',
	'<a href="#" class="flechedroite"><img src="../images/fleche_droite.png" alt="picto fleche droite"></a>',
	'</p>',
	'<table>',
	'<tr>',
	'<th>Lu</th><th>Ma</th><th>Me</th><th>Je</th><th>Ve</th><th>Sa</th><th>Di</th>',
	'</tr>',
	'<tr>',
	'<td><a class="lienJourHorsMois" href="#">30</a></td>',
	'<td><a class="lienJourHorsMois" href="#">31</a></td>',
	'<td><a href="#">1</a></td>',
	'<td class="aujourdHui"><a href="#">2</a></td>',
	'<td><a href="#">3</a></td>',
	'<td><a href="#">4</a></td>',
	'<td><a href="#">5</a></td>',
	'</tr>',
	'<tr class="semaineCourante">',
	'<td><a href="#">6</a></td>',
	'<td class="jourCourant"><a href="#">7</a></td>',
	'<td><a href="#">8</a></td>',
	'<td><a href="#">9</a></td>',
	'<td><a href="#">10</a></td>',
	'<td><a href="#">11</a></td>',
	'<td><a href="#">12</a></td>',
	'</tr>',
	'<tr>',
	'<td><a href="#">13</a></td>',
	'<td><a href="#">14</a></td>',
	'<td><a href="#">15</a></td>',
	'<td><a href="#">16</a></td>',
	'<td><a href="#">17</a></td>',
	'<td><a href="#">18</a></td>',
	'<td><a href="#">19</a></td>',
	'</tr>',
	'<tr>',
	'<td><a href="#">20</a></td>',
	'<td><a href="#">21</a></td>',
	'<td><a href="#">22</a></td>',
	'<td><a href="#">23</a></td>',
	'<td><a href="#">24</a></td>',
	'<td><a href="#">25</a></td>',
	'<td><a href="#">26</a></td>',
	'</tr>',
	'<tr>',
	'<td><a href="#">27</a></td>',
	'<td><a href="#">28</a></td>',
	'<td><a href="#">29</a></td>',
	'<td><a class="lienJourHorsMois" href="#">1</a></td>',
	'<td><a class="lienJourHorsMois" href="#">2</a></td>',
	'<td><a class="lienJourHorsMois" href="#">3</a></td>',
	'<td><a class="lienJourHorsMois" href="#">4</a></td>',
	'</tr>',
	'</table>';
	
}

function bog_html_calendrier2($jour=0, $mois=0, $annee = 0)
{
    echo
    '<section id="bcCentre">',
    '<p id="titreAgenda">',
    '<a href="#" class="flechegauche"><img src="../images/fleche_gauche.png" alt="picto fleche gauche"></a>',
    '<strong>Semaine du 6  au 12 F&eacute;vrier</strong> pour <strong>les L2</strong>',
    '<a href="#" class="flechedroite"><img src="../images/fleche_droite.png" alt="picto fleche droite"></a>',
    '</p>',
    '<section id="agenda">',
    '<div id="intersection"></div>',
    '<div class="case-jour border-TRB border-L">Lundi 6</div>',
    '<div class="case-jour border-TRB">Mardi 7</div>',
    '<div class="case-jour border-TRB">Mercredi 8</div>',
    '<div class="case-jour border-TRB">Jeudi 9</div>',
    '<div class="case-jour border-TRB">Vendredi 10</div>',
    '<div class="case-jour border-TRB">Samedi 11</div>',
    '<div id="col-heures">',
    '<div>7h</div>',
    '<div>8h</div>',
    '<div>9h</div>',
    '<div>10h</div>',
    '<div>11h</div>',
    '<div>12h</div>',
    '<div>13h</div>',
    '<div>14h</div>',
    '<div>15h</div>',
    '<div>16h</div>',
    '<div>17h</div>',
    '<div>18h</div>',
    '</div>',
    '<div class="col-jour border-TRB border-L">',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#" class="case-heure-bas"></a>',
    '<a style="background-color: #00FF00;',
    'border: solid 2px #00DD00;',
    'color: #000000;',
    'top: 131px; ',
    'height: 114px;" class="rendezvous" href="#">TP LW</a>',
    '<a style="color: #FFFFFF;',
    'background-color: #FF0000;',
    'border: solid 2px #DD0000;',
    'top: 357px; ',
    'height: 114px;" class="rendezvous" href="#">TP LW</a>',
    '</div>',
    '<div class="col-jour border-TRB">',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#" class="case-heure-bas"></a>',
    '<a style="color: #FFFFFF;',
    'background-color: #0000FF;',
    'border: solid 2px #0000DD;',
    'top: 295px;',
    'height: 114px;" class="rendezvous" href="#">TP LW</a>',
    '</div>',
    '<div class="col-jour border-TRB">',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#" class="case-heure-bas"></a>',
    '</div>',
    '<div class="col-jour border-TRB">',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#" class="case-heure-bas"></a>',
    '</div>',
    '<div class="col-jour border-TRB">',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#" class="case-heure-bas"></a>',
    '</div>',
    '<div class="col-jour border-TRB">',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#"></a>',
    '<a href="#" class="case-heure-bas"></a>',
    '</div>',
    '</section>',
    '</section>',
    '</section>';
}


?>
