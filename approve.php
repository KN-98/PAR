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

require 'email_helper.php'; 

 

// === Approval Chain Order === 

$approvalSteps = [ 

    'Project Manager', 

    'Contract Engineer', 

    'Group Manager', 

    'Department Director' 

]; 

 

$currentIndex = array_search($role, $approvalSteps); 

if ($decision === 'Approved' && $currentIndex !== false && $currentIndex < count($approvalSteps) - 1) { 

    $nextRole = $approvalSteps[$currentIndex + 1]; 

 

    // Find the next approver for this form 

    $stmt = $conn->prepare("SELECT u.email, u.name FROM approvals a 

        JOIN users u ON a.approver_id = u.id 

        WHERE a.form_id = :form_id AND a.role = :role"); 

 

    $stmt->execute([ 

        'form_id' => $formId, 

        'role' => $nextRole 

    ]); 

    $nextApprover = $stmt->fetch(PDO::FETCH_ASSOC); 

 

    if ($nextApprover) { 

        sendApprovalEmail($nextApprover['email'], $nextApprover['name'], $formId, $nextRole); 

    } 

} 
 

// Redirect back to dashboard 

Header(“Location: dashboard.php”); 

Exit(); 

?> 

 
