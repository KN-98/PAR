<?php 

session_start(); 

 

//  1. Security check — only logged-in users can access 

if (!isset($_SESSION['user_id'])) { 

    header("Location: approver_login.php"); 

    exit(); 

} 

 

//  2. Get user info from session 

$user_name = $_SESSION['user_name']; 

$user_role = $_SESSION['user_role']; 

?> 

 

<!DOCTYPE html> 

<html> 

<head> 

    <title>Approver Dashboard</title> 

    <style> 

        body { 

            font-family: Arial, sans-serif; 

            background: #f4f4f4; 

            margin: 0; 

            padding: 20px; 

        } 

        .header { 

            background: navy; 

            color: white; 

            padding: 15px 20px; 

            display: flex; 

            justify-content: space-between; 

            align-items: center; 

        } 

        .header h2 { 

            margin: 0; 

        } 

        .logout-form { 

            margin: 0; 

        } 

        .logout-form button { 

            background: red; 

            color: white; 

            border: none; 

            padding: 8px 14px; 

            border-radius: 5px; 

            cursor: pointer; 

        } 

        .content { 

            background: white; 

            margin-top: 20px; 

            padding: 20px; 

            border-radius: 10px; 

            box-shadow: 0 0 10px #ccc; 

        } 

    </style> 

</head> 

<body> 

 

<!--  Header with logout --> 

<div class="header"> 

    <h2>Welcome, <?= htmlspecialchars($user_name) ?> (<?= $user_role ?>)</h2> 

    <form action="logout.php" method="post" class="logout-form"> 

        <button type="submit">Logout</button> 

    </form> 

</div> 

 

<!--  Main content --> 

<div class="content"> 

    <h3>Your Approver Dashboard</h3> 

    <p>This is where you can see forms awaiting your approval, approved history, or request details.</p> 

 



</div> 

 

</body> 

</html> 
