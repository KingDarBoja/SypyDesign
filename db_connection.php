<?php

$host= 'sypy-db-instance.cjztblqral8m.us-east-2.rds.amazonaws.com';
$user = 'sypy_design';
$pass = 'sypy_1234';
$db = 'sypydb';
$tname = 'localiz';
$port = 10250;

$con = new mysqli($host, $user, $pass, $db, $port) or die("Unable to connect");
$strSQL = "SELECT  * FROM $tname";
$rs = mysqli_query($con, $strSQL) or die("Unsuccessfull Query");
