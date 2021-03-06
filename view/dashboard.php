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
            <p class='text-left'>Welcome <?php echo $userController->getCurrentUser()->getFirstName()?>&emsp;Credit: $<?php echo number_format($userController->getCurrentUser()->getCredit(), 2)?></p>
        </div>
        <div class='col-sm-2'>
            <button type='button' class='btn btn-primary btn-xs' data-toggle='modal' data-target='#creditModal'>Add Credit</button>
        </div>
        <div class='input-group col-sm-3'>
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
    
<br>
<br>
<div class="container">
    <div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-6">
    <h3> <a href="history">View Your Loan History</a> </h3>
        </div>
    </div>
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
                        <p>Estimated cost calculation</p>
                        <p>$<?php echo number_format($loanController->getEstimatedCost(), 2)?></p>
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
                    //console.log("NO LOAN SEARCH CARS FOR LOACATION");
                    rego = locat['car'];
                    //console.log("REGO: " + rego);
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
                        +"<button type='button' class='btn btn-primary'"/* data-toggle='modal' data-target='#loanModal'*/+" onclick='fillForm("
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
                    if(locat['booked'] == null)
                        booked = false;
                    else
                        booked = true;
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
                    var currentLoanId = '<?php echo $loanController->getCurrentLoanId() ?>';
                    if(locat['booked'] != null && locat['booked'] != currentLoanId)
                        continue;
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
        var minCredit = 50.00;
        var credit = <?php echo $userController->getCurrentUser()->getCredit();?>;
        if(credit < minCredit)
        {
            $('#insufficientCreditModal').modal('show');
            return;
        }
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
        hours = (hours<10 ? '0' : '') + hours;
        minutes = (minutes<10 ? '0' : '') + minutes;

        var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
        $("#loanDate").val(today);
        $("#loanTime").val(hours+":"+minutes);
        $("#expectedReturnDate").attr('min', today);
        $('#loanModal').modal('show');
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

    }
    function fillReturnForm(locat)
    {
        const TO_HOURS = 3600000;
        var loans = <?php echo json_encode($loanController->getAllLoans());?>;
        var currentLoanId = <?php echo json_encode($loanController->getCurrentLoanId());?>;
        //console.log(currentLoanId);
        //console.log(loans);
        var currentLoan;
        for(var i = 0; i < loans.length; ++i)
        {
            if(loans[i]['loanId'] == currentLoanId)
            {
                currentLoan = loans[i];
                break;
            }
        }
        //console.log(currentLoan);
        var currentLocation;
        for(var i = 0; i < locations.length; ++i)
        {
            if(locations[i]['locationId'] == locat)
            {
                currentLocation = locations[i];
                break;
            }
        }
        //console.log(currentLocation);
        var currentCar;
        for(var i = 0; i < cars.length; ++i)
        {
            if(cars[i]['rego'] == currentLoan['car'])
            {
                currentCar = cars[i];
                break;
            }
        }
        //console.log(currentCar);
        $("#return-address").val(currentLocation['address']+", " + currentLocation['city'] + ", " +
                        currentLocation['postcode']);
        $("#return-locationId").val(currentLocation['locationId']);
        
        $("#return-car").val(currentCar['make']);
        $("#return-rego").val(currentCar['rego']);
        
        var loanDateTime = new Date(currentLoan["loanDate"]);

        //console.log(loanDateTime);
        var day = ("0" + loanDateTime.getDate()).slice(-2);
        var month = ("0" + (loanDateTime.getMonth() + 1)).slice(-2);
        var hours = loanDateTime.getHours();
        var minutes = loanDateTime.getMinutes();
        hours = (hours<10 ? '0' : '') + hours;
        minutes = (minutes<10 ? '0' : '') + minutes;

        var today = loanDateTime.getFullYear()+"-"+(month)+"-"+(day) ;
        $("#return-loanDate").val(today);
        $("#return-loanTime").val(hours+":"+minutes);
        
        var now = new Date();
        day = ("0" + now.getDate()).slice(-2);
        month = ("0" + (now.getMonth() + 1)).slice(-2);
        hours = now.getHours();
        minutes = now.getMinutes();
        hours = (hours<10 ? '0' : '') + hours;
        minutes = (minutes<10 ? '0' : '') + minutes;

        today = now.getFullYear()+"-"+(month)+"-"+(day) ;
        $("#returnDate").val(today);
        $("#returnTime").val(hours+":"+minutes);
        var cost = currentCar['cost'] * (now-loanDateTime)/TO_HOURS;
        $("#return-cost").val(cost.toFixed(2));
        
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
                <button type="button" class="close" id='loanClose' data-dismiss="modal" aria-label="Close">
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
<div class="modal fade" id="insufficientCreditModal" tabindex="-1" role="dialog" aria-labelledby="insufficientCreditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="text-center">Insufficient Credit</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="close">X</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please make sure you have sufficient credit in your account to loan the car. Minimum required balance is $50.00</p>
                <button type='button' class='btn btn-primary btn-lg close' data-dismiss='modal'>Close</button>
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
                <form name='book-location' action='book-location' method='post'>
                    <div class='form-group'>
                        <label for='address'>Location Address</label>
                        <input type='text' class='form-control' id='book-address' name='book-address' readonly>
                        <input type='hidden' class='form-control' id='book-locationId' name='book-locationId' readonly>
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
                <form name='return' action='return-loan' method='post'>
                    <div class='form-group'>
                        <label for='address'>Location Address</label>
                        <input type='text' class='form-control' id='return-address' name='return-address' readonly>
                        <input type='hidden' class='form-control' id='return-locationId' name='return-locationId' readonly>
                    </div>
                    <div class='row'>
                        <div class='col-sm-6 form-group'>
                            <label for='car'>Car</label>
                            <input type='text' class='form-control' id='return-car' name='return-car' readonly>
                        </div>
                        <div class='col-sm-6 form-group'>
                            <label for='rego'>Registration</label>
                            <input type='text' class='form-control' id='return-rego' name='return-rego' readonly>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='cost'>Cost</label>
                        <input type='text' class='form-control' id='return-cost' name='return-cost' readonly>
                    </div>
                    <div class='form-group'>
                        <label for='loanDate'>Start Date</label>
                        <input type='date' class='form-control' id='return-loanDate' name='return-loanDate' readonly>
                    </div>
                    <div class='form-group'>
                        <label for='loanTime'>Start Time</label>
                        <input type='time' class='form-control' id='return-loanTime' name='return-loanTime' readonly>
                    </div>
                    <div class='form-group'>
                        <label for='returnDate'>Return Date</label>
                        <input type='date' class='form-control' id='returnDate' name='returnDate' readonly>
                    </div>
                    <div class='form-group'>
                        <label for='returnTime'>Return Time</label>
                        <input type='time' class='form-control' id='returnTime' name='returnTime' readonly>
                    </div>
                    <button type='submit' class='btn btn-primary btn-lg'>Return</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="creditModal" tabindex="-1" role="dialog" aria-labelledby="creditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <h2 class="text-center">Add Credit</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="close">X</span>
                </button>
            </div>
            <div class="modal-body">
            <p>Add credit to your account to book a vehicle</p>
                <form class='form-horizontal' name='credit' action='add-credit' method='post'>
                    <div class='form-group'>
                        <label for='amount'>Amount $</label>
                        <input type='number' class='form-control' id='amount' name='amount' min='1' max='10000' required>
                    </div>
                    <div class='form-group'>
                        <label for='creditCard'>Credit Card Number</label>
                        <input type='text' class='form-control' id='creditCard' name='creditCard' readonly>
                    </div>
                    <div class='form-group'>
                        <label for='expiry'>Card Expiry Date</label>
                        <div class='row'>
                            <div class='col-sm-6'>
                                <select name='expireMM' id='expireMM' class='form-control' readonly>
                                    <option value=''>Month</option>
                                    <option value='01'>January</option>
                                    <option value='02'>February</option>
                                    <option value='03'>March</option>
                                    <option value='04'>April</option>
                                    <option value='05'>May</option>
                                    <option value='06'>June</option>
                                    <option value='07'>July</option>
                                    <option value='08'>August</option>
                                    <option value='09'>September</option>
                                    <option value='10'>October</option>
                                    <option value='11'>November</option>
                                    <option value='12'>December</option>
                                </select> 
                            </div>
                            <div class='col-sm-6'>
                                <select name='expireYY' id='expireYY' class='form-control' readonly>
                                    <option value=''>Year</option>
                                    <option value='18'>2018</option>
                                    <option value='19'>2019</option>
                                    <option value='20'>2020</option>
                                    <option value='21'>2021</option>
                                    <option value='22'>2022</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='cvv'>Card CVV</label>
                        <input type='text' class='form-control' id='cvv' name='cvv' readonly>
                    </div>
                    <button type='submit' class='btn btn-primary btn-lg'>Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var hours = now.getHours();
    var minutes = now.getMinutes();
    minutes = (minutes<10 ? '0' : '') + minutes;
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $("#loanDate").attr('min', today);
    $("#expectedReturnDate").attr('min', today);
</script>
