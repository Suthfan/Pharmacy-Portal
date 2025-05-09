<?php
require_once 'PharmacyDatabase.php';

class PharmacyPortal
{
    private $db;

    public function __construct()
    {
        $this->db = new PharmacyDatabase();
    }

    public function handleRequest()
    {
        $action = $_GET['action'] ?? 'home';

        switch ($action) {
            case 'addPrescription':
                $this->addPrescription();
                break;
            case 'viewPrescriptions':
                $this->viewPrescriptions();
                break;
            case 'viewInventory':
                $this->viewInventory();
                break;
            
            case 'addUser':
                $this->addUser();
                break;
            case 'addMedication':
                $this->addMedication();
                break;
            case 'viewSales':
                $this->viewSales();
                break;
            default:
                $this->home();
        }
    }

    private function home()
    {
        include 'templates/home.php';
    }

    private function addPrescription()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $patientUserName = $_POST['patient_username'];
            $medicationId = $_POST['medication_id'];
            $dosageInstructions = $_POST['dosage_instructions'];
            $quantity = $_POST['quantity'];

            $this->db->addPrescription($patientUserName, $medicationId, $dosageInstructions, $quantity);
            header("Location:?action=viewPrescriptions&message=Prescription Added");
        } else {
            include 'templates/addPrescription.php';
        }
    }
    private function viewInventory() {
        $inventory = $this->db->getInventory();
        include 'templates/viewInventory.php';
    }
    private function viewSales() {
        $inventory = $this->db->getInventory();
        include 'templates/viewSales.php';  
    }
    private function addMedication() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $medicationName = $_POST['medication_name'];
            $dosage = $_POST['dosage'];
            $manufacturer = $_POST['manufacturer'];

            $this->db->addMedication($medicationName, $dosage, $manufacturer);
            echo "<p>Medication added successfully!</p>";
        } else {
            include 'templates/addMedication.php'; 
        }
    }
    private function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userName = $_POST['user_name'];
            $contactInfo = $_POST['contact_info'];
            $userType = $_POST['user_type'];
            $password = $_POST['password']; 
            $this->db->addUser($userName, $contactInfo, $userType, $password);
            header("Location:?action=home&message=User Added");
        } else {
            include 'templates/addUser.php';
        }
    }

    private function viewPrescriptions()
    {
        $prescriptions = $this->db->getAllPrescriptions();
        include 'templates/viewPrescriptions.php';
    }
}
$portal = new PharmacyPortal();
$portal->handleRequest();
