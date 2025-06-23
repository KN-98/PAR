<?php 

// === Supabase DB Config === 

$host = ‘your_supabase_host’; // same as before 

$db   = ‘postgres’; 

$user = ‘postgres’; 

$pass = ‘your_supabase_db_password’; 

$dsn  = “pgsql:host=$host;port=5432;dbname=$db”; 

 

Try { 

    $db = new PDO($dsn, $user, $pass); 

} catch (PDOException $e) { 

    Die(“DB Error: “ . $e->getMessage()); 

} 

 

// === Query email_queue table === 

$stmt = $db->query(“SELECT * FROM email_queue ORDER BY created_at DESC”); 

$emails = $stmt->fetchAll(PDO::FETCH_ASSOC); 

?> 

 

<!DOCTYPE html> 

<html> 

<head> 

  <title>Fake Email Queue</title> 

</head> 

<body> 

  <h2>Email Queue (Placeholder)</h2> 

  <table border=”1” cellpadding=”8”> 

    <tr> 

      <th>Form ID</th> 

      <th>To</th> 

      <th>Role</th> 

      <th>Subject</th> 

      <th>Message</th> 

      <th>Status</th> 

      <th>Created</th> 

    </tr> 

 

    <?php foreach ($emails as $email): ?> 

    <tr> 

      <td><?= htmlspecialchars($email[‘form_id’]) ?></td> 

      <td><?= htmlspecialchars($email[‘recipient_email’]) ?></td> 

      <td><?= htmlspecialchars($email[‘recipient_role’]) ?></td> 

      <td><?= htmlspecialchars($email[‘subject’]) ?></td> 

      <td><?= nl2br(htmlspecialchars($email[‘message’])) ?></td> 

      <td><?= htmlspecialchars($email[‘status’]) ?></td> 

      <td><?= htmlspecialchars($email[‘created_at’]) ?></td> 

    </tr> 

    <?php endforeach; ?> 

  </table> 

</body> 

</html> 

 
