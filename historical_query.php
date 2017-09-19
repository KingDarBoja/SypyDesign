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

while ($row = mysqli_fetch_assoc($rs)) {
    $tiempo_db = strtotime($row['tiempo']);
    if ($tiempo_db >= $secondsi && $tiempo_db < $secondse) {
        $hs_data[] = $row;
    }
    // echo '<script>console.log('.$tiempo_db.')</script>';
}

// while ($row = mysqli_fetch_assoc($rs)) {
//     $hs_data[] = $row;
// }
// echo '<script>console.log('.$secondse.')</script>';
echo json_encode($hs_data);
