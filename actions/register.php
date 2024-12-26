<?php
require_once __DIR__ . "/../classes/Database.php";
require_once __DIR__ . "/../classes/User.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $database = new Database();
    $db = $database->getConnection();

    
    $user = new User($db);
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];

    if($user->create()) {
        echo "Inscription réussie";
        header("Location: ../index.php");
    } else {
        echo "Erreur lors de l'inscription";
    }
}
?> 