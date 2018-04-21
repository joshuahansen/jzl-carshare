<?php require_once('controller/UserController.php');
    require_once('controller/LocationController.php');
    require_once('model/User.php');
    $userController = UserController::getInstance();
    $locationController = LocationController::getInstance();
?>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-sm-2 sidenav'>
            <p>Welcome <?php echo unserialize($userController->getCurrentUser())->getName()['first']?></p>
            <ul class='nav nav-pills nav-stacked'>
                <li class='active nav-item'><a class='nav-link' href='#'>Home</a></li>
                <li class='nav-item'><a class='nav-link' href='#'>Profile</a></li>
                <li class='nav-item'><a class='nav-link' href='#'>Loan History</a></li>
                <li class='nav-item'><a class='nav-link' href='#'>Current Loan</a></li>
            </ul>
            </br>
            <div class='input-group'>
                <input type='text' class='form-control' placeholder='Search Locations..'>
                <span class='input-group-btn'>
                    <button class='btn btn-primary btn-default' type='button'>
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
        <div class='col-sm-8' id="googleMap" style="height:500px; width:100%">
            <div id='info' style='display:none;'>Info Box</div>
        </div>
        <div class='col-sm-2'></div>
        <script>
            function getUserPosition()
            {
               /* if(navigator.geolocation)
                {
                    var position = navigator.geolocation.getCurrentPosition(function (position){
                        console.log( position.coords);
                        return position.coords;
                    });
                    console.log(position);
                    var lat = position.latitiude;
                    var lon = position.longtitude;
                    return mapCenter = new google.maps.LaddtLng(lat, lon);
                }
                else*/
                {
                    return mapCenter = new google.maps.LatLng(-37.818470, 144.953579);
                }
            }
            function addUserPosition(map, mapCenter)
            {
                        var marker = new google.maps.Marker({position: mapCenter});
                        marker.setMap(map);
                        var infoContent = "<h3>Current Location</h3>";
                        var infoWindow = new google.maps.InfoWindow({
                                content: infoContent
                        });
                        marker.addListener('mouseover', function () {
                            $("#info").show();
                        });
            }
            function addLocations(map)
            {
                var locations = <?php echo json_encode($locationController->getLocations("Melbourne"));?>;
                for(var i = 0; i < locations.length; ++i)
                {
                    var locat = locations[i];
                    console.log(locat); 
                    var markerPos = new google.maps.LatLng(locat['longtitude'],locat['latitude']);
                    var marker = new google.maps.Marker({position: markerPos});
                    var infoContent = "<h3>"+locat['address']+"</h3>";
                    console.log(locat['address']);
                    var infoWindow = new google.maps.InfoWindow({
                            content: infoContent
                    });
                    marker.addListener('mouseover', displayLocationDetails(locat));
                    marker.setMap(map);
                }
            }
            function displayLocationDetails(locat)
            {
            }
            function myMap() {
                var mapCanvas = document.getElementById('googleMap');
                var mapCenter = getUserPosition();
                var mapOptions = {center: mapCenter, zoom:12};
                var map = new google.maps.Map(mapCanvas,mapOptions);

                addUserPosition(map, mapCenter);
                addLocations(map);
            }
        </script>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXolLNh8zGpDN3_YE38vEwPMmtBMBxXLw&callback=myMap"></script>
    </div>
    <button type='button' class='btn btn-primary btn-default' data-toggle='modal' data-target='#loanModal'>Loan</button>
</div>
<div class="modal fade" id="loanModal" tabindex="-1" role="dialog" aria-labelledby="loanModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="text-center">Loan</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class=close'>X</span>
                </button>
            </div>
            <div class="modal-body">
                <form name='loan' action='loan' method='post'>
                    <div class='form-group'>
                        <label for='address'>Location Address</label>
                        <input type='text' class='form-control' id='address' name='address' disabled>
                    </div>
                    <div class='form-group'>
                        <label for='car'>Car</label>
                        <input type='text' class='form-control' id='car' name='car' disabled>
                    </div>
                    <div class='form-group'>
                        <label for='cost'>Cost</label>
                        <input type='text' class='form-control' id='cost' name='cost' disabled>
                    </div>
                    <div class='form-group'>
                        <label for='loanDate'>Start Date</label>
                        <input type='date' class='form-control' id='loanDate' name='loanDate'>
                    </div>
                    <div class='form-group'>
                        <label for='loanTime'>Start Time</label>
                        <input type='time' class='form-control' id='loanTime' name='loanTime'>
                    </div>
                    <div class='form-group'>
                        <label for='returnDate'>Expected Return Date</label>
                        <input type='date' class='form-control' id='returnDate' name='returnDate'>
                    </div>
                    <div class='form-group'>
                        <label for='returnTime'>Return Time</label>
                        <input type='time' class='form-control' id='returnTime' name='returnTime'>
                    </div>
                    <button type='submit' class='btn btn-primary btn-lg'>Loan</button>
                </form>
            </div>
        </div>
    </div>
</div>
