<?php 

    $db = new PDO ('mysql:host=127.0.0.1;dbname=db_blog','root','');
    $db->setAttribute (attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_WARNING);


?>