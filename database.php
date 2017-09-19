<?php
$host= 'sypy-db-instance.cjztblqral8m.us-east-2.rds.amazonaws.com';
$user = 'sypy_design';
$pass = 'sypy_1234';
$db = 'sypydb';
$tname = 'localiz';
$port = 10250;
$con = new mysqli($host, $user, $pass, $db, $port) or die("Unable to connect");
$strSQL = "SELECT  * FROM $tname ORDER BY id DESC LIMIT 1 ";
$rs = mysqli_query($con, $strSQL) or die("Unsuccessfull Query");
if ($rs) {
    $row = mysqli_fetch_array($rs);
    echo '<tr>'.'<td>Latitud</td>'.'<td>'.$row['latitud'].'</td>'.'</tr>';
    echo '<tr>'.'<td>Longitud</td>'.'<td>'.$row['longitud'].'</td>'.'</tr>';
    echo '<tr>'.'<td>Tiempo</td>'.'<td>'.$row['tiempo'].'</td>'.'</tr>';
}
mysqli_close($con);
?>
