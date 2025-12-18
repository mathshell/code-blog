<?php 
require_once 'config/functions.php';

// 🔹 Vérifie que l'id est présent et nettoie
$id = isset($_GET['id']) ? strip_tags($_GET['id']) : 0;

// 🔹 Récupère les titres
$articles = getTitles();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shell_blog</title>

    <!-- ✅ Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap-5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'mvc/nav.php'; ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Articles</h1>

    <div class="row"> <!-- Conteneur de la grille -->
        <?php foreach($articles as $article): ?>
            
            <div class="col-md-6 mb-3"> <!-- 2 colonnes par ligne sur medium+ -->
                 <div class="entetetitre">
                   <div class="h-100"><!-- h-100 pour que les cartes aient la même hauteur -->
                    
                        <h2 class="card-title"><?= htmlspecialchars($article->title) ?></h2>
                        <time class="text-muted" datetime="<?= htmlspecialchars($article->date) ?>">
                            le <?= htmlspecialchars($article->date) ?>
                        </time>
                        <div class="mt-2">
                            <a class="btn btn-primary btn-sm" 
                               href="article.php?id=<?= urlencode($article->id) ?>">
                               Voir plus
                            </a>
                        </div>
                  
                </div>
            </div>
                
            </div>
        <?php endforeach; ?>
    </div> <!-- fin row -->

    <section class="text-center mt-4">
        <a class="btn btn-success" href="publisher.php?id=<?= urlencode($id) ?>">
            Publiez un article
        </a>
    </section>
</div>


<!-- ✅ JS Bootstrap Bundle (inclut Popper) -->
<script src="bootstrap-5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
