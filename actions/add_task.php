<?php
require_once __DIR__ . "/../classes/Database.php";
require_once __DIR__ . "/../classes/Task.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    $title = $_POST['title'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    
    // Initialiser severity et priority à null
    $severity = null;
    $priority = null;

    // Récupérer severity si c'est un bug
    if($type === 'bug') {
        $severity = $_POST['severity'];
    }
    
    // Récupérer priority si c'est une feature
    if($type === 'feature') {
        $priority = $_POST['priority'];
    }

    $task = new Task($db, $title, $description, $type, $severity, $priority);

    if($task->addTask()) {
        header("Location: ../index.php?success=1");
        exit();
    } else {
        header("Location: ../index.php?error=1");
        exit();
    }
}
?> 