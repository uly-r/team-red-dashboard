/* Create the database */
CREATE DATABASE IF NOT EXISTS team_red;

/* Switch to team_red database */
USE team_red;

/* Drop existing tables  */
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS quick_links;
DROP TABLE IF EXISTS predefined_icons;
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS notes;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

/* create the tables */
CREATE TABLE quick_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255),
    url TEXT NOT NULL,
    icon_class VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE predefined_icons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    icon_class VARCHAR(50) NOT NULL,
    label VARCHAR(100)
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATE,
    is_completed BOOLEAN DEFAULT FALSE,
    task_priority INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255),
    content TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);