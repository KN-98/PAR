<?php 

session_start(); 

if (!isset($_SESSION['user_id'])) { 

    header("Location: approver_login.php"); 

    exit(); 

} 

 

require 'db_connect.php'; 

 

$formId = $_GET['form_id']; 

$userId = $_SESSION['user_id']; 

$userRole = $_SESSION['user_role']; 

 

// Get form info 

$formStmt = $conn->prepare("SELECT * FROM forms WHERE id = :id"); 

$formStmt->execute(['id' => $formId]); 

$form = $formStmt->fetch(PDO::FETCH_ASSOC); 

 

// Get approval info for current user 

$approvalStmt = $conn->prepare("SELECT * FROM approvals  

    WHERE form_id = :form_id AND approver_id = :approver_id AND role = :role"); 

$approvalStmt->execute([ 

    'form_id' => $formId, 

    'approver_id' => $userId, 

    'role' => $userRole 

]); 

$approval = $approvalStmt->fetch(PDO::FETCH_ASSOC); 

 

if (!$form || !$approval) { 

    die("Access denied or invalid form."); 

} 

?> 

 

<!DOCTYPE html> 

<html> 

<head> 

    <title>Form Details</title> 

    <style> 

        body { font-family: Arial; padding: 20px; background: #f9f9f9; } 

        .container { background: white; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 0 15px #ccc; } 

        label { font-weight: bold; display: block; margin-top: 10px; } 

        textarea, select { width: 100%; padding: 10px; margin-top: 5px; } 

        button { margin-top: 15px; padding: 10px 20px; background: navy; color: white; border: none; border-radius: 5px; cursor: pointer; } 

        a { text-decoration: none; color: gray; } 

    </style> 

</head> 

<body> 

<div class="container"> 

    <h2>Review PAR Form #<?= $form['id'] ?></h2> 

 

    <p><strong>Employee:</strong> <?= $form['employee_name'] ?></p> 

    <p><strong>Form Type:</strong> <?= $form['form_type'] ?></p> 

    <p><strong>Contract:</strong> <?= $form['form_contract'] ?></p> 

    <p><strong>ID Number:</strong> <?= $form['id_number'] ?></p> 

    <p><strong>Your Status:</strong> <?= $approval['status'] ?></p> 

 

    <?php if ($approval['status'] === 'Pending'): ?> 

        <form action="approve.php" method="POST"> 

            <input type="hidden" name="form_id" value="<?= $form['id'] ?>"> 

            <input type="hidden" name="approver_id" value="<?= $approval['approver_id'] ?>"> 

            <input type="hidden" name="role" value="<?= $approval['role'] ?>"> 

 

            <label for="decision">Decision</label> 

            <select name="decision" required> 

                <option value="">-- Select --</option> 

                <option value="Approved">Approve</option> 

                <option value="Rejected">Reject</option> 

            </select> 

 

            <label for="remarks">Remarks (optional)</label> 

            <textarea name="remarks" rows="4"></textarea> 

 

            <button type="submit">Submit Decision</button> 

        </form> 

    <?php else: ?> 

        <p><strong>Remarks:</strong><br><?= nl2br($approval['remarks']) ?></p> 

        <p><strong>Approved At:</strong> <?= $approval['approved_at'] ?></p> 

    <?php endif; ?> 

 

    <p><a href="dashboard.php">← Back to Dashboard</a></p> 

</div> 

</body> 

</html> 
