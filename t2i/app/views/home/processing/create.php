<?php
session_start();


if (!empty($_POST)) {
    $nom = filter_input(INPUT_POST, 'nom', FILTER_DEFAULT);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_DEFAULT);
    $date = filter_input(INPUT_POST, 'date', FILTER_DEFAULT);
    $tel = filter_input(INPUT_POST, 'tel', FILTER_DEFAULT);
    $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
    $adresse = filter_input(INPUT_POST, 'adresse', FILTER_DEFAULT);

    $_SESSION['create-client'] = ['nom'=>$nom, 'prenom'=>$prenom, 'date'=>$date, 'tel'=>$tel, 'mail'=>$mail, 'adresse'=>$adresse];

    header('Location: /www/exos/t2i/home/create');
    exit;
} else {
    $_SESSION['error'] = "Formulaire vide";
    header('Location: /www/exos/t2i/home/create');
    exit;
}
