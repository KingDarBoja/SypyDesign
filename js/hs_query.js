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
      zoom: 12,
      center: latlng2,
      panControl: true,
      zoomControl: true,
      scaleControl: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map2 = new google.maps.Map(document.getElementById("map2"), myOptions2);
  }

  function addMarker(latlng2, time2, id2, map2) {
    var marker = new google.maps.Marker({
      position: latlng2,
      map: map2,
      icon: {
        url: 'img/Trailer_Icon.png',
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

  $("#table_hist").hide();
  $("#btn-historical").click(function() {
    var initial_d = $('#startDate').html();
    var ending_d = $('#endDate').html();
    $('#table_histb tr').fadeOut(200, function() {
      $(this).remove();
    });
    $.ajax({
      type: 'POST',
      url: 'historical_query.php',
      data: {
        startd: initial_d,
        endd: ending_d
      },
      success: function(hs_data) {
        $('#table_hist').fadeIn(200);
        if (typeof myPathTotal2 !== 'undefined') {
          myPathTotal2.setMap(null);
          myPath2 = [];
        }


        var json_hist = jQuery.parseJSON(JSON.stringify(hs_data));
        INIT_LAT = parseFloat(json_hist[json_hist.length - 1].latitud);
        INIT_LON = parseFloat(json_hist[json_hist.length - 1].longitud);
        initMap2();
        $(json_hist).each(function() {
          var ID = this.id;
          var LATITUDE = this.latitud;
          var LONGITUDE = this.longitud;
          var TIME = this.tiempo;
          myCoord2 = new google.maps.LatLng(parseFloat(LATITUDE), parseFloat(LONGITUDE));
          myPath2.push(myCoord2);
          myPathTotal2 = new google.maps.Polyline({
            path: myPath2,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 5
          });
          myPathTotal2.setPath(myPath2)
          myPathTotal2.setMap(map2);
          addMarker(new google.maps.LatLng(LATITUDE, LONGITUDE), TIME, ID, map2);

          var item = $("<tr><td>" + ID + "</td><td>" + LATITUDE + "</td><td>" + LONGITUDE + "</td><td>" + TIME + "</td><tr>").hide();
          $('#table_histb').append(item);
          // $('#table_hist').append("<tr><td>" + ID + "</td><td>" + LATITUDE + "</td><td>" + LONGITUDE + "</td><td>" + TIME + "</td><tr>").hide();
        });
        $('#table_histb > tr').delay(1000).fadeIn(200);
        $("#map2").show();
      },
      dataType: 'json'
    });
  });
})
