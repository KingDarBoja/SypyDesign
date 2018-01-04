<?php
    $title = "SyPy Design";
?>
<?php require_once('header.php'); ?>
  <section>
    <?php
        $host= 'localhost';
        $user = 'root';
        $pass = '';
        $db = 'sypydb';
        $tname1 = 'localiz1';
        $tname2 = 'localiz2';
        $port = 3306;
        $con = new mysqli($host, $user, $pass, $db, $port) or die("Unable to connect");
        $strSQL = "SELECT  * FROM $tname1 ORDER BY id DESC LIMIT 1 ";
        $rs = mysqli_query($con, $strSQL) or die("Unsuccessfull Query");
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
    <div class="row small-collapse medium-collapse expanded">
      <div class="small-12 column">
        <div id="map"></div>
        <script>
          var map;
          var iconBase = 'img/';
          var icons = {
            truck: {
              icon: iconBase + 'Trailer_Icon.png'
            },
            motorcycle: {
              icon: iconBase + 'Motorcycle_Icon.png'
            },
            taxi: {
              icon: iconBase + 'Taxi_Icon.png'
            }
          };
          var strokes = {
            purple: '#551A8B',
            red: '#8B0000',
            blue: '#000080'
          };
          function moveToLocation(lat, lng){
              var center = new google.maps.LatLng(lat, lng);
              // using global variable
              map.panTo(center);
          }
          function initMap() {
            var latlng = {lat: <?php
                if($row['latitud'] == null) {
                  echo 0.0;
                }
              ?> ,
              lng: <?php
                if($row['longitud'] == null) {
                  echo 0.0;
                }
              ?>};
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
            // This part get the encoded json object length and use it to cycle through each one of the sub-objects
            var myPath = {};
            var myPathTotal = {};
            var ID_ST = [];
            var json_obj = [];
            var cc = 0;
            setInterval(function mapload(){
                  $.ajax({
                        url: "location.php",
                        // data: form_data,
                        success: function(data)
                        {
                          var data_size = Object.keys(data).length;
                          // if you want to check every step, Uncomment the next line and edit for every variable.
                          // $('#testa').html(console.log());
                          // Set the array inside another array in order to perform the FOR cycle for each vehicle.
                          while (cc == 0) {
                            for (i = 0; i < data_size; i++) {
                              myPath['vehicle_'+(i+1)] = [];
                            }
                            cc = 1;
                          }
                          json_obj = jQuery.parseJSON(JSON.stringify(data));
                          for (i = 0; i < data_size; i++) {
                            $(json_obj['vehicle_'+(i+1)]).each(function() {
                              var ID = this.id;
                              var LATITUDE = this.latitud;
                              var LONGITUDE = this.longitud;
                              if (ID_ST[i] != this.id) {
                                myCoord = new google.maps.LatLng(parseFloat(LATITUDE),parseFloat(LONGITUDE));
                                myPath['vehicle_'+(i+1)].push(myCoord);
                                switch (i) {
                                  case 0:
                                    myPathTotal['vehicle_'+(i+1)] = setPolyline(myPath['vehicle_'+(i+1)], strokes['purple']);
                                    break;
                                  case 1:
                                    myPathTotal['vehicle_'+(i+1)] = setPolyline(myPath['vehicle_'+(i+1)], strokes['red']);
                                    break;
                                  default:
                                    myPathTotal['vehicle_'+(i+1)] = setPolyline(myPath['vehicle_'+(i+1)], strokes['blue']);
                                }
                                myPathTotal['vehicle_'+(i+1)].setPath(myPath['vehicle_'+(i+1)]);
                                myPathTotal['vehicle_'+(i+1)].setMap(map);
                                switch (i) {
                                  case 0:
                                    addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), map, icons['truck'].icon);
                                    break;
                                  case 1:
                                    addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), map, icons['motorcycle'].icon);
                                    break;
                                  // Add the cases that you want or replace switch statment by if in order to use ranges.
                                  default:
                                    addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), map, icons['taxi'].icon);
                                }
                                ID_ST[i] = this.id;
                              }
                            });
                          }
                        },
                       dataType: "json"//set to JSON
                     })
           }, 5 * 1000);
         }
         function addMarker(latLng, map, icon_type) {
            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
                icon: {
                  url: icon_type,
                  scaledSize: new google.maps.Size(40, 40) // scaled size
                  // origin: new google.maps.Point(0,0), // origin
                  // anchor: new google.maps.Point(0, 0) // anchor
                },
                draggable: false, // enables drag & drop
                animation: google.maps.Animation.DROP
            });
            return marker;
        }
        function setPolyline(pathVal , strokeValue){
          var poly = new google.maps.Polyline({
              path: pathVal,
              strokeColor: strokeValue,
              strokeOpacity: 1.0,
              strokeWeight: 5
          });
          return poly;
        }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG9JVGZEHXp0TrrOMmb9OeTDIHkPq0yQk&callback=initMap"></script>
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
                    echo "Conectado a la tabla: ". $tname1;
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
              <th class="text-center" colspan="4"><h4>Localización</h4></th>
            </tr>
          </thead>
          <tbody id="disp_data">
          </tbody>
        </table>
        <!-- Test div for console.log or display in the HTML DOM -->
        <!-- <div id="testa"></div> -->
      </div>
    </div>
  </section>
  <?php require_once('footer.php'); ?>
