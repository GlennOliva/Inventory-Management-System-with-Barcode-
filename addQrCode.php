
<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Student</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    </head>
    <body>
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
        <form action="qrcode.php"  method="POST" class="form-horizontal" role="form">
                <div class="form-group">
                    <legend>Add QrCode</legend>
                   <?php 
                   if(isset($_GET['msg']))
                    {
                        echo $_GET['msg'];
                    }

                   ?>
                </div>
                <div class="form-group">
                Parking Name: <input type="text" name="cname" class="form-control" required >
                </div>
                
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary" name="add_qr">Add QRCODE</button>
                        
                    </div>
                </div>
        </form>
        </div>

        <div class="col-md-2"></div>
            <div class="col-md-8">
            <h1>QR Code List</h1>
            <br>   
           
            <br>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Parking Name</th>
                        <th>QR CODE</th>
                      
                    </tr>
                </thead>
                <tbody>
                  <?php
                    require_once('config.php');
                   
                   $query="Select * from qr";
                    
                    if($result = $mysqli->query($query)){
                        if($result->num_rows > 0){
                            while($row = $result->fetch_object()){
                                
                    ?>
                        <tr>
                                <td><?php echo $row->id; ?></td>
                                <td><?php echo $row->pname; ?></td>
                                <td><img src='<?php echo $row->qrImage; ?>' width="50px" height="50px"</td>
                               
                        

                 <?php         
                            }
                       } 
                    }     
                  ?>
                </tbody>
            </table>
            
    </div>          
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
