<?php
if (!empty($_GET)) {
    # code...
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins_Panel</title>
</head>
<body>
    <form action="validation.php" method="post">
        <fieldset>
            <legend>validez-vous cette demande d'admission</legend>
            <p>oui: <input type="checkbox" name="oui" id="oui">non: <input type="checkbox" name="non" id="non"></p>
            <button type="submit">Validez</button>
        </fieldset>
    </form>
</body>
</html>