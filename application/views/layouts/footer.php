<?php require_once 'partials/_flashes.php'; ?>
<footer>Footer Login</footer>
<script type="text/javascript" href="<?php echo base_url("assets/js/jquery.min.js") ?>"></script>
<script type="text/javascript" href="<?php echo base_url("assets/js/bootstrap.min.js") ?>"></script>
<script type="text/javascript" href="<?php echo base_url("assets/js/owl.carousel.min.js") ?>"></script>

<script type="text/javascript">
        //https://developers.google.com/maps/documentation/directions/intro?hl=pt-br#Waypoints
        function teste () {
            //Fonte: https://developers.google.com/maps/documentation/javascript/directions#DirectionsRequests
            //https://developers.google.com/maps/documentation/javascript/examples/distance-matrix
            //https://developers.google.com/maps/documentation/javascript/directions#Waypoints
            var directionsService = new google.maps.DirectionsService();
            var request = {
            	origin: 'Curitiba',
            	destination: 'Guarapuava',
            	travelMode: google.maps.TravelMode.DRIVING
            };

            directionsService.route(request, function(response, status) {
            	if (status == google.maps.DirectionsStatus.OK) {
            		console.log(response);
            		var route = response.routes[0];
            		console.log(route.legs[0].distance.text);
            	}
            });
         }

</script>
	<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGlXHsXhyU5qL9BfeUuh9VcsC8V6hgzxw&signed_in=true&callback=teste" type="text/javascript"></script> -->



</body>
</html>