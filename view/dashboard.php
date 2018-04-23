<?php require_once('controller/UserController.php');
    require_once('controller/LocationController.php');
    require_once('controller/CarController.php');
    require_once('model/User.php');
    $userController = UserController::getInstance();
    $locationController = LocationController::getInstance();
    $carController = CarController::getInstance();
?>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-sm-2 sidenav'>
            <p>Welcome <?php echo unserialize($userController->getCurrentUser())->getName()['first']?></p>
            <ul class='nav nav-pills nav-stacked'>
                <li class='nav-item'><a class='nav-link' href='dashboard'>Home</a></li>
                <li class='nav-item'><a class='nav-link' href='#'>Profile</a></li>
                <li class='nav-item'><a class='nav-link' href='#'>Loan History</a></li>
                <li class='nav-item'><a class='nav-link' href='#'>Current Loan</a></li>
            </ul>
            </br>
            <div class='input-group'>
                <input type='text' class='form-control' placeholder='Search Locations'>
                <span class='input-group-btn'>
                    <button class='btn btn-primary' type='button'>
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
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXolLNh8zGpDN3_YE38vEwPMmtBMBxXLw"></script>
        <script>
            var activeInfoWindow;
            var locations = <?php echo json_encode($locationController->getLocations("Melbourne"));?>;
            var cars = <?php echo json_encode($carController->getAllCars());?>;
            function searchCars(rego)
            {
                for(var i = 0; i < cars.length; ++i)
                {
                    console.log("searching cars");
                    if(cars[i]['rego'] == rego)
                    {
                        return cars[i];
                    }
                }
                return false;
            }
            function getUserPosition()
            {
               /* if(navigator.geolocation)
                {
                    var position = navigator.geolocation.getCurrentPosition(function (position){
                        return position.coords;
                    });
                    var lat = position.latitiude;
                    var lon = position.longtitude;
                    return mapCenter = new google.maps.LatLng(lat, lon);
                }
                else*/
                {
                    return mapCenter = new google.maps.LatLng(-37.818470, 144.953579);
                }
            }
            function addUserPosition(map, mapCenter)
            {
                        var customMarker = 'img/map-markers/blue.png'
                        var marker = new google.maps.Marker({
                                position: mapCenter,
                                icon: customMarker
                        });
                        marker.setAnimation(google.maps.Animation.BOUNCE);
                        marker.setMap(map);
            }
            function addLocations(map)
            {
                for(var i = 0; i < locations.length; ++i)
                {
                    var locat = locations[i];
                    console.log(locat['address']);
                    var rego;
                    var carInfo = false;
                    if(locat['car'] != null)
                    {
                        rego = locat['car'];
                        console.log(rego);
                        carInfo = searchCars(rego);
                    }
                    if(carInfo)
                    {
                        console.log("get car img");
                        var carImg;
                        switch(carInfo['make']) {
                            case "Model 3":
                                carImg = 'img/model3.jpg';
                                break;
                            case "Model X":
                                carImg = 'img/modelX.png';
                                break;
                            case "Model S":
                                carImg = 'img/modelS.jpg';
                                break;
                        }
                        var infoContent = "<h5>"+locat['address']+"</h5>"
                            +"<img src='"+carImg+"' style='max-width:95px;max-height:100px;float:right;margin:0px;'>"
                            +"<p>"+locat['city']+", "+locat['postcode'] +"</p><p>"+carInfo['make']+"</p>"
                            +"<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#loanModal' onclick='fillForm("
                            +locat['locationId']+")'>Loan</button>";
                    }
                    else
                    {
                        var infoContent = "<h5>"+locat['address']+"</h5>"
                            +"<p>"+locat['city']+", "+locat['postcode'] +"</p><p>Available to Return Car</p>"
                            +"<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#loanModal' onclick='fillForm("+locat['locationId']+")'>Loan</button>";
                    }
                    var markerPos = new google.maps.LatLng(locat['longtitude'],locat['latitude']);
                    var marker = new google.maps.Marker({position: markerPos});
                    var infoWindow = new google.maps.InfoWindow();

                    google.maps.event.addListener(marker,'click', (function(marker, infoContent, infoWindow){
                        return function() {
                            if(activeInfoWindow)
                            {
                                activeInfoWindow.close();
                            }
                            infoWindow.setContent(infoContent);
                            infoWindow.open(map, marker);
                            activeInfoWindow = infoWindow;
                        };
                    })(marker, infoContent, infoWindow));
                    marker.setMap(map);
                }
            }
            function fillForm(locat)
            {
                var currentLocation;
                var currentCar;
                for(var i = 0; i < locations.length; ++i)
                {
                    if(locations[i]['locationId'] == locat)
                    {
                        currentLocation = locations[i];
                        break;
                    }
                }
                if(currentLocation['car'])
                {
                    for(var i = 0; i < cars.length; ++i)
                    {
                        console.log("searching cars");
                        if(cars[i]['rego'] == currentLocation['car'])
                        {
                            currentCar = cars[i];
                            break;
                        }
                    }
                }
                
                $("#address").val(currentLocation['address']+", " + currentLocation['city'] + ", " +
                                currentLocation['postcode']);
                if(currentCar)
                {
                    $("#car").val(currentCar['make']);
                    $("#rego").val(currentCar['rego']);
                    $("#cost").val(currentCar['cost']);
                }
                else
                {
                    $("#car").val("");
                    $("#rego").val("");
                    $("#cost").val("");
                }
                
                var now = new Date();
                var day = ("0" + now.getDate()).slice(-2);
                var month = ("0" + (now.getMonth() + 1)).slice(-2);
                var hours = now.getHours();
                var minutes = now.getMinutes();
                minutes = (minutes<10 ? '0' : '') + minutes;

                var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
                console.log(hours+":"+minutes);
                $("#loanDate").val(today);
                $("#loanTime").val(hours+":"+minutes);
                $("#returnDate").attr('min', today);
            }
            function myMap() {
                var mapCanvas = document.getElementById('googleMap');
                var mapCenter = getUserPosition();
                var mapOptions = {center: mapCenter, zoom:15};
                var map = new google.maps.Map(mapCanvas,mapOptions);
                

                addUserPosition(map, mapCenter);
                addLocations(map);
            }
            myMap();
        </script>

    </div>
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
                    <div class='row'>
                        <div class='col-sm-6 form-group'>
                            <label for='car'>Car</label>
                            <input type='text' class='form-control' id='car' name='car' disabled>
                        </div>
                        <div class='col-sm-6 form-group'>
                            <label for='rego'>Registration</label>
                            <input type='text' class='form-control' id='rego' name='rego' disabled>
                        </div>
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
