<?php 

Session_start(); 

Session_unset(); 

Session_destroy(); 

Header(“Location: approver_login.php?logged_out=1”); 

Exit(); 

 
