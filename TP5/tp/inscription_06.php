<?php
include('bibli_24sur7.php');

/**
 * Ajoute un utilisateur dans la base de donnée en utilisant le formulaire
 * @æuthor bog
 * @return le tableau d'erreur vide (pas d'erreur) ou contenant les erreurs lors de l'ajout de l'utilisateur
 */
function bogl_add_utilisateur()
{

    echo '<h2>Réception du formulaire d\'inscription utilisateur </h2>';

//Error management

    $length = strlen($_POST['txtNom']);
    if( $length < 4 or  $length > 30)
        {
            $errors['ERREUR_NOM'] = 'E: Le nom doit avoir de 4 à 30 caractères';
        }


    if( empty($_POST['txtMail'])  )
        {
            $errors['ERREUR_MAIL1'] = 'E: L\'adresse mail est obligatoire';
        }

    if( strpos($_POST['txtMail'], '.') === false || strpos($_POST['txtMail'], '@') === false )
        {
            $errors['ERREUR_MAIL2'] = 'E: L\'adresse mail n\'est pas valide';
        }

    $length = strlen($_POST['txtPasse']);
    if( $length < 4 or  $length > 20)
        {
            $errors['ERREUR_PASS'] = 'E: Le mot de passe doit avoir de 4 à 20 caractères';
        }

    if( $_POST['txtPasse'] !== $_POST['txtVerif'] )
        {
            $errors['ERREUR_VERIF'] = 'E: Le mot de passe est différent dans les 2 zones';
        }

    if( checkdate($_POST['selDate_m'],$_POST['selDate_j'],$_POST['selDate_a']) === false )
        {
            $errors['ERREUR_DATE1'] = 'E: La date n\'est pas valide';
        }

    $date_user = mktime(0,0,0,$_POST['selDate_m'],$_POST['selDate_j'],$_POST['selDate_a']);
    $date_now = mktime(0,0,0);
    if( $date_user !== $date_now)
        {
            $errors['ERREUR_DATE2'] = 'E: La date doit être celle du jour';
        }



//check if the already mail exists
    fd_bd_connexion();

    $S = 'SELECT utiMail FROM utilisateur WHERE utiMail="'.htmlentities($_POST['txtMail']).'"';
    $R = mysqli_query($GLOBALS['bd'], $S) or fd_bd_erreur($S);
    $T = mysqli_fetch_assoc($R);

    if( $T !== NULL )
        {
            $errors['ERREUR_MAIL3'] = 'E: Adresse mail déjà prise';
        }

    

///No more errors
    if( ! isset($errors) )
        {

            
//add the
            $date_m = $_POST['selDate_m'];
            $date_j = $_POST['selDate_j'];

            $date_inscri = $_POST['selDate_a'].'0'.$date_m.$date_j;

            
            $S = 'INSERT INTO utilisateur (utiNom, utiMail, utiPasse, utiDateInscription, utiJours, utiHeureMin, utiHeureMax) VALUES("'.htmlentities($_POST['txtNom']).'", "'.htmlentities($_POST['txtMail']).'", "'.md5(htmlentities($_POST['txtPasse'])).'","'.$date_inscri.'",127, 6,22)';
            $R = mysqli_query($GLOBALS['bd'], $S) or fd_bd_erreur($S);

            return [];
        }
    else
        {
            return $errors;
        }

}

/*
$errors = bogl_add_utilisateur();

if( !empty($errors) )
    {
        
        foreach($errors as $e)
            {
                echo $e.'</br>';
            }
    }
else
    {
        $S = 'SELECT utiID FROM utilisateur WHERE utiMail= "'.htmlentities($_POST['txtMail']).'"';
        $R = mysqli_query($GLOBALS['bd'], $S) or fd_bd_erreur($S);
        $T = mysqli_fetch_assoc($R);

        if( $T != NULL )
            {
                echo 'Le nouvel utilisateur a bien été enregistré.</br>Il a le numero '.$T['utiID'];
            }

    }
*/


/**
 * Affiche le formulaire
 * @param $nom string nom par défaut
 * @param $mail string addresse mail par défaut
 * @author bog
 **/
function bogl_aff_formulaire($nom='', $mail='')
{
    
    echo "
    <form action='inscription.php' method='POST'>
      
      <table border=\"1\" cellpadding=\"4\" cellspacing=\"0\">
	<thead>
	</thead>

	<tbody>
	  <tr>
	    <td>Indiquez votre nom</td>
	    <td>
	      <input type='text' name='txtNom' size='40' value='".$nom."'/>
	    </td>
	  </tr>
	  
	  <tr>
	    <td>Indiquez une adresse mail valide</td>
	    <td>
	      <input type='text' name='txtMail' size='40' value='".$mail."'/>
	    </td>
	  </tr>

	  <tr>
	    <td>Choisissez un mot de passe</td>
	    <td>
	      <input type='password' name='txtPasse' size='20' />
	    </td>
	  </tr>
	  <tr>
	    <td>Répétez votre mot de passe</td>
	    <td>
	      <input type='password' name='txtVerif' size='20' />
	    </td>
	  </tr>
	  
	  <tr>
	    <td>Pour vérification, indiquez la date du jour</td>
	    <td>
	      <select name='selDate_j'>
		<option value='1' selected>1
		<option value='2'>2
		<option value='3'>3
		<option value='4'>4
		<option value='5'>5
		<option value='6'>6
		<option value='7'>7
		<option value='8'>8
		<option value='9'>9
		<option value='10'>10
		<option value='11'>11
		<option value='12'>12
		<option value='13'>13
		<option value='14'>14
		<option value='15'>15
		<option value='16'>16
		<option value='17'>17
		<option value='18'>18
		<option value='19'>19
		<option value='20'>20
		<option value='21'>21
		<option value='22'>22
		<option value='23'>23
		<option value='24'>24
		<option value='25'>25
		<option value='26'>26
		<option value='27'>27
		<option value='28'>28
		<option value='29'>29
		<option value='30'>30
		<option value='31'>31
	      </select>

	      <select name='selDate_m'>
		<option value='1' selected>Janvier
		<option value='2'>Février
		<option value='3'>Mars
		<option value='4'>Avril
		<option value='5'>Mai
		<option value='6'>Juin
		<option value='7'>Juillet
		<option value='8'>Août
		<option value='9'>Septembre
		<option value='10'>Octobre
		<option value='11'>Novembre
		<option value='12'>Décembre
	      </select>

	      <select name='selDate_a'>
		<option value='2015'>2015
		<option value='2014'>2014
		<option value='2013'>2013

		<option value='2012'>2012
		<option value='2011'>2011
		<option value='2010'>2010
		<option value='2009'>2009
		<option value='2008'>2008
		<option value='2007'>2007
		<option value='2006'>2006
		<option value='2005'>2005
		<option value='2004'>2004
		<option value='2003'>2003
		<option value='2002'>2002
		<option value='2001'>2001
		<option value='2000' selected>2000
		<option value='1999'>1999
		<option value='1998'>1998
		<option value='1997'>1997
		<option value='1996'>1996
		<option value='1995'>1995
		<option value='1994'>1994
		<option value='1993'>1993
		<option value='1992'>1992
		<option value='1991'>1991
		<option value='1990'>1990
		<option value='1989'>1989
		<option value='1988'>1988
		<option value='1987'>1987
		<option value='1986'>1986
		<option value='1985'>1985
	      </select>
	    </td>
	  </tr>

	  <tr>
	    <td></td>
	    <td>
	      <input type='submit' name='btnValider' value=\"Je m'inscris\">
	    </td>
	  </tr>
	  
	<tbody>
	  
      </table>
    </form>";
}



if( isset($_POST['btnValider']) )
    {
        $errors = bogl_add_utilisateur();

        if( empty($errors) )
            {
                header('Location: liste_users_02.php');
            }
        else
            {
                fd_html_head('24sur7','-');

                foreach($errors as $e)
                    {
                        echo $e.'</br>';
                    }
            }
    }
else
    {
        fd_html_head('24sur7','-');
        bogl_aff_formulaire();
    }

?>