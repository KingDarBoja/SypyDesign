function addMarker2(latlng2, time2, id2, map2, iconObj, veh_obj, rpm2) {
  var marker = new google.maps.Marker({
    position: latlng2,
    // map: map2,
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
  var content = '<div id="iw-container">' +
    '<div class="iw-title">' + '<h6><b>' + veh_obj + '</b></h6>' + '</div>' +
    '<div class="iw-content">' + '<p>' +
    '<b>Latitud: </b>' + latlng2.lat() + '<br/>' +
    '<b>Longitud: </b>' + latlng2.lng() + '<br/>' +
    '<b>Tiempo: </b>' + time2 + '<br/>' +
    '<b>RPM: </b>' + rpm2 + '<br/>' +
    '</p>' + '</div></div>';

  var content = '<div id="iw-container">' +
    '<div class="iw-title">' + veh_obj + '</div>' +
    '<div class="iw-content">' +
    '<div class="iw-subTitle"></div>' +
    '<p>' +
    '<b>Latitud: </b>' + latlng2.lat() +
    '<br> <b>Longitud: </b>' + latlng2.lng() +
    '<br> <b>Tiempo: </b>' + time2 +
    '<br> <b>RPM: </b>' + rpm2 +
    '</p>' +
    '</div>' +
    '<div class="iw-bottom-gradient"></div>' +
    '</div>';

  var infoWindow = new google.maps.InfoWindow({
    content: content,
    maxWidth: 350
  });

  google.maps.event.addListener(marker, 'click',
    function(event) {
      infoWindow.open(map2, marker);
      // infoWindows[this.infoWindowIndex].open(this.map2, this.marker);
    }
  );

  google.maps.event.addListener(map2, 'click', function() {
    infoWindow.close();
  });

  infoWindows.push(infoWindow);
  markers[veh_obj].push(marker);

  google.maps.event.addListener(infoWindow, 'domready', function() {

    // Reference to the DIV that wraps the bottom of infowindow
    var iwOuter = $('.gm-style-iw');

    /* Since this div is in a position prior to .gm-div style-iw.
     * We use jQuery and create a iwBackground variable,
     * and took advantage of the existing reference .gm-style-iw for the previous div with .prev().
     */
    var iwBackground = iwOuter.prev();

    // Removes background shadow DIV
    iwBackground.children(':nth-child(2)').css({
      'display': 'none'
    });

    // Removes white background DIV
    iwBackground.children(':nth-child(4)').css({
      'display': 'none'
    });

    // Reference to the div that groups the close button elements.
    var iwCloseBtn = iwOuter.next();

    // Apply the desired effect to the close button
    iwCloseBtn.css({
      width: '25px',
      height: '25px',
      opacity: '1',
      right: '52px',
      top: '15px',
      border: '6px solid #48b5e9',
      'border-radius': '15px',
      'box-shadow': '0 0 5px #3990B9'
    });

    // If the content of infowindow not exceed the set maximum height, then the gradient is removed.
    if ($('.iw-content').height() < 140) {
      $('.iw-bottom-gradient').css({
        display: 'none'
      });
    }

    // The API automatically applies 0.7 opacity to the button after the mouseout event. This function reverses this event to the desired value.
    iwCloseBtn.mouseout(function() {
      $(this).css({
        opacity: '1'
      });
    });

  });

  return markers[veh_obj];
}

var map2;
var myPath2 = [];
// var myPathTotal2;
infoWindows = Array();
var markers = [];
$("#map2").hide();
var myPathTotal2 = {};
var obj_marcador = {};

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
  // var myPathTotal2 = {};
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
          markers['vehicle_' + (i + 1)] = [];
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
        // console.log(json_hist['vehicle_1'][json_hist['vehicle_1'].length - 1]);
        $('#error_msg_hist').hide();
        // For each element from the query, we asign a marker


        for (i = 0; i < hsdata_size; i++) {
          $(json_hist['vehicle_' + (i + 1)]).each(function() {
            var ID = this.id;
            var LATITUDE = this.latitud;
            var LONGITUDE = this.longitud;
            var TIME = this.tiempo;
            var RPM = this.rpm;
            if (RPM == null) {
              RPM = 0;
            }
            if (ID_HS[i] != this.id) {
              obj_marcador['vehicle_' + (i + 1)] = addMarker2(new google.maps.LatLng(LATITUDE, LONGITUDE), TIME, ID, map2, icons['truck'].icon, 'vehicle_' + (i + 1), RPM);
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
              // myPathTotal2['vehicle_' + (i + 1)].setMap(map2);
              setPolyPath(myPathTotal2, map2, hsdata_size);
              // switch (i) {
              //   case 0:
              //     obj_marcador['vehicle_' + (i + 1)] = addMarker2(new google.maps.LatLng(LATITUDE, LONGITUDE), TIME, ID, map2, icons['truck'].icon, 'vehicle_' + (i + 1));
              //     break;
              //   case 1:
              //     obj_marcador['vehicle_' + (i + 1)] = addMarker2(new google.maps.LatLng(LATITUDE, LONGITUDE), TIME, ID, map2, icons['motorcycle'].icon, 'vehicle_' + (i + 1));
              //     break;
              //   case 2:
              //     obj_marcador['vehicle_' + (i + 1)] = addMarker2(new google.maps.LatLng(LATITUDE, LONGITUDE), TIME, ID, map2, icons['taxi'].icon, 'vehicle_' + (i + 1));
              //     break;
              //     // Add the cases that you want or replace switch statment by if in order to use ranges.
              //   default:
              //     obj_marcador['vehicle_' + (i + 1)] = addMarker2(new google.maps.LatLng(LATITUDE, LONGITUDE), TIME, ID, map2, icons['taxi'].icon);
              // }
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
