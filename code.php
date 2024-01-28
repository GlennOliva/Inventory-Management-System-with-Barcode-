<?php
include('config/dbcon.php');
session_start();

if(isset($_POST['delete_adminbtn']))
{

    $id = $_POST['admin_id'];
    //Create SQL query to delete admin
$sql = "SELECT * FROM tbl_admin WHERE id=$id";

// Execute the query
$result = mysqli_query($conn, $sql);

$count = mysqli_fetch_array($result);


$image_name = $count['image'];

   $sql1 = "DELETE FROM tbl_admin WHERE id=$id";
   $result1 = mysqli_query($conn,$sql1);

   if($result1)
   {
        if(file_exists("images/admin/".$image_name))
        {
            unlink("images/admin/".$image_name);
        }

        echo 200;

    }
    else
    {
        echo 500;
    }


}
else if(isset($_POST['delete_empbtn']))
{

    $id = $_POST['emp_id'];
    //Create SQL query to delete admin
$sql2 = "SELECT * FROM tbl_employee WHERE id=$id";

// Execute the query
$result2 = mysqli_query($conn, $sql2);

$count1 = mysqli_fetch_array($result2);


$image_name1 = $count1['image'];

   $sql3 = "DELETE FROM tbl_employee WHERE id=$id";
   $result3 = mysqli_query($conn,$sql3);

   if($result3)
   {
        if(file_exists("images/admin/".$image_name1))
        {
            unlink("images/admin/".$image_name1);
        }

        echo 300;

    }
    else
    {
        echo 600;
    }


}

else if(isset($_POST['delete_barbtn']))
{

    $id = $_POST['bar_id'];
    //Create SQL query to delete admin
$barsql = "SELECT * FROM tbl_barcode WHERE id=$id";

// Execute the query
$barresult = mysqli_query($conn, $barsql);

$barcount = mysqli_fetch_array($barresult);


$image_namebar = $barcount['barcode_image'];

   $barsql1 = "DELETE FROM tbl_barcode WHERE id=$id";
   $barresult1 = mysqli_query($conn,$barsql1);

   if ($barresult1) {
    if (file_exists("images/qrcode/".$image_namebar)) {
        unlink("images/qrcode/".$image_namebar);
    }
    echo 400; // Success
} else {
    $error_message = mysqli_error($conn); // Get the MySQL error message
    echo 800; // Error
    // Log the error message for debugging
    error_log("Barcode Deletion Error: " . $error_message);
}



}

else if(isset($_POST['delete_inventorybtn']))
{

    $invid = $_POST['inventory_id'];
    
    $inventorysql = "DELETE FROM tbl_product WHERE id = $invid";
     // Execute the delete query
     $invresult = mysqli_query($conn, $inventorysql);

     if ($invresult) {
         // Check if any rows were affected by the delete query
         if (mysqli_affected_rows($conn) > 0) {
             echo 500; // Success
         } else {
             echo 1000; // Failed (no rows affected)
         }
     } else {
         echo 1000; // Failed (query execution error)
     }

}


?>