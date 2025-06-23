<?php 


include ('session_check.php');
// === Supabase DB Config === 
$host = ‘your_supabase_host’; // e.g., db.abc123.supabase.co 

$db   = ‘postgres’; 

$user = ‘postgres’; 

$pass = ‘your_supabase_db_password’; 

$dsn  = “pgsql:host=$host;port=5432;dbname=$db”; 

 

Try { 

    $db = new PDO($dsn, $user, $pass); 

} catch (PDOException $e) { 

    Die(“DB Error: “ . $e->getMessage()); 

} 

 

// === POST Inputs === 

$form_id = $_POST[‘form_id’]; 

$current_role = $_POST[‘role’]; 

$current_user_id = $_POST[‘user_id’]; 

 

// === 1. Mark current approval as Approved === 

$approve = $db->prepare(“UPDATE approvals  

                         SET status = ‘Approved’, approved_at = NOW()  

                         WHERE form_id = ? AND approver_id = ?”); 

$approve->execute([$form_id, $current_user_id]); 

 

// === 2. Role Order Logic === 

$role_order = [‘Project Manager’, ‘Contract Engineer’, ‘Group Manager’, ‘Department Director’]; 

$current_index = array_search($current_role, $role_order); 

 

If ($current_index !== false && $current_index < count($role_order) – 1) { 

    $next_role = $role_order[$current_index + 1]; 

 

    // === 3. Get Next Approver Info === 

    $next = $db->prepare(“SELECT id, email FROM users WHERE role = ? LIMIT 1”); 

    $next->execute([$next_role]); 

    $next_user = $next->fetch(PDO::FETCH_ASSOC); 

 

    If ($next_user) { 

        // === 4. Log fake email into email_queue === 

        $subject = “Approval Needed for Form #$form_id”; 

        $message = “Hi $next_role,\n\nForm #$form_id has been approved by $current_role.\nPlease review it.”; 

 

        $insert = $db->prepare(“INSERT INTO email_queue (form_id, recipient_email, recipient_role, subject, message) 

                                VALUES (?, ?, ?, ?, ?)”); 

        $insert->execute([$form_id, $next_user[‘email’], $next_role, $subject, $message]); 

 

        Echo “✅ Approval recorded. Fake email queued for: {$next_user[‘email’]}”; 

    } else { 

        Echo “⚠️ Next approver ($next_role) not found in users table.”; 

    } 

} else { 

    Echo “✅ Final approval completed or invalid role.”; 

} 

?> 

 
