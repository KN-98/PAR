<?php 

Session_start(); 

If (!isset($_SESSION[‘user_id’])) { 

    Header(“Location: approver_login.php”); 

    Exit(); 

} 

 

Require ‘db_connect.php’; 

 

$formId = $_POST[‘form_id’]; 

$approverId = $_POST[‘approver_id’]; 

$role = $_POST[‘role’]; 

$decision = $_POST[‘decision’]; 

$remarks = $_POST[‘remarks’]; 

$now = date(‘Y-m-d H:i:s’); 

 

// 1. Update the approval 

$sql = “UPDATE approvals SET  

    Status = :status,  

    Remarks = :remarks,  

    Approved_at = TO_TIMESTAMP(:approved_at, ‘YYYY-MM-DD HH24:MI:SS’) 

    WHERE form_id = :form_id AND approver_id = :approver_id AND role = :role”; 

 

$stmt = $conn->prepare($sql); 

$stmt->execute([ 

    ‘status’ => $decision, 

    ‘remarks’ => $remarks, 

    ‘approved_at’ => $now, 

    ‘form_id’ => $formId, 

    ‘approver_id’ => $approverId, 

    ‘role’ => $role 

]); 

 

// 2. If approved, trigger next approver via email (TO BE IMPLEMENTED) 

 

// Redirect back to dashboard 

Header(“Location: dashboard.php”); 

Exit(); 

?> 

 
