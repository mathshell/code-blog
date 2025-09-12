<?php 
require 'config/functions.php';
$error = "";
if (!empty($_POST)) {
    
    //netoyage des champs
    $usrname = strip_tags($_POST['usrname']?? '');
    $password = strip_tags($_POST['password']?? '');

    //  ppel de la fonction login.
   login($usrname, $password);
}else{

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sing-up</title>
</head>
<body>
    <button>
        <a href="index.php">acceuille</a>
    </button>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <center>
        <form action="login.php" method="post">
            <fieldset>
                <legend>Connexion</legend>
                <p>
                    <label for="usrname">Nom d'utilisateur</label>
                </p>
                <input type="text" placeholder="Ex: usrName" name = "usrname" id = "usrname" required>
                <p>
                    <label for="password">Mot de passe</label>
                </p>
                <input type="password" name="password" id="password" required>
            </fieldset>
            <input type="submit" value="Connection.">
            
        </form>
        
        <button>
            <a href="singin.php">S'inscrire</a>
        </button>
    </center>
</body>
</html>