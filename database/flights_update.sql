USE roadtrip_db;
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
  pax INT NOT NULL, total DECIMAL(10,2) NOT NULL,
  status ENUM('confirmed','cancelled') DEFAULT 'confirmed',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY(flight_id) REFERENCES flights(id),
  FOREIGN KEY(return_flight_id) REFERENCES flights(id)
);
