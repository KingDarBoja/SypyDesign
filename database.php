<?php
$host= 'localhost';
$user = 'root';
$pass = '';
$db = 'sypydb';
$tname1 = 'localiz1';
$tname2 = 'localiz2';
$port = 3306;
$con = new mysqli($host, $user, $pass, $db, $port) or die("Unable to connect");
$strSQL1 = "SELECT  * FROM $tname1 ORDER BY id DESC LIMIT 1 ";
$strSQL2 = "SELECT  * FROM $tname2 ORDER BY id DESC LIMIT 1 ";
$rs1 = mysqli_query($con, $strSQL1) or die("Unsuccessfull Query");
if ($rs1) {
    $row1 = mysqli_fetch_array($rs1);
}
$rs2 = mysqli_query($con, $strSQL2) or die("Unsuccessfull Query");
if ($rs2) {
    $row2 = mysqli_fetch_array($rs2);
}
echo '<tr style="font-weight:bold">'.'<td>Vehiculo</td>'.'<td>Camion</td>'.'<td>Moto</td>'.'</tr>';
echo '<tr>'.'<td>Latitud</td>'.'<td>'.$row1['latitud'].'</td>'.'<td>'.$row2['latitud'].'</td>'.'</tr>';
echo '<tr>'.'<td>Longitud</td>'.'<td>'.$row1['longitud'].'</td>'.'<td>'.$row2['longitud'].'</td>'.'</tr>';
echo '<tr>'.'<td>Tiempo</td>'.'<td>'.$row1['tiempo'].'</td>'.'<td>'.$row2['tiempo'].'</td>'.'</tr>';
echo '<tr>'.'<td>RPM</td>'.'<td>'.$row1['rpm'].'</td>'.'<td>'.$row2['rpm'].'</td>'.'</tr>';

mysqli_close($con);
?>
