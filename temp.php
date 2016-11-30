<?php 

$date = date("y-m-d");
$date = strtotime("+3 days", strtotime($date));
echo date("y-m-d", $date);

?>