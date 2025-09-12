<?php
require 'config/functions.php';

if (!empty($_POST)) {
    // Nettoyage des champs
    $name     = strip_tags($_POST['name'] ?? '');
    $lname    = strip_tags($_POST['lname'] ?? '');
    $usrname  = strip_tags($_POST['usrname'] ?? '');
    $psswrd   = strip_tags($_POST['psswrd'] ?? '');
    $email    = strip_tags($_POST['email'] ?? '');
    $code     = strip_tags($_POST['code'] ?? '');

    // Appel de la fonction register
    $client = register($code, $psswrd, $name, $lname, $email, $usrname);

    // Affichage d'une alerte si succès
    if (!empty($client->bool) && $client->bool) {
        header ('location: publisher.php');
        echo '<script>alert("'.htmlspecialchars($client->welcom).'"); window.location.href="publisher.php;</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>
<body>
    <button>
        <a href="index.php" type="button"> acceuille.</a>
    </button>
    
    <form action="singin.php" method="post">
        <fieldset>
            <legend>Inscription</legend>
            <p>
                <label for="name">Nom</label>
                <input type="text" name="name" id="name">
            </p>
            <p>
                <label for="lname">Pre-Nom</label>
                <input type="text" name="lname" id="lname">
            </p>
            <p>
                <label for="usrname">Cree un nom d'utilisateur:</label>
                <input type="text" name="usrname" id="usrname">
            </p>
            <p>
                <label for="email">votre E-mail</label>
                <input type="email" name="email" id="email">
            </p>
            <p>
                <label for="psswrd">Crée un mot de passe:</label>
                <input type="password" name="psswrd" id="psswrd">
            </p>
            
            
            
            <label for="code">Generez un code : <br>
            <p>
                en cliquan sur générer un pop-up avec le code vous sera envoyé mémorisez-le et entrez-le.
            </p><button type="button" id = "pret">Generer</button></label>
            <input type="text" name="code" id="code">
            
            <script>
               let even = document.getElementById('pret');
                    even.onclick = function() {
                        let code = Math.floor(Math.random() * (30- 20 + 1) + 20);
                        alert(code);
                    };

            </script>
            
        </fieldset>
        <button type="submit">Valider</button>
        <button type="button">
            <a href="login.php">seconnecter</a>
        </button>
    </form>
</body>
</html>