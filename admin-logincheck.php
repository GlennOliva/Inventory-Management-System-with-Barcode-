<?php

    if(!isset($_SESSION['admin_id']))
    {
        header('location: admin-login.php');
    }

?>