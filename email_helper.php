
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

 
