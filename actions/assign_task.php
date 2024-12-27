<?php
require_once __DIR__ . "/../classes/Database.php";
require_once __DIR__ . "/../classes/Task.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    $taskId = $_POST['taskId'];
    $userId = $_POST['userId'];

    $task = new Task($db, "", "", "");
    
    if($task->assignTask($taskId, $userId)) {
        echo "success";
        header("Location: ../index.php");
    } else {
        echo "error";
    }
}
?> 