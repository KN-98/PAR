<?php 

session_start(); 

require 'db_connect.php'; 

 

// ✅ Protect page: Only logged-in users 

if (!isset($_SESSION['user_id'])) { 

    header("Location: approver_login.php"); 

    exit(); 

} 

 

$user_id = $_SESSION['user_id']; 

$user_role = $_SESSION['user_role']; 

 

$form_id = isset($_GET['form_id']) ? intval($_GET['form_id']) : 0; 

 

// ✅ Fetch the form 

$stmt = $conn->prepare("SELECT * FROM forms WHERE id = :form_id"); 

$stmt->execute(['form_id' => $form_id]); 

$form = $stmt->fetch(PDO::FETCH_ASSOC); 

 

// ✅ If form not found 

if (!$form) { 

    echo "<p>❌ Form not found.</p>"; 

    exit(); 

} 

 

// ✅ Check if the logged-in approver is supposed to approve this 

$stmt = $conn->prepare(" 

    SELECT * FROM approvals  

    WHERE form_id = :form_id AND approver_role = :role 

"); 

$stmt->execute([ 

    'form_id' => $form_id, 

    'role' => $user_role 

]); 

$approval = $stmt->fetch(PDO::FETCH_ASSOC); 

 

if (!$approval) { 

    echo "<p>⛔ You are not assigned to approve this form.</p>"; 

    exit(); 

} 

 

// ✅ Handle approval action 

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 

    $status = $_POST['status']; 

    $comment = $_POST['comment']; 

 

    $stmt = $conn->prepare(" 

        UPDATE approvals  

        SET status = :status, comment = :comment, approved_at = CURRENT_TIMESTAMP  

        WHERE form_id = :form_id AND approver_role = :role 

    "); 

    $stmt->execute([ 

        'status' => $status, 

        'comment' => $comment, 

        'form_id' => $form_id, 

        'role' => $user_role 

    ]); 

 

    echo "<p style='color: green;'>✅ You have $status this form.</p>"; 

    // Optionally send email to next approver here 

} 

 

?> 

 

<!DOCTYPE html> 

<html> 

<head> 

    <title>Form Viewer</title> 

    <style> 

        body { font-family: Arial; padding: 20px; background: #f9f9f9; } 

        .form-box { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; } 

        label { font-weight: bold; } 

        .field { margin-bottom: 10px; } 

        textarea { width: 100%; height: 80px; } 

        button { margin-top: 10px; padding: 10px; border: none; border-radius: 5px; } 

        .approve { background: green; color: white; } 

        .reject { background: red; color: white; } 

    </style> 

</head> 

<body> 

 

<div class="form-box"> 

    <h2>Form #<?= $form['id'] ?> Details</h2> 

 

    <div class="field"><label>Type:</label> <?= $form['form_type'] ?></div> 

    <div class="field"><label>Contract:</label> <?= $form['form_contract'] ?></div> 

    <div class="field"><label>Employee:</label> <?= $form['employee_name'] ?> (<?= $form['id_number'] ?>)</div> 

 

    <hr> 

 

    <h3>Approval</h3> 

    <p>Status: <strong><?= $approval['status'] ?></strong></p> 

    <p>Comment: <?= htmlspecialchars($approval['comment']) ?></p> 

    <p>Approved At: <?= $approval['approved_at'] ?? '—' ?></p> 

 

    <?php if ($approval['status'] === 'Pending'): ?> 

        <form method="POST"> 

            <label for="comment">Comment:</label><br> 

            <textarea name="comment" required></textarea><br> 

 

            <button type="submit" name="status" value="Approved" class="approve">✅ Approve</button> 

            <button type="submit" name="status" value="Rejected" class="reject">❌ Reject</button> 

        </form> 

    <?php else: ?> 

        <p>This form has already been <?= $approval['status'] ?>.</p> 

    <?php endif; ?> 

</div> 

 

</body> 

</html> 
