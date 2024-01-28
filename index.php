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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>

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
          <p class="font-weight-bold">DASHBOARD</p>
        </div>

        <div class="main-cards">

            <?php
            $sql = "SELECT COUNT(*) AS product_count FROM tbl_product";

            $prodres = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($prodres);

            if($prodres)
            {
              $row = mysqli_fetch_assoc($prodres);
              $product_count = $row['product_count'];
            }
            
            ?>

          <div class="card">
            <div class="card-inner">
              <p class="text-primary">PRODUCTS</p>
              <span class="material-icons-outlined text-blue">inventory_2</span>
            </div>
            <span class="text-primary font-weight-bold"><?php echo $product_count;?></span>
          </div>

          <?php
            $sql1 = "SELECT COUNT(*) AS item_count FROM tbl_borroweditem";

            $itemres = mysqli_query($conn, $sql1);

            $count = mysqli_num_rows($itemres);

            if($itemres)
            {
              $row = mysqli_fetch_assoc($itemres);
              $item_count = $row['item_count'];
            }
            
            ?>

          <div class="card">
            <div class="card-inner">
              <p class="text-primary">BROUGHT ITEM</p>
              <span class="material-icons-outlined text-orange">add_shopping_cart</span>
            </div>
            <span class="text-primary font-weight-bold"><?php echo $item_count;?></span>
          </div>

          <?php
            $sql3 = "SELECT COUNT(*) AS emp_count FROM tbl_employee";

            $empres = mysqli_query($conn, $sql3);

            $count = mysqli_num_rows($empres);

            if($empres)
            {
              $row = mysqli_fetch_assoc($empres);
              $emp_count = $row['emp_count'];
            }
            
            ?>


          <div class="card">
            <div class="card-inner">
              <p class="text-primary">EMPLOYEE</p>
              <span class="material-icons-outlined text-green">badge</span>
            </div>
            <span class="text-primary font-weight-bold"><?php echo $emp_count;?></span>
          </div>

          <?php
            $sql4 = "SELECT COUNT(*) AS admin_count FROM tbl_admin";

            $adminres = mysqli_query($conn, $sql4);

            if($adminres)
            {
              $row = mysqli_fetch_assoc($adminres);
              $admin_count = $row['admin_count'];
            }
            
            ?>


          <div class="card">
            <div class="card-inner">
              <p class="text-primary">ADMIN NO.</p>
              <span class="material-icons-outlined text-red">person</span>
            </div>
            <span class="text-primary font-weight-bold"><?php echo $admin_count;?></span>
          </div>

        </div>


        <?php
$sqlcat = "SELECT category, COUNT(*) AS product_count FROM tbl_product GROUP BY category";
$resultcat = mysqli_query($conn, $sqlcat);
$category = array();
$productCount = array();

while ($row = mysqli_fetch_array($resultcat)) {
    $category[] = $row['category'];
    $productCount[] = $row['product_count'];



}



$sql = "SELECT
            DATE_FORMAT(date_return, '%b') AS month_name,
            COUNT(*) AS borrow_count
        FROM
            tbl_returnitem
        GROUP BY
            month_name
        ORDER BY
            month_name";
            $months = array();
            $borrowCounts = array();
            
            // Execute the SQL query
$result = mysqli_query($conn, $sql);

if (!$result) {
    // Query failed, handle the error
    echo "SQL Error: " . mysqli_error($conn);
} else {
    // Query succeeded, fetch the data
    $months = array();
    $borrowCounts = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $months[] = $row['month_name'];
        $borrowCounts[] = (int)$row['borrow_count'];
    }

    // Format the data for ApexCharts
    $chartData = array(
        'labels' => $months,
        'series' => array(
            array(
                'name' => 'Borrowed Items',
                'data' => $borrowCounts,
            ),
        ),
    );

    // Convert the data to JSON for use in JavaScript
    $chartDataJson = json_encode($chartData);
}
            
?>


        <div class="charts">

          <div class="charts-card">
            <p class="chart-title">Top 5 Products</p>
            <div id="bar-chart">
            <script>
    var barChartOptions = {
        series: [{
            data: <?php echo json_encode($productCount); ?>,
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: false
            },
        },
        colors: [
            "#246dec",
            "#cc3c43",
            "#367952",
            "#f5b74f",
            "#4f35a1"
        ],
        plotOptions: {
            bar: {
                distributed: true,
                borderRadius: 4,
                horizontal: false,
                columnWidth: '40%',
            }
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false
        },
        xaxis: {
            categories: <?php echo json_encode($category); ?>,
        },
        yaxis: {
            title: {
                text: "Count Category Product"
            }
        }
    };

    var barChart = new ApexCharts(document.querySelector("#bar-chart"), barChartOptions);
    barChart.render();
</script>

            </div>
          </div>

          <div class="charts-card">
    <p class="chart-title">Borrowed Items</p>
    <div id="area-chart"></div>
    <script>
        // Your PHP code to fetch dynamic data here
        var chartData = <?php echo $chartDataJson; ?>; // Assuming you have the chart data in PHP

        // AREA CHART
        var areaChartOptions = {
            series: [
                {
                    name: 'Borrowed Items',
                    data: chartData.series[0].data // Use the dynamic data here
                }
            ],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            colors: ["#4f35a1"],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth'
            },
            labels: chartData.labels, // Use the dynamic labels here
            markers: {
                size: 0
            },
            yaxis: [
                {
                    title: {
                        text: 'Borrowed Items',
                    },
                },
            ],
            tooltip: {
                shared: true,
                intersect: false,
            }
        };

        var areaChart = new ApexCharts(document.querySelector("#area-chart"), areaChartOptions);
        areaChart.render();
    </script>
</div>


        </div>
      </main>
      <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->

    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
  </body>
</html>