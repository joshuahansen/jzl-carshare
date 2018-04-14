<?php require_once('controller/UserController.php');?>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-sm-2 sidenav'>
            <p>Welcome <?php //echo $userController->getCurrentUser()->getName();?></p>
            <ul class='nav nav-pills nav-stacked'>
                <li class='active'><a href='#'>Home</a></li>
                <li><a href='#'>Profile</a></li>
                <li><a href='#'>Loan History</a></li>
                <li><a href='#'>Current Loan</a></li>
            </ul>
            </br>
            <div class='input-group'>
                <input type='text' class='form-control' placeholder='Search Locations..'>
                <span class='input-group-btn'>
                    <button class='btn btn-default' type='button'>
                        <i class="fas fa-search"></i>
                    </button>
                </span>
            </div>
            </br>
            <div>
                <label class='control-label' for='searchRadius'>Search Radius:</label>
                <select class='form-control' id='searchRadius'>
                    <option value='none' default>None</option>
                    <option value='1'>1km</option>
                    <option value='2'>2km</option>
                    <option value='5'>5km</option>
                    <option value='10'>10km</option>
                    <option value='15'>15km</option>
                </select>
            </div>
        </div>
        <div class='col-sm-8' id="googleMap" style="height:500px; width:100%"></div>
        <div class='col-sm-2'></div>
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
</div>
