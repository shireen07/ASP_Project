<?php

 include_once __DIR__.'/../includes/js_css.php';

 ?>

<!--Top Navigation Bar-->
<nav class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 hidden-xs">
                  <span class="nav-text text-left" style="font-size:12px">
                      <div class="dropdown DDoptions">
                          <a href="#" class="dropdown-toggle DDOptions_Label" data-toggle="dropdown">Options</a>
                          <span class="caret"></span>
                          <ul class="dropdown-menu" role="menu">
                              <li>
                                <a href="<?php echo SITE_URL;?>/php/changePassword.php">
                                    <i class="fas fa-envelope" aria-hidden="true"></i> Change Password
                                </a><br>
                                <a href="#">
                                    <i class="fas fa-phone" aria-hidden="true"></i> Contact us
                                </a><br>
                              </li>
                          </ul>
                      </div> <!--DD div Bar-->
                  </span>   
            </div> <!--col-sm-4 hidden xs menu div-->

          
            <div class="col-sm-4 text-center">
                  <a href="https://www.facebook.com/" class="social"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
                  <a href="https://twitter.com/" class="social"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                  <a href="https://www.instagram.com/" class="social"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                  <a href="https://www.youtube.com/" class="social"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                  <a href="https://www.google.com/" class="social"><i class="fab fa-google" aria-hidden="true"></i></a>
                  <a href="https://dribbble.com/" class="social"><i class="fab fa-dribbble" aria-hidden="true"></i></a>
            </div> <!--icon div-->

            <div class="col-sm-4 text-right hidden-xs"> 
                <!--Login welcome message. Msg pulled from server.php-->
                <div class="loginWelcome">
                    <!--Welcome message and logout-->
                    <div class="contentHomePage">
                          <?php if (isset($_SESSION['username'])): ?>
                            <p><i class="fas fa-user" aria-hidden="true"></i> Welcome 
                            <strong style="font-family:'Snowburst One',cursive;">
                                <?php echo $_SESSION['username']; ?></strong></p>
                            <p><a href="homePage.php?logout='1'" style="color: red; ">Logout</a></p>
                          <?php endif ?>
                    </div> <!--contentHomePage div-->
                </div> <!--loginwelcome div-->
            </div><!--login welcome  div-->

        </div> <!--row  div-->
    </div> <!--container div-->
</nav>  <!---Top Nav Bar End-->



<!--Navbar Mega Menu Start-->
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-bottom: 3px;">
      
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
   </button>

   <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
         <li class="nav-item" style="margin:10px;">
           <a class="nav-link" href="<?php echo SITE_URL;?>/php/expertAdvice.php"><i class="fas fa-chess-queen"></i> Expert Advice</a>
         </li>
         <li class="nav-item" style="margin:10px;">
            <?php if($_SESSION['username'] == 'Admin'):?>
              <a class="nav-link" href="<?php echo SITE_URL;?>/admin/index.php"><i class="fab fa-autoprefixer"></i> Admin Home</a>
            <!--<a class="nav-link" href="<?php echo SITE_URL;?>/php/deals.php"><i class="far fa-bell"></i> Deals</a> -->
            <?php endif;?>
         </li>
         <div class="collapse navbar-collapse js-navbar-collapse">
         <ul class="nav navbar-nav nav-item">
           <li class="dropdown mega-dropdown">
           <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Collection</a>
         <ul class="dropdown-menu mega-dropdown-menu list-inline" aria-labelledby="navbarDropdown">
            <li class="col-md-3 list-inline-item align-top">
              <ul>
                <li class="dropdown-header" style="font-size:20px; color:teal;">Fresh in Store</li>
                <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="1900"> <!--data-interval for moving slider every 1.9sec-->
                  <div class="carousel-inner">
                    <!-- Start Item 1 -->
                    <div class="carousel-item active" style="background:white;">
                      <a href="#"><img src="https://www.forever21.com/images/1_front_750/00277666-01.jpg" 
                      style="width:50%;margin-left:10%;" class="img-responsive" alt="product 1"></a>
                      <h4 style="font-size:18px; color:teal;"><small>Foliage Print Shirt Dress</small></h4>
                      <button class="btn btn-sm btn-primary" type="button">$25</button>
                      <a href="../php/category.php?cat=6">
                        <button class="btn btn-sm btn-default" type="button"><i class="fas fa-heart"></i>View</button>
                      </a>
                    </div>
                    <!-- End Item 1-->
                    <!-- Start Item 2 -->
                    <div class="carousel-item" style="background:white;">
                      <a href="#"><img src="https://www.forever21.com/images/1_front_750/00263129-01.jpg"
                      style="width:50%;margin-left:15%;" class="img-responsive" alt="product 2"></a>
                      <h4 style="font-size:18px; color:teal;"><small>&nbsp; High-Rise Knee-Slit Jeans </small></h4>
                      <button class="btn btn-sm btn-primary" type="button">$29</button>
                      <a href="../php/category.php?cat=8">
                        <button class="btn btn-sm btn-default" type="button"><i class="fas fa-heart"></i>View</button>
                      </a>
                    </div>
                    <!-- End Item 2-->
                    <!-- Start Item 3 -->
                    <div class="carousel-item" style="background:white;">
                      <img src="https://assets.thebodyshop.com/medias/vanilla-chai-candle-3-640x640.jpg?context=product-images/h96/h80/13283996991518/vanilla-chai-candle_3-640x640.jpg" 
                      style="width:75%;" class="img-responsive" alt="product 3">
                      <h4 style="font-size:18px; color:teal;"><small>Chai Vanilla Candel</small></h4>
                      <button class="btn btn-sm btn-primary" type="button">$12.00</button>
                      <a href="../php/category.php?cat=20">
                        <button class="btn btn-sm btn-default" type="button"><i class="fas fa-heart"></i>View</button>
                      </a>
                    </div>
                    <!-- End Item 3 -->
                  </div>
                  <!-- End Carousel Inner -->
                </div>
                <!-- /.carousel -->
                <!-- <li><a href="<?php //echo SITE_URL;?>/php/viewAll.php">View all Collection&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-circle-right"></i></span></a></li> -->
              </ul>
            </li>
    <!---************************************************* PHP CODE - START ****************************************************-->

                  <!--we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database-->
                  <!--PHP CODE TO AUTO GENERATE THE DROPDOWN MENU-->
                  <?php
                      $sql = 'SELECT * FROM `categories` WHERE `parent` = 0';
                      //$pquery = $db -> query($sql); //parent query
                      $pquery = mysqli_query($edb, $sql); //edb is for cartbugs_shoppe database & db is for user_reg database
                  ?>
                
                  <!--PHP CODE TO call categories from db autonomously to be displayed instead of hardcoding them - START-->
                  <?php while ($pquery && $parent = mysqli_fetch_assoc($pquery)): ?>
                      <?php $parent_id = $parent['id']; //parent id 
                        $sql2 = "SELECT * FROM categories WHERE parent = '$parent_id' "; //get the inner categories for that parent
                        $cquery = $edb->query($sql2); //child query
                      ?>
                      <!--PHP CODE  - END-->

                      <li class="col-xs-2 list-inline-item align-top">
                        <ul>
                            <!--Extra menu item for php start-->
                            <li class="dropdown-header">  <?php echo $parent['category']; ?>  </li>
                            <!--while loop for autogeneration for child menu items and GIVING LINKS TO EACH MENU ITEM USING CHILD ID-->
                            <?php while($cquery && $child = mysqli_fetch_assoc($cquery)): ?>
                            <li><a href="/ASP_Project/php/category.php?cat=<?=$child['id']?>">  <?php echo $child['category']; ?>   </a></li>
                            <!--End the php while loop FOR CHILD -->
                            <?php endwhile; ?>
                          
                          <!--Extra menu item for php End-->
                        </ul>
                      </li>
                      <!--End the php while loop FOR PARENT -->
                    <?php endwhile; ?>
                    <!-- <hr style="border:none; height:1px;background-color:grey; width:74%; margin-top:-9%;
                              margin-left:25%; color:gray "> -->

    <!---************************************************* PHP CODE - END ******************************************************-->
                <li>
            </ul>
                  
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

        <!--Company Title And Logo-->
        <a class="navbar-brand" href="<?php echo SITE_URL;?>/php/homePage.php"
            style="color:Tomato;font-family:'Snowburst One',cursive; font-weight:bolder; font-size:33px; margin-right:34%;">
        <img src="<?php echo SITE_URL;?>/images/CartBugLogo.png" width="40" class="d-inline-block align-top" alt="logo" style="margin-top:-3%">
            CartBug's Shoppe
        </a>

        <!--Shopping Cart Code-->
         <a class="nav-link nav-item" href="<?php echo SITE_URL;?>/php/cart.php" style="color:tomato; font-size:25px;">
            <i class="fas fa-shopping-cart"></i> My Cart
          </a>
      
    </ul>
        <!--Search Bar on Main Nav-->
        <!-- <form class="form-inline my-2 my-lg-0" action="siteSearch.php" method="post"> 
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" value=">>">
                <i class="fas fa-search"></i> 
            </button>
        </form> -->
  </div>
</nav>
 <!--Navbar Mega Menu End-->
