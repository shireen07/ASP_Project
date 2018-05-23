<!--Home Page. For after the User has logged in-->


<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php';

//user-registration db file
include('../registration/server.php'); 

//if the user is empty they cannot access this page
//START
if(empty($_SESSION['username'])){
  header('location: ../registration/login.php');
}
//END

//database connection file - initial file
//we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
require_once('../core/init.php');

//Include files that have seperate elements of the page like header, navbar, main content, footer etc
//include('../includes/head.php');

//populate dropdown from database table
include('../includes/navigation.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scaleable=no, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Cartbug.com Home</title>



  <?php  include_once __DIR__.'/../includes/js_css.php'; ?>
    <link rel="stylesheet" href="<?php echo SITE_URL;?>/css/homePageCSS.css">

</head>


<body>

    <!-- HERE :> mega drop down populated through the included file at the top: ../includes/navigation.php-->

    <!--Bootstrap Carousel Code-->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
      </ol>
        <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
          <img class="d-block" src="../images/lady.jpeg" alt="First slide" width="70%" 
              style="margin-left:15%; border-radius:25px;">
          <div class="carousel-caption" id="carauselPara">
        
          <!--Welcome message on the first slide - START-->
        <!--Login welcome message. Msg pulled from server.php-->
        <div class="loginWelcome_2">
        <?php if (isset($_SESSION['success'])): ?>
              <div class="error success">
                  <h3 class="welcometext">
                      <?php 
                          echo $_SESSION['success'];
                          unset($_SESSION['success']);
                      ?>
                  </h3>
              </div>
            <?php endif ?>
        </div>
        <!--Welcome message on the first slide - END-->
          </div>
        </div>
        <div class="carousel-item">
          <img class="d-block" src="../images/hippie.jpeg" alt="Second slide" width="70%" 
              style="margin-left:15%; border-radius:25px;">
        </div>
        <div class="carousel-item">
          <img class="d-block" src="../images/sliderImage03.jpeg" alt="Third slide" width="70%" 
              style="margin-left:15%; border-radius:25px;">
        </div>
        <div class="carousel-item">
          <img class="d-block" src="../images/girls.jpeg" alt="Fourth slide" width="70%" 
              style="margin-left:15%; border-radius:25px;">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" style="margin-left:10%">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next" style="margin-right:10%">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>
    <!--Bootstrap Carousle End-->



    <!--Featured Products - SQUARES - Start-->
    <!--Product squares Row div start-->
    <div class="row" style="margin-top:3%; margin-bottom:3%;">
      <!--Square 1 -->
    <article>
      <div class="item-wrapper" id="productSquare_1" onclick="location='category.php?cat=21'">
      <figure>
        <a href="#">
          <div class="image" style="background-image:url(https://image.freepik.com/free-photo/hand-holding-a-red-gift-on-a-blue-background_23-2147591201.jpg)"></div>
          <div class="lighting"></div>
        </a>
      </figure>
        <div class="item-content" >
          <h1 id="productH1">GO BOLD..</h1>
          <p id="productPara">A unique love deserves a unique gift. Express your individuality and love with our most customeized gifts!</p>
          <div class="author" id="productPara">Catbugs ~</div>
        </div>
      </div>
    </article>

    <!--Square 2 -->
    <article>
      <div class="item-wrapper" id="productSquare_2" onclick="location='/ASP_Project/php/viewAll.php'">
        <figure>
          <a href="#">
            <div class="image" style="background-image:url(https://www.adorama.com/alc/wp-content/uploads/2014/07/shutterstock_598339082.jpg);"></div>
            <div class="lighting"></div>
          </a>
        </figure>
        <div class="item-content">
          <h1 id="productH1">View All Items</h1>
          <p id="productPara">We got something Pretty for every occasion!!</p>
          <div class="author" id="productPara">CartBugs ~</div>
        </div>
      </div>
    </article>

    <!--Square 3 -->
    <article>
      <div class="item-wrapper" id="productSquare_3" onclick="location='category.php?cat=14'">
        <figure>
          <a href="#">
            <div class="image" style="background-image:url(http://asia.be.com/wp-content/uploads/sites/2/2017/11/23099232_328538750948483_5047259701549465600_n.jpg);"></div>
            <div class="lighting"></div>
          </a>
        </figure>
        <div class="item-content">
          <h1 id="productH1">BODY CARE</h1>
          <p id="productPara">Make peace with sensitive skin! Discover our Almond Milk & Honey Collection created to give you the softest skin experience.</p>
          <div class="author" id="productPara">The Body Shop ~</div>
        </div>
      </div>
    </article>
    </div> <!-- product square Row div ends-->

    <!--JS for product squares-->
    <script>
        var articles = $('article > .item-wrapper'),
        lightingRgb = '255,255,255';

    articles.mousemove(function(e) {
      var current = $(this),
          x = current.width() - e.offsetX * 2,
          y = current.height() - e.offsetY * 2,
          rx = -x / 30,
          ry = y / 24,
          deg = Math.atan2(y, x) * (180 / Math.PI) + 45;
      current.css({"transform":"scale(1.05) rotateY("+rx+"deg) rotateX("+ry+"deg)"});
      $('figure > .lighting',this).css('background','linear-gradient('+deg+'deg, rgba('+lightingRgb+',0.32) 0%, rgba('+lightingRgb+',0) 100%)');
    });

    articles.on({
      'mouseenter':function() {
        var current = $(this);
        current.addClass('enter ease').removeClass("leave");
        setTimeout(function(){
          current.removeClass('ease');
        }, 280);
      },
      'mouseleave':function() {
        var current = $(this);
        current.css({"transform":"rotate(0)"});
        current.removeClass('enter').addClass("leave");
        $('figure > .lighting',this).removeAttr('style');
      }}
    );
    </script>
    <!--Featured Products - SQUARES - End-->


     <!--******************  BOOTSTRAP PRODUCT SLIDERS ****************************-->
     <?php
        $sliderQ = $edb->query("SELECT `id`, `title`,`image` FROM `products` 
                                        WHERE categories IN ('6','8','21','15','14','22','19','7') 
                                        ORDER BY price  LIMIT 6 ");
        $sliderQ2 = $edb->query("SELECT `id`, `title`,`image` FROM `products` 
                                         WHERE categories IN ('6','8','21','15','14','22','19','7') 
                                         GROUP BY brand LIMIT 6 ");
     ?>
     <br><br><br>
     <h3 class="CategoryName"><center>Some of Our Popular Products</center></h3><br>
     <div class="container">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <!--Slider 1-->
                <div class="carousel-item active">
                    <div class="row">
                        <?php while($sliderResult1 = mysqli_fetch_assoc($sliderQ)):
                               $photos = explode(',' , $sliderResult1['image']);
                               $id1 = $sliderResult1['id'];
                        ?>
                          <div class="col-sm-2">
                              <img class="d-block w-100" src="<?= $photos[0];?>" alt="<?=$sliderResult1['title'];?>" 
                                  style="height:150px" onclick="sliderClick()">
                          </div>
                        <?php endwhile;?>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <?php while($sliderResult2 = mysqli_fetch_assoc($sliderQ2)):
                              $photos2 = explode(',' , $sliderResult2['image']);
                              $id2 = $sliderResult2['id'];
                        ?>
                          <div class="col-sm-2">
                              <img class="d-block w-100" src="<?= $photos2[0];?>" alt="<?=$sliderResult2['title'];?>" 
                                   style="height:150px" onclick="sliderClick()">
                          </div>
                        <?php endwhile;?>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
     </div>
     <br><br><br><br><br>

    <!---**********************************************************************************************************************-->


    <!--Footer Container Start-->
    <footer class="footer">
        <div class="container-fluid" style="margin: 0px 10px 0px 10px;">
            <div class="row">
            <div class="col-xl-3 footer-one">
            <div class="foot-logo">
                  <img src="../images/CartBugLogo.png" style=" width:30%; float:left; margin-right:3%;">
                  <h4 class="title" style="font-size:22px;"> About us</h4>
              </div> 
                
                <p>We are a <small style="color:yellow; font-size:15px;">Tiny</small> Company but our work is <strong>ABSOLUTELY HUGE.<br/></strong>
                We partner with Brands to deliver World-class digital Shopping experience</p>
                <ul class="social-icon">
                <a href="https://www.facebook.com/" class="social"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
                <a href="https://twitter.com/" class="social"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                <a href="https://www.instagram.com/" class="social"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                <a href="https://www.youtube.com/" class="social"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                <a href="https://www.google.com/" class="social"><i class="fab fa-google" aria-hidden="true"></i></a>
                <a href="https://dribbble.com/" class="social"><i class="fab fa-dribbble" aria-hidden="true"></i></a>
                </ul>
            </div>
            <div class="col-xl-3">
                <h4 class="title" style="font-size:22px;">Quick Links</h4>
                <span class="acount-icon">          
                <a href="homePage.php"><i class="fas fa-user-circle" aria-hidden="true"></i> Your Account</a>
                <a href="<?php echo SITE_URL;?>/php/expertAdvice.php"><i class="far fa-file-alt" aria-hidden="true"></i> Newsletter Signup</a>
                <a href="#"><i class="fas fa-chess-knight" aria-hidden="true"></i> Careers</a>
                <a href="#"><i class="fas fa-globe" aria-hidden="true"></i> Avout Us</a>           
                </span>
            </div>
            <div class="col-xl-3">
                <h4 class="title" style="font-size:22px;">Collections~</h4>
                <div class="category" style="font-size:15px;">
                    <a href="<?php echo SITE_URL;?>/php/category.php?cat=6">Women's Apparels</a>
                    <a href="<?php echo SITE_URL;?>/php/category.php?cat=14">Skin Care</a>
                    <a href="<?php echo SITE_URL;?>/php/category.php?cat=18">Fragrances</a>
                    <a href="<?php echo SITE_URL;?>/php/category.php?cat=9">Formal Wear</a>
                    <a href="<?php echo SITE_URL;?>/php/category.php?cat=20">Candles</a>
                    <a href="<?php echo SITE_URL;?>/php/category.php?cat=8">Jeans</a>
                    <a href="<?php echo SITE_URL;?>/php/category.php?cat=21">Gifts</a>           
                </div>
            </div>
            <div class="col-xl-3">
                <h4 class="title" style="font-size:22px;">Payment</h4>
                <p>Build loyalty and benefits from years of innovation.<br> We accept the following payment modes</p>
                <ul class="payment">
                    <li><a href="https://portal.discover.com/customersvcs/universalLogin/ac_main"><i class="fab fa-cc-discover" aria-hidden="true"></i></a></li>
                    <li><a href="https://www.paypal.com/signin?country.x=US&locale.x=en_US"><i class="fab fa-paypal" aria-hidden="true"></i></a></li>            
                    <li><a href="https://usa.visa.com/"><i class="fab fa-cc-visa" aria-hidden="true"></i></a></li>
                    <li><a href="https://pay.amazon.com/us"><i class="fab fa-amazon-pay" aria-hidden="true"></i></a></li>
                </ul>
                </div>
            </div>
            <hr style="border:none; height:1px;background-color:white; width:100%;">
            <div class="footer-bottom">
            <div class="container">
              <div class="row">
                <div class="col-sm-6 ">
                  <div class="copyright-text">
                    <p>CopyRight © 2018 Digital All Rights Reserved</p>
                  </div>
                </div> <!-- End Col -->
                <div class="col-sm-6">
                    <div class="copyright-text pull-right">
                    <p> <a href="homePage.php" style="color:royalblue;">Home</a> | 
                        <a href="#" style="color:royalblue;">Privacy</a> |
                        <a href="#" style="color:royalblue;">Terms & Conditions</a> | 
                        <a href="#" style="color:royalblue;">Refund Policy</a> </p>
                  </div>					
                              
                </div> <!-- End Col -->
              </div>
            </div>
        </div>
    </div>	
    </footer>
    <!--Footer Container End-->
    <!---**********************************************************************************************************************-->

</body>
</html>

<!--Slider on click fnction-->
<script>
  function sliderClick(){
    location.href = '/ASP_Project/php/viewAll.php';
  }//end func
</script>