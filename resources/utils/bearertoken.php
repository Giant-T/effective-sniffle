<?php
// Utilisation > php nomDuScript.php nomUsager motDePasse
$user = $argv[1];
$password = $argv[2];

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$token = base64_encode("username:" . $user . " password:" . $password);

// Le mot de passe hashé, peut être utilisé pour ajouter manuellement le mot
// de passe dans la table users de la BD ou bien en utilisant la route de création d'usager
echo "Mot de passe hashé : " . $hashedPassword . "\n";
// Ce qui doit être ajouté dans l'entête de la requête http
echo "Bearer token : " . $token;
