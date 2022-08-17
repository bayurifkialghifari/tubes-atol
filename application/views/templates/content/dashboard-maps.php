<?php
$key = 'AIzaSyCAkHocM29jkneqd5rY54DFdoDDv4r7EIM';

$tran_id = 0;
$driver = 0;
$from = null;
$to = null;
$distance = null;
$price = null;

if(isset($transaction)) {
	$transaction = $transaction[0];
	$tran_id = $transaction['tran_id'];
	$driver = $transaction['tran_driv_id'];
	$from = $transaction['tran_asal'];
	$to = $transaction['tran_tujuan'];
	$distance = $transaction['tran_jarak'];
	$price = $transaction['tran_harga'];
}
?>
<div class="container">


<!-- Shearch on map -->
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<form role="form" id="calculate-route" method="post">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6">
					<label for="txtFrom">
						Origin from :</label>
					<input type="text" id="txtFrom" name="txtFrom" class="form-control" required="required" placeholder="Location From"
							size="40" />
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6">
					<label for="txtTo">
						Destination :</label>
					<input type="text" id="txtTo" name="txtTo" class="form-control" required="required" placeholder="Location To" value="<?= $to ? $to : '' ?>"
						size="40" />
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 text-center pt-3 pb-3">
			    	<input type="submit" value="Search" class="btn btn-primary" <?php if(isset($transaction)) : ?>
							disabled="disabled"
						<?php endif ?> />
	    		</div>
			</div>

		</form>  
	</div>
</div>




<!-- Google map -->
<div id="DivMap">
</div>



<!-- Order Detail -->
<div id="detail" style="display: none">
	<form id="order" role="form" method="post">

		<div class="row pt-3">
			<div class="col-md-12">
				<h5 class="mb-4 text-uppercase text-center">details</h5>
					<p>DISTANCE <input type="text" id="jarak" readonly="" class="form-control form-md"></p>
					<p>PRICE <input type="text" id="price" readonly="" class="form-control form-md"></p>
					<p>DURATION <input type="text" id="lama" readonly="" class="form-control form-md"></p>
					<p style="display: none">DRIVER <input type="text" id="driver" readonly="" class="form-control form-md"></p>
					<div class="text-center">
						<button type="button" onclick="done()" class="btn btn-success ">Sampai</button>
					</div>
				<br>
			</div>
		</div>

	</form>
</div>




<style type="text/css">
#DivMap
{
  width: 100%;
  height: 500px;
  box-shadow: 5px 5px 15px 5px #888888;
}
</style>

<script src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=<?= $key ?>"></script>
<script>
	// On load function
    calculateRoute()

	//For TextBox Search..............
    google.maps.event.addDomListener(window, 'load', () => 
    {
        var places      = new google.maps.places.Autocomplete(document.getElementById('txtFrom'))
        
        google.maps.event.addListener(places, 'place_changed', () => 
        {
            var place   = places.getPlace()
        })

        var places1     = new google.maps.places.Autocomplete(document.getElementById('txtTo'))

        google.maps.event.addListener(places1, 'place_changed', () => 
        {
            var place1  = places1.getPlace()
        })
    })

	// Menampilkan map
    function calculateRoute(rootfrom = null, rootto = null, latitude = null, longitude = null) 
    {



        var myOptions   = {
            zoom: 17,
            center: new google.maps.LatLng(latitude, longitude),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }



        // Draw the map
        var mapObject   = new google.maps.Map(document.getElementById("DivMap"), myOptions)
 
        var directionsService = new google.maps.DirectionsService()
        var directionsRequest = {
            origin: rootfrom,
            destination: rootto,
            travelMode: google.maps.DirectionsTravelMode.DRIVING,
            unitSystem: google.maps.UnitSystem.METRIC
        }

        directionsService.route(
        directionsRequest,
        (response, status) => 
        {

            if (status == google.maps.DirectionsStatus.OK) 
            {
				new google.maps.DirectionsRenderer(
				{
					map: mapObject,
					directions: response
				})
            }
            else
            {
              $("#lblError").append("Unable To Find Root")
            }
        }
        )
    }

	function done() {
		$.ajax({
			method: 'post',
			url: '<?= base_url() ?>socket/done',
			data:
			{
				status: 'Done',
				driv_id: <?= $this->session->userdata('data')['id'] ?>,
				trans_id: <?= $tran_id ?>,
			},
			success(data)
			{
				$.message('ARRIVE AT DESTINATION !!', 'ORDER', 'success')

				setTimeout(() => {
					location.href = '<?= base_url() ?>myorder'	
				}, 1000)
			},
			error($xhr)
			{
				console.log($xhr)
			}
		})
	}

	$(document).ready(() => 
    {    

        load()

        // Load function data
        function load()
        {
			if (navigator.geolocation) 
			{
				navigator.geolocation.getCurrentPosition(showPosition)
			}
        }

        // Show Position
        function showPosition(position) 
        { 
			let latitude    = position.coords.latitude
			let longitude   = position.coords.longitude

			$.ajax({
				method: 'get',
				url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + latitude + ',' + longitude + '&sensor=true&key=<?= $key ?>',
				async: true,
				success(data)
				{
					<?php if($from) : ?>
						$('#txtFrom').val('<?= $from ?>')

						$('#calculate-route').submit()
					<?php else : ?>
						$('#txtFrom').val(data.results[1].formatted_address)

						calculateRoute(null, null, latitude, longitude)
					<?php endif; ?>
				}
			})
        }

        // If the browser supports the Geolocation API
        if (typeof navigator.geolocation == "undefined") 
        {
			$("#lblError").text("Your browser doesn't support the Geolocation API")

			return
        }

		// On Submit rute pesanan
		$("#calculate-route").submit((ev) => 
		{
			let from 	= $("#txtFrom").val()
			let to 		= $("#txtTo").val()

			ev.preventDefault()

			calculateRoute(from, to)

			$('#pesan').prop('disabled', false)

			// Menghitung jarak
			var service = new google.maps.DistanceMatrixService()

			service.getDistanceMatrix(
			{
				origins: [from],
				destinations: [to],
				travelMode: 'DRIVING',
				unitSystem: google.maps.UnitSystem.MATRIX
			}, callback)




			function callback(response, status) 
			{

				let jarak 		    = response.rows[0].elements[0].distance.value
				let jarakText 	  = response.rows[0].elements[0].distance.text
				let lama          = response.rows[0].elements[0].duration.text
				let angka 		    = Number(jarak) * <?= $harga ?>

				var number_string = angka.toString(),
				sisa            = number_string.length % 3,
				rupiah          = number_string.substr(0, sisa),
				ribuan          = number_string.substr(sisa).match(/\d{3}/g);
				
				if (ribuan) {
					separator = sisa ? '.' : '';
					rupiah += separator + ribuan.join('.');
				}
				$('#price').val(rupiah)
				$('#jarak').val(jarakText)
				$('#lama').val(lama)

				$('#detail').css('display', 'block')
			}
		})
	})
</script>
