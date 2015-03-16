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
    
    $date_user = mktime(0,0,0,(int)$_POST['selDate_m'],(int)$_POST['selDate_j'],(int)$_POST['selDate_a']);
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


/**
 * Affiche le formulaire
 * @param $nom string nom par défaut
 * @param $mail string addresse mail par défaut
 * @author bog
 **/
function bogl_aff_formulaire($nom='', $mail='')
{
    echo '<form method="POST" action="inscription.php">';
    echo '<table border=\"1\" cellpadding=\"4\" cellspacing=\"0\">';
    echo '<caption style="text-align:left;"><h1>Inscription d\'un utilisateur</h1> </caption>';
    echo bog_form_ligne('Indiquez votre nom' ,bog_form_input('texte','txtNom',$nom,'40'));
    echo bog_form_ligne('Indiquez une adresse mail valide' ,bog_form_input('texte','txtMail',$mail,'40'));
    echo bog_form_ligne('Choisissez un mot de passe' ,bog_form_input('password','txtPasse','','20'));
    echo bog_form_ligne('Répéter votre mot de passe' ,bog_form_input('password','txtVerif','','20'));
    echo bog_form_ligne('Pour vérification, indiquez la date du jour' ,bog_form_date('selDate',13,1,1995));
    echo bog_form_ligne('' ,bog_form_input('submit','btnValider','Je m\'inscris'));
                        
    echo '</table>';
    echo '</form>';
}



if( isset($_POST['btnValider']) )
    {
        $errors = bogl_add_utilisateur();

        if( empty($errors) )
            {
                /* PAS D'ERREUR - ALL IS OK */
                session_start();
                $_SESSION['nom'] = $_POST['txtNom'];
                
                
                //get the ID
                $S= 'SELECT utiID FROM utilisateur WHERE utiMail="'.$_POST['txtMail'].'"';
                $R= mysqli_query($GLOBALS['bd'],$S) or fd_bd_erreur($S);
                $T = mysqli_fetch_assoc($R);
                $_SESSION['id'] = $T['utiID'];
                
                echo '<h2>--> HELLO '.$_SESSION['nom'].' '.$_SESSION['id'].'</h2>';
                fd_redirige('protegee.php');
                
                
            }
        else
            {
                fd_html_head('24sur7','-');

                bogl_aff_formulaire($_POST['txtNom'], $_POST['txtMail']);
                
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