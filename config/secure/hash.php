<?php 

/*******  je cherche ici a cree un algorithme qui vas prendre en entree deux variable dont
 * ***** une peut cuntenire des strings pour  générer une suite de caractèrre qui ensemble 
 * ***** forment une valeur unique 
 * ***** l'idéale c'est quqe cette cléf ai minimum 20 carractères
 */
function prompt_key($id, $passWdrd) {
    $min = 20;
    $max = 30;
    $randomVal = random_int($min, $max); // Longueur souhaitée

    // On mélange l'entrée avec un sel aléatoire
    $data = $id . $passWdrd . random_bytes(16);

    // On génère un hash très long
    $hash = hash('sha256', $data);

    // On coupe à la longueur souhaitée (20 à 30 caractères)
    return substr($hash, 0, $randomVal);
}

