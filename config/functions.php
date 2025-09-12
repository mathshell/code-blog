<?php 

    


//ICI NOUS RECUPERONS LES DONNEES (les titres des articles) DANS NOTRE BASE DE DONNEE A LA TABLE "articles"
function getTitles()
{
    try {
        //code...
        require 'connect.php'; // connection a la base de donnée grace au fichier connect.php 
        $req = $db->prepare('SELECT id, title, date FROM articles ORDER BY id ASC');
        $req->execute();
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        
        $req->closeCursor();
        return $data;
    } catch (Exception $e) {
        //throw $th;
        die('Erreur : '.$e->getMessage());
    }
    
    
    
}
//Cette fonction recupere l'article qui a été choisi par le visiteur dans la premierre page
function getArticle($id) {      
    require 'connect.php';
    $req = $db->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute(array($id));
    if ($req->rowCount() == 1) {
        $data = $req->fetch(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    } else {
        header('location: index.php');
    }
    
    
}

//CETTE FONCTION AJOUTE UN COMMENTAIRE DANS LA BASE DE DONNEE DANS LA TABLE COMMENTS
function addComment($articleId, $author, $comment){
    try {
        require 'connect.php';
        $req = $db->prepare('INSERT INTO comments (article_id, author, comment, date) VALUES (?, ?, ?, NOW())');
        $req->execute(array($articleId, $author, $comment));
        if (!$success) {
            $errorInfo = $req->errorInfo();
            throw new Exception("Erreur SQL : " . implode(" | ", $errorInfo));
        }
        $confirm = "message en registré avec succes!";
        $req->closeCursor();
        return $confirm;
        

    } catch (Exception $e) {
        $confirm = 'Erreur : '.$e->getMessage();
        return $confirm;
    }
    
}

//CETTE FONCTION RECUPERE LES COMMENTAIRES DANS LA BASE DE DONNEE
function loadComment($id){
    try {
        require 'connect.php';
        $req = $db->prepare('SELECT * FROM comments WHERE article_id = ? ORDER BY date ASC');
        $req->execute([$id]);
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}

//CETTE FONTION INCREMENTE LE NOMBRE D'ARTICLE D'AUTEUR DANS LA BASE DE DONNEE
function publish($id, $article, $titre) {
    require 'connect.php';

    try {
        // Récupérer les infos de l'auteur
        $req = $db->prepare('SELECT Nbr_article, Nam_writer FROM writers WHERE usr_key = ?');
        $req->execute([$id]);
        $data = $req->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new Exception("Auteur introuvable.");
        }

        // Incrémenter le nombre d'articles
        $Nw_nombre = $data['Nbr_article'] + 1;

        $req = $db->prepare('UPDATE writers SET Nbr_article = ? WHERE usr_key = ?');
        $req->execute([$Nw_nombre, $id]);

        // Insérer l'article
        $req = $db->prepare('INSERT INTO articles (title, content, Author, date) VALUES (?, ?, ?, NOW())');
        $success = $req->execute([$titre, $article, $data['Nam_writer']]);

        return $success;

    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}


//cCETTE FONCTION RECUPERE LES DONNEES DANS UNE TABLE WRITERS
function login($name, $mt_Pss){                                 //prends en parametres deux valleurs
    require 'connect.php';                                      //se connecte a la base de donné
    $req = $db->prepare('SELECT usr_key, passWrd FROM writers WHERE Nam_writer = ?'); //prepare la requete
    $req->execute([$name]); //l'execute en lui passant une variable
    $data = $req->fetch(); //transmet a la variable les retour de la requette sous forme d'objet
    $req->closeCursor();
   
        if(empty($data)) {  // si la variable est vide 
            $error = 'nom d\'utilisateur inconu'; //passe une phrase dans la variable quit doit contenir la clef de connection.
            header ('location: login.php?='.$error);
        }elseif (!empty($data)) { // si la variable n'est pas vide,
            // 2. Vérifier le mot de passe entré par l'utilisateur
            if ($mt_Pss == $data['passWrd']) { //verification du mo de passe 
                header('location: publisher.php?id='.urlencode($data['usr_key']));
                
                
            } else {
                $error = 'mot de masse incorrect';
                header ('location: login.php?id='.urlencode($error));
            }
                
        }


   
} 


//CETTE FONCTION ENREGISTRE DE NOUVEAU ECRIVAINS DANS LA BASE DE DONNEE
/**
 * cette fonction n'est appeler que losrque entre le code envoyer par le blog.
 */
function register($id, $passWrd, $Fname, $Lname, $email, $usrN){
    require 'connect.php';
    require 'secure/hash.php';

    $Nbr = 0;
    $new_key = prompt_key($id, $passWrd);

    try {
        $req = $db->prepare('INSERT INTO writers 
            (First_Nam, Last_Nam, `e-mail`, Nam_writer, Nbr_article, usr_key, passWrd, Rgister_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');

        $req->execute([$Fname, $Lname, $email, $usrN, $Nbr, $new_key, $passWrd]);

        $req->closeCursor();

        return (object)[
            'bool' => true,
            'welcom' => 'Vos informations ont bien été enregistrées.'
        ];

    } catch (PDOException $e) {
        throw new Exception("Erreur SQL : " . implode(" | ", $req->errorInfo()));
    }
}

//CETTE FONCTION A PÔUR BUT DE VERIFIER L'IDENTIFIANT DE DE L'AUTEUR DE LA OUBLICATION AVANT DE L'EFFECTUER.
function validator($id){
    require 'connect.php';

    $req = $db->prepare('SELECT id FROM writers WHERE usr_key = ?');
    $req->execute(array($id));
    $data = $req->fetch();
    $req->closeCursor();
    if (!empty($data) && is_numeric($data)) {
        return true;
    } else {
        return false;
    }
    
    
}
