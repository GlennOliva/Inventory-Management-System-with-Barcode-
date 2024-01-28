<?php   include('config/dbcon.php');
session_start();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/form.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="shortcut icon" href="images/tup-white.png" type="image/x-icon">
  </head>
  <body>

  <?php
  if(!isset($_SESSION['admin_id']))
  {
      echo '<script>
                                      swal({
                                          title: "Error",
                                          text: "You must login first before you proceed!",
                                          icon: "error"
                                      }).then(function() {
                                          window.location = "admin-login.php";
                                      });
                                  </script>';
                                  exit;
  }
  
  
  ?>
    <div class="grid-container">

      <!-- Header -->
      <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>
        <div class="header-left">
          <span class="material-icons-outlined">search</span>
        </div>
        <?php
         if(isset($_SESSION['admin_id']))

         {
             $admin_id = $_SESSION['admin_id'];
            
         
            
             //sql query to get all data in database
             $sql2 = "SELECT * FROM tbl_admin WHERE id = $admin_id";

             //check if the query is executed or not
             $result2 = mysqli_query($conn,$sql2);

             //count rows to check if we have foods or not in database
             $count2 = mysqli_num_rows($result2);

           

             if($count2>0)
             {
                 //we have food
                 while($row1=mysqli_fetch_assoc($result2))
                 {
                     //GET THE VALUE FROM INDI COLS
                     $username = $row1['username'];
                    

                 ?>
                   <div class="header-right">
                    <p>Welcome back: <b><?php echo $username;?></b></p>
                  </div>
        
                  <?php

                  }
                }
                  else
                  {
                      //we don't have admin
                    
                      echo '<script>
                      swal({
                          title: "Error",
                          text: "Admin not available",
                          icon: "error"
                      }).then(function() {
                          window.location = "admin-acc.php";
                      });
                  </script>';
                  exit;
                  }

                  
                }



        ?>
      
      </header>
      <!-- End Header -->

      <!-- Sidebar -->
      <aside id="sidebar">
        <div class="sidebar-title">
          <div class="sidebar-brand">
            <span class="logo"><img src="images/tup-white.png" alt=""></span><br> SOTUP INVENTORY
          </div>
          <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
        </div>

        <ul class="sidebar-list">
          <li class="sidebar-list-item">
            <a href="index.php" >
              <span class="material-icons-outlined">dashboard</span> Dashboard
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="admin-acc.php">
              <span class="material-icons-outlined">person</span> Admin account
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="employee-acc.php" >
              <span class="material-icons-outlined">badge</span> Employee
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="inventory-product.php" >
              <span class="material-icons-outlined">fact_check</span> Inventory Product
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="barcode-gen.php" >
              <span class="material-icons-outlined">qr_code_scanner</span> Barcode Generate
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="reportlist.php" >
              <span class="material-icons-outlined">poll</span> Reports List
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="admin-logout.php" >
              <span class="material-icons-outlined">logout</span> Logout
            </a>
          </li>
        </ul>
      </aside>
      <!-- End Sidebar -->

      <!-- Main -->
      <main class="main-container">
        <div class="main-title">
          <p class="font-weight-bold">UPDATE ADMIN PASSWORD</p>
        </div>


        <?php
           
           if(isset($_GET['id']))
           {
            $id = $_GET['id'];
           }
           ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex">
                 
        
                   
                 <div class="inputBox">
                    <span>Update Password (required)</span>
                    <input type="password" class="box" required maxlength="100" placeholder="Current Password" name="current_password">
                 </div>
        
        
                 <div class="inputBox">
                    <span>Update Password (required)</span>
                    <input type="password" class="box" required maxlength="100" placeholder="New Password" name="new_password">
                 </div>
        
        
                 <div class="inputBox">
                    <span>Update Password (required)</span>
                    <input type="password" class="box" required maxlength="100" placeholder="Confirm Password" name="confirm_password">
                 </div>
                 
        
        
                
              </div>
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <input type="submit" value="Update Password" class="btn" name="updatepass_admin">
           </form>
      </main>



      <?php
        //check if the button is clicked or nit

        if(isset($_POST['updatepass_admin']))
        {
            $id = $_POST['id'];
            $current_passowrd = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);

            //check whether the user with current id and currrent password exist or not
            $sql = "SELECT * FROM tbl_admin WHERE id=$id && password ='$current_passowrd'";

            //executre the query

            $result = mysqli_query($conn,$sql);

            if($result==true)
            {
                $count = mysqli_num_rows($result);

                if($count==1)
                {
                    //User exist and password can be changed

                    //check whether the new password confrim and match
                    if($new_password==$confirm_password)
                    {
                        //update the password
                        $sql2 = "UPDATE tbl_admin SET password ='$new_password' WHERE id=$id";

                        //execute the query
                        $result2 = mysqli_query($conn,$sql2);

                        //check if the query executed or not
                        if($result2==true)
                        {
                            //display success messaage
                            echo '<script>
                                swal({
                                    title: "Success",
                                    text: "Successfully Update the password!",
                                    icon: "success"
                                }).then(function() {
                                    window.location = "admin-acc.php";
                                });
                            </script>';
                            
                            exit; 
                        }
                        else
                        {
                            //display error message
                            echo '<script>
                            swal({
                                title: "Error",
                                text: "Failed to update password",
                                icon: "error"
                            }).then(function() {
                                window.location = "admin-acc.php";
                            });
                        </script>';

                        exit;
                        }
                    }
                    else
                    {
                        //redirect to adminaccpage with error
                        echo '<script>
                    swal({
                        title: "Error",
                        text: "Password not match",
                        icon: "error"
                    }).then(function() {
                        window.location = "admin-acc.php";
                    });
                </script>';

                exit;
                    }
                }
                else{
                    //user doesn't exist
                    echo '<script>
                    swal({
                        title: "Error",
                        text: "User doesnt exist",
                        icon: "error"
                    }).then(function() {
                        window.location = "admin-acc.php";
                    });
                </script>';

                exit;
                }
            }
        }
   ?>
      <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
  </body>
</html>