-- Create the 'users' table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    username VARCHAR(50) UNIQUE,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    reg_date DATE
);

-- Create the 'posts' table
CREATE TABLE posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(100),
    description TEXT,
    image VARCHAR(255),
    post_time TIME,
    post_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) 
        ON DELETE CASCADE   -- Delete posts when the user is deleted
        ON UPDATE CASCADE   -- Update user_id in posts when user_id is updated
);

-- Create the 'reserved_posts' table
CREATE TABLE reserved_posts (
    reserve_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(100),
    description TEXT,
    image VARCHAR(255),
    post_time TIME,
    post_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) 
        ON DELETE CASCADE   -- Delete reserved_posts when the user is deleted
        ON UPDATE CASCADE   -- Update user_id in reserved_posts when user_id is updated
);
