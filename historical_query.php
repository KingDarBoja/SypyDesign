<?php
include('db_connection.php');
$hs_data = array();

// Calling the variables from hs_query.js
if (isset($_POST['startd'])) {
    $initial_d = $_POST['startd'];
} else {
    $initial_d = '01-01-2017 00:00';
}
if (isset($_POST['endd'])) {
    $ending_d = $_POST['endd'];
} else {
    $ending_d = '01-12-2017 00:00';
}

// Testing dates in order to prove the PHP code below.
// $initial_d = '01-01-2004 00:05';
// $ending_d = '10-01-2004 12:00';

$secondsi = strtotime($initial_d);
$secondse = strtotime($ending_d);

for ($i=0; $i < intval($spr); $i++) {
  while ($row = mysqli_fetch_assoc($rs[$i])) {
    $tiempo_db = strtotime($row['tiempo']);
    if ($tiempo_db >= $secondsi && $tiempo_db < $secondse) {
        $hs_data['vehicle_'.($i+1)][] = $row;
    }
    // echo '<script>console.log('.$row['tiempo'].')</script>';
  }
}

// while ($row = mysqli_fetch_assoc($rs)) {
//     $tiempo_db = strtotime($row['tiempo']);
//     if ($tiempo_db >= $secondsi && $tiempo_db < $secondse) {
//         $hs_data['vehicle_1'][] = $row;
//     }
//     // echo '<script>console.log('.$tiempo_db.')</script>';
// }
//
// while ($row1 = mysqli_fetch_assoc($rs1)) {
//     $tiempo_db1 = strtotime($row1['tiempo']);
//     if ($tiempo_db1 >= $secondsi && $tiempo_db1 < $secondse) {
//         $hs_data['vehicle_2'][] = $row1;
//     }
//     // echo '<script>console.log('.$tiempo_db.')</script>';
// }

// while ($row = mysqli_fetch_assoc($rs)) {
//     $hs_data[] = $row;
// }
// echo '<script>console.log('.$secondse.')</script>';
echo json_encode($hs_data);
