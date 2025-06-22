<?php 

Use PHPMailer\PHPMailer\PHPMailer; 

Use PHPMailer\PHPMailer\Exception; 

 

Require ‘vendor/autoload.php’; // Only if you installed PHPMailer via Composer 

 

Function sendApprovalEmail($toEmail, $toName, $formId, $nextRole) { 

    $subject = “PAR Approval Required - $nextRole”; 

    $link = http://yourdomain.com/form_view.php?form_id=$formId; 

    $body = “ 

        <p>Dear $toName,</p> 

        <p>A PAR Form (ID: $formId) is awaiting your <strong>$nextRole</strong> approval.</p> 

        <p><a href=’$link’>Click here to review and approve the form.</a></p> 

        <p>Thank you.</p>”; 

 

    // Simulate if no real email setup 

    If (!function_exists(‘mail’)) { 

        Echo “<!—Simulated Email to $toEmail à”; 

        Return; 

    } 

 

    $mail = new PHPMailer(true); 

    Try { 

        $mail->isSMTP(); 

        $mail->Host = ‘smtp.example.com’;  // change this 

        $mail->SMTPAuth = true; 

        $mail->Username = ‘your_email@example.com’; 

        $mail->Password = ‘your_password’; 

        $mail->SMTPSecure = ‘tls’; 

        $mail->Port = 587; 

 

        $mail->setFrom(‘noreply@example.com’, ‘PAR System’); 

        $mail->addAddress($toEmail, $toName); 

        $mail->isHTML(true); 

        $mail->Subject = $subject; 

        $mail->Body = $body; 

        $mail->send(); 

    } catch (Exception $e) { 

        Error_log(“Mailer Error: “ . $mail->ErrorInfo); 

    } 

} 

  // Simulated email test 
<?php 

Function sendApprovalEmail($toEmail, $toName, $formId, $nextRole) { 

    $link = “form_view.php?form_id=$formId”; // relative path for now 

 

    // Simulated email output 

    Echo “<div style=’border:2px dashed green; padding:15px; margin:20px; background:#f0fff0;’>”; 

    Echo “<h3>📬 Simulated Email Sent</h3>”; 

    Echo “<p><strong>To:</strong> $toName &lt;$toEmail&gt;</p>”; 

    Echo “<p><strong>Subject:</strong> PAR Approval Required - $nextRole</p>”; 

    Echo “<p><strong>Message:</strong></p>”; 

    Echo “<p>A PAR form (ID: $formId) is awaiting your <strong>$nextRole</strong> approval.</p>”; 

    Echo “<p><a href=’$link’>Click here to review and approve the form</a></p>”; 

    Echo “<p><em>This is a simulated email. No actual email was sent.</em></p>”; 

    Echo “</div>”; 

} 

 
