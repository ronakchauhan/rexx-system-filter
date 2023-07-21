<?php
require_once "pdo.php";

// Code for Loading Filtered Data
if (isset($_POST['search'])) {
    $searchQuery = "SELECT * FROM rexx_event_management ";
    $conditions = array();

    if (isset($_POST["employeeName"]) && !empty($_POST["employeeName"])) {
        $employeeName = $_POST['employeeName'];
        $conditions[] = "employee_name LIKE '%$employeeName%'";
    }
    if (isset($_POST["eventName"]) && !empty($_POST["eventName"])) {
        $eventName = $_POST['eventName'];
        $conditions[] = "event_name LIKE '%$eventName%'";
    }
    if (isset($_POST["eventDate"]) && !empty($_POST["eventDate"])) {
        $eventDate = $_POST['eventDate'];
        $conditions[] = "event_date LIKE '%$eventDate%'";
    }

    if (count($conditions) > 0) {
        $searchQuery .= " WHERE " . implode(' AND ', $conditions);
    }
    $stmt = $pdo->query($searchQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rexx System Event Search</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<header class="header">
    <h1 class="heading mt-4">Rexx System Event Search</h1>
</header>
<div class="container">
    <div class="form-container">
        <form method="post">
            <div class="form-row">
                <input type="hidden" name="search" value="true">
                <div class="col-md-4 form-group">
                    <label for="employeeName">Employee Name:</label>
                    <input type="text" class="form-control" id="employeeName" name="employeeName">
                </div>
                <div class="col-md-4 form-group">
                    <label for="eventName">Event Name:</label>
                    <input type="text" class="form-control" id="eventName" name="eventName">
                </div>
                <div class="col-md-4 form-group">
                    <label for="eventDate">Event Date:</label>
                    <input type="date" class="form-control" id="eventDate" name="eventDate">
                </div>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="search">
            </div>
        </form>
    </div>
    <div class="header">
        <h2 class="table-title">Filtered Data</h2>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
            <tr>
                <th>Participation Id</th>
                <th>Employee Name</th>
                <th>Employee Email</th>
                <th>Event Id</th>
                <th>Event Name</th>
                <th>Participation Fee</th>
                <th class="nowrap">Event Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($stmt):
            $total_Fees = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $row['participation_id'] ?></td>
                    <td><?= $row['employee_name'] ?></td>
                    <td><?= $row['employee_email'] ?></td>
                    <td><?= $row['event_id'] ?></td>
                    <td><?= $row['event_name'] ?></td>
                    <td>$<?= $row['participation_fee'] ?></td>
                    <td class="nowrap"><?= $row['event_date'] ?></td>
                </tr>
                <?php
                $total_Fees += $row['participation_fee'];
            endwhile;
            ?>
            </tbody>
            <tfoot>
            <tr class="total-row">
                <td colspan="5">Total Participation Fees</td>
                <td colspan="2">$<?= $total_Fees ?></td>
            </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>
</body>
</html>
