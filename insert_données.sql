-- Insérer des utilisateurs
use taskflow ;
INSERT INTO users (name, email) VALUES 
('Alice', 'alice@example.com'),
('Bob', 'bob@example.com'),
('Charlie', 'charlie@example.com');

-- Insérer des tâches normales
INSERT INTO tasks (title, description, status, id_user, type) VALUES 
('Prepare Documentation', 'Write detailed project documentation', 'done', 1, 'task'),
('Team Meeting', 'Organize a team meeting to discuss updates', 'to-do', 2, 'task');

-- Insérer des bugs
INSERT INTO tasks (title, description, status, id_user, type) VALUES 
('Fix Login Bug', 'Resolve the login issue for admin users', 'to-do', 1, 'bug'),
('UI Overlap Issue', 'Fix the overlap issue in the header', 'in-progress', 3, 'bug');

-- Insérer des features
INSERT INTO tasks (title, description, status, id_user, type) VALUES 
('Add Dark Mode', 'Implement dark mode for the application', 'in-progress', 2, 'feature'),
('Multi-Language Support', 'Add support for multiple languages', 'to-do', 3, 'feature');

-- Insérer des bugs dans la table `bugs`
INSERT INTO bugs (id_task, severity) VALUES 
(3, 'high'), -- Le bug "Fix Login Bug"
(4, 'medium'); -- Le bug "UI Overlap Issue"

-- Insérer des features dans la table `features`
INSERT INTO features (id_task, priority) VALUES 
(5, 'high'), -- La feature "Add Dark Mode"
(6, 'medium'); -- La feature "Multi-Language Support"
