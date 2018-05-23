
<!--pRODUCT pAGE..Product displayed according to category id obtained-->

<?php
//database connection file - initial file
//we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
require_once('../core/init.php');

//Include files that have seperate elements of the page like header, navbar, main content, footer etc
include('../includes/head.php');

//populate dropdown from database table
include('../includes/navigation.php');

include('../includes/headerFull.php'); //includes the img after the nav bar. we intend to change images per page

include('../includes/leftbar.php'); //includes the left side bar filters

?>

<?php
    //CODE FOR DISPLAYING CHILD CATEGORY PRODUCTS - if cat is set
    if(isset($_GET['cat'])){
        $cat_id = sanitize($_GET['cat']);
    }else{
        $cat_id = '';
    }//end ifelse - child Cat

    //SQL statemnt for auto-populating product thumbs depending on the cat_id selected
    //cat_id gets the category specific products and featured=1 will show only those products which want to be featured by the admin on the page.
    $sql = "SELECT * FROM products WHERE categories = '$cat_id' AND featured = 1";
    $product_Q = $edb -> query($sql); //method 'query' runs the $sql statement
    $category = get_category($cat_id); // assco array as we pass in the cat_id ie the child id we fire a function which gives us the parent and child name and ids using an inner join stamnt
    //var_dump($category);
?>


<!--************************************** PHP CODE - START ****************************************************************-->
    
    <!--display errors or success message-->
    <!--Main Content - START-->
    <div class="col-md-8">
      <span id="displayMessage" style="height:20px;"></span> <!--span to display message-->
      <h2 class="text-center" id="CategoryName">
          <?=$category['parent']. ' ~ ' .$category['child']; ?> Collections..
      </h2>
      <!--divide the main content into 4 subcolumns-->
      <div class="row">

      <!--IMPORTANT :: Making the code dynamic by populting the thumbs from database 'edb'-->

           <!--Display Product START-->
           <!--wE START THE LOOP HERE TO DISPLAY PRODUCT THUMBS DYNAMICALLY-->
       <!--IMPORTANT :: Making the code dynamic by populting the thumbs from database 'edb'-->
      <?php while($product_Q && $product = mysqli_fetch_assoc($product_Q)) :  ?>

           <div class="col-sm-3 text-center" id="main_content_col">
             <?php
                //we have multiple images so grab the first one
                $photos = explode(',' , $product['image']);
             ?>
             <img src="<?= $photos[0];?>" alt="<?= $product['title']; ?>" id="product_Img_Square" />

             <p id="product_title"> <?= $product['title']; ?> </p>

             <p id="price_text" class="list price text-danger">List Price: <s>$ <?= $product['list_price']; ?> </s></p>

             <p id="price_text"class="price"><strong>Our Price: $ <?= $product['price']; ?> </strong></p>

             <!--pass the prod thumbs id from the id col from products table in onclick fucnt to auto-gen 
             the data being displayed in modal-->
             <button type="button" class="btn btn-sm btn btn-info" id="product_info_btn" 
             onclick="detailsModal(<?= $product['id']; ?>)">Product Info</button> <!--deleted attr : data-toggle="modal" data-target="#details-modal" -->
          </div><!--Display Product END -->
       

       <?php endwhile; /*ending the product while loop*/ ?> 

      </div><!--end inner row for main content-->
    </div> <!--Main Content - END-->
   
<!--************************************** PHP CODE - END ****************************************************************-->


<?php

//right side bar
include('../includes/rightbar.php');

//php file that includes the pop up modal which contains product info
//include('../includes/detailsModal.php');

//php file that contains the page footer
include('../includes/footer.php'); //includes the left side bar filters

?>

<!--*********************************************************************************-->

<!--JS function to display the dynamic data into the detailsModal.php-->
<script>
   function detailsModal(id){
       //creating a onject variable with a JSON string
       var data = {"id" : id};
       //creating a AJAX Http request to call the data from the prod thumbs id and displying it dynamically in the modal
       $.ajax ({
           //baseurl is the main proj folder defined in init.php and we are concatinating the php page path to it
           url : '/ASP_Project/includes/detailsModal.php',
           type: 'POST',
           data : data, //data is given the variable data declared above
           success: function(data){
               //append all the data you get from the detailsModal page to the bottom of the body
               jQuery('body').append(data);
               jQuery('#details-modal').modal('toggle') //#details-modal is the id for the entire modal container
           },
           error : function(){
               alert("We are facing issues with retriving data. Please try again!")
           }
       });

   }//end func detailsModal

</script>
