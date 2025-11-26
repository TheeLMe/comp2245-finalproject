DROP DATABASE IF EXISTS dolphin_crm;
CREATE DATABASE dolphin_crm;
USE dolphin_crm;

-- Create USERS table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    password VARCHAR(255),
    email VARCHAR(150) UNIQUE,
    role VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create CONTACTS table
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(20),
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    email VARCHAR(150),
    telephone VARCHAR(50),
    company VARCHAR(150),
    type VARCHAR(20), -- Sales Lead or Support
    assigned_to INT,
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES users(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Create NOTES table
CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT,
    comment TEXT,
    created_by INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contact_id) REFERENCES contacts(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Insert required admin user (hashed password)
INSERT INTO users (firstname, lastname, email, password, role)
VALUES (
    'Admin',
    'User',
    'admin@project2.com',
    '$2y$10$9kWfRTY6aIpiI5yAx7AnZ.7rwhhtjfiPgk41IrT9jpJ1rssZCvSO6',
    'admin'
);

-- Grant all privileges to the admin user
CREATE USER 'AdminUser'@'localhost' IDENTIFIED BY 'password123';
GRANT ALL PRIVILEGES ON dolphin_crm.* TO 'AdminUser'@'localhost' IDENTIFIED BY 'password123';