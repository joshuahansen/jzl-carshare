<div class="login-container">
    <div class="card card-container">
    <h2 class="login-title text-center">Login</h2>
    <hr class="loginhr">
        <form name="login" class="form-signin" action="verify" method="post">
            <p class="input-title">Email</p>
            <input type="text" id="email" name='email' class="login-box" placeholder="email@email.com" required autofocus>
            <p class="input-title">Password</p>
            <input type="password" id="password" name='password' class="pword-box" placeholder="******" required>
            <a class="forgot" href="">Forgotten password?</a>
            <button class="btn btn-lg btn-primary" type="submit">Login</button>
        </form>
            <button class="btn btn-lg btn-secondary" type="button" data-toggle="modal" data-target="#myModal">Register</button>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="login-title text-center">Register</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form name="register" action="register" method="post">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>First Name</label>
                                            <input type="text" name='firstName' placeholder="Enter First Name Here.." class="form-control" required>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label>Last Name</label>
                                            <input type="text" name='lastName' placeholder="Enter Last Name Here.." class="form-control" required>
                                        </div>
                                    </div>					
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name='address' placeholder="Enter Address Here.." rows="1" class="form-control" required></textarea>
                                    </div>	
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>City</label>
                                            <input type="text" name='city' placeholder="Enter City Here.." class="form-control" required>
                                        </div>		
                                        <div class="col-sm-6 form-group">
                                            <label>Postcode</label>
                                            <input type="text" name='postcode' placeholder="Enter Postcode Here.." class="form-control" required>
                                        </div>		
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 form-group">
                                            <label>Email</label>
                                            <input type="text" name='email' placeholder="Enter Email Here.." class="form-control" required>
                                        </div>		
                                        <div class="col-sm-6 form-group">
                                            <label>License Number</label>
                                            <input type="text" placeholder="Enter License Number.." class="form-control" required>
                                        </div>	
                                    </div>						
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name='password' placeholder="Enter Password Here.." class="form-control" required>
                                </div>		
                                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>				
                                </div>
                            </form> 
                        
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
</div>
