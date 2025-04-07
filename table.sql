CREATE DATABASE apothecare;
USE apothecare;

-- Gebruiker tabel met role
CREATE TABLE gebruiker (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    wachtwoord VARCHAR(255) NOT NULL,
    adres TEXT NOT NULL,
    telefoon_nummer VARCHAR(20) NOT NULL,
    role ENUM('user', 'personeel') NOT NULL DEFAULT 'user'
);


-- Product tabel (moet vóór recepten aangemaakt worden)
CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_naam VARCHAR(255) NOT NULL,
    product_beschrijving TEXT NOT NULL,
    product_prijs DECIMAL(10,2) NOT NULL,
    product_voorraad INT NOT NULL
);

-- Recepten tabel (nu met correcte foreign keys)
CREATE TABLE recepten (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gebruiker_id INT NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (gebruiker_id) REFERENCES gebruiker(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

-- Admin tabel
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gebruiker_id INT UNIQUE NOT NULL,
    rechten_id INT NOT NULL,
    FOREIGN KEY (gebruiker_id) REFERENCES gebruiker(id) ON DELETE CASCADE
);

-- Voorraad tabel
CREATE TABLE voorraad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNIQUE NOT NULL,
    product_voorraad INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

-- Chatbot tabel
CREATE TABLE chatbot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gebruiker_id INT NOT NULL,
    gebruiker_bericht TEXT NOT NULL,
    ai_bericht TEXT NOT NULL,
    FOREIGN KEY (gebruiker_id) REFERENCES gebruiker(id) ON DELETE CASCADE
);

-- bestelling
CREATE TABLE bestelling (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gebruiker_id INT NOT NULL,
    product_id INT NOT NULL,
    prijs DECIMAL(10,2) NOT NULL,
    status_bestelling VARCHAR(50) NOT NULL,
    artikel_aantal INT NOT NULL,
    gebruiker_adres TEXT NOT NULL,
    totaal_prijs DECIMAL(10,2) NOT NULL,
    bestel_datum DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    aflever_datum DATETIME,
    FOREIGN KEY (gebruiker_id) REFERENCES gebruiker(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

--
ALTER TABLE product ADD COLUMN product_afbeelding VARCHAR(255) AFTER product_voorraad;