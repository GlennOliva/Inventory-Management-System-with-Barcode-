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
          <p class="font-weight-bold">UPDATE BARCODE GENERATE</p>
        </div>


                    <?php

            //1get the id 
            $id = $_GET['id'];

            //create sql querty

            $sql = "SELECT * FROM tbl_barcode WHERE id=$id";

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

                    $product_name = $row['product_name'];
                    $product_description = $row['product_description'];
                    $property_number = $row['property_number'];
                    $price = $row['price'];
                    $quantity_stock = $row['quantity_stock'];
                    $category = $row['category'];
                    $current_image = $row['barcode_image'];

                  
                }
                else
                {
                    header('Location: barcode-gen.php');
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
                     window.location = "barcode-gen.php";
                 });
             </script>';
 
             exit;
 
             }
             else
             {
                 //image available
                 ?>
                     <img src="<?php echo $current_image;?>" style="width: 20%;">
 
                 <?php
             }
         
         ?> 
         
 
     
     </div>
 
 
     <div class="flex">

               <div class="inputBox">
                  <span>Product_name (required)</span>
                  <input type="text" class="box" required maxlength="100" placeholder="enter Product" name="product_name" value="<?php echo $product_name;?>">
               </div>
      
               <div class="inputBox">
                  <span>Product_description (required)</span>
                  <textarea name="product_description" id="" cols="30" rows="10" value="<?php echo $product_description;?>"></textarea>
               </div>
      
               <div class="inputBox">
                  <span>Property_number (required)</span>
                  <input type="number" class="box" required maxlength="100" placeholder="enter property_number" value="<?php echo $property_number;?>" name="property_number">
               </div>
      
               <div class="inputBox">
                <span>Product_stock (required)</span>
                <input type="number" class="box" required maxlength="100" placeholder="enter product_stock" value="<?php echo $quantity_stock?>" name="product_stock">
             </div>
              
               <div class="inputBox">
                  <span>Product_price (required)</span>
                  <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" value="<?php echo $price;?>" onkeypress="if(this.value.length == 10) return false;" name="product_price">
               </div>

               <div class="inputBox">
                <span>Product_Category (required)</span>
                <select id="product_category" name="product_category">
                    <option value="Electronics" <?php if ($category === 'Electronics') echo 'selected'; ?>>Electronics</option>
                    <option value="Appliances" <?php if ($category === 'Appliances') echo 'selected'; ?>>Appliances</option>
                    <option value="cleaning_material" <?php if ($category === 'cleaning_material') echo 'selected';?>>Cleaning Material</option>
                </select>
                    </div>

      
      
      
            </div>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
            <input type="submit" value="Update Barcode" class="btn" name="update_barcode">
            </form>
      </main>
      <!-- End Main -->




    </div>

    <?php
// Check whether the submit button is clicked or not
include('phpqrcode/qrlib.php');
if (isset($_POST['update_barcode'])) {
    $id = $_POST['id'];
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $property_number = mysqli_real_escape_string($conn, $_POST['property_number']);
    $quantity_stock = intval($_POST['product_stock']); // Ensure it's an integer
    $price = floatval($_POST['product_price']); // Ensure it's a float
    $category = mysqli_real_escape_string($conn, $_POST['product_category']);

    // Generate the new barcode data based on the updated product details
    $new_barcode_data = "$product_name $product_description $property_number $quantity_stock $price $category";

    // Generate QR code for the new data
    $file = 'images/qrcode/' . time() . '.png';
    QRcode::png($new_barcode_data, $file, 'H', 4, 4);

    // Get the current barcode image from the database
    $sql_get_current_image = "SELECT barcode_image FROM tbl_barcode WHERE id = '$id'";
    $result_get_current_image = mysqli_query($conn, $sql_get_current_image);
    
    // Check if the query executed successfully
    if ($result_get_current_image === false) {
        // Query error
        $error_message = mysqli_error($conn);
        die("SQL Error: $error_message");
    }
    
    // Check if any rows were returned
    if (mysqli_num_rows($result_get_current_image) === 0) {
        // No records matched the provided ID
        echo '<script>
        swal({
            title: "Error",
            text: "No records matched the update criteria for ID ' . $id . '",
            icon: "error"
        }).then(function() {
            window.location = "update-barcodegen.php";
        });
        </script>';
        exit;
    }

    $row_get_current_image = mysqli_fetch_assoc($result_get_current_image);
    $current_image = $row_get_current_image['barcode_image'];

    // Update the barcode details in the database (including the image)
    $sql = "UPDATE tbl_barcode SET product_name = '$product_name', product_description = '$product_description', property_number = '$property_number', quantity_stock = '$quantity_stock', price = '$price', category = '$category', barcode_image = '$file' WHERE id = '$id'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($result === true) {
        // Query update successful, you can remove the current image if needed
        // Assuming the $current_image variable contains the filename of the current image
        if (!empty($current_image)) {
            $remove_path = "images/qrcode/$current_image";
            unlink($remove_path); // Remove the current image
        }

        echo '<script>
        swal({
            title: "Success",
            text: "Barcode Successfully Updated",
            icon: "success"
        }).then(function() {
            window.location = "barcode-gen.php";
        });
        </script>';

        exit; // Make sure to exit after performing the redirect
    } else {
        // Failed to update
        $error_message = mysqli_error($conn); // Get the MySQL error message
        echo '<script>
        swal({
            title: "Error",
            text: "Barcode Failed to Update: ' . $error_message . '",
            icon: "error"
        }).then(function() {
            window.location = "update-barcodegen.php";
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