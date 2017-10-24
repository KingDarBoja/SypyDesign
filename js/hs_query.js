$(document).ready(function() {
  var map2;
  var myPath2 = [];
  var myPathTotal2;
  infoWindows = Array();
  markers = Array();
  $("#map2").hide();

  function initMap2() {

    var latlng2 = {
      lat: INIT_LAT,
      lng: INIT_LON
    };
    var myOptions2 = {
      zoom: 15,
      center: latlng2,
      panControl: true,
      zoomControl: true,
      scaleControl: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map2 = new google.maps.Map(document.getElementById("map2"), myOptions2);
  }

  function addMarker(latlng2, time2, id2, map2, iconObj) {
    var marker = new google.maps.Marker({
      position: latlng2,
      map: map2,
      icon: {
        url: iconObj,
        scaledSize: new google.maps.Size(40, 40) // scaled size
        // origin: new google.maps.Point(0,0), // origin
        // anchor: new google.maps.Point(0, 0) // anchor
      },
      draggable: false, // enables drag & drop
      animation: google.maps.Animation.DROP,
      infoWindowIndex: id2
    });
    var content = '<div id="Marker_Time">' +
      '<h6>' + 'Title Place' + '</h6>' +
      '<p>' + time2 + '</p>' + '</div>';

    var infoWindow = new google.maps.InfoWindow({
      content: content
    });

    google.maps.event.addListener(marker, 'click',
      function(event) {
        infoWindow.open(map2, marker);
        // infoWindows[this.infoWindowIndex].open(this.map2, this.marker);
      }
    );

    infoWindows.push(infoWindow);
    markers.push(marker);


    return marker;
  }

  var iconBase = 'img/';
  var icons = {
    truck: {
      icon: iconBase + 'Trailer_Icon.png'
    },
    motorcycle: {
      icon: iconBase + 'Motorcycle_Icon.png'
    }
  };
  var strokes = {
    purple: '#551A8B',
    red: '#8B0000',
    blue: '#'
  };

  function setPolyline(pathVal, strokeValue) {
    var poly = new google.maps.Polyline({
      path: pathVal,
      strokeColor: strokeValue,
      strokeOpacity: 1.0,
      strokeWeight: 5
    });
    return poly;
  }

  // Uncomment if you want to enable table animations (historical query)
  $("#table_hist").hide();

  $("#btn-historical").click(function() {
    var initial_d = $('#startDate').html();
    var ending_d = $('#endDate').html();

    // Uncomment if you want to enable table animations (historical query)
    // $('#table_histb tr').fadeOut(200, function() {
    //   $(this).remove();
    // });
    var myPath2 = {};
    var myPathTotal2 = {};
    var ID_HS = [];
    var json_hist = [];
    var cc = 0;
    $.ajax({
      type: 'POST',
      url: 'historical_query.php',
      data: {
        startd: initial_d,
        endd: ending_d
      },
      success: function(hs_data) {
        // Uncomment if you want to enable table animations (historical query)
        // $('#table_hist').fadeIn(200);
        var hsdata_size = Object.keys(hs_data).length;
        while (cc == 0) {
          for (i = 0; i < hsdata_size; i++) {
            myPath2['vehicle_' + (i + 1)] = [];
          }
          cc = 1;
        }
        // if (typeof myPathTotal2 !== 'undefined') {
        //   // myPathTotal2.setMap(null);
        //   myPath2 = {};
        // }
        var json_hist = jQuery.parseJSON(JSON.stringify(hs_data));
        if (hsdata_size == undefined) {
          INIT_LAT = 0;
          INIT_LON = 0;
          initMap2();
          $("#map2").show();
          $('#error_msg_hist').html("<h4>Error: No se obtuvieron resultados en su búsqueda.</h4>").show();
        } else {
          // console.log(json_hist['vehicle_1']);
          INIT_LAT = parseFloat(json_hist['vehicle_1'][json_hist['vehicle_1'].length - 1].latitud);
          INIT_LON = parseFloat(json_hist['vehicle_1'][json_hist['vehicle_1'].length - 1].longitud);
          initMap2();
          console.log(json_hist['vehicle_1'][json_hist['vehicle_1'].length - 1]);
          $('#error_msg_hist').hide();
          // For each element from the query, we asign a marker


          for (i = 0; i < hsdata_size; i++) {
            $(json_hist['vehicle_' + (i + 1)]).each(function() {
              var ID = this.id;
              var LATITUDE = this.latitud;
              var LONGITUDE = this.longitud;
              var TIME = this.tiempo;
              if (ID_HS[i] != this.id) {
                myCoord = new google.maps.LatLng(parseFloat(LATITUDE), parseFloat(LONGITUDE));
                myPath2['vehicle_' + (i + 1)].push(myCoord);
                switch (i) {
                  case 0:
                    myPathTotal2['vehicle_' + (i + 1)] = setPolyline(myPath2['vehicle_' + (i + 1)], strokes['purple']);
                    break;
                  case 1:
                    myPathTotal2['vehicle_' + (i + 1)] = setPolyline(myPath2['vehicle_' + (i + 1)], strokes['red']);
                    break;
                  default:
                    myPathTotal2['vehicle_' + (i + 1)] = setPolyline(myPath2['vehicle_' + (i + 1)], strokes['blue']);
                }
                myPathTotal2['vehicle_' + (i + 1)].setPath(myPath2['vehicle_' + (i + 1)]);
                myPathTotal2['vehicle_' + (i + 1)].setMap(map2);
                switch (i) {
                  case 0:
                    addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), TIME, ID, map2, icons['truck'].icon);
                    break;
                  case 1:
                    addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), TIME, ID, map2, icons['motorcycle'].icon);
                    break;
                    // Add the cases that you want or replace switch statment by if in order to use ranges.
                  default:
                    addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), TIME, ID, map2, icons['truck'].icon);
                }
                ID_HS[i] = this.id;
              }
            });
          }



          // for (i = 0; i < hsdata_size; i++) {
          //   $(json_hist['vehicle_' + (i + 1)]).each(function() {
          //     var ID = this.id;
          //     var LATITUDE = this.latitud;
          //     var LONGITUDE = this.longitud;
          //     var TIME = this.tiempo;
          //     myCoord2 = new google.maps.LatLng(parseFloat(LATITUDE), parseFloat(LONGITUDE));
          //     myPath2['vehicle_' + (i + 1)].push(myCoord);
          //     myPathTotal2 = new google.maps.Polyline({
          //       path: myPath2,
          //       strokeColor: '#FF0000',
          //       strokeOpacity: 1.0,
          //       strokeWeight: 5
          //     });
          //     myPathTotal2.setPath(myPath2)
          //     myPathTotal2.setMap(map2);
          //     addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), TIME, ID, map2);
          //
          //     var item = $("<tr><td>" + ID + "</td><td>" + LATITUDE + "</td><td>" + LONGITUDE + "</td><td>" + TIME + "</td><tr>").hide();
          //
          //     // Uncomment to enable table append items from historical query
          //     $('#table_histb').append(item);
          //     // $('#table_hist').append("<tr><td>" + ID + "</td><td>" + LATITUDE + "</td><td>" + LONGITUDE + "</td><td>" + TIME + "</td><tr>").hide();
          //   });
          // }
          // Uncomment if you want to enable table animations (historical query)
          // $('#table_histb > tr').delay(1000).fadeIn(200);

          $("#map2").show();
        }
      },
      dataType: 'json'
    });
  });
})
