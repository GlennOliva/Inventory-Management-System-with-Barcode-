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
    <link rel="stylesheet" href="css/form.css">
  </head>
  <body>

  <?php
  if(!isset($_SESSION['emp_id']))
  {
      echo '<script>
                                      swal({
                                          title: "Error",
                                          text: "You must login first before you proceed!",
                                          icon: "error"
                                      }).then(function() {
                                          window.location = "employee-login.php";
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
         if(isset($_SESSION['emp_id']))

         {
             $emp_id = $_SESSION['emp_id'];
            
         
            
             //sql query to get all data in database
             $sql2 = "SELECT * FROM tbl_employee WHERE id = $emp_id";

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
                          text: "Employee not available",
                          icon: "error"
                      }).then(function() {
                          window.location = "employee-login.php";
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
            <a href="borrow-item.php">
              <span class="material-icons-outlined">inventory</span> Borrow Item Product
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="item-return.php" >
              <span class="material-icons-outlined">assignment_returned</span> Item Product Return
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="employee-logout.php" >
              <span class="material-icons-outlined">logout</span> Logout
            </a>
          </li>
        </ul>
      </aside>
      <!-- End Sidebar -->

      <!-- Main -->
      <main class="main-container" id="admin_table">
        <div class="main-title">
          <p class="font-weight-bold">Borrow Item Product</p>
        </div>
        <?php
// Assuming you have a database connection established earlier as $conn

// Query to select all product details
$selectitem = "SELECT product_name, category, property_number, price FROM tbl_product";
$itemres = mysqli_query($conn, $selectitem);

// Check if there are any products
if (mysqli_num_rows($itemres) > 0) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="flex">
            <div class="inputBox">
                <span>Product Name (required)</span>
                <select id="product_name" name="product_name">
                    <option value="">Select Product</option>
                    <?php
                    while ($row = mysqli_fetch_assoc($itemres)) {
                        $product_name = $row['product_name'];
                        $category = $row['category'];
                        $property_number = $row['property_number'];
                        $price = $row['price'];
                        echo "<option value='$product_name' data-category='$category' data-property='$property_number' data-price='$price'>$product_name</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Your other input fields go here -->
            <div class="inputBox">
                <span>Product Category (required)</span>
                <input type="text" class="box" required maxlength="100" placeholder="Category" name="product_category" id="product_category">
            </div>
            <div class="inputBox">
                <span>Employee_name (required)</span>
                <input type="text" class="box" required maxlength="100" placeholder="Enter name" name="emp_name" id="emp_name">
            </div>
            <div class="inputBox">
                <span>Property Number (required)</span>
                <input type="text" class="box" required maxlength="100" placeholder="Property Number" name="property_number" id="property_number">
            </div>
            <div class="inputBox">
                <span>Price (required)</span>
                <input type="text" class="box" required maxlength="100" placeholder="Price" name="price" id="price">
            </div>
            <div class="inputBox">
                <span>Quantity (required)</span>
                <input type="text" class="box" required maxlength="100" placeholder="Price" name="quantity" id="quantity">
            </div>
        </div>
        <input type="submit" value="Borrow Item" class="btn" name="borrow_item">
    </form>
    <script>
        // JavaScript to handle dropdown change event
        document.getElementById("product_name").addEventListener("change", function () {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById("product_category").value = selectedOption.getAttribute("data-category");
            document.getElementById("property_number").value = selectedOption.getAttribute("data-property");
            document.getElementById("price").value = selectedOption.getAttribute("data-price");
        });
    </script>
    <?php
} else {
    echo "No products found.";
}
?>


<?php
if(isset($_POST['borrow_item']))
{
  $product_name = $_POST['product_name'];
  $category = $_POST['product_category'];
  $emp_name = $_POST['emp_name'];
  $property_number = $_POST['property_number'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];

  // Retrieve the current stock quantity
  $selectStock = "SELECT quantity_stock FROM tbl_product WHERE product_name = '$product_name'"; // Adjust your table and column names
  $stockResult = mysqli_query($conn, $selectStock);

  if(mysqli_num_rows($stockResult) > 0) {
    $row = mysqli_fetch_assoc($stockResult);
    $currentStock = $row['quantity_stock'];
    
    // Check if there is enough stock to borrow
    if ($currentStock >= $quantity) {
      // Calculate the new stock quantity
      $newStock = $currentStock - $quantity;

      // Update the stock quantity in the database
      $updateStock = "UPDATE tbl_product SET quantity_stock = $newStock WHERE product_name = '$product_name'";
      $updateResult = mysqli_query($conn, $updateStock);

      if($updateResult) {
        // Insert the borrowed item
        $sql = "INSERT INTO tbl_borroweditem SET employee_id = $emp_id , product_name = '$product_name' , employee_name = '$emp_name' ,quantity = $quantity , property_number = $property_number , price = $price , category = '$category' , place_on = NOW()";
        $res = mysqli_query($conn, $sql);

        if($res == true) {
          // Successfully borrowed item
          echo '<script>
          swal({
              title: "Success",
              text: "Successfully Borrow Item",
              icon: "success"
          }).then(function() {
              window.location = "item-return.php";
          });
          </script>';
          exit;
        } else {
          // Failed to insert the borrowed item
          echo '<script>
          swal({
              title: "Error",
              text: "Failed Borrow Item",
              icon: "error"
          }).then(function() {
              window.location = "borrow-item.php";
          });
          </script>';
          exit;
        }
      } else {
        // Failed to update stock quantity
        echo '<script>
        swal({
            title: "Error",
            text: "Failed to Update Stock Quantity",
            icon: "error"
        }).then(function() {
            window.location = "borrow-item.php";
        });
        </script>';
        exit;
      }
    } else {
      // Not enough stock to borrow
      echo '<script>
      swal({
          title: "Error",
          text: "Not Enough Stock to Borrow",
          icon: "error"
      }).then(function() {
          window.location = "borrow-item.php";
      });
      </script>';
      exit;
    }
  } else {
    // Product not found in the database
    echo '<script>
    swal({
        title: "Error",
        text: "Product not found in the database",
        icon: "error"
    }).then(function() {
        window.location = "borrow-item.php";
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
    <script src="js/deladmin.js"></script>
  </body>
</php>