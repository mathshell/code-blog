<?php
require_once 'config/functions.php';

// Vérification de l'ID dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php'); 
    exit;
}

$id = (int) $_GET['id']; // sécurisation
$errors = [];
$success = null;

// Récupération de l'article
$article = getArticle($id);
if (!$article) {
    header('HTTP/1.0 404 Not Found');
    echo "Article non trouvé.";
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author  = strip_tags(trim($_POST['author'] ?? ''));
    $comment = strip_tags(trim($_POST['comment'] ?? ''));

    if (empty($author)) {
        $errors[] = 'Entrez votre pseudonyme';
    }
    if (empty($comment)) {
        $errors[] = 'Laissez un commentaire';
    }

    if (empty($errors)) {
        addComment($id, $author, $comment);

        // Redirection pour éviter le double envoi
        header("Location: article.php?id=$id&success=1");
        exit;
    }
}

// Chargement des articles et commentaires
$articles = getTitles();
$com      = loadComment($id);

// Message de succès après redirection
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success = "Commentaire publié avec succès";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?= htmlspecialchars($article->title) ?></title>
</head>
<body>
    <?php include 'mvc/nav.php'; ?>
    <section class="article">
        <div class="entetearticle">
            <h1><?= htmlspecialchars($article->title) ?></h1>
            <p><?= htmlspecialchars($article->date) ?></p>
        </div>
        <p class="news"><?= nl2br(htmlspecialchars($article->content)) ?></p>
    </section>

    <section class="navigation">
        <div class = "oders"> <h3>Articles récents</h3></div> 
        <div>
            <?php foreach ($articles as $articl): ?>
                <div class="intitle">
                    <h5><?= htmlspecialchars($articl->title) ?></h5>
                    <a href="article.php?id=<?= $articl->id ?>">Lire</a>
                </div>
            <?php endforeach; ?>
        </div> 
    </section>

    <section class="comments-section">
        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p> 
            <?php endforeach; ?>
        <?php endif; ?>

        <br><br>
        <h3>Commentaires</h3>
        <?php if ($com): ?>
            <?php foreach($com as $comm): ?>
                <div class="coms">
                   <p class = "namcom"><strong><?= htmlspecialchars($comm->author) ?></strong></p> 
                    <p class = "comm"><?= nl2br(htmlspecialchars($comm->comment)) ?></p>
                    <time>le    <?= htmlspecialchars($comm->date) ?></time>
                </div>
            <?php endforeach; ?>    
        <?php else: ?>
            <p><br></p>
        <?php endif; ?>

        <form action="article.php?id=<?= $article->id ?>" method="post">
            <fieldset>
                <legend>Laissez un commentaire...</legend>
                <p>
                    <label for="author">Pseudo :</label><br>
                    <input type="text" name="author" id="author" 
                           value="<?= $author ?? '' ?>">
                </p>
                <p>
                    <label for="comment">Commentaire :</label><br>
                    <textarea name="comment" id="comment" cols="30" rows="8"><?= $comment ?? '' ?></textarea>
                </p>
                <button type="submit" id="envoyer">Envoyer</button>
            </fieldset>
        </form>
        <br>
        <a href="index.php">Accueil</a>
    </section>
</body>
</html>
