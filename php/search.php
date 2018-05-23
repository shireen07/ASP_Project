
<!--Search Page-->

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
    $sql= "SELECT * FROM products";
    $cat_id = (($_POST['cat'] != '')? sanitize($_POST['cat']) : ''); //if search button is clicked in filters.php ie its not blank then set it as cat_id
    
    //1 - check for search param cart id
    if($cat_id == ''){
        //is empty then concat to our sql statement above
        $sql .= " WHERE deleted = 0 "; //because we dont wana show any deleted producst in the search
    }else{
        //cat id is not empty then concat
        $sql .= " WHERE categories = '{$cat_id}' AND deleted = 0 "; //we wana show all items in that category but not show deleted items
    }//end if 1

    //posted value from filter for price | we continue to build up our sql query depending on each search param clicked. it checks all each time
    $price_sort = (($_POST['price_sort'] != '')? sanitize($_POST['price_sort']) : '');
    $min_price = (($_POST['min_price'] != '')? sanitize($_POST['min_price']) : '');
    $max_price = (($_POST['max_price'] != '')? sanitize($_POST['max_price']) : '');

    //posted val from filter for brand
    $brand = (($_POST['brand'] != '')? sanitize($_POST['brand']) : '');

    //2 - check min price
    if($min_price != ''){
        $sql .= " AND price >= '{$min_price}' ";
    }//end if 2

    //3 - check max price
    if($max_price != '' ){
        $sql .= " AND price <= '{$max_price}' ";
    }//end if 3

    //4 - check brand
    if($brand != ''){
        $sql .= " AND brand = '{$brand}' ";
    }else{}//end if 4

    //5 - checking our price sort Low to High
    if($price_sort == 'low'){
        $sql .= " ORDER BY price";
    }//end if 5

    //6 - checking our price sort High to Low
    if($price_sort == 'high'){
        $sql .= " ORDER BY price DESC";
    }//end if 6
    
    //BY THE END OF ALL THESE CHECKS ABOVE OUR SQL HAS BEEN BUILT UP
    //NOW RUN THE SQL STATMNT THRU THE $product_Q and get the search param we are looking for

    $product_Q = $edb -> query($sql); //method 'query' runs the $sql statement
    $category = get_category($cat_id); // assco array as we pass in the cat_id ie the child id we fire a function which gives us the parent and child name and ids using an inner join stamnt
    //var_dump($category);
?> 


<!--************************************** PHP CODE - START ****************************************************************-->
    
    <!--display errors or success message-->
    <!--Main Content - START-->
    <div class="col-md-8">
      <span id="displayMessage" style="height:20px;"></span> <!--span to display message-->

      <!--If cat_id is not empty means we have a categroy adn we wana search according to it so the title will be of that cat else it will be a general search-->
      <?php if($cat_id != ''): ?>
         <h2 class="text-center" id="CategoryName">
             <?=$category['parent']. ' ~ ' .$category['child']; ?> Collections..
         </h2>
      <?php else: ?>
         <h2 class="text-center" id="CategoryName">Searched Collections..</h2>
      <?php endif; ?>

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
             <img src="<?=$photos[0];?>" alt="<?= $product['title']; ?>" id="product_Img_Square" />

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
