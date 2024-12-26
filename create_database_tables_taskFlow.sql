DROP DATABASE IF EXISTS taskflow;
CREATE DATABASE taskflow;
use taskflow ;
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);
CREATE TABLE tasks (
    id_task INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('to-do', 'in-progress', 'done') DEFAULT 'to-do',
    id_user INT,
    type ENUM('task', 'bug', 'feature') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);
CREATE TABLE bugs (
    id_bug INT PRIMARY KEY,
    id_task INT ,
    severity ENUM('low', 'medium', 'high') NOT NULL,
    FOREIGN KEY ( id_task) REFERENCES tasks( id_task) ON DELETE CASCADE
);
CREATE TABLE features (
    id_feature INT PRIMARY KEY,
    id_task INT ,
    priority ENUM('low', 'medium', 'high') NOT NULL,
    FOREIGN KEY (id_task) REFERENCES tasks(id_task) ON DELETE CASCADE
);
