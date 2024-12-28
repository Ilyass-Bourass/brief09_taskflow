<?php
require_once __DIR__ . "/classes/Database.php";
require_once __DIR__ . "/classes/Task.php";
require_once __DIR__ . "/classes/user.php";


$database = new Database();
$db = $database->getConnection();


$userObj = new User($db, "", "");
$users = $userObj->getAllUser();


$task = new Task($db, "", "", "");


if(isset($_POST['userID']) && !empty($_POST['userID'])) {
   
    $tasks = $task->getAllTasksUser($_POST['userID']);
} else {

    $tasks = $task->getAllTasks();
}

$taskCount = 0;
$bugCount = 0;
$featureCount = 0;

foreach($tasks as $task) {
    switch($task['type']) {
        case 'task':
            $taskCount++;
            break;
        case 'bug':
            $bugCount++;
            break;
        case 'feature':
            $featureCount++;
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">TaskFlow</div>
        <div class="auth-buttons">
            <button id="btnInscription">Inscription</button>
            <button id="btnConnexion">Connexion</button>
        </div>
    </header>

    <div class="main-container">
        <!-- Sidebar Gauche -->
        <div class="sidebar">
            <h2>Dashboard Admin</h2>
           <form method="POST" action="">
           <select name="userID" onchange="this.form.submit()">
                <option value="">Tous les utilisateurs</option>
                <?php foreach($users as $user): ?>
                    <option value="<?php echo $user['id_user']; ?>" 
                        <?php echo (isset($_POST['userID']) && $_POST['userID'] == $user['id_user']) ? 'selected' : ''; ?>>
                        <?php echo $user['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
           </form>
        </div>

        <!-- Contenu Principal -->
        <div class="main-content">
            <!-- Statistiques -->
            <div class="statistics">
                <div class="stat-box">
                    <h3>Tâches</h3>
                    <span id="taskCount"><?php echo $taskCount; ?></span>
                </div>
                <div class="stat-box">
                    <h3>Bugs</h3>
                    <span id="bugCount"><?php echo $bugCount; ?></span>
                </div>
                <div class="stat-box">
                    <h3>Features</h3>
                    <span id="featureCount"><?php echo $featureCount; ?></span>
                </div>
            </div>

            <!-- Bouton Ajouter Tâche -->
            <button id="addTaskBtn" class="add-task-btn">+ Nouvelle Tâche</button>

            <!-- Kanban Board -->
            <div class="kanban-board">
                <div class="column todo">
                    <h2>À Faire</h2>
                    <div class="task-list" id="todoList">
                        <?php foreach($tasks as $task): ?>
                            <?php if($task['status'] === 'to-do'): ?>
                                <div class="task-card <?php echo $task['type']; ?>">
                                    <h3><?php echo $task['title']; ?></h3>
                                    <p><?php echo $task['description']; ?></p>
                                    <div class="task-info">
                                        <span class="assigned-to">👤 Assigné à: 
                                            <form action="actions/assign_task.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="taskId" value="<?php echo $task['id_task']; ?>">
                                                <select name="userId" onchange="this.form.submit()">
                                                    <option value="">Sélectionner un utilisateur</option>
                                                    <?php foreach($users as $user): ?>
                                                        <option value="<?php echo $user['id_user']; ?>" 
                                                            <?php echo ($user['id_user'] == $task['id_user']) ? 'selected' : ''; ?>>
                                                            <?php echo $user['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </form>
                                        </span>
                                        
                                        <?php if($task['type'] === 'bug'): ?>
                                            <span class="severity">⚠️ Sévérité: <?php echo $task['severity']; ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if($task['type'] === 'feature'): ?>
                                            <span class="priority">🎯 Priorité: <?php echo $task['priority']; ?></span>
                                        <?php endif; ?>
                                        
                                        <div class="divStatusPlusdétails" >
                                            <form action="actions/update_status.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="taskId" value="<?php echo $task['id_task']; ?>">
                                                <select name="status" onchange="this.form.submit()">
                                                    <option value="to-do" <?php echo ($task['status'] === 'to-do') ? 'selected' : ''; ?>>À Faire</option>
                                                    <option value="in-progress" <?php echo ($task['status'] === 'in-progress') ? 'selected' : ''; ?>>En Cours</option>
                                                    <option value="done" <?php echo ($task['status'] === 'done') ? 'selected' : ''; ?>>Terminé</option>
                                                </select>
                                            </form>
                                            <a href="task_détails.php?id=<?php echo $task['id_task'] ?>" class="details-link">🔍 Voir détails</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="column in-progress">
                    <h2>En Cours</h2>
                    <div class="task-list" id="inProgressList">
                        <?php foreach($tasks as $task): ?>
                            <?php if($task['status'] === 'in-progress'): ?>
                                <div class="task-card <?php echo $task['type']; ?>">
                                    <h3><?php echo $task['title']; ?></h3>
                                    <p><?php echo $task['description']; ?></p>
                                    <div class="task-info">
                                        <span class="assigned-to">👤 Assigné à: 
                                            <form action="actions/assign_task.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="taskId" value="<?php echo $task['id_task']; ?>">
                                                <select name="userId" onchange="this.form.submit()">
                                                    <option value="">Sélectionner un utilisateur</option>
                                                    <?php foreach($users as $user): ?>
                                                        <option value="<?php echo $user['id_user']; ?>" 
                                                            <?php echo ($user['id_user'] == $task['id_user']) ? 'selected' : ''; ?>>
                                                            <?php echo $user['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </form>
                                        </span>
                                        
                                        <?php if($task['type'] === 'bug'): ?>
                                            <span class="severity">⚠️ Sévérité: <?php echo $task['severity']; ?></span>
                                        <?php endif; ?>
                                        <?php if($task['type'] === 'feature'): ?>
                                            <span class="priority">🎯 Priorité: <?php echo $task['priority']; ?></span>
                                        <?php endif; ?>
                                        <div class="divStatusPlusdétails" >
                                            <form action="actions/update_status.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="taskId" value="<?php echo $task['id_task']; ?>">
                                                <select name="status" onchange="this.form.submit()">
                                                    <option value="to-do" <?php echo ($task['status'] === 'to-do') ? 'selected' : ''; ?>>À Faire</option>
                                                    <option value="in-progress" <?php echo ($task['status'] === 'in-progress') ? 'selected' : ''; ?>>En Cours</option>
                                                    <option value="done" <?php echo ($task['status'] === 'done') ? 'selected' : ''; ?>>Terminé</option>
                                                </select>
                                            </form>
                                            <a href="task_détails.php?id=<?php echo $task['id_task'] ?>" class="details-link">🔍 Voir détails</a>
                                        </div>
                                        
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="column done">
                    <h2>Terminé</h2>
                    <div class="task-list" id="doneList">
                        <?php foreach($tasks as $task): ?>
                            <?php if($task['status'] === 'done'): ?>
                                <div class="task-card <?php echo $task['type']; ?>">
                                    <h3><?php echo $task['title']; ?></h3>
                                    <p><?php echo $task['description']; ?></p>
                                    <div class="task-info">
                                        <span class="assigned-to">👤 Assigné à: 
                                            <form action="actions/assign_task.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="taskId" value="<?php echo $task['id_task']; ?>">
                                                <select name="userId" onchange="this.form.submit()">
                                                    <option value="">Sélectionner un utilisateur</option>
                                                    <?php foreach($users as $user): ?>
                                                        <option value="<?php echo $user['id_user']; ?>" 
                                                            <?php echo ($user['id_user'] == $task['id_user']) ? 'selected' : ''; ?>>
                                                            <?php echo $user['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </form>
                                        </span>
                                        
                                        <?php if($task['type'] === 'bug'): ?>
                                            <span class="severity">⚠️ Sévérité: <?php echo $task['severity']; ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if($task['type'] === 'feature'): ?>
                                            <span class="priority">🎯 Priorité: <?php echo $task['priority']; ?></span>
                                        <?php endif; ?>
                                        <div class="divStatusPlusdétails" >
                                            <form action="actions/update_status.php" method="POST" style="display: inline;">
                                                <input type="hidden" name="taskId" value="<?php echo $task['id_task']; ?>">
                                                <select name="status" onchange="this.form.submit()">
                                                    <option value="to-do" <?php echo ($task['status'] === 'to-do') ? 'selected' : ''; ?>>À Faire</option>
                                                    <option value="in-progress" <?php echo ($task['status'] === 'in-progress') ? 'selected' : ''; ?>>En Cours</option>
                                                    <option value="done" <?php echo ($task['status'] === 'done') ? 'selected' : ''; ?>>Terminé</option>
                                                </select>
                                            </form>
                                            <a href="task_détails.php?id=<?php echo $task['id_task'] ?>" class="details-link">🔍 Voir détails</a>
                                        </div>
                                        
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Inscription -->
    <div id="inscriptionModal" class="modal">
        <div class="modal-content">
            <h2>Inscription</h2>
            <form id="inscriptionForm" method="POST" action="actions/register.php">
                <input type="text" name="name" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>

    <!-- Modal Nouvelle Tâche -->
    <div id="taskModal" class="modal">
        <div class="modal-content">
            <h2>Nouvelle Tâche</h2>
            <form id="taskForm" method="POST" action="actions/add_task.php">
                <input type="text" name="title" placeholder="Titre" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <select id="taskType" name="type">
                    <option value="task">Tâche Simple</option>
                    <option value="bug">Bug</option>
                    <option value="feature">Feature</option>
                </select>
                <!-- Champs spécifiques pour les bugs -->
                <div id="bugFields" style="display: none;">
                    <select name="severity">
                        <option value="low">Faible</option>
                        <option value="medium">Moyen</option>
                        <option value="high">Élevé</option>
                    </select>
                </div>
                <!-- Champs spécifiques pour les features -->
                <div id="featureFields" style="display: none;">
                    <select name="priority">
                        <option value="low">Faible</option>
                        <option value="medium">Moyen</option>
                        <option value="high">Élevé</option>
                    </select>
                </div>
                <button type="submit">Créer</button>


                
            </form>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>