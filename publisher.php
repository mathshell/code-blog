<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Appel à ton API d'authentification
        $url = "http://localhost/api/auth.php";
        $data = json_encode(["username" => $username, "password" => $password]);

        $options = [
            "http" => [
                "header"  => "Content-Type: application/json\r\n" .
                             "Content-Length: " . strlen($data) . "\r\n",
                "method"  => "POST",
                "content" => $data,
                "ignore_errors" => true
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            $error = "Erreur lors de l'appel à l'API.";
        } else {
            $response = json_decode($result, true);

            // DEBUG : voir la réponse de l'API
            echo '<pre>'; var_dump($response); echo '</pre>';

            if (isset($response['token']) && !empty($response['token'])) {
                // Stocker le token en session
                $_SESSION['jwt'] = $response['token'];
                session_write_close(); // s'assure que la session est bien sauvegardée
                header("Location: publisher.php");
                exit;
            } else {
                $error = "Identifiants invalides ou pas de token reçu !";
            }
        }
    }
}
?>

<!DOCTYPE html> <html lang="fr"> 
    <head> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link rel="stylesheet" href="style.css"> <title>Publier un article sur Shell</title> 
    </head> 
    <body> 
        <?php include 'mvc/nav.php'; ?> 
        <form action="publishing.php" method="GET"> <br> 
        <p> <label for="title">Titre du blog :</label> </p> 
        <input type="text" name = "title" id="title" required> 
        <p> <label for="content">Contenu de l'article : </label> </p> 
        <textarea name="content" id = "content"cols = "150" rows = "30" required></textarea> 
        <p> <label for="author"> <input type="checkbox" name="author" id="author" required> 
        En publiant cet article vous consentez a ce que votre nom soit indiquer comme auteur de cette 
        article. <a href="#"> <small>condition de confidentialité...</small></a> 
    </label> </p> 
    <input type="hidden" name="id" value = "<?= $id ?>"> 
    <button type="submit">Publier</button> 
</form> 
</body> 
</html>
