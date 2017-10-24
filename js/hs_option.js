$(document).ready(function() {
  $('#his_option_tabs').on('change.zf.tabs', function() {
    var tabId = $(this).find('.tabs-title.is-active a').attr('data-tabs-target');
    switch (tabId) {
      case "one-vehicle":
        console.log("Primer vehiculo");
        break;
      case "two-vehicle":
        console.log("Segundo vehiculo");
        break;
      case "both-vehicle":
        console.log("Ambos vehiculos");
        break;
      default:
        console.log("Por defecto");
    }
  });
})
