<?php 
        
    require_once 'config/functions.php';
    if (!empty($_GET)) {
        extract($_GET);
        $id = strip_tags($_GET);    
    }else {
        $id = '0';
    }
    $articles = getTitles();
    
    
        
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Shell_blog</title>
</head>
<body>

<?php include'mvc/nav.php'; ?>
    <h1>Articles</h1>

    <?php 
    foreach($articles as $article):?>
    <div class = "entetetitre">
        <h2 ><?= $article->title ?></h2><time datetime="date">le  <?= $article->date ?></time>
        <div class = "voirplus">
            <a href="article.php?id=<?= $article->id ?>">voir plus</a>
        </div>
    </div>
    
    
    <?php endforeach;?>
    <section class = "publisher">
       <button >
            <a href="publisher.php?="<?= $id ?>> publiez un article.</a> 
    </button >
    </section>
    
    
</body>
</html>