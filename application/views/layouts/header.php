<!DOCTYPE html>
<html lang="pt">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>Casa do Pirogue<?php if (isset($page_title)) { echo ' | '.$page_title; } ?></title>
 <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <!-- <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" /> -->
        <!--[if IE]>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/styleIE.css" />
        <![endif]-->
        <!-- <script type="text/javascript" src="<?php base_url(); ?>/assets/js/jquery-1.3.2.js"></script> -->
        <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>scripts/scripts.js"></script> -->
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

      /*  function calcRoute() {
              //var start = document.getElementById("start").value;
              //var end = document.getElementById("end").value;

            }*/
        </script>
         <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGlXHsXhyU5qL9BfeUuh9VcsC8V6hgzxw&signed_in=true&callback=teste" type="text/javascript"></script>

</head>
<body>
<header>Header Login</header>

<!-- <div id="map" style="float:left;width:70%; height:100%"></div>
<div id="directionsPanel" style="float:right;width:30%;height 100%"></div> -->
