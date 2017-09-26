<?php
    $title = "SyPy Design";
?>
<?php require_once('header.php'); ?>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDG9JVGZEHXp0TrrOMmb9OeTDIHkPq0yQk">
</script>
<section>
  <div class="row">
    <div class="small-12 columns">
      <div class="titulo">
        <h2>Historicos</h2>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="small-6 columns">
      <table class="table">
      	<thead>
      		<tr>
      			<th class="text-center">Start date&nbsp;
      				<a href="#" class="button tiny" id="dp_initial" data-date-format="yyyy-mm-dd hh:ii" data-date="2017-01-01 12:00">Change</a>
      			</th>
      		</tr>
      	</thead>
      	<tbody>
      		<tr>
      			<td id="startDate">2017-01-01 12:00</td>
      		</tr>
      	</tbody>
      </table>
      <div class="alert alert-box"  style="display:none;" id="alert">	<strong>Oh snap!</strong>
      </div>
    </div>
    <div class="small-6 columns">
      <table class="table">
      	<thead>
      		<tr>
      			<th class="text-center">End date&nbsp;
      				<a href="#" class="button tiny" id="dp_ending" data-date-format="yyyy-mm-dd hh:ii" data-date="2017-12-01 12:00">Change</a>
      			</th>
      		</tr>
      	</thead>
      	<tbody>
      		<tr>
      			<td id="endDate">2017-12-01 12:00</td>
      		</tr>
      	</tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="small-12 columns">
      <a class="button" href="#" id="btn-historical">Obtener Historicos</a>

      <!-- Uncomment if you want to see all the data obtained from query  -->
      <!-- <table id="table_hist">
        <thead>
          <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Latitud</th>
            <th class="text-center">Longitud</th>
            <th class="text-center">Tiempo</th>
          </tr>
        </thead>
        <tbody id="table_histb">
          <tr>
          </tr>
        </tbody>
      </table> -->
    </div>
  </div>
  <div class= "row small-collapse medium-collapse expanded">
    <div class="small-12 columns">
      <div id="error_msg_hist"></div>
      <div id="map2"></div>
    </div>
  </div>
  <script>
  $(function(){
    // implementation of custom elements instead of inputs

    var startDate = new Date(2017, 1, 1);
  	var endDate = new Date(2017, 12, 1);
  	var checkin = $('#dp_initial').fdatepicker({
      format: 'yyyy-mm-dd hh:ii',
  		disableDblClickSelection: true,
  		pickTime: true
    })
  		.on('changeDate', function (ev) {
  		if (ev.date.valueOf() > endDate.valueOf()) {
  			$('#alert').show().find('strong').text('The start date can not be greater then the end date');
  		} else {
  			$('#alert').hide();
  			startDate = new Date(ev.date);
  			$('#startDate').text($('#dp_initial').data('date'));
  		}
      // $('#dp_ending')[0].focus();

  	}).data('datepicker');

  	var checkout = $('#dp_ending').fdatepicker({
      format: 'yyyy-mm-dd hh:ii',
  		disableDblClickSelection: true,
  		pickTime: true,
        onRender: function (date) {
		        return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
	      }
    })
  		.on('changeDate', function (ev) {
  		if (ev.date.valueOf() < startDate.valueOf()) {
  			$('#alert').show().find('strong').text('The end date can not be less then the start date');
  		} else {
  			$('#alert').hide();
  			endDate = new Date(ev.date);
  			$('#endDate').text($('#dp_ending').data('date'));
  		}

  	}).data('datepicker');

  });
  </script>
</section>

<?php require_once('footer.php'); ?>
