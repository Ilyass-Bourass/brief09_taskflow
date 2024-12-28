<?php
require_once __DIR__ . "/classes/Database.php";
require_once __DIR__ . "/classes/Task.php";

if($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $id_task=$_GET['id'];
    $database = new Database();
    $db = $database->getConnection();

    $task = new Task($db, "", "", "");
    $task=$task->getTask($id_task);
}
?> 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la tâche</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="details-page-container">
        <div class="details-header">
            <h1>Titre : <?php echo $task['title']; ?></h1> 
            <span class="creation-date">Créée le:<?php echo $task['created_at']; ?></span>
        </div>

        <div class="details-content">
            <div class="details-grid">
                <div class="details-item">
                    <div class="details-label">Description</div>
                    <p><?php echo $task['description']; ?></p>
                </div>

                <div class="details-item">
                    <div class="details-label">Type</div>
                    <p><?php echo $task['type']; ?></p>
                </div>

                <div class="details-item">
                    <div class="details-label">Statut</div>
                    <p><?php echo $task['status']; ?></p>
                </div>

                <div class="details-item">
                    <div class="details-label">Assigné à</div>
                    <p><?php echo $task['assigned_to']; ?></p>
                </div>

                <div class="details-item severity">
                    <div class="details-label">Sévérité</div>
                    <p><?php echo $task['severity']; ?></p>
                </div>

                <div class="details-item priority">
                    <div class="details-label">Priorité</div>
                    <p><?php echo $task['priority']; ?></p>
                </div>
            </div>
        </div>

        <a href="index.php" class="back-button">Retour au tableau</a>
    </div>
</body>
</html> 