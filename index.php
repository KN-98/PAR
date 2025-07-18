<?php
include ('session_check.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PAR Forms Portal</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h2 { margin-top: 0; }
    .form-section { display: none; margin-top: 20px; }
    label { display: block; margin-top: 10px; font-weight: bold; }
    input, select, textarea { width: 50%; padding: 6px; margin-top: 5px; }
    .row { display: flex; gap: 10px; }
    .row > div { flex: 1; }
  </style>
</head>
<body>

<h2>PAR Form</h2>
<label>Royal Commission for Jubail and Yanbu</label>
<label>Attn: Mr. Ahmad Ali AL Shiban</label>

<label for="form-selector">Select PAR Type:</label>
<select id="form-selector" onchange="switchForm()">
  <option value="start-par">Start PAR</option>
  <option value="stop-par">Stop PAR</option>
  <option value="vacation">Vacation</option>
</select>

<label for="contract-selector">Select Contract:</label>
<select id="contract-selector" name="form_contract">
  <option value="S14-842">S14-842</option>
  <option value="Y01-842">Y01-842</option>
  <option value="Y01A-842">Y01A-842</option>
</select>

<!-- START PAR FORM -->
<div id="start-par" class="form-section" style="display: block;">
  <form action="submit_start_par.php" method="post" enctype="multipart/form-data">
    <h3>Start PAR Form</h3>
    <div class="row">
      <div><label>PAR No:<input type="text" name="par_no"></label></div>
      <div><label>Date:<input type="date" name="date"></label></div>
    </div>
    <label>ID No:<input type="text" name="id_no"></label>
    <label>Position Title:<input type="text" name="position_title" value="PEST CONTROLLER"></label>
    <label>Full Name:<input type="text" name="full_name"></label>
    <label>Nationality:<input type="text" name="nationality"></label>
    <label>Employee Number:<input type="text" name="employee_number"></label>
    <label>Effective Date:<input type="date" name="effective_date"></label>
    <label>Supervisory Position:
      <select name="is_supervisory" onchange="toggleDirectorApproval(this, 'director-approval-start')">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
      </select>
    </label>
    <label>Attachment:<input type="file" name="attachment"></label>
    <h4>Approval Signatures</h4>
    <div class="row">
      <div><label>Project Manager:<input type="text" name="project_manager"></label></div>
      <div><label>Contract Engineer:<input type="text" name="contract_engineer"></label></div>
      <div><label>Group Manager:<input type="text" name="group_manager"></label></div>
    </div>
    <div class="row" id="director-approval-start" style="display: none;">
      <div><label>Department Director:<input type="text" name="department_director"></label></div>
    </div>
    <button type="submit">Submit Start PAR</button>
  </form>
</div>

<!-- STOP PAR FORM -->
<div id="stop-par" class="form-section">
  <form action="submit_stop_par.php" method="post">
    <h3>Stop PAR Form</h3>
    <label>Employee Name:<input type="text" name="employee_name"></label>
    <label>Employee Number:<input type="text" name="employee_number"></label>
    <label>Reason for Stop:<textarea name="reason"></textarea></label>
    <label>Effective Date:<input type="date" name="effective_date"></label>
    <label>Remarks:<textarea name="remarks"></textarea></label>
    <label>Supervisory Position:
      <select name="is_supervisory" onchange="toggleDirectorApproval(this, 'director-approval-stop')">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
      </select>
    </label>
    <h4>Approval Signatures</h4>
    <div class="row">
      <div><label>Supervisor:<input type="text" name="supervisor"></label></div>
      <div><label>Contract Manager:<input type="text" name="contract_manager"></label></div>
    </div>
    <div class="row" id="director-approval-stop" style="display: none;">
      <div><label>Department Director:<input type="text" name="department_director"></label></div>
    </div>
    <button type="submit">Submit Stop PAR</button>
  </form>
</div>

<!-- VACATION FORM -->
<div id="vacation" class="form-section">
  <form action="submit_vacation.php" method="post">
    <h3>Vacation Form</h3>
    <label>Employee Name:<input type="text" name="employee_name"></label>
    <label>Employee Number:<input type="text" name="employee_number"></label>
    <label>Start Date:<input type="date" name="start_date"></label>
    <label>Return Date:<input type="date" name="return_date"></label>
    <label>Total Days:<input type="number" name="total_days"></label>
    <label>Type of Leave:
      <select name="leave_type">
        <option value="Annual">Annual</option>
        <option value="Emergency">Emergency</option>
        <option value="Sick">Sick</option>
      </select>
    </label>
    <label>Remarks:<textarea name="remarks"></textarea></label>
    <label>Supervisory Position:
      <select name="is_supervisory" onchange="toggleDirectorApproval(this, 'director-approval-vacation')">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
      </select>
    </label>
    <h4>Approval Signatures</h4>
    <div class="row">
      <div><label>Project Manager:<input type="text" name="project_manager"></label></div>
      <div><label>Contract Supervisor:<input type="text" name="contract_supervisor"></label></div>
    </div>
    <div class="row" id="director-approval-vacation" style="display: none;">
      <div><label>Department Director:<input type="text" name="department_director"></label></div>
    </div>
    <button type="submit">Submit Vacation Request</button>
  </form>
</div>

<script>
  function switchForm() {
    const selected = document.getElementById("form-selector").value;
    document.querySelectorAll('.form-section').forEach(form => {
      form.style.display = 'none';
    });
    document.getElementById(selected).style.display = 'block';
  }

  function toggleDirectorApproval(selectElem, targetId) {
    const isSupervisory = selectElem.value === "Yes";
    document.getElementById(targetId).style.display = isSupervisory ? "flex" : "none";
  }
</script>

</body>
</html>