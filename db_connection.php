<?php

$host= 'localhost';
$user = 'root';
$pass = '';
$db = 'sypydb';
$tname1 = 'localiz1';
$tname2 = 'localiz2';
$port = 3306;

$con = new mysqli($host, $user, $pass, $db, $port) or die("Unable to connect");
$strCount = "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='".$db."'";
$tableCount = mysqli_query($con,$strCount) or die("Unsuccessfull Query Length");
// echo $tableCount;
$howManyTables = mysqli_fetch_assoc($tableCount);
$spr = implode(",",$howManyTables);

// echo $tableCount;
for ($i=0; $i < intval($spr); $i++) {
  $strSQL[$i] = "SELECT * FROM localiz".($i+1);
  $rs[$i] = mysqli_query($con, $strSQL[$i]) or die("Unsuccessfull Query");
  // $rs_temp[$i] = implode(",",mysqli_fetch_assoc($rs[$i]));
}

// echo '<script>console.log('.$tableCount.')</script>';
// $strSQL = "SELECT  * FROM $tname";
// $strSQL1 = "SELECT  * FROM $tname2";
// $rs = mysqli_query($con, $strSQL) or die("Unsuccessfull Query");
// $rs1 = mysqli_query($con, $strSQL1) or die("Unsuccessfull Query");
// echo implode(",",mysqli_fetch_assoc($rs));
