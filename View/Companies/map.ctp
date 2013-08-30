<script>
	function initialize() {
		var myLatlng = new google.maps.LatLng(0,0);
		var mapOptions = {
			zoom: 1,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.SATELLITE
		}
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		$.getJSON('/users.json', function(data) {
			$.each(data.data, function(k, v) {
				$.each(v.User.companies, function(k, val) {
					var position = new google.maps.LatLng(val.location.lat, val.location.lon);
					new google.maps.Marker({
						position: position,
						map: map,
						title: val.name
					});
				});
			});
		});
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);
</script>

 <div id="map-canvas" style="width: 500px; height: 500px;"></div>
