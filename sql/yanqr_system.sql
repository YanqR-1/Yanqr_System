-- Create database
CREATE DATABASE IF NOT EXISTS yanqr_social;
USE yanqr_social;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    bio TEXT,
    profile_image VARCHAR(255) DEFAULT 'default-avatar.png',
    cover_image VARCHAR(255) DEFAULT 'default-cover.jpg',
    location VARCHAR(100),
    website VARCHAR(255),
    favorite_game VARCHAR(100),
    level INT DEFAULT 1,
    xp INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Posts table
CREATE TABLE posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    game_tag VARCHAR(100),
    like_count INT DEFAULT 0,
    comment_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Comments table
CREATE TABLE comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Likes table
CREATE TABLE likes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_like (post_id, user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample users with DIFFERENT profile images
-- Password for all users is 'password123'
INSERT INTO users (username, email, password, full_name, bio, profile_image, location, favorite_game) VALUES
('Kaizenn', 'Alkenbacs@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Kaizenm', 'Professional gamer and streamer', 'profile_1_default.jpg', 'Nasipit', 'The Mikmik'),
('YanqR', 'Giancant3@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'YanqR', 'Game developer and artist', 'profile_3_default.jpg', 'Buenavista', 'Adopt Me'),

-- Insert sample posts
INSERT INTO posts (user_id, content, game_tag, like_count, comment_count) VALUES
(1, 'Just reached level 50 in Adventure Quest! So excited! 🎮', 'Adventure Quest', 45, 12),
(2, 'Check out this new character design I created', 'Battle Arena', 78, 23),

-- Insert sample comments
INSERT INTO comments (post_id, user_id, content) VALUES
(1, 2, 'Congrats! That\'s amazing!'),
(1, 3, 'Wow, you\'re so good!'),

-- Insert sample likes
INSERT INTO likes (post_id, user_id) VALUES
(1, 2), (1, 3), (2, 1), (3, 1), (3, 2);