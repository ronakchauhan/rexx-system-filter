<?php
require_once "readJson.php";
require_once "pdo.php";

try {
    // SQL query to create the table
    $query = "CREATE TABLE IF NOT EXISTS rexx_event_management (
                participation_id INT(11) AUTO_INCREMENT PRIMARY KEY, 
                employee_name VARCHAR(255) NOT NULL,
                employee_email VARCHAR(255) NOT NULL,
                event_id INT(11) NOT NULL,
                event_name VARCHAR(255) NOT NULL,
                participation_fee DECIMAL(10,2) NOT NULL,
                event_date DATE NOT NULL)";

    // Execute the query
    $stmt = $pdo->prepare($query);

    if ($stmt->execute()) {
        echo "Table 'rexx_event_management' created successfully!";
    } else {
        echo "Error creating table.";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

try {
    $dataInsertStatus = 0;

    foreach ($jsonData as $key => $value) {
        try {
            // Prepare and execute the INSERT query using a prepared statement
            $stmt = $pdo->prepare("INSERT INTO rexx_event_management (participation_id, employee_name, employee_email, event_id, event_name, participation_fee, event_date) 
                               VALUES (:Id, :name, :email, :event_id, :event_name, :fee, :event_date)");
            $stmt->bindParam(':Id', $value["participation_id"]);
            $stmt->bindParam(':name', $value["employee_name"]);
            $stmt->bindParam(':email', $value["employee_mail"]);
            $stmt->bindParam(':event_id', $value["event_id"]);
            $stmt->bindParam(':event_name', $value["event_name"]);
            $stmt->bindParam(':fee', $value["participation_fee"]);
            $stmt->bindParam(':event_date', $value["event_date"]);

            if ($stmt->execute()) {
                $dataInsertStatus = 0;
            } else {
                $dataInsertStatus = 1;
            }
        } catch (PDOException $e) {
            echo "Error while importing data: " . $e->getMessage();
            $dataInsertStatus = 1;
            break;
        }
    }

    if ($dataInsertStatus === 1) {
        echo $stmt->errorInfo();
        echo "Error while import data";
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}