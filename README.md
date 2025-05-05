
# Pharmacy Web Platform

This is a web-based pharmacy platform developed using PHP and MySQL. It allows pharmacists and patients to securely access prescription information, manage medications, and monitor inventory and sales. The platform includes user management with role-based access, prescription management, and inventory control.

## Features

- **User Management**: Pharmacists and patients can register, log in, and view/manage their information.
- **Prescription Management**: Pharmacists can add, view, and manage prescriptions for patients.
- **Medication Management**: Add and view medications, including details such as name, dosage, manufacturer, etc.
- **Inventory Control**: Track the stock of medications in the pharmacy.
- **Sales Tracking**: View sales data based on prescriptions.
- **Role-Based Access**: Different functionalities are available depending on the user's role (pharmacist or patient).

## Requirements

- PHP 
- MySQL
- A local or remote server to run the PHP files (e.g., XAMPP )

## Installation

### Step 1: Clone the repository
Clone the repository to your local machine using the following command:
```bash
git clone https://github.com/Suthfan/Pharmacy-Portal.git
````

### Step 2: Set up the Database

1. Open your MySQL server and run pharmacy_portal_db.sql

### Step 3: Configure Database Connection

Edit the `PharmacyDatabase.php` file to set your database credentials (hostname, username, password, and database name).

### Step 4: Run the Platform

* Place all the files in your server's web directory (e.g., `htdocs` for XAMPP).
* Open `localhost/Pharmacy-Portal` in your browser to access the platform.
* Or run `php -S localhost:8000` in terminal from the root folder.

## Usage

### User Registration and Login

1. Pharmacists and patients can register on the login page. A secure login system is in place.
2. Pharmacists will have access to manage prescriptions, inventory, and sales.
3. Patients will be able to view their prescriptions.

### Add Medication

Pharmacists can add new medications to the system by navigating to the "Add Medication" page. This will insert new medication entries into the `Medications` table.

### Prescription Management

Pharmacists can add prescriptions that automatically reduce inventory based on the prescribed quantity.

### Inventory Management

The platform automatically updates the inventory after a prescription is added. It also triggers alerts if any medication's stock is low.

### Sales Tracking

The platform records the sale of medications and associates the sales with specific prescriptions. You can view sales details by navigating to the "View Sales" page.

## Technologies Used

* **Frontend**: HTML, CSS, JavaScript
* **Backend**: PHP
* **Database**: MySQL
* **Session Management**: PHP Sessions for login states
* **Password Security**: `password_hash()` and `password_verify()` for secure password management

## Database Schema

### Users Table

Stores user details including username, contact info, user type (pharmacist or patient), and password.

### Medications Table

Stores details of medications such as name, dosage, and manufacturer.

### Prescriptions Table

Stores prescriptions, linking to both users and medications.

### Inventory Table

Stores the current stock of medications.

### Sales Table

Tracks sales based on prescriptions, including quantity and sale amount.

## Contact

For questions or suggestions, feel free to open an issue or contact the author at \[[ssuthfan13@gmail.com](mailto:ssuthfan13@gmail.com)].

