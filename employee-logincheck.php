<?php

    if(!isset($_SESSION['emp_id']))
    {
        header('location: employee-login.php');
    }

?>