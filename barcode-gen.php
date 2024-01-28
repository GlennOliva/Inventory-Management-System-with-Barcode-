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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
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
            <a href="inventory-product.php" >
              <span class="material-icons-outlined">fact_check</span> Inventory Product
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="barcode-gen.php">
              <span class="material-icons-outlined">qr_code_scanner</span> Barcode Generate
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="reportlist.php">
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
      <main class="main-container" id="admin_table">
        <div class="main-title">
          <p class="font-weight-bold">Barcode Generate</p>
        </div>

        
        <div class="btn-add">
            <a href="add-barcodegen.php" class="btn1"><i class="material-icons-outlined">qr_code</i> Add Barcode</a>
        </div>
           <table  style="width: 100%;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Product_name</th>
                    <th>Property_number</th>
                    <th>Product_price</th>
                    <th>Product_stock</th>
                    <th>barcode_Image</th>
                    <th>Category</th> 
                    <th>Actions</th>
                </tr>
            </thead>

            <?php
              //sql query 
              $sql = "SELECT * FROM tbl_barcode";

              $res = mysqli_query($conn,$sql);

              $count = mysqli_num_rows($res);

              if($count>0)
              {
                while($row = mysqli_fetch_assoc($res))
                {
                  $id = $row['id'];
                  $product_name = $row['product_name'];
                  $product_description = $row['product_description'];
                  $property_number = $row['property_number'];
                  $price = $row['price'];
                  $quantity_stock = $row['quantity_stock'];
                  $barcode_image = $row['barcode_image'];
                  $category = $row['category'];

                  ?>

                  <tr>
                <td><?php echo $id;?></td>
                <td><?php echo $product_name;?></td>
                <td><?php echo $property_number;?></td>
                <td><?php echo $price;?></td>
                <td><?php echo $quantity_stock;?></td>
                <td><img src="<?php echo $barcode_image; ?>" width='65px' ></td>
                <td><?php echo $category;?></td>
                <td>
                    <div class="btn-group">
                            <a href="update-barcodegen.php?id=<?php echo $id; ?>" class="btn"><i class="material-icons-outlined">edit</i> Update</a>
                            <form action="code.php" method="post">
                            <button type="button"  class="btn-del delete_barbtn" value="<?= $id;?>"><i class="material-icons-outlined">delete</i> Delete</button>
                            </form>
                        </div>
                </td>
            </tr>



                  <?php
                  
                }
              }
            ?>
            
                

            </table>

      </main>
      <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script src="js/deladmin.js"></script>
  </body>
</html>