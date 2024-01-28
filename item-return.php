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
             $employee_id = $_SESSION['emp_id'];
            
         
            
             //sql query to get all data in database
             $sql2 = "SELECT * FROM tbl_employee WHERE id = $employee_id";

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
          <p class="font-weight-bold">Item list Borrowed</p>
        </div>

           <table  style="width: 95%;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Emp_Id</th>
                    <th>Product_name</th>
                    <th>Employee_name</th>
                    <th>Product_Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Property_number</th>
                    <th>Date Borrowed</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <?php 
      

                //query to get all data from tbl_admin database
                $sql = "SELECT * FROM tbl_borroweditem WHERE employee_id = $employee_id";

                //execute the query
                $result = mysqli_query($conn,$sql);

                //check whether if the query is execute or not

                if($result==True)
                {
                    //count the rows to check we have data in database or not
                    $count = mysqli_num_rows($result);

                    $ids=1;

                    //check the num of rows
                    if($count>0)
                    {
                        while($rows=mysqli_fetch_assoc($result))
                        {
                            $id = $rows['id'];
                            $emp_id = $rows['employee_id'];
                            $product_name = $rows['product_name'];
                            $employee_name = $rows['employee_name'];
                            $category = $rows['category'];
                            $quantity = $rows['quantity'];
                            $price = $rows['price'];
                            $property_number = $rows['property_number'];
                            $place_on = $rows['place_on'];

                            ?>
                            <tr>
                            <td><?php echo $ids++;?></td>
                            <td><?php echo $emp_id;?></td>
                            <td><?php echo $product_name;?></td>
                            <td><?php echo $employee_name;?></td>
                            <td><?php echo $category;?></td>
                            <td><?php echo $quantity;?></td>
                            <td><?php echo $price;?></td>
                            <td><?php echo $property_number;?></td>
                            <td><?php echo $place_on;?></td>
                           
                            <td style>
                          <form action="" method="post">
                          <div class="btn-group" style="margin-right: 30px;">
                            <input  type="submit" class="btn" value="Return Item" name="return_item">
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <input type="hidden" name="emp_id" value="<?php echo $emp_id;?>">
                            <input type="hidden" name="product_name" value="<?php echo $product_name;?>">
                            <input type="hidden" name="employee_name" value="<?php echo $employee_name;?>">
                            <input type="hidden" name="category" value="<?php echo $category;?>">
                            <input type="hidden" name="quantity_stock" value="<?php echo $quantity;?>">
                            <input type="hidden" name="price" value="<?php echo $price;?>">
                            <input type="hidden" name="property_number" value="<?php echo $property_number;?>">
                        </div>
                        </form>
                </td>
            </tr>
        
                
            <?php
            
                        }
                        
                    }
                    else
                    {

                    }

                }

            ?>

            </table>


            <?php
if (isset($_POST['return_item'])) {
    $borrow_id = $_POST['id'];
    $emp_id = $_POST['emp_id'];
    $product_name = $_POST['product_name'];
    $employee_name = $_POST['employee_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity_stock'];
    $price = $_POST['price'];
    $property_number = $_POST['property_number'];

   
    $delete_query = "DELETE FROM tbl_borroweditem WHERE id = $borrow_id";
    if ($conn->query($delete_query) === TRUE) {
        // Step 2: Increment stock in tbl_product
        $update_query = "UPDATE tbl_product SET quantity_stock = quantity_stock + $quantity WHERE product_name = '$product_name'";
        if ($conn->query($update_query) === TRUE) {
            // Step 3: Insert into tbl_returnitem
            $insert_query = "INSERT INTO tbl_returnitem (borrow_id, emp_id, product_name, employee_name, category, quantity_stock, price, property_number , date_return , item_status) VALUES ('$borrow_id','$emp_id', '$product_name', '$employee_name', '$category', $quantity, $price, '$property_number' , NOW() , 'Returned')";
            if ($conn->query($insert_query) === TRUE) {
              echo '<script>
              swal({
                  title: "Success",
                  text: "Successfully Return Item",
                  icon: "success"
              }).then(function() {
                  window.location = "item-return.php";
              });
              </script>';
              exit;
            } else {
              echo '<script>
              swal({
                  title: "Error",
                  text: "Failed to Return Item",
                  icon: "error"
              }).then(function() {
                  window.location = "item-return.php";
              });
              </script>';
              exit;
            }
        } else {
          echo '<script>
          swal({
              title: "Error",
              text: "Failed to update product stock",
              icon: "error"
          }).then(function() {
              window.location = "item-return.php";
          });
          </script>';
          exit;
        }
    } else {
      echo '<script>
      swal({
          title: "Error",
          text: "Failed to delete Item",
          icon: "error"
      }).then(function() {
          window.location = "item-return.php";
      });
      </script>'; 
      exit;
    }
    
    $conn->close();
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
    <script src="js/deladmin.js"></script>
  </body>
</html>