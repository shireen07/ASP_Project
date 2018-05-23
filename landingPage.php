<!--Landing Page is the First page the User will view of the website. 
It will give user the option of signing up or logging in.-->


<?php 
//user-registration db file
include('registration/server.php'); 

//database connection file - initial file
//we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
require_once('core/init.php');

//Include files that have seperate elements of the page like header, navbar, main content, footer etc
//include('includes/head.php');

//populate dropdown from database table
//include('includes/navigation.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scaleable=no, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Cartbug.com Home</title>

    <link rel="stylesheet" href="css/LandingPageCSS.css">
    <?php include_once BASEURL.'includes/js_css.php'?>

<script type="text/javascript">
    var scale = 'scale(0.2)';
    document.body.style.webkitTransform =  scale;    // Chrome, Opera, Safari
    document.body.style.msTransform =   scale;       // IE 9
    document.body.style.transform = scale; //General
</script>

</head>

<body>
<?php //include_once BASEURL.'includes/js_css.php'?>

<!--Top Navigation Bar-->
<nav class="top-bar">
  <div class="container">
    <div class="row">
       <div class="col-sm-4 hidden-xs">
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
         <ul class="tools">
           <li class="dropdown">
             <a class="" href="registration/login.php"><i class="fas fa-user" aria-hidden="true"></i> My Account</a> 
           </li>
           <li class="dropdown">
             <a class="" href="registration/register.php"><i class="fas fa-user-plus" aria-hidden="true"></i> SignUp</a> 
           </li>
         </ul>
       </div>
    </div>
  </div>
</nav>  <!---Top Nav Bar End-->


<!--Navbar Mega Menu Start-->
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-bottom: 3px;">
   <a class="navbar-brand" href="landingPage.php"
      style="color:Tomato;font-family:'Snowburst One',cursive; font-weight:bolder; font-size:35px; ">
   <img src="images/CartBugLogo.png" width="50" class="d-inline-block align-top" alt="logo" style="margin-top:-3%">
    CartBug's Shoppe
   </a>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
   aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
   </button>

   <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
         <li class="nav-item" style="margin:10px;">
           <a class="nav-link" href="php/expertAdvice.php"><i class="fas fa-chess-queen"></i> Expert Advice</a>
         </li>
         <!-- <li class="nav-item" style="margin:10px;">
           <a class="nav-link" href="php/deals.php"><i class="far fa-bell"></i> Deals</a>
         </li> -->
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
                      <a href="#"><img src="https://www.forever21.com/images/1_front_750/00262549-03.jpg" 
                      style="width:50%;margin-left:10%;" class="img-responsive" alt="product 1"></a>
                      <h4 style="font-size:22px; color:teal;"><small>Forever 21 Bomber Jacket, Olive</small></h4>
                      <button class="btn btn-primary" type="button" style="margin-top:10px">$49.99</button>
                      <button href="registration/login.php" class="btn btn-default" type="button" style="margin-top:10px">
                             <i class="fas fa-heart"></i> View</button>
                    </div>
                    <!-- End Item 1-->
                    <!-- Start Item 2 -->
                    <div class="carousel-item" style="background:white;">
                      <a href="#"><img src="https://www.forever21.com/images/1_front_750/00262426-02.jpg"
                      style="width:50%;margin-left:15%;" class="img-responsive" alt="product 2"></a>
                      <h4 style="font-size:22px; color:teal;"><small>&nbsp; Chandelier Disc Earrings</small></h4>
                      <button class="btn btn-primary" type="button" style="margin-top:10px">$9.99</button>
                      <button href="registration/login.php" class="btn btn-default" type="button" style="margin-top:10px">
                             <i class="fas fa-heart"></i> View</button>
                    </div>
                    <!-- End Item 2-->
                    <!-- Start Item 3 -->
                    <div class="carousel-item" style="background:white;">
                      <a href="#"><img src="https://www.forever21.com/images/1_front_750/00261093-01.jpg" 
                      style="width:43.3%;margin-left:15%;" class="img-responsive" alt="product 3"></a>
                      <h4 style="font-size:22px; color:teal;"><small>Palladio Definer Contour & Highlight Palette</small></h4>
                      <button class="btn btn-primary" type="button" style="margin-top:10px">$49.99</button>
                      <button href="registration/login.php" class="btn btn-default" type="button"style="margin-top:10px">
                             <i class="fas fa-heart"></i> View</button>
                    </div>
                    <!-- End Item 3 -->
                  </div>
                  <!-- End Carousel Inner -->
                </div>
                <!-- /.carousel -->
                <li class="divider"></li><br>
                <li><a href="registration/login.php">View all Collection&nbsp;&nbsp;&nbsp;<i class="fas fa-arrow-circle-right"></i></span></a></li>
              </ul>
            </li>
            <li class="col-md-3 list-inline-item align-top">
              <ul>
                <li class="dropdown-header">Womens Apparels</li>
                <li><a href="php/dresses.php">Dresses</a></li>
                <li><a href="php/dresses.php">Tops</a></li>
                <li><a href="php/dresses.php">Jeans &amp; Capris</a></li>
                <li><a href="php/dresses.php">Formal Wear</a></li>
                <li><a href="php/dresses.phpp">Sweaters &amp; Jackets</a></li>
                
                <hr style="border:none; height:1px;background-color:grey; width:100%;">
                
                <li class="dropdown-header">Accessories</li>
                <li><a href="php/dresses.php">Hand Bags &amp; Backpacks</a></li>
                <li><a href="php/dresses.php">Jewelry</a></li>
                <li><a href="php/dresses.php">Sunglasses</a></li>
              </ul>
            </li>
            <li class="col-md-2 list-inline-item align-top">
              <ul>
                <li class="dropdown-header">SkinCare</li>
                <li><a href="php/dresses.php">Cleansers &amp; Toners</a></li>
                <li><a href="php/dresses.php">Lotions &amp; BodyButters</a></li>
                <li><a href="php/dresses.php">FaceMasks &amp; Oils</a></li>
                
                <hr style="border:none; height:1px;background-color:grey; width:100%;">

                <li class="dropdown-header">Fragrances</li>
                <li><a href="php/dresses.php">For Her</a></li>
                <li><a href="php/dresses.php">Body Mists</a></li>
                <li><a href="php/dresses.php">Eau de Parfum</a></li>
                <li><a href="php/dresses.php">Candles</a></li>
                <li><a href="#" class="invisible">Invisible row</a></li>
              </ul>
            </li>
            <li class="col-md-3 list-inline-item align-top">
              <ul>
                <li class="dropdown-header">Gifts</li>
                <li><a href="php/dresses.php">Body Care Giftss</a></li>
                <li><a href="php/dresses.php">Fragrance gifts</a></li>
                <li><a href="php/dresses.php">Jewelry Collections</a></li>
                <li><a href="#" class="invisible">Invisible row</a></li>
                
               <!--  <hr style="border:none; height:1px;background-color:grey; width:100%;">

               <li class="dropdown-header">Newsletter</li>
                 <form class="form" role="form">
                  <div class="form-group">
                    <label class="sr-only" for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email">
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                </form> -->
            </li>
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

<!--Shopping Cart Code-->
      <li class="nav-item">
         <a class="nav-link" href="#" style="color:tomato; font-size:25px;"><i class="fas fa-shopping-cart"></i></a>
      </li>
    </ul>
    <!-- <form class="form-inline my-2 my-lg-0"> 
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> </button>
    </form> -->
  </div>
</nav>
 <!--Navbar Mega Menu End-->


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
      <img class="d-block w-100" src="images/picBB.jpeg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="images/shoes.jpeg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="images/hippie.jpeg" alt="Third slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="images/picCC.jpeg" alt="Fourth slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
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
  <div class="item-wrapper" id="productSquare_1">
  <figure>
     <a href="#">
       <div class="image" style="background-image:url(http://hdwallpaperbackgrounds.net/wp-content/uploads/2015/09/Diamond-Jewelry-HD-Wallpapers.jpg)"></div>
       <div class="lighting"></div>
     </a>
  </figure>
    <div class="item-content" >
      <h1 id="productH1">GO BOLD..</h1>
      <p id="productPara" style="margin-top:15%;">A unique love deserves a unique ring. Express your individuality and love with our most Rings!</p>
      <div class="author" id="productPara">Kay Jewelers ~</div>
    </div>
  </div>
</article>

<!--Square 2 -->
<article>
  <div class="item-wrapper" id="productSquare_2">
    <figure>
       <a href="#">
         <div class="image" style="background-image:url(https://www.adorama.com/alc/wp-content/uploads/2014/07/shutterstock_598339082.jpg);"></div>
         <div class="lighting"></div>
       </a>
    </figure>
    <div class="item-content">
      <h1 id="productH1">NEW ARRIVALS</h1>
      <p id="productPara" style="margin-top:15%;">We got something Pretty for every occasion!!</p>
      <div class="author" id="productPara">Loft ~</div>
    </div>
  </div>
</article>

<!--Square 3 -->
<article>
  <div class="item-wrapper" id="productSquare_3">
    <figure>
       <a href="#">
         <div class="image" style="background-image:url(http://citymall.com.lb/wp-content/uploads/the-body-shop-products-citymall-lebanon-AMH-e1512134905601.jpg);"></div>
         <div class="lighting"></div>
       </a>
    </figure>
    <div class="item-content">
      <h1 id="productH1">BODY CARE</h1>
      <p id="productPara" style="margin-top:15%;">Make peace with sensitive skin! Discover our Almond Milk & Honey Collection created to give you the softest skin experience.</p>
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



<!--Promotional Video Feed Start-->
<div class="embed-responsive embed-responsive-16by9"
     style="width:55%; margin-left:25%; margin-bottom:5%; border-radius:20px;">
     <iframe src="https://www.youtube.com/embed/GGgLHIGfY9g" frameborder="0" 
      allow="autoplay; encrypted-media"></iframe>
     </div>
<!--Promotional Video Feed End-->

<!---**********************************************************************************************************************-->


<!--Footer Container Start-->
<footer class="footer">
    <div class="container-fluid" style="margin: 0px 20px 0px 10px;">
        <div class="row">
        <div class="col-xl-3 footer-one">
        <div class="foot-logo">
              <img src="images/CartBugLogo.png" style="width:30%; float:left; margin-right:3%;">
              <h4 class="title"> About us</h4>
		      </div> 
            
            <p>We are a <small style="color:yellow;">Tiny</small> Company but our work is <strong>ABSOLUTELY HUGE.<br/></strong>
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
            <h4 class="title">Quick Links</h4>
            <span class="acount-icon">          
            <a href="registration/login.php"><i class="fas fa-user-circle" aria-hidden="true"></i> Your Account</a>
            <a href="php/newsLetter.php"><i class="far fa-file-alt" aria-hidden="true"></i> Newsletter Signup</a>
            <a href="php/careers.php"><i class="fas fa-chess-knight" aria-hidden="true"></i> Careers</a>
            <a href="php/aboutUs.php"><i class="fas fa-globe" aria-hidden="true"></i> Avout Us</a>           
            </span>
        </div>
        <div class="col-xl-3">
            <h4 class="title">Collections~</h4>
            <div class="category">
                <a href="registration/login.php">Women's Apparels</a>
                <a href="registration/login.php">Skin Care</a>
                <a href="registration/login.php">Candles</a>
                <a href="registration/login.php">Fragrances</a>
                <a href="registration/login.php">Dresses</a>
                <a href="registration/login.php">Body Care Gifts</a>
                <a href="registration/login.php">Cleansers</a>
                <a href="registration/login.php">Jeans</a>           
            </div>
        </div>
        <div class="col-xl-3">
            <h4 class="title">Payment</h4>
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
                <p> <a href="registration/login.php" style="color:royalblue;">Home</a> | 
                    <a href="registration/login.php" style="color:royalblue;">Privacy</a> |
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

