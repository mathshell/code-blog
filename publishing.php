<?php 
require 'config/functions.php';

if (empty($_GET)) {
    header('Location: wrongtarget.php'); // redirection vers une page d'erreur 
    exit;
}

extract($_GET);

// Sécurisation des entrées
$auteur  = strip_tags($_GET['author'] ?? '');
$article = strip_tags($_GET['content'] ?? '');
$titre   = strip_tags($_GET['title'] ?? '');
$id      = strip_tags($_GET['id'] ?? '');

if (empty($id)) {
    $error = 'Identifiant perdu';
    header('Location: index.php?error=' . urlencode($error));
    exit;
}

if (!empty($auteur) && !empty($article) && !empty($titre)) {
    // Appel de la fonction publish pour la publication.
    $rep = publish($id, $article, $titre);

    if ($rep) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="style.css">
            <title>Publication</title>
        </head>
        <body>
            <h1>Publication</h1>
            <script>
                alert("Votre article a été publié avec succès !");
                
            </script>
            <a href="index.php?id="<?php echo urlencode($id); ?> >  consultez</a> 
        </body>
        </html>
        <?php 
    } else {
        echo "<p style='color:red'>Erreur lors de la publication.</p>";
    }
} else {
    echo "<p style='color:red'>Veuillez remplir tous les champs.</p>";
}
?>
