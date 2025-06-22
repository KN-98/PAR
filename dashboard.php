<?php 

Session_start(); 

If (!isset($_SESSION[‘user_id’])) { 

    Header(“Location: approver_login.php”); 

    Exit(); 

} 

 

$userId = $_SESSION[‘user_id’]; 

$userRole = $_SESSION[‘user_role’]; 

$userName = $_SESSION[‘user_name’]; 

 

// Simulated DB connection (replace this later) 

Require ‘db_connect.php’; 

 

// Get forms assigned to this approver and pending for their role 

$sql = “SELECT f.id AS form_id, f.form_type, f.employee_name, a.status 

        FROM approvals a 

        JOIN forms f ON f.id = a.form_id 

        WHERE a.approver_id = :uid AND a.role = :role AND a.status = ‘Pending’”; 

 

$stmt = $conn->prepare($sql); 

$stmt->execute([‘uid’ => $userId, ‘role’ => $userRole]); 

$forms = $stmt->fetchAll(PDO::FETCH_ASSOC); 

?> 

 

<!DOCTYPE html> 

<html> 

<head> 

    <title>Approval Dashboard</title> 

    <style> 

        Body { font-family: Arial; padding: 20px; background: #f4f4f4; } 

        Table { border-collapse: collapse; width: 100%; background: white; box-shadow: 0 0 10px #ccc; } 

        Th, td { padding: 12px; border: 1px solid #ccc; text-align: left; } 

        H2 { color: navy; } 

        a.button { background: navy; color: white; padding: 6px 12px; text-decoration: none; border-radius: 5px; } 

    </style> 

</head> 

<body> 

 

<h2>Welcome, <?= htmlspecialchars($userName) ?> (<?= $userRole ?>)</h2> 

<p><a href=”logout.php”>Logout</a></p> 

 

<?php if (count($forms) > 0): ?> 

    <h3>Pending Approvals</h3> 

    <table> 

        <tr> 

            <th>Form ID</th> 

            <th>Employee Name</th> 

            <th>Form Type</th> 

            <th>Status</th> 

            <th>Action</th> 

        </tr> 

        <?php foreach ($forms as $form): ?> 

            <tr> 

                <td><?= $form[‘form_id’] ?></td> 

                <td><?= $form[‘employee_name’] ?></td> 

                <td><?= $form[‘form_type’] ?></td> 

                <td><?= $form[‘status’] ?></td> 

                <td><a class=”button” href=”form_view.php?form_id=<?= $form[‘form_id’] ?>”>View</a></td> 

            </tr> 

        <?php endforeach; ?> 

    </table> 

<?php else: ?> 

    <p>No pending approvals for you right now.</p> 

<?php endif; ?> 

 

</body> 

</html> 

 
