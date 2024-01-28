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
    <link rel="shortcut icon" href="images/tup-white.png" type="image/x-icon">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/form.css">

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
          <p class="font-weight-bold">UPDATE PRODUCT</p>
        </div>

        


<?php
include('config/dbcon.php');




// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch the product data based on the provided ID (You may need to modify this query)
    $sql = "SELECT * FROM tbl_product WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    
    // Check if a product with the provided ID exists
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the product details and assign them to variables
        $row = mysqli_fetch_assoc($result);
        $product_name = $row['product_name'];
        $product_desc = $row['product_description'];
        $property_num = $row['property_number'];
        $price = $row['price'];
        $quantity_stock = $row['quantity_stock'];
        $category = $row['category'];
    } else {
        // Handle the case where the product with the provided ID does not exist
        header('Location: update-product.php?error=product_not_found');
        exit;
    }
}

// Rest of your form HTML

?>



      
            <form action="" method="post" enctype="multipart/form-data">

           
     
         <div class="flex">
            <div class="inputBox">
                <span>Product_name (required)</span>
                <input type="text" class="box" required maxlength="100" placeholder="enter Product" value="<?php echo $product_name;?>"  id="product_name" name="product_name">
             </div>
    
             <div class="inputBox">
    <span>Product_description (required)</span>
    <textarea name="product_description" id="product_description" required cols="30" rows="10"><?php echo $product_desc; ?></textarea>
</div>

    
             <div class="inputBox">
                <span>Property_number (required)</span>
                <input type="number" class="box" required maxlength="100" placeholder="enter property_number" value="<?php echo $property_num;?>"  id="property_number" name="property_number">
             </div>

             <div class="inputBox">
                <span>Product_price (required)</span>
                <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" value="<?php echo $price;?>" onkeypress="if(this.value.length == 10) return false;" id="product_price" name="product_price">
             </div>
    
             <div class="inputBox">
              <span>Product_stock (required)</span>
              <input type="number" class="box" required maxlength="100"  placeholder="enter product_stock" id="product_stock" value="<?php echo $quantity_stock;?>"  name="product_stock">
           </div>
            
            

             <div class="inputBox">
                <span>Product_category (required)</span>
                <input type="text" class="box" required maxlength="100" value="<?php echo $category;?>" placeholder="enter Product"  id="product_category" name="product_category">
             </div>


             
    
    
    
    </div>

    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="submit" value="Update Product" class="btn" name="update_product">

  
    </form>

         

    
      </main>
      <!-- End Main -->


      <?php
      if(isset($_POST['update_product']))
      {
        $id = $_POST['id'];
        $product_name = $_POST['product_name'];
        $product_desc = $_POST['product_description'];
        $property_number = $_POST['property_number'];
        $product_price = $_POST['product_price'];
        $product_stock = $_POST['product_stock'];
        $product_category = $_POST['product_category'];

        //sql query
        $updateproduct = "UPDATE tbl_product SET product_name='$product_name', product_description='$product_desc',
        property_number='$property_number', price='$product_price', quantity_stock='$product_stock', category='$product_category' WHERE id='$id'";


        //res
        $res = mysqli_query($conn,$updateproduct);

        if($res == true)
        {
          //data updated
          echo '<script>
        swal({
            title: "Success",
            text: "Product is updated",
            icon: "success"
        }).then(function() {
            window.location = "inventory-product.php";
        });
        </script>';
        exit;

        }
        else
        {
          //data not update
          echo '<script>
        swal({
            title: "Error",
            text: "Product not updated",
            icon: "error"
        }).then(function() {
            window.location = "update-product.php";
        });
        </script>';
        exit;
        }
      }
      
      ?>



    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
  </body>
</html>