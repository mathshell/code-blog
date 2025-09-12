<?php 
require 'config/functions.php';

extract($_GET);
$id = strip_tags($_GET['id']?? '');

if(empty($id)){ 
    $er = 'connection refuseé: jeton de connection absant';
    header('location: login.php?error='.urlencode($er)); 
    
}




?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Publier un article sur Shell</title>
</head>
<body>
    <button><a href="index.php">acceuille</a></button>
    <form action="publishing.php" method="GET">
        <br>
        <p>
            <label for="title">Titre du blog :</label>
        </p>
        <input type="text" name = "title" id="title" required>
        <p>
            <label for="content">Contenu de l'article : </label>
        </p>
        <textarea name="content" id = "content"cols = "150" rows = "30" required></textarea>
        <p>
            <label for="author"> <input type="checkbox" name="author" id="author" required> En publiant cet article vous consentez a ce que votre nom soit indiquer comme 
                auteur de cette article. <a href="#"> <small>condition de confidentialité...</small></a>
            </label>
        </p>
        <input type="hidden" name="id" value = "<?= $id ?>">
        <button type="submit">Publier</button>
    </form>
</body>
</html>
