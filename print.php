<?php include('config/dbcon.php');


session_start();


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="print.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    </head>
    <body>

        <div class = "invoice-wrapper" id = "print-area">
            <div class = "invoice">
                <div class = "invoice-container">
                    <div class = "invoice-head">
                        <div class = "invoice-head-top">
                            <div class = "invoice-head-top-left text-start">
                                <img src = "images/tup-white.png">
                            </div>
                            <div class = "invoice-head-top-right text-end">
                                <h3>Invoice</h3>
                            </div>
                        </div>
                        <div class = "hr"></div>
                        <div class="invoice-head-middle">
    <div class="invoice-head-middle-left text-start">
        <p><span class="text-bold" id="currentDate"></span>: <span id="currentTime"></span></p>
    </div>
</div>

                        <div class = "hr"></div>
                        <div class = "invoice-head-bottom">
                            <div class = "invoice-head-bottom-left">
                                <ul>
                                    <li class = 'text-bold'>SOTUP INVENTORY TUP MANILA</li>
                                </ul>
                            </div>


                        </div>
                    </div>
                    <div class = "overflow-view">
                        <div class = "invoice-body">
                            <table>
                                <thead>
                                    <tr>
                                        <td class = "text-bold">Product_name</td>
                                        <td class = "text-bold">Category</td>
                                        <td class = "text-bold">Quantity</td>
                                        <td class = "text-bold">Price</td>
                                        <td class = "text-bold">Property_number</td>
                                        <td class = "text-bold">Date_return</td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                            
                            $sql = "SELECT * FROM tbl_returnitem WHERE item_status = 'Returned'";

                            $incomeres = mysqli_query($conn, $sql);
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
                    
                                    ?> 
                                       <tr>
                                        <td><?php echo $product_name;?></td>
                                        <td><?php echo $category;?></td>
                                        <td><?php echo $quantity;?></td>
                                        <td><?php echo $price;?></td>
                                        <td><?php echo $property_number;?></td>
                                        <td class = "text-end"><?php echo $date_return;?></td>
                                    </tr>



<?php
                                }
                            }
                            ?>

                                 
                                    
                                    
                                </tbody>

                             

                                

                            </table>
                           
                        </div>
                    </div>
                    <div class = "invoice-foot text-center">
                        <p><span class = "text-bold text-center">NOTE:&nbsp;</span>This is computer generated receipt and does not require physical signature.</p>

                        <div class="invoice-btns">
    <button type="button" class="invoice-btn" onclick="printInvoice()">
        <span>
            <i class="fa-solid fa-print"></i>
        </span>
        <span>Print</span>
    </button>
    <button type="button" class="invoice-btn" onclick="Back()">
        <span>
        <i class="fa-solid fa-backward"></i>
        </span>
        <span>Back</span>
    </button>
</div>

<script>
    function printInvoice() {
        // Print the invoice
        window.print();
    }

    function Back() {
    // Redirect to reportlist.php
    window.location.href = "reportlist.php";
}

function updateDateTime() {
    const currentDateElement = document.getElementById("currentDate");
    const currentTimeElement = document.getElementById("currentTime");

    const now = new Date();
    const dateOptions = { year: 'numeric', month: '2-digit', day: '2-digit' };
    const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit' };

    const currentDate = now.toLocaleDateString(undefined, dateOptions);
    const currentTime = now.toLocaleTimeString(undefined, timeOptions);

    currentDateElement.textContent = currentDate;
    currentTimeElement.textContent = currentTime;
}

// Update the date and time initially and then every second
updateDateTime();
setInterval(updateDateTime, 1000);

</script>
                    </div>
                </div>
            </div>
        </div>

     
      

    </body>
</html>