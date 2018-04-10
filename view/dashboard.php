<div class='container' id="googleMap" style="height:500px; width:1000px"></div>
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
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXolLNh8zGpDN3_YE38vEwPMmtBMBxXLw&callback=myMap"></script>
</div>
    
