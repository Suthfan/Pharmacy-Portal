-- Create the database
DROP DATABASE IF EXISTS pharmacy_portal_db;
CREATE DATABASE pharmacy_portal_db;
USE pharmacy_portal_db;

-- Users Table
CREATE TABLE Users (
    userId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(45) NOT NULL UNIQUE,
    contactInfo VARCHAR(200),
    userType ENUM('pharmacist', 'patient') NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Medications Table
CREATE TABLE Medications (
    medicationId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    medicationName VARCHAR(45) NOT NULL,
    dosage VARCHAR(45) NOT NULL,
    manufacturer VARCHAR(100)
);

-- Prescriptions Table
CREATE TABLE Prescriptions (
    prescriptionId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    medicationId INT NOT NULL,
    prescribedDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dosageInstructions VARCHAR(200),
    quantity INT NOT NULL,
    refillCount INT DEFAULT 0,
    FOREIGN KEY (userId) REFERENCES Users(userId) ON DELETE CASCADE,
    FOREIGN KEY (medicationId) REFERENCES Medications(medicationId) ON DELETE CASCADE
);

-- Inventory Table
CREATE TABLE Inventory (
    inventoryId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    medicationId INT NOT NULL,
    quantityAvailable INT NOT NULL,
    lastUpdated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (medicationId) REFERENCES Medications(medicationId) ON DELETE CASCADE
);

-- Sales Table
CREATE TABLE Sales (
    saleId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    prescriptionId INT NOT NULL,
    saleDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    quantitySold INT NOT NULL,
    saleAmount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (prescriptionId) REFERENCES Prescriptions(prescriptionId) ON DELETE CASCADE
);

-- View: MedicationInventoryView
CREATE OR REPLACE VIEW MedicationInventoryView AS
SELECT 
    m.medicationId,
    m.medicationName,
    m.dosage,
    m.manufacturer,
    i.quantityAvailable
FROM Medications m
JOIN Inventory i ON m.medicationId = i.medicationId;

-- Trigger: After inserting prescription, reduce inventory
DELIMITER //
CREATE TRIGGER AfterPrescriptionInsert
AFTER INSERT ON Prescriptions
FOR EACH ROW
BEGIN
    UPDATE Inventory
    SET quantityAvailable = quantityAvailable - NEW.quantity,
        lastUpdated = CURRENT_TIMESTAMP
    WHERE medicationId = NEW.medicationId;

    -- Check for low stock and insert into log if needed (optional)
    -- Example: SELECT 'Stock low for medicationId' ...;
END;
//
DELIMITER ;

-- Stored Procedure: AddOrUpdateUser
DELIMITER //
CREATE PROCEDURE AddOrUpdateUser (
    IN in_userId INT,
    IN in_userName VARCHAR(45),
    IN in_contactInfo VARCHAR(200),
    IN in_userType ENUM('pharmacist', 'patient'),
    IN in_password VARCHAR(255)
)
BEGIN
    IF in_userId IS NULL THEN
        INSERT INTO Users (userName, contactInfo, userType, password)
        VALUES (in_userName, in_contactInfo, in_userType, in_password);
    ELSE
        UPDATE Users
        SET userName = in_userName,
            contactInfo = in_contactInfo,
            userType = in_userType,
            password = in_password
        WHERE userId = in_userId;
    END IF;
END;
//
DELIMITER ;

-- Stored Procedure: ProcessSale
DELIMITER //
CREATE PROCEDURE ProcessSale (
    IN in_prescriptionId INT,
    IN in_quantitySold INT,
    IN in_saleAmount DECIMAL(10,2)
)
BEGIN
    DECLARE medId INT;
    
    SELECT medicationId INTO medId
    FROM Prescriptions
    WHERE prescriptionId = in_prescriptionId;

    INSERT INTO Sales (prescriptionId, quantitySold, saleAmount)
    VALUES (in_prescriptionId, in_quantitySold, in_saleAmount);

    UPDATE Inventory
    SET quantityAvailable = quantityAvailable - in_quantitySold,
        lastUpdated = CURRENT_TIMESTAMP
    WHERE medicationId = medId;
END;
//
DELIMITER ;

-- Insert Sample Data

-- Users
INSERT INTO Users (userName, contactInfo, userType, password) VALUES
('admin1', 'admin@example.com', 'pharmacist', '$2y$10$samplehashedpass1'),
('john_doe', 'john@example.com', 'patient', '$2y$10$samplehashedpass2'),
('jane_smith', 'jane@example.com', 'patient', '$2y$10$samplehashedpass3');

-- Medications
INSERT INTO Medications (medicationName, dosage, manufacturer) VALUES
('Paracetamol', '500mg', 'Pharma Inc.'),
('Ibuprofen', '200mg', 'HealthCorp'),
('Amoxicillin', '250mg', 'BioMed Ltd.');

-- Inventory
INSERT INTO Inventory (medicationId, quantityAvailable) VALUES
(1, 100),
(2, 150),
(3, 200);

-- Prescriptions
INSERT INTO Prescriptions (userId, medicationId, dosageInstructions, quantity) VALUES
(2, 1, 'Take 1 tablet every 6 hours', 10),
(3, 2, 'Take 1 tablet after meals', 15),
(3, 3, 'Take 2 capsules daily', 20);

-- Sales
INSERT INTO Sales (prescriptionId, quantitySold, saleAmount) VALUES
(1, 5, 25.00),
(2, 10, 30.00),
(3, 10, 45.00);
