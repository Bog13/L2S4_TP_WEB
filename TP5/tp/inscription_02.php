<?php

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


foreach($_POST as $key => $value)
    {
        echo 'Zone '.$key.' = '.$value.' </br>';
    }


mysqli_close($bd);

?>