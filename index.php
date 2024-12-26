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
            <select id="userSelect">
                <option value="">Sélectionner un utilisateur</option>
                <!-- Les utilisateurs seront ajoutés ici dynamiquement -->
            </select>
        </div>

        <!-- Contenu Principal -->
        <div class="main-content">
            <!-- Statistiques -->
            <div class="statistics">
                <div class="stat-box">
                    <h3>Tâches</h3>
                    <span id="taskCount">0</span>
                </div>
                <div class="stat-box">
                    <h3>Bugs</h3>
                    <span id="bugCount">0</span>
                </div>
                <div class="stat-box">
                    <h3>Features</h3>
                    <span id="featureCount">0</span>
                </div>
            </div>

            <!-- Bouton Ajouter Tâche -->
            <button id="addTaskBtn" class="add-task-btn">+ Nouvelle Tâche</button>

            <!-- Kanban Board -->
            <div class="kanban-board">
                <div class="column todo">
                    <h2>À Faire</h2>
                    <div class="task-list" id="todoList">
                        <!-- Exemple de tâche normale -->
                        <div class="task-card task">
                            <h3>Mettre à jour la documentation</h3>
                            <p>Rédiger la documentation technique du projet</p>
                            <div class="task-info">
                                <span class="assigned-to">👤 Assigné à: 
                                    <select class="user-select">
                                        <option value="">Sélectionner un utilisateur</option>
                                    </select>
                                </span>
                                <select class="status-select">
                                    <option value="todo" selected>À Faire</option>
                                    <option value="in-progress">En Cours</option>
                                    <option value="done">Terminé</option>
                                </select>
                                <a href="#" class="details-link">🔍 Voir détails</a>
                            </div>
                        </div>

                        <!-- Exemple de bug -->
                        <div class="task-card bug">
                            <h3>Erreur d'authentification</h3>
                            <p>Les utilisateurs ne peuvent pas se connecter sur Firefox</p>
                            <div class="task-info">
                                <span class="assigned-to">👤 Assigné à: 
                                    <select class="user-select">
                                        <option value="">Sélectionner un utilisateur</option>
                                    </select>
                                </span>
                                <span class="severity">⚠️ Sévérité: Élevée</span>
                                <select class="status-select">
                                    <option value="todo" selected>À Faire</option>
                                    <option value="in-progress">En Cours</option>
                                    <option value="done">Terminé</option>
                                </select>
                                <a href="#" class="details-link">🔍 Voir détails</a>
                            </div>
                        </div>

                        <!-- Exemple de feature -->
                        <div class="task-card feature">
                            <h3>Mode sombre</h3>
                            <p>Implémenter le thème sombre dans l'application</p>
                            <div class="task-info">
                                <span class="assigned-to">👤 Assigné à: 
                                    <select class="user-select">
                                        <option value="">Sélectionner un utilisateur</option>
                                    </select>
                                </span>
                                <span class="priority">🎯 Priorité: Moyenne</span>
                                <select class="status-select">
                                    <option value="todo">À Faire</option>
                                    <option value="in-progress" selected>En Cours</option>
                                    <option value="done">Terminé</option>
                                </select>
                                <a href="#" class="details-link">🔍 Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="column in-progress">
                    <h2>En Cours</h2>
                    <div class="task-list" id="inProgressList">
                        <!-- Les tâches seront ajoutées ici -->
                    </div>
                </div>

                <div class="column done">
                    <h2>Terminé</h2>
                    <div class="task-list" id="doneList">
                        <!-- Les tâches seront ajoutées ici -->
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
            <form id="taskForm" method="POST" action="">
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

    <!-- Modal Détails -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <h2>Détails de la tâche</h2>
            <div class="task-details">
                <h3 id="taskTitle">Titre de la tâche</h3>
                <p id="taskDescription">Description de la tâche</p>
                <div class="details-info">
                    <p>Assigné à: <span id="taskAssignee">Utilisateur</span></p>
                    <p>Statut: <span id="taskStatus">Statut</span></p>
                    <p>Type: <span id="taskType">Type</span></p>
                    <p id="severityField">Sévérité: <span id="taskSeverity">-</span></p>
                    <p id="priorityField">Priorité: <span id="taskPriority">-</span></p>
                    <p>Créé le: <span id="taskCreatedAt">Date</span></p>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>