
<?php  
//this page is being called by dresses.php //its not included. //ergo we include our edb object by including init.php file
require_once('../core/init.php');

//passing the correct info of the product selected to be displayed in the modal
$id = $_POST['id'];
$id = (int)$id; //casting the var to an integer which makes sure the id selected is validated

//setting up sql query to pass the product id
$sql = "SELECT * FROM products WHERE id = '$id' ";
//executing the query
$result = $edb -> query($sql);
$product = mysqli_fetch_assoc($result); //turns the result of the query into an associative array

//2nd edb call to get the brand name from the brand table
$brand_id = $product['brand']; //the brand in product table is an int. its the id of the brand in the brand table
$sql_2 = "SELECT brand FROM brand WHERE id = '$brand_id' "; //col and table named same
$brandQuery = $edb -> query($sql_2);
$brand_name = mysqli_fetch_assoc($brandQuery);

//making the sizes displayed in the modal to be dynamic
$size_string = $product['sizes']; //we have sizes and available qty mentioned in this col ie "size:qty "
$size_string = rtrim($size_string, ',');//when product dynamically added by admin get rid of the last comma that gets automatically added in edb
//seperate the various sizes using php func 'explode' and make a new array
$size_array = explode(',' , $size_string); //comma is the delimiter used
//var_dump($size_array);
?>

<?php ob_start(); /*obj buffer start and read all the code below and send it to ajax req to display*/?> 


<!---***************************************DETAILS MODAL START *********************************************************-->

<!--PRODUCT DETAILS FOR PRODUCT 1 -LIGHT BOX -  START -->
<!--The aria-hidden property tells screen-readers if they should ignore the element-->
<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document" id="modalBox"> <!--gives you a large dialog or a large modal-->
      <div class="modal-content" >

          <div class="modal-header">
              <h4 class="modal-title" style="color:teal;font-family:'Snowburst One',cursive; font-weight:bolder; font-size:22px;">
                  <?php echo $product['title']; ?>
              </h4>
              <button class="close" type="button" onclick="closeModal()" aria-label="Close"> <!--top of the modal X sign-->
                <span aria-hidden="true">&times;</span> <!--data-dismiss="modal"-->
              </button>
          </div>  <!--end class="modal-header"-->
          
          <span id="modal_errors" style="height:20px;"></span> <!--span to display errors while adding to cart-->

          <div class="modal-body">
            <div class="container-luid">
                <div class="row">
                    <div class="col-sm-6 fotorama"> <!--fotorama is for slide show of img-->
                        <!--Looping through if multiple images added-->
                        <?php $photos = explode(',' , $product['image']); 
                            foreach($photos as $photo):
                        ?>
                            <div class="center-block">
                                <img src="<?=$photo; ?>" alt="<?= $product['title'];?>" 
                                id="product_details_img" class="details img-responsive"/>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-sm-6">
                        <p class="text-center details" id="product_details_info">Product Information</p>
                        <!--php func nl2br is used for preserving our line breaks and make it look more asthetic-->
                        <p><strong style="font-size:18px">Details</strong><br> <?= nl2br($product['description']); ?>
                        <hr>
                        <p class="text-success" style="font-weight:bold; line-height:0.2;">Price: $<?= $product['price']; ?></p>
                        <p style="font-weight:bold">Brand: <?= $brand_name['brand']; ?></p>

                        <form action="../admin/parsers/add_cart.php" method="post" id="add_product_form" style="width:50%">
                            <!--START hidden input for product id-->
                            <input type="hidden" name="product_id" value="<?= $id;?>">
                            <!--END hidden input for product id-->

                            <!--START hidden input to call when cart btn is clicked to show item available-->
                            <input type="hidden" name="available" id="available" value="">
                            <!--END hidden input-->

                            <div class="form-group">
                                <div class="col-xs-3">
                                    <label for="quantity"> Quantity: </label>
                                    <input type="number" min="0" max="10" class="form-control" id="quantity" name="quantity" style="height:30px;"/>
                                </div>
                            </div> <!--END First - class="form-group"-->

                            <div class="form-group">
                                <label for="size">Size:</label>
                                <select name="size" id="size" class="form-control" style="height:35px;">
                                  <option value=""></option>
                                  <?php foreach($size_array as $string){
                                    //explode the $string to get individual vals and put them in a seperate array
                                    $string_array = explode(':' , $string);
                                    $size = $string_array[0];
                                    $available = $string_array[1];
                                    //if size has 0 qty then dont show size
                                    if($available > 0){
                                         echo '<option value="'.$size.'" data-available="'.$available.'"> '.$size.' (Available: '.$available.') </option>'; //parenthesis says how many available
                                      }
                                  }?>
                                </select>
                            </div> <!--END Second - class="form-group"-->
                        </form> 
                    </div>
                </div> <!--div row end-->
            </div> <!--END class="container-fluid" under modal-body-->
          </div><!--end class="modal-body"-->

          <div class="modal-footer">
              <button class="btn btn-default" onclick="closeModal()" >Close</button> <!--data-dismiss="modal"-->
              <button class="btn btn-warning" onclick="add_to_cart();return false;"> <!--custom func is in includes footer-->
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </button>
          </div><!--end class="modal-footer"-->

      </div> <!--end class="modal-content"-->
   </div> <!--end class="modal-dialog modal-lg"-->

</div><!--end modal details-1 -->
<!--PRODUCT DETAILS FOR PRODUCT 1 - END -->


<script>
    //var to listen for when size changes.So we can later calculate how many are available and make changes to the edb products table accordingly
    //add an event listener when size changes then fire off func - 
    /*every time we change the size in the dropdown, it will fire this function and grab the data-available attribute of the 
    selected item and it will plug that value right into the hidden input called available | so we will have access to the
     availabe qty value using the add_to_cart func in includes footer coz we invoke the available val there| 
     helps us make checks to see if they are taking more than available*/
    jQuery('#size').change(function(){
      //anonymous func| we create a custom attribute called data-available to get the qty
      var available = jQuery('#size option:selected').data("available");
      jQuery('#available').val(available);
    });

    //fotorama JS for initialization so we can make multiple images into a slideshow
    $(function () {
       $('.fotorama').fotorama({
           //all the attributes we want to incorporate 
           transition : "crossfade",
           height : "57%",
           arrows : "always",
           click : "true",
           swipe : "true",
           nav : "thumbs",
           maxwidth : "100%",
           loop: "true",
       });
    });

    //JQ func fires and closes the modal
    function closeModal(){
      jQuery('#details-modal').modal('hide');
    
    //clear up the html modal data displayed so that when you click on a product we display that products modal data and not needing to keep refreshing
    setTimeout(function(){
      //target code generated from AJAX call and remove it to refresh the moda;
      jQuery('#details-modal').remove();
      //target the modal backdfrop ie the dark overlay you see behind your modal and remove it to refresh
      jQuery('.modal-backdrop').remove();
    } , 500); //2 param= 1=anonym func and 2=time in ms it waits
    }//end func closeModal
</script>


<?php echo ob_get_clean(); /*clear buffer memory*/?>

<!---********************************************* DETAILS MODAL END ****************************************************-->
