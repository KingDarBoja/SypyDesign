function setPolyPath(myPathTotal2, map2, hsdata_size) {
  // this.options[this.selectedIndex].value;
  $('#select_vehicle').on('change', function() {
    var labelId = $('#select_vehicle option:selected').val();
    // console.log(Object.keys(obj_marcador).length);
    switch (labelId) {
      case "first_vehicle":
        // console.log("Primer vehiculo");
        myPathTotal2['vehicle_' + 1].setMap(map2);
        for (var j = 0; j < Object.keys(obj_marcador).length; j++) {
          for (var i = 0; i < obj_marcador['vehicle_' + (j + 1)].length; i++) {
            if (j == 0) {
              obj_marcador['vehicle_' + (j + 1)][i].setMap(map2);
            } else {
              obj_marcador['vehicle_' + (j + 1)][i].setMap(null);
            }
          }
        }
        myPathTotal2['vehicle_' + 2].setMap(null);
        myPathTotal2['vehicle_' + 3].setMap(null);
        break;
      case "second_vehicle":
        // console.log("Segundo vehiculo");
        myPathTotal2['vehicle_' + 2].setMap(map2);
        for (var j = 0; j < Object.keys(obj_marcador).length; j++) {
          for (var i = 0; i < obj_marcador['vehicle_' + (j + 1)].length; i++) {
            if (j == 1) {
              obj_marcador['vehicle_' + (j + 1)][i].setMap(map2);
            } else {
              obj_marcador['vehicle_' + (j + 1)][i].setMap(null);
            }
          }
        }
        myPathTotal2['vehicle_' + 1].setMap(null);
        myPathTotal2['vehicle_' + 3].setMap(null);
        break;
      case "third_vehicle":
        // console.log("Tercer vehiculo");
        myPathTotal2['vehicle_' + 3].setMap(map2);
        for (var j = 0; j < Object.keys(obj_marcador).length; j++) {
          for (var i = 0; i < obj_marcador['vehicle_' + (j + 1)].length; i++) {
            if (j == 2) {
              obj_marcador['vehicle_' + (j + 1)][i].setMap(map2);
            } else {
              obj_marcador['vehicle_' + (j + 1)][i].setMap(null);
            }
          }
        }
        myPathTotal2['vehicle_' + 1].setMap(null);
        myPathTotal2['vehicle_' + 2].setMap(null);
        break;
      case "all_vehicle":
        // console.log("Ambos vehiculos");
        for (var k = 0; k < hsdata_size; k++) {
          myPathTotal2['vehicle_' + (k + 1)].setMap(null);
          myPathTotal2['vehicle_' + (k + 1)].setMap(map2);
        }
        for (var j = 0; j < Object.keys(obj_marcador).length; j++) {
          for (var i = 0; i < obj_marcador['vehicle_' + (j + 1)].length; i++) {
            obj_marcador['vehicle_' + (j + 1)][i].setMap(map2);
          }
        }
        break;
      default:
        // console.log("Por defecto");
        for (var k = 0; k < hsdata_size; k++) {
          myPathTotal2['vehicle_' + (k + 1)].setMap(null);
          myPathTotal2['vehicle_' + (k + 1)].setMap(map2);
        }
        for (var j = 0; j < Object.keys(obj_marcador).length; j++) {
          for (var i = 0; i < obj_marcador['vehicle_' + (j + 1)].length; i++) {
            obj_marcador['vehicle_' + (j + 1)][i].setMap(map2);
          }
        }
        break;
    }
  });
};

// function removeLine(i) {
//   myPathTotal['vehicle_' + (i + 1)].setMap(null);
// }
//
// function addLine(i) {
//   myPathTotal['vehicle_' + (i + 1)].setMap(map2);
// }
