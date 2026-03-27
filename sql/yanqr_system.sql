-- Create database if not exists
CREATE DATABASE IF NOT EXISTS yanqr_system;
USE yanqr_system;

-- Create users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    bio TEXT,
    avatar VARCHAR(255) DEFAULT 'default-avatar.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create posts table
CREATE TABLE posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    likes_count INT DEFAULT 0,
    comments_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create comments table
CREATE TABLE comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create likes table
CREATE TABLE likes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_like (post_id, user_id)
);

-- Insert sample users (password is '123456' for all)
INSERT INTO users (username, email, password, full_name, bio) VALUES
('Yanqr', 'Gian@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'YanqR', 'Professional gamer'),
('Kaizen', 'Alken@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'KAIZENN', 'Game developer'),
('Chackmamba', 'Ford@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'FORD', 'Competitive gaming');

-- Insert sample posts
INSERT INTO posts (user_id, content) VALUES
(1, 'Hello everyone! Welcome to YanqR! 🎮 This is awesome!'),
(2, 'Just finished developing a new game feature! Excited to share it!'),
(1, 'Anyone want to play together tonight?'),
(3, 'Check out my new gaming setup! It\'s amazing!');

-- Insert sample comments
INSERT INTO comments (post_id, user_id, content) VALUES
(1, 2, 'Welcome! Great to have you here!'),
(1, 3, 'This platform looks awesome!'),
(2, 1, 'Congratulations! Can\'t wait to see it!'),
(3, 2, 'I\'m in! What game are we playing?');

-- Insert sample likes
INSERT INTO likes (post_id, user_id) VALUES
(1, 2), (1, 3), (2, 1), (3, 1), (4, 2);