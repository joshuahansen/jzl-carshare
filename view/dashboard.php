<?php require_once('controller/UserController.php');
    require_once('controller/LocationController.php');
    require_once('controller/CarController.php');
    require_once('controller/LoanController.php');
    require_once('model/User.php');
    $userController = UserController::getInstance();
    $locationController = LocationController::getInstance();
    $carController = CarController::getInstance();
    $loanController = LoanController::getInstance();
?>
<div class='container-fluid'>
    <div class='row search-bar'>
        <div class='col-sm-2'>
            <p class='text-center'>Welcome <?php echo $userController->getCurrentUser()->getFirstName()?></p>
        </div>
        <div class='input-group col-sm-4'>
            <input type='text' class='form-control' id='textSearch' placeholder='Search Locations'>
                <span class='input-group-btn'>
                    <button class='btn btn-primary' type='button'>
                        <i class="fas fa-search"></i>
                    </button>
                </span>
        </div>
        <div class='col-sm-2 text-right'>
            <label class='control-label' for='searchRadius'>Search Radius:</label>
        </div>
        <div class='col-sm-3'>
            <select class='form-control' id='searchRadius'>
                <option value='none' default>None</option>
                <option value='500'>500m</option>
                <option value='1000'>1km</option>
                <option value='2000'>2km</option>
                <option value='5000'>5km</option>
                <option value='10000'>10km</option>
                <option value='15000'>15km</option>
            </select>
        </div>
        <div class='col-sm-1'></div>
    </div>
</div>
<div class='container-fluid' id="googleMap" style="height:700px; width:100%">
            <div id='info' style='display:none;'>Info Box</div>
</div>

<?php 
    if(isset($_SESSION['currentLoan'])){ ?>
                
    <section class="bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-6">

                    <h2>Current Loan</h2>
                    <br>
                    <h4 class="myh4">Car Details</h4>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Model:</th>
                                <td> <?php echo $loanController->getCurrentLoan()->getCar()->getMake() ?> </td>
                            </tr>

                            <tr>
                                <th scope="row">Registration:</th>
                                <td> <?php echo $loanController->getCurrentLoan()->getCar()->getRegistration() ?> </td>
                            </tr>

                            <tr>
                                <th scope="row">Location:</th>
                                <td> <?php echo $loanController->getCurrentLoan()->getLoanLocation()->getAddress() ?> </td>
                            </tr>           
                        </tbody>     
                    </table>
                    <br>
                    <h4 class="myh4">Loan Details</h4>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Start Date:</th>
                                <td> <?php echo $loanController->getCurrentLoan()->getLoanDateTime()->format('d/m/Y H:i'); ?> </td>
                            </tr>

                            <tr>
                                <th scope="row">Expected Return:</th>
                                <td> <?php $edt = $loanController->getCurrentLoan()->getExpectedDateTime(); if($edt != Null){echo $edt->format('d/m/Y H:i');}?> </td>
                            </tr>          
                        </tbody>     
                    </table>            
                </div>

                <div class="col-lg-4 cars-col">
                    <h2>Lockbox Code</h2>
                    <br>
                    <div class="lockbox">
                        <p><?php echo $loanController->getCurrentLoan()->getLockbox() ?></p>
                    </div>
                    <div class="totalcost">
                        <p>Total cost calculation</p>
                    </div>
                </div>
                <div class="col-lg-1"></div>
            </div>
        </div>
    </section>
<?php } ?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQiJqF_IzXo0IU_ntxbeA63_nAS77xnjA&libraries=places,geometry"></script>
<script>
    var activeInfoWindow;
    var locations = <?php echo json_encode($locationController->getAllLocations());?>;
    var cars = <?php echo json_encode($carController->getAllCars());?>;
    function searchCars(rego)
    {
        for(var i = 0; i < cars.length; ++i)
        {
            if(cars[i]['rego'] == rego)
            {
                return cars[i];
            }
        }
        return false;
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
    function calcDistance(userPos, locationPos)
    {
        return google.maps.geometry.spherical.computeDistanceBetween(userPos, locationPos);
    }
    function addLocations(map, userPos)
    {
        for(var i = 0; i < locations.length; ++i)
        {
            var locat = locations[i];
            var locationLatLng = new google.maps.LatLng(locat['longtitude'], locat['latitude']);
            var searchRadius = $("#searchRadius").val()
            if (searchRadius == "none" || calcDistance(userPos, locationLatLng) <= searchRadius)
            {
                var rego;
                var carInfo = false;
                var currentLoan = <?php if(isset($_SESSION['currentLoan'])){ echo "true";} else {echo "false";};?>;
                if(locat['car'] != null)
                {
                    console.log("NO LOAN SEARCH CARS FOR LOACATION");
                    rego = locat['car'];
                    console.log("REGO: " + rego);
                    carInfo = searchCars(rego);
                }
                if(carInfo && !currentLoan)
                {
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
                else if(currentLoan && !carInfo)
                {
                    booked = false;
                    if(!booked)
                    {
                        var infoContent = "<h5>"+locat['address']+"</h5>"
                            +"<p>"+locat['city']+", "+locat['postcode'] +"</p><p>Available to Return Car. Book location</p>"
                            +"<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#bookModal' onclick='fillBookForm("+locat['locationId']+")'>Book</button>";
                    }
                    else
                    {
                        var infoContent = "<h5>"+locat['address']+"</h5>"
                            +"<p>"+locat['city']+", "+locat['postcode'] +"</p><p>Available to Return Car</p>"
                            +"<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#returnModal' onclick='fillReturnForm("+locat['locationId']+")'>Return</button>";
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
                if(cars[i]['rego'] == currentLocation['car'])
                {
                    currentCar = cars[i];
                    break;
                }
            }
        }

        $("#address").val(currentLocation['address']+", " + currentLocation['city'] + ", " +
                        currentLocation['postcode']);
        $("#lat").val(currentLocation['latitude']);
        $("#long").val(currentLocation['longtitude']);
        $("#locationId").val(currentLocation['locationId']);
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
        $("#loanDate").val(today);
        $("#loanTime").val(hours+":"+minutes);
        $("#returnDate").attr('min', today);
    }
    function fillBookForm(locat)
    {
        var currentLocation;
        for(var i = 0; i < locations.length; ++i)
        {
            if(locations[i]['locationId'] == locat)
            {
                currentLocation = locations[i];
                break;
            }
        }

        $("#book-address").val(currentLocation['address']+", " + currentLocation['city'] + ", " +
                        currentLocation['postcode']);
        $("#book-lat").val(currentLocation['latitude']);
        $("#book-long").val(currentLocation['longtitude']);
        $("#book-locationId").val(currentLocation['locationId']);

/*        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var hours = now.getHours();
        var minutes = now.getMinutes();
        minutes = (minutes<10 ? '0' : '') + minutes;

        var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
        $("#loanDate").val(today);
        $("#loanTime").val(hours+":"+minutes);
        $("#returnDate").attr('min', today);*/
    }
    function fillReturnForm(locat)
    {
        currentLoan = <?php echo json_encode($_SESSION['currentLoan']);?>;
        console.log(currentLoan);
    }
    function myMap(position) {
        var coords  = position.coords
        var mapCanvas = document.getElementById('googleMap');
        var mapCenter = new google.maps.LatLng(coords.latitude, coords.longitude);
        var mapOptions = {center: mapCenter, zoom:15};
        var map = new google.maps.Map(mapCanvas,mapOptions);

        addUserPosition(map, mapCenter);
        addLocations(map, mapCenter);

        var searchRadius = $("#searchRadius").val();
        if(searchRadius != "none")
        {
            circle = new google.maps.Circle({
            center: mapCenter,
            clickable: false,
            draggable: false,
            editable: false,
            fillColor: '#2196F3',
            fillOpacity: 0.17,
            map: map,
            radius: parseInt(searchRadius),
            strokeColor: '#1976D2',
            strokeOpacity: 0.62,
            strokeWeight: 1
            });
            map.fitBounds(circle.getBounds());
        }

        //link search box
        var input = document.getElementById('textSearch');
        var searchBox = new google.maps.places.SearchBox(input);
    //     map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }
    navigator.geolocation.getCurrentPosition(myMap);
    $("#searchRadius").change(function () {
        navigator.geolocation.getCurrentPosition(myMap);
    });
</script>

<div class="modal fade" id="loanModal" tabindex="-1" role="dialog" aria-labelledby="loanModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="text-center">Loan</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="close">X</span>
                </button>
            </div>
            <div class="modal-body">
                <form name='loan' action='create-loan' method='post'>
                    <div class='form-group'>
                        <label for='address'>Location Address</label>
                        <input type='text' class='form-control' id='address' name='address' readonly>
                        <input type='hidden' class='form-control' id='lat' name='lat' readonly>
                        <input type='hidden' class='form-control' id='long' name='long' readonly>
                        <input type='hidden' class='form-control' id='locationId' name='locationId' readonly>
                    </div>
                    <div class='row'>
                        <div class='col-sm-6 form-group'>
                            <label for='car'>Car</label>
                            <input type='text' class='form-control' id='car' name='car' readonly>
                        </div>
                        <div class='col-sm-6 form-group'>
                            <label for='rego'>Registration</label>
                            <input type='text' class='form-control' id='rego' name='rego' readonly>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='cost'>Cost</label>
                        <input type='text' class='form-control' id='cost' name='cost' readonly>
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
                        <label for='expectedReturnDate'>Expected Return Date</label>
                        <input type='date' class='form-control' id='expectedReturnDate' name='expectedReturnDate'>
                    </div>
                    <div class='form-group'>
                        <label for='expectedReturnTime'>Expected Return Time</label>
                        <input type='time' class='form-control' id='expectedReturnTime' name='expectedReturnTime'>
                    </div>
                    <button type='submit' class='btn btn-primary btn-lg'>Loan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="text-center">Book this Location to return car</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="close">X</span>
                </button>
            </div>
            <div class="modal-body">
            <p>Location booking lasts 1 hour. After that time the location becomes free for other users to book and return</p>
                <form name='loan' action='book-location' method='post'>
                    <div class='form-group'>
                        <label for='address'>Location Address</label>
                        <input type='text' class='form-control' id='book-address' name='address' readonly>
                        <input type='hidden' class='form-control' id='book-lat' name='lat' readonly>
                        <input type='hidden' class='form-control' id='book-long' name='long' readonly>
                        <input type='hidden' class='form-control' id='book-locationId' name='locationId' readonly>
                    </div>
                    <button type='submit' class='btn btn-primary btn-lg'>Book Return</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="text-center">Return Car</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="close">X</span>
                </button>
            </div>
            <div class="modal-body">
                <form name='loan' action='return-loan' method='post'>
                    <div class='form-group'>
                        <label for='address'>Location Address</label>
                        <input type='text' class='form-control' id='address' name='address' readonly>
                        <input type='hidden' class='form-control' id='lat' name='lat' readonly>
                        <input type='hidden' class='form-control' id='long' name='long' readonly>
                        <input type='hidden' class='form-control' id='locationId' name='locationId' readonly>
                    </div>
                    <div class='row'>
                        <div class='col-sm-6 form-group'>
                            <label for='car'>Car</label>
                            <input type='text' class='form-control' id='car' name='car' readonly>
                        </div>
                        <div class='col-sm-6 form-group'>
                            <label for='rego'>Registration</label>
                            <input type='text' class='form-control' id='rego' name='rego' readonly>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='cost'>Cost</label>
                        <input type='text' class='form-control' id='cost' name='cost' readonly>
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
                        <label for='expectedReturnDate'>Expected Return Date</label>
                        <input type='date' class='form-control' id='expectedReturnDate' name='expectedReturnDate'>
                    </div>
                    <div class='form-group'>
                        <label for='expectedReturnTime'>Expected Return Time</label>
                        <input type='time' class='form-control' id='expectedReturnTime' name='expectedReturnTime'>
                    </div>
                    <div class='form-group'>
                        <label for='returnDate'>Return Date</label>
                        <input type='date' class='form-control' id='returnDate' name='returnDate'>
                    </div>
                    <div class='form-group'>
                        <label for='returnTime'>Return Time</label>
                        <input type='time' class='form-control' id='returnTime' name='returnTime'>
                    </div>
                    <button type='submit' class='btn btn-primary btn-lg'>Return</button>
                </form>
            </div>
        </div>
    </div>
</div>
