<?php
require_once 'database.php';

try {
    $pdo = Database::connect();
    
    // Create users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        role ENUM('admin', 'staff') DEFAULT 'staff',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Create patients table
    $pdo->exec("CREATE TABLE IF NOT EXISTS patients (
        id INT PRIMARY KEY AUTO_INCREMENT,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        birth_date DATE,
        gender ENUM('male', 'female', 'other'),
        contact VARCHAR(15) NOT NULL,
        email VARCHAR(100),
        address TEXT,
        medical_history TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Create appointments table
    $pdo->exec("CREATE TABLE IF NOT EXISTS appointments (
        id INT PRIMARY KEY AUTO_INCREMENT,
        patient_id INT NOT NULL,
        user_id INT NOT NULL,
        appointment_date DATETIME NOT NULL,
        treatment VARCHAR(100) NOT NULL,
        notes TEXT,
        status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    // Create treatments table
    $pdo->exec("CREATE TABLE IF NOT EXISTS treatments (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        cost DECIMAL(10,2) NOT NULL,
        duration INT NOT NULL COMMENT 'Duration in minutes'
    )");

    // Create payments table
    $pdo->exec("CREATE TABLE IF NOT EXISTS payments (
        id INT PRIMARY KEY AUTO_INCREMENT,
        appointment_id INT NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        payment_method ENUM('cash', 'card', 'insurance') NOT NULL,
        payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        notes TEXT,
        FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE
    )");

    // Insert default admin user
    $stmt = $pdo->prepare("INSERT INTO users (username, password, full_name, role) 
                          VALUES (?, ?, ?, 'admin')");
    $stmt->execute([
        'admin',
        password_hash('admin123', PASSWORD_DEFAULT),
        'System Administrator'
    ]);

    echo "Database tables created successfully!";
} catch (PDOException $e) {
    die("Migration failed: ".$e->getMessage());
}