<?php 

Session_start(); 

 

// Handle login if form is submitted 

If ($_SERVER[“REQUEST_METHOD”] === “POST”) { 

    $email = $_POST[‘email’]; 

    $password = $_POST[‘password’]; 

 

    // === Database connection === 

    $host = ‘localhost’; 

    $db = ‘your_database_name’;      // 🔁 Replace with your Oracle DB name 

    $user = ‘your_db_user’;          // 🔁 Replace with your Oracle DB user 

    $pass = ‘your_db_password’;      // 🔁 Replace with your Oracle DB password 

 

    Try { 

        $conn = new PDO(“oci:dbname=$host/$db;charset=AL32UTF8”, $user, $pass); 

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

 

        // Check user by email 

        $stmt = $conn->prepare(“SELECT * FROM users WHERE email = :email”); 

        $stmt->execute([‘email’ => $email]); 

        $userData = $stmt->fetch(PDO::FETCH_ASSOC); 

 

        If ($userData && $password === $userData[‘password_hash’]) { 

            $_SESSION[‘user_id’] = $userData[‘id’]; 

            $_SESSION[‘user_role’] = $userData[‘role’]; 

            $_SESSION[‘user_name’] = $userData[‘name’]; 

 

            Echo “<script>window.location.href = ‘dashboard.php’;</script>”; 

            Exit(); 

        } else { 

            $error = “Invalid email or password.”; 

        } 

    } catch (PDOException $e) { 

        $error = “Database error: “ . $e->getMessage(); 

    } 

} 

?> 

 

<!-- === HTML Login Form === à 

<!DOCTYPE html> 

<html> 

<head> 

    <title>Approver Login</title> 

    <style> 

        Body { 

            Font-family: Arial, sans-serif; 

            Background: #f7f7f7; 

            Display: flex; justify-content: center; align-items: center; 

            Height: 100vh; 

        } 

        .login-box { 

            Background: white; 

            Padding: 30px; 

            Border-radius: 12px; 

            Box-shadow: 0 0 15px #ccc; 

            Width: 300px; 

        } 

        .login-box h2 { 

            Margin-bottom: 20px; 

            Text-align: center; 

            Color: navy; 

        } 

        Input[type=email], input[type=password] { 

            Width: 100%; 

            Padding: 10px; 

            Margin-bottom: 15px; 

            Border: 1px solid #ccc; 

            Border-radius: 6px; 

        } 

        Button { 

            Width: 100%; 

            Padding: 10px; 

            Background: navy; 

            Color: white; 

            Border: none; 

            Border-radius: 6px; 

            Cursor: pointer; 

        } 

        .error { 

            Color: red; 

            Margin-bottom: 10px; 

            Text-align: center; 

        } 

    </style> 

</head> 

<body> 

<div class=”login-box”> 

    <h2>Approver Login</h2> 

 

    <?php if (!empty($error)) echo “<div class=’error’>$error</div>”; ?> 

 

    <form method=”POST” action=””> 

        <input type=”email” name=”email” placeholder=”Email” required /> 

        <input type=”password” name=”password” placeholder=”Password” required /> 

        <button type=”submit”>Login</button> 

    </form> 

</div> 

</body> 

</html> 

 
