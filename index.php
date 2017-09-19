<?php
    $title = "SyPy Design";
?>
<?php require_once('header.php'); ?>

  <section>
    <?php
        $host= 'sypy-db-instance.cjztblqral8m.us-east-2.rds.amazonaws.com';
        $user = 'sypy_design';
        $pass = 'sypy_1234';
        $db = 'sypydb';
        $tname = 'localiz';
        $port = 10250;
        $con = new mysqli($host, $user, $pass, $db, $port) or die("Unable to connect");
        $strSQL = "SELECT  * FROM $tname ORDER BY id DESC LIMIT 1 ";
        $rs = mysqli_query($con,$strSQL) or die("Unsuccessfull Query");
        if ($rs) {
            $row = mysqli_fetch_array($rs);
        }
        mysqli_close($con);
    ?>
    <script>
      function ajaxCall() {
          $.ajax({
              url: "database.php",
              success: (function (result) {
                  $("#disp_data").html(result);
              })
          })
      };

      ajaxCall(); // To output when the page loads
      setInterval(ajaxCall, (10 * 1000)); // x * 1000 to get it in seconds
    </script>

    <div class="row align-center">
      <div class="small-12 columns text-center">
        <div class="titulo">
          <h2>Sy-Py Design</h2>
        </div>
      </div>
    </div>
    <div class="row align-center">
      <div class="small-12 columns text-center">
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
			</div>
		</div>
    <div class="row align-center text-center">
      <div class="small-8 columns">
        <table class="table_db">
          <thead>
            <tr>
              <th class="text-center" colspan="2"><h4>Localización</h4></th>
            </tr>
          </thead>
          <tbody id="disp_data">
          </tbody>
        </table>
      </div>
    </div>
    <div class="row expanded align-center">
      <div class="small-12 columns">
        <div id="map"></div>
            <script>
              var map;
              var myPath = [];

              function moveToLocation(lat, lng){
                  var center = new google.maps.LatLng(lat, lng);
                  // using global variable:
                  map.panTo(center);
              }
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
               // addMarker(new google.maps.LatLng(<?php echo $row['latitud'] ?>, <?php echo $row['longitud'] ?>), map);
               var ID_ST = 0;
               setInterval(function mapload(){
                     $.ajax({
                           url: "location.php",
                            // data: form_data,
                           success: function(data)
                           {
                             //var json_obj = $.parseJSON(data);//parse JSON
                             var json_obj = jQuery.parseJSON(JSON.stringify(data));
                             // Data Treatment in order to obtain the new latlng coordinates.
                             $(jQuery.parseJSON(JSON.stringify(data))).each(function() {
                               var ID = this.id;
                               var LATITUDE = this.latitud;
                               var LONGITUDE = this.longitud;
                               if (ID_ST != this.id) {
                                 myCoord = new google.maps.LatLng(parseFloat(LATITUDE),parseFloat(LONGITUDE));
                                 myPath.push(myCoord);
                                 var myPathTotal = new google.maps.Polyline({
                                    path: myPath,
                                    strokeColor: '#FF0000',
                                    strokeOpacity: 1.0,
                                    strokeWeight: 5
                                 });
                                 myPathTotal.setPath(myPath)
                                 myPathTotal.setMap(map);
                                 addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), map);
                                 moveToLocation(parseFloat(LATITUDE),parseFloat(LONGITUDE));
                                 ID_ST = this.id;
                               }
                            });
                           },
                           dataType: "json"//set to JSON
                         })
               }, 10 * 1000);
             }

              function addMarker(latLng, map) {
                  var marker = new google.maps.Marker({
                      position: latLng,
                      map: map,
                      icon: {
                        url: 'img/Trailer_Icon.png',
                        scaledSize: new google.maps.Size(40, 40) // scaled size
                        // origin: new google.maps.Point(0,0), // origin
                        // anchor: new google.maps.Point(0, 0) // anchor
                      },
                      draggable: false, // enables drag & drop
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
  </section>
  <?php require_once('footer.php'); ?>
