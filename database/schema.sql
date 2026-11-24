CREATE DATABASE IF NOT EXISTS roadtrip_db CHARACTER SET utf8mb4;
USE roadtrip_db;
CREATE TABLE users(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  first_name VARCHAR(60) NULL,
  last_name VARCHAR(60) NULL,
  middle_initial VARCHAR(10) NULL,
  suffix VARCHAR(20) NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  phone VARCHAR(20) NULL,
  id_type VARCHAR(50) NULL,
  id_number VARCHAR(50) NULL,
  kyc_verified TINYINT(1) DEFAULT 0,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','staff','traveler') NOT NULL DEFAULT 'traveler',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE destinations(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  region VARCHAR(80) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE trips(
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(120) NOT NULL,
  destination VARCHAR(120) NULL,
  budget DECIMAL(10,2) DEFAULT 0,
  stay_type VARCHAR(50) DEFAULT 'hotel',
  stay_cost DECIMAL(10,2) DEFAULT 0,
  start_date DATE, end_date DATE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE bookings(
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  destination_id INT NOT NULL,
  travel_date DATE NOT NULL,
  pax INT NOT NULL DEFAULT 1,
  total DECIMAL(10,2) NOT NULL,
  status ENUM('pending','confirmed','delayed','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE CASCADE
);
CREATE TABLE itineraries(
  id INT AUTO_INCREMENT PRIMARY KEY,
  trip_id INT NOT NULL, day_no INT NOT NULL, activity VARCHAR(255) NOT NULL,
  FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE
);
CREATE TABLE expenses(
  id INT AUTO_INCREMENT PRIMARY KEY,
  trip_id INT NOT NULL, category VARCHAR(60) NOT NULL, amount DECIMAL(10,2) NOT NULL, note VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE
);
-- Default logins: admin@roadtrip.local / admin123 and traveler@roadtrip.local / admin123
INSERT INTO users(name,email,password_hash,role) VALUES('Admin','admin@roadtrip.local','$2y$12$UCmHOWBnBW/wrNpYG4kQQeNe0diCXsXI6GKHk7wXxkF35e6Ljj4c6','admin');
INSERT INTO users(name,email,password_hash,role) VALUES('Traveler Demo','traveler@roadtrip.local','$2y$12$UCmHOWBnBW/wrNpYG4kQQeNe0diCXsXI6GKHk7wXxkF35e6Ljj4c6','traveler');
INSERT INTO destinations(name,region,description,price) VALUES
('Cebu City','Visayas','Heritage sites and beaches',3200),
('Puerto Princesa','Palawan','Underground river tour',4800),
('Davao City','Mindanao','Mt. Apo and Eden Nature Park',3900);
CREATE TABLE IF NOT EXISTS flights(
  id INT AUTO_INCREMENT PRIMARY KEY,
  origin CHAR(3) NOT NULL, dest CHAR(3) NOT NULL,
  depart_at DATETIME NOT NULL, duration_min INT NOT NULL,
  airline VARCHAR(60) NOT NULL, flight_no VARCHAR(10) NOT NULL,
  price DECIMAL(10,2) NOT NULL, seats INT NOT NULL DEFAULT 150,
  UNIQUE KEY uq_flight(origin,dest,depart_at,flight_no),
  INDEX(origin,dest,depart_at)
);
CREATE TABLE IF NOT EXISTS flight_bookings(
  id INT AUTO_INCREMENT PRIMARY KEY,
  ref VARCHAR(12) NOT NULL UNIQUE,
  user_id INT NOT NULL, flight_id INT NOT NULL, return_flight_id INT NULL,
  pax INT NOT NULL,
  contact_phone VARCHAR(20) NULL,
  contact_email VARCHAR(120) NULL,
  kyc_id_type VARCHAR(50) NULL,
  kyc_id_number VARCHAR(50) NULL,
  total DECIMAL(10,2) NOT NULL,
  status ENUM('confirmed','delayed','cancelled') DEFAULT 'confirmed',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY(flight_id) REFERENCES flights(id),
  FOREIGN KEY(return_flight_id) REFERENCES flights(id)
);
