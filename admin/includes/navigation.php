
<!--Bootstrap CDN - JS and JQ -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 

<!--Top Navigation Bar-->
<nav class="top-bar">
  <div class="container">
  <div class="row">
       <div class="col-sm-3 hidden-xs">
            <span class="nav-text text-left" style="font-size:14px">
                <i class="fas fa-phone" aria-hidden="true"></i>  +321 877 5177 <br>
                <i class="fas fa-envelope" aria-hidden="true"></i> sxb38200@ucmo.edu
            </span>
       </div>
       <div class="col-sm-4 text-center">
            <a href="https://www.facebook.com/" class="social"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
            <a href="https://twitter.com/" class="social"><i class="fab fa-twitter" aria-hidden="true"></i></a>
            <a href="https://www.instagram.com/" class="social"><i class="fab fa-instagram" aria-hidden="true"></i></a>
            <a href="https://www.youtube.com/" class="social"><i class="fab fa-youtube" aria-hidden="true"></i></a>
            <a href="https://www.google.com/" class="social"><i class="fab fa-google" aria-hidden="true"></i></a>
            <a href="https://dribbble.com/" class="social"><i class="fab fa-dribbble" aria-hidden="true"></i></a>
       </div>
       <div class="col-sm-4 text-right hidden-xs">
    
       <!--Login welcome message. Msg pulled from server.php-->
    <div class="loginWelcome">
    <!--Welcome message and logout-->
   <div class="contentHomePage">
        <?php if (isset($_SESSION['username'])): ?>
           <p><i class="fas fa-user" aria-hidden="true"></i> Welcome 
           <strong style="font-family:'Snowburst One',cursive;">
              <?php echo $_SESSION['username']; ?></strong></p>
           <p><a href="../php/homePage.php?logout='1'" style="color: red; ">Logout</a></p> <!--Home page because homepg directs you to login screen when you log out-->
        <?php endif ?>
    </div>

    </div>


       </div>
    </div>
  </div>
</nav>  <!---Top Nav Bar End-->



<!--Navbar Mega Menu Start-->
<nav class="navbar navbar-expand-lg navbar-light bg-light" id="megaMenu_Nav" style="padding-bottom: 3px;">
   <a class="navbar-brand" href="/ASP_Project/admin/index.php"
      style="color:Tomato;font-family:'Snowburst One',cursive; font-weight:bolder; font-size:35px;">
   <img src="../images/CartBugLogo.png" width="50" class="d-inline-block align-top" alt="logo" style="margin-top:-3%">
    CartBug's Admin
   </a>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
   </button>

   <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
         <li class="nav-item" style="margin:10px;">
           <a class="nav-link" href="/ASP_Project/php/viewAll.php"><i class="far fa-bell"></i> User Collections</a>
         </li>
         <div class="collapse navbar-collapse js-navbar-collapse">
         <ul class="nav navbar-nav nav-item">
           <li class="dropdown mega-dropdown">
           <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Manage Collections</a>
         <ul class="dropdown-menu mega-dropdown-menu list-inline" aria-labelledby="navbarDropdown">

           <li class="col-xs-3 list-inline-item align-top">
                <ul>
                   <li class="dropdown-header"><a href="brands.php"><b>Brands</b></a></li> <hr>
                   <li class="dropdown-header"><a href="categories.php"><b>Categories</b></a></li><hr>
                   <li class="dropdown-header"><a href="products.php"><b>Products</b></a></li><hr>        
                   <li class="dropdown-header"><a href="index.php"><b>My Dashboard</b></a></li><hr>      
                </ul>
            </li> 
            <li class="col-xs-3 list-inline-item align-top">
                <ul>
                    <li class="dropdown-header"><a href="archived.php"><b>Archived items &nbsp;&nbsp;</b></a></li><hr>
                    <li class="dropdown-header"><a href="users.php"><b>Our Users &nbsp;&nbsp;</b></a></li><hr>
                    <li class="dropdown-header"><a href="changePassword_admin.php"><b>Change Password &nbsp;&nbsp;</b></a></li><hr>
                </ul>
            </li>   

         </ul>
        </li>
      </ul>

    </div>
    <!-- /.nav-collapse -->
    <script>
       jQuery(document).on('click', '.mega-dropdown', function(e) {
       e.stopPropagation()
       })
    </script>

  </div>
</nav>
 <!--Navbar Mega Menu End-->
<!---**********************************************************************************************************************-->