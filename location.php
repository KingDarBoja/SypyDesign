<?php

$host= 'sypy-db-instance.cjztblqral8m.us-east-2.rds.amazonaws.com';
$user = 'sypy_design';
$pass = 'sypy_1234';
$db = 'sypydb';
$tname = 'localiz1';
$tname2 = 'localiz2';
$port = 10250;
$con = new mysqli($host, $user, $pass, $db, $port) or die("Unable to connect");

$strCount = "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='".$db."'";
$tableCount = mysqli_query($con,$strCount) or die("Unsuccessfull Query Length");
// echo $tableCount;
$howManyTables = mysqli_fetch_assoc($tableCount);
$spr = implode(",",$howManyTables);
$data = array();
// echo $tableCount;
for ($i=0; $i < intval($spr); $i++) {
  $strSQL[$i] = "SELECT * FROM localiz".($i+1)." ORDER BY id DESC LIMIT 1 ";
  $rs[$i] = mysqli_query($con, $strSQL[$i]) or die("Unsuccessfull Query");
  // $rs_temp[$i] = implode(",",mysqli_fetch_assoc($rs[$i]));
}
for ($i=0; $i < intval($spr); $i++) {
  while ($row = mysqli_fetch_assoc($rs[$i])) {
    $data['vehicle_'.($i+1)][] = $row;
  }
}

echo json_encode($data);
//
// $strSQL = "SELECT  * FROM $tname ORDER BY id DESC LIMIT 1 ";
// $strSQL1 = "SELECT  * FROM $tname2 ORDER BY id DESC LIMIT 1 ";
// $rs = mysqli_query($con,$strSQL) or die("Unsuccessfull Query");
// $rs1 = mysqli_query($con,$strSQL1) or die("Unsuccessfull Query");
// $data = array();
// if ($rs) {
//     $data['vehicle_1'] = mysqli_fetch_assoc($rs);
// }
// if ($rs1) {
//     $data['vehicle_2'] = mysqli_fetch_assoc($rs1);
// }
// echo json_encode($data);
//echo("addMarker($lat, $lon, '<b>$name</b><br />$desc');\n");
?>
