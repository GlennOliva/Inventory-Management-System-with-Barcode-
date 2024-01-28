<?php

include('phpqrcode/qrlib.php');

$path = 'images/';
$qrcode = $path.time().".png";
QRcode :: png("idok", $qrcode, 'H', 4 , 4);
echo "<img src='".$qrcode."'>";
?>
