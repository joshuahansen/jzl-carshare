<nav class="navbar navbar-light navbar-expand-lg" id="nav">
    <div class="container">
        <a class="navbar-brand" href="/JZL-carshare/">JZL Carshare</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link" href="">About Us</a>
                        <div class="dropdown-content">
                            <a href="story">Our Story</a>
                            <a href="cars">Our Cars</a>
                            <a href="locations">Our Locations</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="loan">Loan</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact">Contact Us</a>
                </li>
                <li class="nav-item">
                    <?php
                        if(isset($_SESSION['user']))
                        {
                            echo '<a class="nav-link" href="logout">Log Out</a>';
                        }
                        else
                        {
                            echo '<a class="nav-link" href="login">Log In</a>';
                        }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
