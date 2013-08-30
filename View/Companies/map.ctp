<script>
	function initialize() {
		var myLatlng = new google.maps.LatLng(0,0);
		var mapOptions = {
			zoom: 1,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.SATELLITE
		}
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		function load() {
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
		
		google.maps.event.addListener(map, "dragend", function(){
			load();
		});

		function getBorders() {
			var pointA = {
				lat:map.getBounds().getNorthEast().lat(),
				lng:map.getBounds().getSouthWest().lng()
			};
			var pointB= {
				lat:map.getBounds().getSouthWest().lat(),
				lng:map.getBounds().getNorthEast().lng()
			};
			var b = pointB.lat + "," + pointB.lng;
			var a= pointA.lat + "," + pointA.lng;
			return {southEast:b, northWest:a}
		}
		load();
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>

 <div id="map-canvas" style="width: 500px; height: 500px;"></div>
