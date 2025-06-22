<?php 

Require ‘db_connect.php’; 

 

If ($_SERVER[“REQUEST_METHOD”] === “POST”) { 

    $name = $_POST[‘name’]; 

    $email = $_POST[‘email’]; 

    $role = $_POST[‘role’]; 

    $password = $_POST[‘password’]; 

    $confirm = $_POST[‘confirm’]; 

 

    // Basic checks 

    If ($password !== $confirm) { 

        $error = “Passwords do not match.”; 

    } elseif (strlen($password) < 6) { 

        $error = “Password must be at least 6 characters.”; 

    } else { 

        // Hash the password 

        $hashed = password_hash($password, PASSWORD_DEFAULT); 

 

        // Insert user 

        $stmt = $conn->prepare(“INSERT INTO users (name, email, role, password)  

                                VALUES (:name, :email, :role, :password)”); 

        $stmt->execute([ 

            ‘name’ => $name, 

            ‘email’ => $email, 

            ‘role’ => $role, 

            ‘password’ => $hashed 

        ]); 

 

        Header(“Location: approver_login.php?registered=1”); 

        Exit(); 

    } 

} 

?> 

 

<!DOCTYPE html> 

<html> 

<head> 

    <title>Approver Registration</title> 

    <style> 

        Body { font-family: Arial; padding: 20px; background: #f4f4f4; } 

        Form { background: white; padding: 20px; border-radius: 10px; max-width: 400px; margin: auto; box-shadow: 0 0 10px #ccc; } 

        Input, select { width: 100%; padding: 10px; margin-top: 10px; } 

        Button { padding: 10px; background: navy; color: white; border: none; border-radius: 5px; margin-top: 15px; } 

        .error { color: red; margin-top: 10px; } 

    </style> 

</head> 

<body> 

 

<form method=”POST”> 

    <h2>Create Account</h2> 

 

    <label>Name</label> 

    <input type=”text” name=”name” required> 

 

    <label>Email</label> 

    <input type=”email” name=”email” required> 

 

    <label>Role</label> 

    <select name=”role” required> 

        <option value=””>-- Select Role --</option> 

        <option value=”Project Manager”>Project Manager</option> 

        <option value=”Contract Engineer”>Contract Engineer</option> 

        <option value=”Group Manager”>Group Manager</option> 

        <option value=”Department Director”>Department Director</option> 

    </select> 

 

    <label>Password</label> 

    <input type=”password” name=”password” required> 

 

    <label>Confirm Password</label> 

    <input type=”password” name=”confirm” required> 

 

    <button type=”submit”>Register</button> 

 

    <?php if (!empty($error)): ?> 

        <p class=”error”><?= $error ?></p> 

    <?php endif; ?> 

</form> 

 

</body> 

</html> 

 
