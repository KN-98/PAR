<?php
include ('session_check.php');

<a href="generate_pdf.php? $form_id=1" target="_blank"> Preview form as PDF</a>
?>
  
<!DOCTYPE html> 

<html> 

<head> 

  <title>Approval Form</title> 

</head> 

<body> 

  <h2>Simulate Form Approval</h2> 

  <form action=”approve.php” method=”POST”> 

    <label>Form ID:</label><br> 

    <input type=”number” name=”form_id” required><br><br> 

 

    <label>Your Role:</label><br> 

    <select name=”role” required> 

      <option>Project Manager</option> 

      <option>Contract Engineer</option> 

      <option>Group Manager</option> 

      <option>Department Director</option> 

    </select><br><br> 

 

    <label>Your User ID:</label><br> 

    <input type=”number” name=”user_id” required><br><br> 

 

    <button type=”submit”>Approve</button> 

  </form> 

</body> 

</html> 

 
