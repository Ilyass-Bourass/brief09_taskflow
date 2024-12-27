<?php
require_once __DIR__ . "/../classes/Database.php";
require_once __DIR__ . "/../classes/User.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database=new Database();
    $db=$database->getConnection();

    $name=$_POST['name'];
    $email=$_POST['email'];

    $user=new USER ($db, $name,$email);

    if($user->create()){
        echo "inscription réussie";
        header("Location: ../index.php");
    }else{
        echo "Erreur lors de l'inscription";
    }
}
?> 