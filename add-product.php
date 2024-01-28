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


    <script src="./node_modules/html5-qrcode/html5-qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <!-- Include the required JavaScript libraries -->


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
          <p class="font-weight-bold">ADD PRODUCT</p>
        </div>
        
                <style>
                  #reader {
  width: 400px;

  margin-bottom: 2%;
  border: 2px solid #000; /* Add a black border with 2px width */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Add a shadow effect */
}
                </style>

    

        <div id="reader"></div>


        


    <!-- Add an event listener for when a QR code is successfully scanned -->
    <script type="text/javascript">

function showHint(qrCodeMessage) {
  // Replace this with your desired logic for handling the QR code message
  console.log("QR Code Message: " + qrCodeMessage);
}

function onScanSuccess(qrCodeMessage) {
  // Split the scanned data into an array based on whitespace
  const scannedDataArray = qrCodeMessage.split(' ');

  // Check if the scanned data has the expected number of elements
  if (scannedDataArray.length < 5) {
    // Display an error message if the data is not as expected
    swal({
      title: "Error",
      text: "Scanned data does not contain all required elements",
      icon: "error"
    });
    return; // Stop processing further
  }

  // Populate the form fields with the scanned data
  document.getElementById("result").value = scannedDataArray[0]; // Product Name
  document.getElementById("product_description").value = scannedDataArray[1]; // Product Description
  document.getElementById("property_number").value = scannedDataArray[2]; // Property Number
  document.getElementById("product_price").value = scannedDataArray[3]; // Product Price
  document.getElementById("product_stock").value = scannedDataArray[4]; // Product Stock

  // Handle the "Product Category" field, considering additional elements
  if (scannedDataArray.length > 5) {
    document.getElementById("product_category").value = scannedDataArray.slice(5).join(' ');
  } else {
    // If no additional elements, set "Product Category" to an empty string
    document.getElementById("product_category").value = "";
  }

  console.log("QR Code Message: " + qrCodeMessage);
  console.log("Scanned Data Array Length: " + scannedDataArray.length);

  // Call the function to handle form submission
  submitForm();

  // Display a success message (optional)
  swal({
    title: "Success",
    text: "Product Successfully Inserted",
    icon: "success"
  }).then(function() {
    window.location = "inventory-product.php";
  });
}


function onScanError(errorMessage) {
  // Handle scan error here, e.g., display an error message
  console.error("QR Code Scan Error: " + errorMessage);
}



function submitForm() {
  // Get form data
  const productName = document.getElementById("result").value;
  const productDescription = document.getElementById("product_description").value;
  const propertyNumber = document.getElementById("property_number").value;
  const productPrice = document.getElementById("product_price").value;
  const productStock = document.getElementById("product_stock").value;
  const productCategory = document.getElementById("product_category").value;

 


   console.log("productName:", productName);
   console.log("productDescription:", productDescription);
   console.log("productCategory:", productCategory);
  console.log("propertyNumber:", propertyNumber);
   console.log("productStock:", productStock);
  console.log("productPrice:", productPrice);

  // Create a FormData object to send the data
  const formData = new FormData();
  formData.append('product_name', productName);
  formData.append('product_description', productDescription);
  formData.append('property_number', propertyNumber);
  formData.append('product_price', productPrice);
  formData.append('product_stock', productStock);
  formData.append('product_category', productCategory);
 



  // Send a POST request to the PHP script
  fetch('insert_data.php', {
    method: 'POST',
    body: formData,
  })
  .then(response => {
    // Handle the response from the server (e.g., display a success message)
    console.log(response);
  })
  .catch(error => {
    // Handle any errors
    console.error(error);
  });
}

var html5QrcodeScanner = new Html5QrcodeScanner(
  "reader", { fps: 10, qrbox: 250 }
);
html5QrcodeScanner.render(onScanSuccess, onScanError);

</script>


       

             <form action="" method="post" enctype="multipart/form-data">
                <div class="flex">
                    
                   <div class="inputBox">
                      <span>Product_name (required)</span>
                      <input type="text" class="box" required maxlength="100" id="result" placeholder="enter Product" name="product_name">
                      <input type="hidden" id="scanned_value" name="scanned_value">
                   </div>


                   
          
                  <div class="inputBox">
                      <span>Product_description (required)</span>
                      <textarea name="product_description" id="product_description" cols="30" rows="10"></textarea>
                     
                   </div>

                   <div class="inputBox">
                      <span>Property_number (required)</span>
                      <input type="number" class="box" id="property_number" required maxlength="100" placeholder="enter property_number" name="property_number">
                   </div>


                

                   <div class="inputBox">
                      <span>Product_price (required)</span>
                      <input type="number" min="0" class="box"  required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="product_price" id="product_price">
                   </div>
          
                  
    
                 
          
                   <div class="inputBox">
                    <span>Product_stock (required)</span>
                    <input type="number" class="box"  required maxlength="100" placeholder="enter product_stock" name="product_stock" id="product_stock">
                 </div>

                 <div class="inputBox">
                    <span>Product Category (required)</span>
                    <input type="text" class="box" required placeholder="Enter product category" name="product_category" id="product_category">
                </div>


                  
                  

               

      
          
          
                </div>
                
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
</php>