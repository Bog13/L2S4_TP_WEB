<?php
/** @file
 * Bibliothèque générale de fonctions
 *
 * @author : Frederic Dadeau - frederic.dadeau@univ-fcomte.fr
 */

//____________________________________________________________________________

/**
 * Génère le code HTML du début des pages.
 *
 * @param string	$titre		Titre de la page
 * @param string	$css		url de la feuille de styles liée
 */
function bog_html_head($titre, $css = '../styles/style.css') {
	echo '<!DOCTYPE HTML>',
		'<html>',
        '<head>',
        '<meta charset="UTF-8">',
        '<title>', $titre, '</title>';

    if( $css != '-' )
        {
            echo '<link rel="stylesheet" href="', $css, '">';
        }
    
    echo '<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">',
        '</head>',
        '<body>',
        '<main id="bcPage">';
}?>