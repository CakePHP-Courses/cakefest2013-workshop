<script>
	function initialize() {
		var myLatlng = new google.maps.LatLng(0,0);
		var mapOptions = {
			zoom: 1,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.SATELLITE
		}
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		$.getJSON('/companies/index.json', function(data) {
			$.each(data.data, function(key, val) {
				var position = new google.maps.LatLng(val.Company.latitude, val.Company.longitude);
				new google.maps.Marker({
					position: position,
					map: map,
					title: val.Company.name
				});
			});
		});
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);
</script>

 <div id="map-canvas" style="width: 500px; height: 500px;"></div>