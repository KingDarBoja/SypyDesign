<!DOCTYPE html>
<?php
  $page = $_SERVER['PHP_SELF'];
  $sec = "10";
?>
<html>
  <head>
	  <title>SyPy Design</title>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />   
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/flexboxgrid/6.3.1/flexboxgrid.min.css" type="text/css" >
    <link rel="stylesheet" type="text/css" href="css/estilos.css" media="screen" />
  </head>
  <body>
    <?php
        $user = 'root';
        $pass = '';
        $db = 'syrusp';
        $tname = 'localiz';

        $con = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
        $strSQL = "SELECT  * FROM $tname ORDER BY id DESC LIMIT 1 ";
        $rs = mysqli_query($con,$strSQL) or die("Unsuccessfull Query");
        if($rs) {
          $row = mysqli_fetch_array($rs);
        }
        mysqli_close($con);
    ?>
    <div class="row center-xs">
      <div class="col-xs-12">
        <div class="titulo">
          <h2>Sy-Py Design</h2>
        </div>
      </div>
    </div>
    <div class="row center-xs">
      <div class="col-xs-12">
        <div class="header_db">
          <h5><?php
              if ($con) {
                echo "Conectado a la base de datos: ". $db;
              } else {
                echo "Fallo al conectarse a la base de datos: ". $db;
              }
          ?>
          </h5>
          <h5>
            <?php
                if ($strSQL) {
                  echo "Conectado a la tabla: ". $tname;
                } else {
                  echo "Fallo al conectarse a la base de datos";
                }
            ?>
          </h5>
        </div>
        <div class="tabla_db row center-xs">
          <div class="col-xs-6">
            <table>
              <thead>
                <tr>
                  <th colspan="2"><h4>Localización</h4></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Latitud</td>
                  <td><?php echo $row['latitud']  ?></td>
                </tr>
                <tr>
                  <td>Longitud</td>
                  <td><?php echo $row['longitud'] ?></td>
                </tr>
                <tr>
                  <td>Tiempo</td>
                  <td><?php echo $row['tiempo'] ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row center-xs">
      <div class="col-xs-6">
        <div id="map"></div>
            <script>
              var map;
              function initMap() {
                var latlng = {lat: <?php echo $row['latitud'] ?> , lng: <?php echo $row['longitud'] ?>};
                var myOptions = {
                    zoom: 16,
                    center: latlng,
                    panControl: true,
                    zoomControl: true,
                    scaleControl: true,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
               // Create map object with options
               map = new google.maps.Map(document.getElementById("map"), myOptions);
               addMarker(new google.maps.LatLng(<?php echo $row['latitud'] ?>, <?php echo $row['longitud'] ?>), map);
             }
              function addMarker(latLng, map) {
                  var marker = new google.maps.Marker({
                      position: latLng,
                      map: map,
                      draggable: true, // enables drag & drop
                      animation: google.maps.Animation.DROP
                  });
                  return marker;
              }
            </script>
            <script async defer
              src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG9JVGZEHXp0TrrOMmb9OeTDIHkPq0yQk&callback=initMap">
            </script>
      </div>
    </div>
  </body>
</html>
