<nav class="navbar navbar-light navbar-expand-lg" id="nav">
   <div class="container">
       <div class="navbar-header">
           <a class="navbar-brand" href="/JZL-carshare/">JZL Carshare</a>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
 </button>
       </div>
       <div id="navbarSupportedContent" class="navbar-collapse collapse">
           <ul class="navbar-nav ml-auto">
               <li class="nav-item">
                   <div class="dropdown">
                       <a class="nav-link" href="">About Us</a>
                       <div class="dropdown-content">
                           <a href="cars">Our Cars</a>
                           <a href="locations">Our Locations</a>
                       </div>
                   </div>
               </li>
               <li class="nav-item">
                 <a class="nav-link" href="dashboard">Dashboard</a>
               </li>
                 <li class="nav-item">
                     <?php
                         if(isset($_SESSION['currentUser'])):
                     ?>
                        <a class="nav-link" href="logout">Logout</a>
                     <?php else: ?>
                        <a class="nav-link" href="login">Login</a>
                    <?php endif; ?>
                 </li>
             </ul>

         </div>
     </div>
</nav> 
