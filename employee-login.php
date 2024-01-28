<?php 

include('config/dbcon.php');
session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" href="images/tup-white.png" type="image/x-icon">
    <title>Employee Login</title>
    <link rel="stylesheet" href="css/adminlogin.css">
   
</head>
<body>
<div class="box-container">
    <div class="box-image">
        <img src="images/tup-white.png" alt="">
    </div>
    <div class="box-login">
        <h1>Employee login</h1>
        <form method="POST">
            <div class="input-container">
                <i class="material-icons-sharp">person</i>
                <input type="text" name="username" placeholder="Username">
            </div>
            <div class="input-container">
                <i class="material-icons-sharp">lock</i>
                <input type="password" name="password" id="password" placeholder="Password">
                <span class="toggle-password" onclick="togglePasswordVisibility()" >
                <i class="material-icons-sharp" id="password-icon">visibility</i>
                </span>
            </div>
            <input type="submit" name="login-submit" value="Login" class="submit-button">
        </form>
        <span style="padding-top: 5%; text-decoration: none; font-size: 14px;">login here as <a href="admin-login.php">Admin</a></span>
    </div>
</div>




<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var toggleSpan = document.querySelector(".toggle-password");
        var passwordIcon = document.getElementById("password-icon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.textContent = "visibility_off";
        } else {
            passwordInput.type = "password";
            passwordIcon.textContent = "visibility";
        }
    }
</script>




</body>
</html>




<?php


    //check if the submit button is clicked or not
    if(isset($_POST['login-submit']))
    {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //sql to check the user with username and password exists or not
        $sql = "SELECT * FROM tbl_employee WHERE username = '$username' AND password = '$password'";

        //execute the sql queery
        $result = mysqli_query($conn,$sql);

        //count the rows 
        $count = mysqli_num_rows($result);

        if($count==1)
        {

            $row = mysqli_fetch_assoc($result);
            $_SESSION['emp_id'] = $row['id'];
            
            //user is exist
            echo '<script>
            swal({
                title: "Success",
                text: "Login Successfully",
                icon: "success"
            }).then(function() {
                window.location = "borrow-item.php";
            });
        </script>';

       



       
        
        exit;

        }
        else{
            //user not available
            echo '<script>
            swal({
                title: "Error",
                text: "Username or Password did not match",
                icon: "error"
            }).then(function() {
                window.location = "employee-login.php";
            });
        </script>';
        
        exit;
        }
    }

?>