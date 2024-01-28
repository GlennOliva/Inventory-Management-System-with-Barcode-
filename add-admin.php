<?php include('config/dbcon.php');
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

    <link rel="shortcut icon" href="images/tup-white.png" type="image/x-icon">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/form.css">
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
          <p class="font-weight-bold">ADD ADMIN</p>
        </div>


        

     

            <form action="" method="post" enctype="multipart/form-data">
                <div class="flex">
                   <div class="inputBox">
                      <span>Username (required)</span>
                      <input type="text" class="box" required maxlength="100" placeholder="enter username" name="name">
                   </div>
          
                   <div class="inputBox">
                      <span>Email (required)</span>
                      <input type="text" class="box" required maxlength="100" placeholder="enter email" name="email">
                   </div>
          
                   <div class="inputBox">
                      <span>image (required)</span>
                      <input type="file" name="image-admin" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
                  </div>
          
          
          
                   <div class="inputBox">
                      <span>Address (required)</span>
                      <textarea name="address" placeholder="enter address" class="box" required maxlength="200" cols="20" rows="3"></textarea>
                   </div>
          
                   <div class="inputBox">
                      <span>Password (required)</span>
                      <input type="password" class="box" required maxlength="100" placeholder="enter password" name="password">
                   </div>
          
                  
                   <div class="inputBox">
                      <span>Age (required)</span>
                      <input type="number" min="0" class="box" required max="9999999999" placeholder="enter age" onkeypress="if(this.value.length == 10) return false;" name="age">
                   </div>
          
          
          
                </div>
                
                <input type="submit" value="Add admin" class="btn" name="add_admin">
             </form>


             <?php
          if(isset($_POST['add_admin']))
          {
            $username = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $password = md5($_POST['password']);
            $age = $_POST['age'];

             //upload the image if selected
            if(isset($_FILES['image-admin']['name']))
            {
                //get the details of the selected image
                $image_name = $_FILES['image-admin']['name'];

                //check if the imaage selected or not.
                    if ($image_name != "") {
                        // Image is selected
                        // Rename the image
                        $ext_parts = explode('.', $image_name);
                        $ext = end($ext_parts);
                    
                        // Create a new name for the image
                        $image_name = "Admin-Pic" . rand(0000, 9999) . "." . $ext;
                    
                        // Upload the image
                    
                        // Get the src path and destination path
                    
                        // Source path is the current location of the image
                        $src = $_FILES['image-admin']['tmp_name'];
                    
                        // Destination path for the image to be uploaded
                        $destination = "images/admin/" . $image_name;
                    
                        // Upload the food image
                        $upload = move_uploaded_file($src, $destination);
                    
                        // Check if the image uploaded or not
                        if ($upload == false) {
                            // Failed to upload the image
                            echo '<script>
                                swal({
                                    title: "Error",
                                    text: "Failed to upload image",
                                    icon: "error"
                                }).then(function() {
                                    window.location = "add-admin.php";
                                });
                            </script>';
                    
                            die();
                            exit;
                        }
                        else 
                        {
                            // Image uploaded successfully
                            
                        }
                    }
            
            }
            else
            {
                $image_name = ""; 
            }

                  //SQL query to save the data into database
          $sql = "INSERT INTO tbl_admin SET  username = '$username' , email = '$email',
          address = '$address' , password = '$password' , age = '$age', image = '$image_name'
          ";

          //execute query to insert data in database
          $result = mysqli_query($conn , $sql) or die(mysqli_error());

          //check the query is executed or not

          if ($result == true) {
            
              
              echo '<script>
                  swal({
                      title: "Success",
                      text: "Admin Successfully Inserted",
                      icon: "success"
                  }).then(function() {
                      window.location = "admin-acc.php";
                  });
              </script>';
              
              exit; // Make sure to exit after performing the redirect
          }
          
      else{
          echo '<script>
          swal({
              title: "Error",
              text: "Admin Failed to  Insert",
              icon: "error"
          }).then(function() {
              window.location = "add-admin.php";
          });
      </script>';

      exit;
          
      }

          }
        
        ?>

     
      </main>
      <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
  </body>
</php>