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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
          <p class="font-weight-bold">Report List</p>
        </div>
        <div class="print-btn-container">
            <form method="POST" class="dateform" style="margin-bottom: 20px;">
                <label for="from_date" class="from_date">From Date:</label>
                <input type="date" id="from_date" name="from_date">
                <label for="to_date" class="to_date">To Date:</label>
                <input type="date" id="to_date" name="to_date">
                <input type="submit" name="submit" value="Filter">
            </form>
        
            <a href="print.php" class="print-btn"><i class="material-icons-outlined">print</i></a>
        </div>
        
        <table class="tbl-full" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Borrowed_id</th>
                    <th>Emp_id</th>
                    <th>Product_name</th>
                    <th>Employee_name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Property_number</th>
                    <th>Date_return</th>
                    <th>Item_status</th>
                </tr>
            </thead>
            <tbody>
                <!-- <?php
                // Initialize the date variables
                $from_date = isset($_POST['from_date']) ? $_POST['from_date'] : null;
                $to_date = isset($_POST['to_date']) ? $_POST['to_date'] : null;
        
                // Build the SQL query
                $income = "SELECT * FROM tbl_returnitem WHERE item_status = 'Returned'";
                if ($from_date && $to_date) {
                    $income .= " AND date_return >= '$from_date' AND date_return <= '$to_date'";
                }
        
                // Execute the query
                $incomeres = mysqli_query($conn, $income);
                $totalSum = 0;
        
                // Count the rows
                $incomecount = mysqli_num_rows($incomeres);
        
                // Check the count greater than 0 
                if ($incomecount > 0) {
                    $ids = 1;
                    // Fetch the data
                    while ($incomerow = mysqli_fetch_assoc($incomeres)) {
                        // ... Fetch the data as before
                        $id = $incomerow['id'];
                        $borrow_id = $incomerow['borrow_id'];
                        $emp_id = $incomerow['emp_id'];
                        $product_name = $incomerow['product_name'];
                        $employee_name = $incomerow['employee_name'];
                        $category = $incomerow['category'];
                        $quantity = $incomerow['quantity_stock'];
                        $price = $incomerow['price'];
                        $property_number = $incomerow['property_number'];
                        $date_return = $incomerow['date_return'];
                        $item_status = $incomerow['item_status']
        
                        ?> -->
                        <tr>
                            <td><?php echo $ids++;?></td>
                            <td><?php echo $borrow_id;?></td>
                            <td><?php echo $emp_id;?></td>
                            <td><?php echo $product_name;?></td>
                            <td><?php echo $employee_name;?></td>
                            <td><?php echo $category;?></td>
                            <td><?php echo $quantity;?></td>
                            <td><?php echo $price;?></td>
                            <td><?php echo $property_number;?></td>
                            <td><?php echo $date_return;?></td>
                            <td><?php echo $item_status;?></td>
                         
                        </tr>
                        <!-- <?php
                    }
                }
                ?> -->
                
            </tbody>
        </table>
        
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