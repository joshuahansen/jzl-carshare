<div class='container-fluid' id="googleMap" style="height:500px;"></div>

<section class="bg-primary">

    <div class='container text-center'>
        <h1>Melbourne Locations</h1>
        <p>We currently have a range of locations around Melbourne where you can pick up and drop of a car.</p>
        <p>All our current locations are listed bellow:</p>
        <?php
            require_once('controller/LocationController.php');
            $locationController = LocationController::getInstance();
            $locations = $locationController->getLocations("Melbourne");
            $count = 0;
            echo "<div class='row'>";
            foreach($locations as $location)
            {
                if($count % 2 == 0)
                {
                    echo "</div>";
                    echo "<div class='row'>";
                }
                echo "<div class='col-sm-6 location' onclick='animateMarker(".$location['longtitude'].", "
                    .$location['latitude'].")'>";
                echo "<h4>".$location['city']."</h4>";
                echo "<p>".$location['address'].", ".$location['postcode']."</p>";
                echo "</div>";
                ++$count;
            }
            echo "</div></section>";
        ?>

<script>
function myMap() {
    var mapCenter = new google.maps.LatLng(-37.818470, 144.953579);
    var mapCanvas = document.getElementById('googleMap');
    var mapOptions = {center: mapCenter, zoom:12};
    var map = new google.maps.Map(mapCanvas,mapOptions);
    
    var locations = <?php echo json_encode($locations);?>;
     
    for(var i = 0; i < locations.length; ++i)
    {
        var locat = locations[i];
        var markerPos = new google.maps.LatLng(locat['longtitude'],locat['latitude']);
        var marker = new google.maps.Marker({position: markerPos});
        marker.setMap(map);
    }
}
function animateMarker(lon, lat)
{
    var mapCenter = new google.maps.LatLng(lon, lat);
    var mapCanvas = document.getElementById('googleMap');
    var mapOptions = {center: mapCenter, zoom:16};
    var map = new google.maps.Map(mapCanvas,mapOptions);
    var markerPos = new google.maps.LatLng(lon, lat);
    var marker = new google.maps.Marker({position: markerPos, animation: google.maps.Animation.BOUNCE});
    marker.setMap(map);
    window.scrollTo(0,0);
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQiJqF_IzXo0IU_ntxbeA63_nAS77xnjA&callback=myMap"></script>
</div>
    
