<div class='container' id="googleMap" style="height:500px; width:1000px"></div>
<script>
function myMap() {
    if(navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(function (position){
            var lon = position.coords.longitude;
            var lat = position.coords.latitude;
            var mapCenter = new google.maps.LatLng(lat, lon);
            var mapCanvas = document.getElementById('googleMap');
            var mapOptions = {center: mapCenter, zoom:12};
            var map = new google.maps.Map(mapCanvas,mapOptions);
            var marker = new google.maps.Marker({position: mapCenter});
            marker.setMap(map);
        });
    }
    else
    {
        var mapCenter = new google.maps.LatLng(-37.818470, 144.953579);
        var mapCanvas = document.getElementById('googleMap');
        var mapOptions = {center: mapCenter, zoom:12};
        var map = new google.maps.Map(mapCanvas,mapOptions);
    }
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXolLNh8zGpDN3_YE38vEwPMmtBMBxXLw&callback=myMap"></script>
</div>
    
