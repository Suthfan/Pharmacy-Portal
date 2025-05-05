<?php
class PharmacyDatabase
{
    private $host = "localhost";
    private $port = "3306";
    private $database = "pharmacy_portal_db";
    private $user = "root";
    private $password = "";
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        echo "Successfully connected to the database";
    }
    
    public function validateUser($userName, $password) {
        // Prepare the SQL query to select the user by userName
        $stmt = $this->connection->prepare(
            "SELECT userId, userName, userType, password FROM Users WHERE userName = ?"
        );
    
        if ($stmt === false) {
            die('Database query preparation failed: ' . $this->connection->error);
        }
    
        // Bind parameters and execute the statement
        $stmt->bind_param("s", $userName);
        $stmt->execute();
    
        // Bind the result to variables
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user) {
            $userId = $user['userId'];
            $userName = $user['userName'];
            $userType = $user['userType'];
            $storedPassword = $user['password'];
        } else {
            return null; // User not found
        }
    
        // Verify the entered password with the stored hashed password
        if ($userId && password_verify($password, $storedPassword)) {
            return ['userId' => $userId, 'userName' => $userName, 'userType' => $userType];
        } else {
            return null;  // Invalid credentials
        }
    }
    


    public function addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity)
    {
        $stmt = $this->connection->prepare(
            "SELECT userId FROM Users WHERE userName = ? AND userType = 'patient'"
        );
        $stmt->bind_param("s", $patientUserName);
        $stmt->execute();
        $patientId = null;
        $stmt->bind_result($patientId);
        $stmt->fetch();
        $stmt->close();

        if ($patientId) {
            $stmt = $this->connection->prepare(
                "INSERT INTO prescriptions (userId, medicationId, dosageInstructions, quantity) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("iisi", $patientId, $medicationId, $dosageInstructions, $quantity);
            $stmt->execute();
            $stmt->close();
            echo "Prescription added successfully";
        } else {
            echo "failed to add prescription";
        }
    }

    public function getAllPrescriptions()
    {
        $result = $this->connection->query("SELECT * FROM  prescriptions join medications on prescriptions.medicationId= medications.medicationId");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addOrGetUser($userName, $contactInfo, $userType)
    {
        // Check if user exists
        $stmt = $this->connection->prepare("SELECT userId FROM Users WHERE userName = ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $userId = null;
        $stmt->bind_result($userId);
        if ($stmt->fetch()) {
            $stmt->close();
            return $userId;
        }
        $stmt->close();

        // If not, insert new user
        $stmt = $this->connection->prepare(
            "INSERT INTO Users (userName, contactInfo, userType) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $userName, $contactInfo, $userType);
        if ($stmt->execute()) {
            $userId = $stmt->insert_id;
            $stmt->close();
            return $userId;
        }
        $stmt->close();
        return null;
    }
    
    public function getUserDetails($userId)
    {
        $stmt = $this->connection->prepare("SELECT * FROM Users WHERE userId = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }


    public function MedicationInventory()
    {
        $result = $this->connection->query("SELECT * FROM MedicationInventoryView");
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    // Add this function to PharmacyDatabase.php
    public function addUser($userName, $contactInfo, $userType, $password)
    {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the query to insert the new user
        $stmt = $this->connection->prepare(
            "INSERT INTO Users (userName, contactInfo, userType, password) VALUES (?, ?, ?, ?)"
        );
        if ($stmt === false) {
            // Log the error
            die('Database query preparation failed: ' . $this->connection->error);
        }

        // Bind the parameters (userName, contactInfo, userType, hashed password)
        $stmt->bind_param("ssss", $userName, $contactInfo, $userType, $hashedPassword);
        $stmt->execute();

        // Check if the insertion was successful
        if ($stmt->affected_rows > 0) {
            echo "User added successfully!";
        } else {
            echo "Failed to add user.";
        }

        // Close the statement
        $stmt->close();
    }

    public function addMedication($medicationName, $dosage, $manufacturer) {
        // Prepare the SQL statement to insert medication
        $stmt = $this->connection->prepare("INSERT INTO medications (medicationName, dosage, manufacturer) VALUES (?, ?, ?)");
        if ($stmt === false) {
            return false; // If prepare fails
        }
        
        // Bind parameters
        $stmt->bind_param("sss", $medicationName, $dosage, $manufacturer);
        
        // Execute the statement
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
    public function getSales() {
        $query = "
            SELECT s.saleId, s.prescriptionId, s.saleDate, s.quantitySold, s.saleAmount, p.dosageInstructions, m.medicationName
            FROM sales s
            JOIN prescriptions p ON s.prescriptionId = p.prescriptionId
            JOIN medications m ON p.medicationId = m.medicationId
        ";

        $result = $this->connection->query($query);
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
    public function getInventory() {
        $query = "
            SELECT medications.medicationName, medications.dosage, medications.manufacturer, inventory.quantityAvailable 
            FROM inventory
            INNER JOIN medications ON inventory.medicationId = medications.medicationId
        ";
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    


    //Add Other needed functions here
}
