<?php
require_once __DIR__ . "/../classes/Database.php";
require_once __DIR__ . "/../classes/Task.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    $taskId = $_POST['taskId'];
    $newStatus = $_POST['status'];

    $task = new Task($db, "", "", "");
    
    if($task->updateStatus($taskId, $newStatus)) {
        header("Location: ../index.php");
    } else {
        header("Location: ../index.php?error=1");
    }
    exit();
}
?> 