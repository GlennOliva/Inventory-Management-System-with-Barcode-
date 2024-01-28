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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/form.css">

    <link rel="shortcut icon" href="images/tup-white.png" type="image/x-icon">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body>
    <div class="grid-container">


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
          <p class="font-weight-bold">UPDATE ADMIN</p>
        </div>


                    <?php

            //1get the id 
            $id = $_GET['id'];

            //create sql querty

            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            //execute the query
            $result = mysqli_query($conn,$sql);

            //check if the query is executed or not!
            if($result == True)
            {
                //check if the data is available or not
                $count = mysqli_num_rows($result);

                //ccheck if we have admin data or not
                if($count==1)
                {
                    //display the details
                    //echo "admin available"; 
                    $row = mysqli_fetch_assoc($result);

                    $username = $row['username'];
                    $email = $row['email'];
                    $address = $row['address'];
                    $age = $row['age'];
                    $current_image = $row['image'];

                  
                }
                else
                {
                    header('Location: admin-acc.php');
                    exit();
                }
            }

            ?>

        <form action="" method="post" enctype="multipart/form-data">

            <div class="dummy-image" >
          <?php
 
   
     
             if($current_image == "")
             {
                 //image not available
                 echo '<script>
                 swal({
                     title: "Error",
                     text: "Image not available",
                     icon: "error"
                 }).then(function() {
                     window.location = "admin-acc.php";
                 });
             </script>';
 
             exit;
 
             }
             else
             {
                 //image available
                 ?>
                     <img src="images/admin/<?php echo $current_image;?>" style="width: 20%;">
 
                 <?php
             }
         
         ?> 
         
 
     
     </div>
 
 
     <div class="flex">
          <div class="inputBox">
             <span>Update Username (required)</span>
             <input type="text" class="box" required maxlength="100" placeholder="enter username" name="name" value="<?php echo $username;?>">
          </div>
 
          <div class="inputBox">
             <span>Update Email (required)</span>
             <input type="text" class="box" required maxlength="100" placeholder="enter email" name="email" value="<?php echo $email;?>">
          </div>
 
          <div class="inputBox">
             <span>Update image (required)</span>
             <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
         </div>
 
 
 
          <div class="inputBox">
     <span>Update Address (required)</span>
     <textarea name="address" placeholder="enter address" class="box" required maxlength="200" cols="20" rows="3"><?php echo $address; ?></textarea>
 </div>

 <div class="inputBox">
    <span>Update Age (required)</span>
    <input type="number" min="0" class="box" required max="9999999999" placeholder="enter age" onkeypress="if(this.value.length == 10) return false;" name="age" value="<?php echo $age;?>">
 </div>



</div>
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="hidden" name="current_image" value="<?php echo $current_image;?>">
<input type="submit" value="Update admin" class="btn" name="update_admin">
</form>
      </main>
      <!-- End Main -->




    </div>


    <?php
    
        //check whether the submit button is clicked or not
        if(isset($_POST['update_admin']))
        {
            $id = $_POST['id'];
            $username = $_POST['name'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $address = $_POST['address'];
            $current_image = $_POST['current_image'];

            //check whether upload button is click or not
            if(isset($_FILES['image']['name']))
            {
                $image_name = $_FILES['image']['name']; //new image nname

                //check if the file is available or not
                if($image_name!="")
                {
                    //image is available

                    //rename the image
                    $ext = end(explode('.', $image_name));
                    $image_name = "Admin-Pic-".rand(0000, 9999).'.'.$ext;

                    //get the source path and destination
                    $src_path = $_FILES['image']['tmp_name'];
                    $destination_path = "images/admin/".$image_name;

                    //upload the image
                    $upload = move_uploaded_file($src_path,$destination_path);

                    //check if the image is uploaded or not
                    if($upload==false)
                    {
                        //failed to upload
                        echo '<script>
                        swal({
                            title: "Error",
                            text: "Failed to upload image",
                            icon: "error"
                        }).then(function() {
                            window.location = "admin-acc.php";
                        });
                    </script>';

                    exit;

                                    
                    }
                    //remove the current image if available
                    if($current_image!="")
                    {
                        //current image is available
                        $remove_path = "images/admin/".$current_image;

                        $remove = unlink($remove_path);

                        //check whether the image is remove or not
                        if($remove==false)
                        {
                            //failed to remove current image
                            echo '<script>
                            swal({
                                title: "Error",
                                text: "Failed to remove current image",
                                icon: "error"
                            }).then(function() {
                                window.location = "admin-acc.php";
                            });
                        </script>';

                        exit;

                            
                        }
                    }
                }
            }
            else
            {
                $image_name = $current_image;
            }




            //create sql query update
            $sql = "UPDATE tbl_admin SET username = '$username' , email = '$email' , age = '$age', address = '$address', image = '$image_name'  WHERE id = '$id'";

            //execute the query
            $result = mysqli_query($conn,$sql);

            //check the query executed or not
            if($result == True)
            {
                //query update sucess
                echo '<script>
                swal({
                    title: "Success",
                    text: "Admin Successfully Update",
                    icon: "success"
                }).then(function() {
                    window.location = "admin-acc.php";
                });
            </script>';
            
            exit; // Make sure to exit after performing the redirect
            }
            else{
                //failed to update
                echo '<script>
                    swal({
                        title: "Error",
                        text: "Admin Failed to  Update",
                        icon: "error"
                    }).then(function() {
                        window.location = "update-admin.php";
                    });
                </script>';

                exit;
            }
        }
    ?>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
  </body>
</html>