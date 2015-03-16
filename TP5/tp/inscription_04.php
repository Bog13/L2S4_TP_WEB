<?php
include('bibli_24sur7.php');

echo '<h2>Réception du formulaire d\'inscription utilisateur </h2>';

$is_form_correct = true;

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


//display all the errors
if(isset($errors))
    {
        $is_form_correct = false;

        foreach($errors as $e)
            {
                echo $e.'</br>';
            }
    }


///No more errors
if(!$is_form_correct){ return;}

//add the 
$S = 'INSERT INTO utilisateur (utiNom, utiMail, utiPasse, utiDateInscription, utiJours, utiHeureMin, utiHeureMax) VALUES("'.htmlentities($_POST['txtNom']).'", "'.htmlentities($_POST['txtMail']).'", "'.md5(htmlentities($_POST['txtPasse'])).'",4,127, 6,22)';
$R = mysqli_query($GLOBALS['bd'], $S) or fd_bd_erreur($S);

//get the id
$S = 'SELECT utiID FROM utilisateur WHERE utiMail= "'.htmlentities($_POST['txtMail']).'"';
$R = mysqli_query($GLOBALS['bd'], $S) or fd_bd_erreur($S);
$T = mysqli_fetch_assoc($R);

if( $T != NULL )
    {
        echo 'Le nouvel utilisateur a bient été enregistré.</br>Il a le numero '.$T['utiID'];
    }

//destroy
mysqli_close($bd);

?>