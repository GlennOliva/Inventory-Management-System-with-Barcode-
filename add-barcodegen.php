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
            <a href="index.php">
              <span class="material-icons-outlined">dashboard</span> Dashboard
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="admin-acc.php" >
              <span class="material-icons-outlined">person</span> Admin account
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="employee-acc.php" >
              <span class="material-icons-outlined">badge</span> Employee
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="inventory-product.php">
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
      <main class="main-container" >
        <div class="main-title">
          <p class="font-weight-bold">Barcode Generator</p>
        </div>

        <?php
include('phpqrcode/qrlib.php');

if (isset($_POST['add_qr'])) {
    // Sanitize and validate user inputs
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $property_number = mysqli_real_escape_string($conn, $_POST['property_number']);
    $product_stock = intval($_POST['product_stock']); // Ensure it's an integer
    $product_price = floatval($_POST['product_price']); // Ensure it's a float
    $product_category = mysqli_real_escape_string($conn, $_POST['product_category']);
    $path = 'images/qrcode/';
    $file = $path . time(). ".png";

    $query = "INSERT INTO tbl_barcode (product_name, product_description, property_number,  price, quantity_stock, category, barcode_image)
              VALUES ('$product_name', '$product_description', '$property_number', '$product_price', '$product_stock',  '$product_category', '$file')";

    if ($conn->query($query) === true) {
        // Generate QR code
        $data_to_encode = "$product_name $product_description $property_number $product_price $product_stock  $product_category";
        QRcode::png($data_to_encode, $file, 'H', 4 , 4);

        // Display the generated QR code image
        echo '<img src="' . $file . '" alt="Generated QR Code">';

        echo '<script>
        swal({
            title: "Success",
            text: "Barcode Successfully Inserted",
            icon: "success"
        }).then(function() {
            window.location = "barcode-gen.php";
        });
        </script>';

        exit;
    } else {
        echo '<script>
        swal({
            title: "Error",
            text: "Barcode Failed to Insert",
            icon: "error"
        }).then(function() {
            window.location = "barcode-gen.php";
        });
        </script>';

        exit;
    }
}
?>



        
        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex">

               <div class="inputBox">
                  <span>Product_name (required)</span>
                  <input type="text" class="box" required maxlength="100" placeholder="enter Product" name="product_name">
               </div>
      
               <div class="inputBox">
                  <span>Product_description (required)</span>
                  <textarea name="product_description" id="" cols="30" rows="10"></textarea>
                 
               </div>

      
               <div class="inputBox">
                  <span>Property_number (required)</span>
                  <input type="number" class="box" required maxlength="100" placeholder="enter property_number" name="property_number">
               </div>
      
              
               <div class="inputBox">
                  <span>Product_price (required)</span>
                  <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="product_price">
               </div>

               
               <div class="inputBox">
                <span>Product_stock (required)</span>
                <input type="number" class="box" required maxlength="100" placeholder="enter product_stock" name="product_stock">
             </div>

               <div class="inputBox">
               <span>Product_Category (required)</span>
                <select id="product_category" name="product_category">
                    <option value="electronics">Electronics</option>
                    <option value="appliances">Applianes</option>
                    <option value="cleaning_material">Cleaning Material</option>
                </select>
              </div>
      
      
      
            </div>
            
            <input type="submit" value="Generate QR code" class="btn" name="add_qr">
         </form>
      </main>
      <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
  </body>
</html>