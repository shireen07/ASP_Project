<?php  
    //user-registration db file
    include('../registration/server.php'); 

    //Include files that have seperate elements of the page like header, navbar, main content, footer etc
    include('includes/head.php');

    //if the user is empty they cannot access this page
    //START
    if(empty($_SESSION['username'])){
    header('location: ../registration/login.php');
    }
    //END
?>

<?php
    //database connection file - initial file
    //we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
    require_once('../core/init.php');


    //check for delete button of product page: THE PRODUCT IS DELETED FROM FE BUT IT STILL REMAINS IN THE EDB SO WE CAN USE IT FOR REPORTS ETC.
    //THE PRODUCT IS ARCHIVED. make the delete col in edb products table 1 to remove prod from FE but still keep it in the BEnd
    if(isset($_GET['delete'])){
        $id = sanitize($_GET['delete']);
        //we make delete=1 to remove prod from products table and featured=0 so that the prod is removed freom the user FE as well
        $edb -> query("UPDATE products SET `deleted` = 1, `featured` = 0 WHERE `id` = '$id' ");
        header('location: products.php');
    }//end if - delete button


    $edbPath = ''; //var for image path 

    //ADD New Product Button OR Edit Product form (when we hit edit button we get the same add-form but with the edit data populated in it)
    if(isset($_GET['add']) || isset($_GET['edit'])){
        //add btn clicked if we do not add the nav page it does not get included because a few mandatory includes are in else clause
        require('includes/navigation.php'); 

        //grab Brands from brand table to display in the Add-Form below
        $brand_query = $edb-> query("SELECT * FROM brand ORDER BY brand ");

        //grab parent from category table and display in Add-Form below
        $parent_query = $edb -> query("SELECT * FROM categories WHERE parent = 0 ORDER BY category ");

        //add-form title is set first because we want to auto populate it if edit product is clicked and title is left blank.
        //create a check on all the variables used in add form. we use the same variables in edit form so we check when the avar is used.. to add or to edit
        //if var is set to post and is not blank then sanitize it and 
        $title = ((isset($_POST['title']) && $_POST['title'] != '')? sanitize($_POST['title']) : ''); 
        $brand = ((isset($_POST['brand']) && !empty($_POST['brand']) )? sanitize($_POST['brand']) :'');
        $parent = ((isset($_POST['parent']) && !empty($_POST['parent']) )? sanitize($_POST['parent']) :'');
        $category = ((isset($_POST['child']) && !empty($_POST['child']) )? sanitize($_POST['child']) : ''); //we know he child now so we need to know what cat the parent is from so we can display it in the below code
        $price = ((isset($_POST['price']) && $_POST['price'] != '')? sanitize($_POST['price']) : '');
        $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')? sanitize($_POST['list_price']) : '');
        $description = ((isset($_POST['description']) && $_POST['description'] != '')? sanitize($_POST['description']) : '');
        $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')? sanitize($_POST['sizes']) : '');
        $sizes = rtrim($sizes, ',');//get rid of the extra comma
        $saved_image = '';

        //check if edit button is clicked and set
        if(isset($_GET['edit'])){
            $edit_id = (int)$_GET['edit']; //we need this to change our form action in add form. we use the same form to edit products as well.takes value from the edit icon clicked and assign it as edit id so we only edit that particular product thats clicekd
            $product_results = $edb -> query("SELECT * FROM products WHERE id = '$edit_id' "); //query to auto populate the form when a edit product is clicked
            $product = mysqli_fetch_assoc($product_results);
            
            //check for image delete button in edit product
            if(isset($_GET['delete_image'])){
                $imgi = (int)$_GET['imgi'] - 1; //when multiple imgs and we want to del a specific one
                $images = explode(',' , $product['image']); //gives us the images array
                //delete image in edit product clicked and we get its edit id from the click as well
                $image_url = $_SERVER['DOCUMENT_ROOT'].$images[$imgi];
                unset($images[$imgi]); //remove the img from the arrays before updating the record
                @unlink($image_url); //unset() did not work for us
                //turn the array into a string befor updating into edb
                $imageString = implode(',' , $images);
                
                
                //update edb after unset the image | change the array to string and now update the string into edb
                $edb -> query("UPDATE products SET `image` = '{$imageString}' WHERE `id` = '$edit_id' ");
                echo '<script>window.location.href = "products.php?edit=" + <?php $edit_id;?> ; </script>'; //redirect to edit page
            
                // Reset images array after remove datad from it 
                //we use this array below so if we dont reset the string the image is deleted from dir and sql but shows on FE and gives offset errors
                $product['image'] = $imageString;
               

            }//end if - delete image btn

            $category = ((isset($_POST['child']) && $_POST['child'] != '')? sanitize($_POST['child']) : $product['categories']);//for child and parent category get parent product
            $title = ((isset($_POST['title']) && $_POST['title'] != '')? sanitize($_POST['title']) : $product['title']);//set title to auto display
            $brand = ((isset($_POST['brand']) && $_POST['brand'] != '')? sanitize($_POST['brand']) : $product['brand']);
            //we have child cat declared above which we can use to echo the parent cat
            $parentQ = $edb -> query ("SELECT * FROM categories WHERE id = '$category' ");
            $parentResult = mysqli_fetch_assoc($parentQ);
            $parent = ((isset($_POST['parent']) && $_POST['parent'] != '')? sanitize($_POST['parent']) : $parentResult['parent']);
            $price = ((isset($_POST['price']) && $_POST['price'] != '')? sanitize($_POST['price']) : $product['price']);
            $list_price = ((isset($_POST['list_price']))? sanitize($_POST['list_price']) : $product['list_price']);
            $description = ((isset($_POST['description']))? sanitize($_POST['description']) : $product['description']);
            $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')? sanitize($_POST['sizes']) : $product['sizes']);
            $sizes = rtrim($sizes, ',');//get rid of the extra comma
            $saved_image = (($product['image'] != '')? $product['image'] : "");
            $edbPath = $saved_image;

            //if sizes are not empty 
            if(!empty($sizes)){
                //build the sizes array that can be inputed intp the edb product table
                $sizeString = sanitize($sizes);
                $sizeString = rtrim($sizeString, ','); //get rid of the comma at the end of the array
                $sizesArray = explode(',' , $sizeString);

                $sArray = array(); //used for size in the foreach
                $qArray = array(); //used for qty in foreach
                $tArray = array(); //used for threshold in foreach
                //make the form sticky
                foreach ($sizesArray as $ss) {
                    //we have access to each element. make new array and explode the array. we explode the array twice as we have an array that has multiple sizes and qtys seperated by ':'.
                    $s = explode(':', $ss); //explode the sizestring and seperate using ':'
                    $sArray[] = $s[0]; //use these arrays in the modal loop for size and qty and threshold
                    $qArray[] = $s[1];
                    $tArray[] = $s[2]; 
                }//end foreach

            }else{
                   $sizesArray = array();//empty array if post is not set
                 }//end nested ifelse for sizes

        }//end  if for edit icon isset


        //make the add-form sticky. so that if there are validation errors we dont want admin to re-enter data. it should be retained
        //if sizes are posted
        if($_POST){ 
            //empty array for storing errors
            $errorsEDB = array();

             //-------------form validation for POST--START-------------------------//
            //make sure the required firelds are filled in before form submitted
            $required = array('title', 'brand','price','parent', 'child', 'sizes');
            $allowed = array('png', 'jpg', 'gif', 'jpeg');//allowed image types
            $tmpLoc = array();
            $uploadPath = array(); //save multiple images 

            //validation
            foreach ($required as $field ) {
                if($_POST[$field] == ''){
                    $errorsEDB[] = 'Please fill all the fields with an <b>Asterisk (*)</b>';
                    break; //we get a undefined child error because the ajax function has not fired yet. so we use break 
                }//end if to check for $field
            }//end foreach - validation that fields are filled


         //Code to Upload multiple Images:::::
            $photoCount = count($_FILES['photo']['name']); //count how many images are being uploaded and their names
            //validation for image files upload
            if($photoCount > 0){
                    // var_dump($_FILES); Example:= array(1) { ["photo"]=> array(5) { ["name"]=> string(7) "09A.jpg" ["type"]=> string(10) "image/jpeg" ["tmp_name"]=> string(24) "C:\xampp\tmp\php36D6.tmp" ["error"]=> int(0) ["size"]=> int(115201) } } 
                //We need to loop through all the files and get all the below vars for each so use a loop
                for($i=0; $i< $photoCount; $i++){
                   $name = $_FILES['photo']['name'][$i]; //grabs the photo name and which elemnt number in array it is
                   $nameArray = explode('.' , $name); //name array
                   $fileName = $nameArray[0];
                   $fileExt = $nameArray[1];
                   $mime = explode('/' , $_FILES['photo']['type'][$i]); //type array for the current photo in the loop
                   $mimeType = $mime[0];
                   $mimeExt = $mime[1];
                   $tmpLoc[] = $_FILES['photo']['tmp_name'][$i]; //tmpLoc array declared above
                   $fileSize = $_FILES['photo']['size'][$i]; //size array
                   $uploadName = md5(microtime().$i). '.' .$fileExt;//give the image a name | wwhen we upload multiple images essentially the microtime for all the images is the same so we were getting 4 same images on uploading 4 different images. so we concatinated $i to the microtime to change the name and so it will display all 4 diff images when uplaoded
                   $uploadPath[] = BASEURL.'images/products/'. $uploadName; //created an upload location path
                   if($i != 0){
                       //to get a edpPath with multiple image locs in a string seperated by comma
                       //when it loops through the array on first img ie index 0 it will skip the comma but later after every img it will add a comma
                       $edbPath .= ',';
                   }//end if nested
                   $edbPath .= '/ASP_Project/images/products/'. $uploadName; //we dont want the BASEURL inputed into the edb.

                    //check for mime type to be image
                    if($mimeType != 'image'){
                        $errorsEDB[] = 'The File MUST be an image!';
                    }//end if- mimeType

                    //check if image types are from the allowed list
                    //we check for the needle (ie $fileExt) in the haystack (ie $allowed)
                    if(!in_array($fileExt, $allowed)){
                        //file type is other than the specified options then display error
                        $errorsEDB[] = 'File uploaded must be of extension .png, .jpg, .jpeg, or .gif';
                    }//end if - check img type

                    //check image size for 15MB to Bytes
                    if($fileSize > 15000000){
                        //file size greater than 15MB
                        $errorsEDB[] = 'The File size must be under 15MB!';
                    }//end if - img size check 

                    //check if fileExt matches the mimeExt
                    if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')){
                        $errorsEDB[] = 'The File extension DOES NOT match the File!';
                    }//end if - check fileExt matches mimeExt
                    
                }//end nested forLoop
            }//end if -file upload validation check

            
            if(!empty($errorsEDB)){
                //display errors using helpers.php func
                echo display_errors($errorsEDB);
            }else{
                //errors array empty so update edb table //func used for uploading the array of img files to edb
                if($photoCount > 0){
                    for($i=0; $i < $photoCount; $i++){
                        //upload multiple images as a string to the $edb products 
                        move_uploaded_file($tmpLoc[$i] , $uploadPath[$i]); //prebuilt php func
                    }//end for to get multiple images string
                }//end if - move upload func
                
                //AND Now upload the rest of the inputs into edb table
                $insert_sql = "INSERT INTO products (`title`, `price`, `list_price`, `brand`, `categories`, `sizes`, `image`, `description`) 
                                      VALUES ('$title', '$price', '$list_price', '$brand', '$category', '$sizes', '$edbPath', '$description')";
                //CHANGE THE SQL STATMENT IF PRODUCT EDITTED SO THE INSERT QUERY BECOMES UPDATE QUERY.
                if(isset($_GET['edit'])){
                    $insert_sql = "UPDATE products SET `title` = '$title', `price` = '$price', `list_price` = '$list_price', `description` = '$description',
                                                       `brand` = '$brand', `categories` = '$category', `sizes` = '$sizes', `image` = '$edbPath'
                                                        WHERE `id` = '$edit_id' ";
                }//end if - edit product sql statmnt                
                $edb -> query($insert_sql);//execute query
                echo '<script>window.location.href = "products.php";</script>'; //header('location: /ASP_Project/admin/products.php');//if query executed the redirect page to the same loc
                
            }//end ifelse - $errorsEDB is not empty
            //-------------form validation for POST--END-------------------------//
            
        }//end if - size posted
?>
                       <!--*********** ADD NEW PRODUCT FORM PAGE START ************-->

        <!--Display Add-Form: for when Add button is clicked or Edit form when Edit icon is clicked-->
        <!--we use the same form for add and edit so add=id or edit=id is selected depending on the button clicked-->
        <h2 class="brands-title"><?=((isset($_GET['edit']))? 'Edit a Product..': 'Add a New Product..');?></h2><hr>
        <form action="products.php?<?=((isset($_GET['edit']))? 'edit='.$edit_id : 'add=1');?>" 
              method="post" enctype="multipart/form-data"> <!--enctype used to upload files-->
           <div class="row" style="margin:0px 10px 10px 10px;">
                <!--div for title input-->
                <div class="form-group col-md-3">
                    <label id="labelfont" for="title">Title* :</label>
                    <input type="text" class="form-control" name="title" id="title"
                            value="<?=$title;?>"> <!--ternary if created at the top of the page-->
                </div>
                
                <!--div for brand input--> <!--name of an element is used in $_POST assoc array & we use id because we declare a for-->
                <div class="form-group col-md-3">
                    <label id="labelfont" for="brand">Brand* :</label>
                    <select class="form-control" name="brand" id="brand">
                        <!--if POST is set and POST_brand equal to blank then echo 'selected' else nothing-->
                        <option value="" <?=(($brand == '')? ' selected':'') ;?> ></option>

                        <?php while($b = mysqli_fetch_assoc($brand_query)): ?>
                            <!--if POST is set and POST_brand equal to the brand id then echo 'selected' else nothing-->
                            <option value="<?=$b['id'];?>" <?=(($brand == $b['id'])?' selected' : ''); ?> > 
                                <?=$b['brand'];?> 
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!--div for Parent Category input-->
                <div class="form-group col-md-3">
                    <label id="labelfont" for="parent">Parent Category* :</label>
                    <select class="form-control" name="parent" id="parent">
                        <option value="" <?=(($parent == '')? ' selected':'');?> ></option>
                         
                         <!--for each one of the items in $parent_query array we are going to loop through and display it in options-->
                        <?php while($p = mysqli_fetch_assoc($parent_query)): ?>
                            <option value="<?= $p['id'];?>"<?=(($parent == $p['id'])?' selected' : ''); ?>> 
                                <?= $p['category'];?> 
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!--div for Child Category input-->
                <div class="form-group col-md-3">
                    <label id="labelfont" for="child">Child Category* :</label>
                    <select class="form-control" name="child" id="child">
                        <!--child categories are pulled up from child_categories.php and the JS in admin/inclues/footer.php -->
                    </select>
                </div>

                <!--div for Price input-->
                <div class="form-group col-md-3">
                    <label id="labelfont" for="price">Price* :</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?= $price; ?>">
                </div>

                <!--div for List Price input-->
                <div class="form-group col-md-3">
                    <label id="labelfont" for="list_price">List Price :</label>
                    <input type="text" class="form-control" id="list_price" name="list_price" value="<?= $list_price; ?>">
                </div>

                <!--Button that pops up a modal to input sizes, qty, description-->
                <div class="form-group col-md-3">
                   <label id="labelfont" class="invisible">Sizes &amp; Quantity Input</label> <br>
                   <button class="btn btn-info form-control" onclick="jQuery('#sizesModal').modal('toggle'); return false;">
                       <b>Sizes &amp; Quantity Input</b>
                   </button>
                </div>

                <!--div for a read ONLY preview of the size and Qty data we enter into the modal-->
                <div class="form-group col-md-3">
                    <label id="labelfont" for="sizes">Sizes &amp; Qty Preview:</label>
                    <!--readonly attribute is used in this input so admin cannot edit the preview. he needs to access the modal and make changes for them to reflect in the preview-->
                    <input type="text" class="form-control" id="sizes" name="sizes" value="<?= $sizes;?>" readonly >
                </div>

                <!--Image Upload-->
                <div class="form-group col-md-6">
                    <!--if edit product clicked then just display the image of that product else give the file input type to choose a new image-->
                    <?php if(@$saved_image != ''): ?>
                        <?php 
                            $imgi = 1;/*img incrementor*/ 
                            $images = explode(',' , @$saved_image);
                          
                        ?>
                        <?php foreach(@$images as $image): /*loop thru individual img to show all so we can delete each individually*/?>
                            <div class="saved-image float-left">
                                <img src="<?=$image; ?>"/> &nbsp;&nbsp;
                                <a href="products.php?delete_image=1&edit=<?=$edit_id;?>&imgi=<?=$imgi;?>" 
                                class="btn btn-outline-danger"><b>Delete Image</b></a>
                            </div>
                        <?php $imgi++; endforeach; ?> <!--'cause we need to increment imgi every time before next img delete can be created-->
                    <?php else: ?>
                        <label id="labelfont" for="photo">Upload Product Image(s) :</label>
                        <input type="file" name="photo[]" id="photo" class="form-control" multiple/> <!--attrbute 'multiple' lets us add multiple images at the same time-->
                    <?php endif; ?>
                </div>

                <!--blank div for asthetics-->
                <div class="form-group col-md-6"></div>

                <!--Text box for description of the Product-->
                <div class="form-group col-md-6">
                    <label id="labelfont" for="description">Product Description :</label>
                    <textarea class="form-control" name="description" id="description" rows="6"><?= $description; ?></textarea>
                </div>

                 <!--blank divs for asthetics-->
                 <br><div class="form-group col-md-5"></div>
                 <div class="form-group col-md-4"></div>

                <!--add product button-->
                <div class="form-group col-md-2" style="margin:30px 0 30px 0">
                    <input type="submit" class="btn btn-success form-control" style="font-weight:bolder; font-size:18px;"
                           value="<?=((isset($_GET['edit']))? 'Save Editted product' : 'Add product'); ?>">
                </div>
                <!--Cancel and go back to products page button-->
                <div class="form-group col-md-2" style="margin:30px 0 30px 0">
                    <a href="products.php" class="btn btn-danger form-control" style="font-weight:bolder; font-size:18px;">Cancel</a>
                </div>

           </div><!--end div for row-->
        </form>

        
        <!-- Modal to input Size and Qty of the product : START -->
        <div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sizesModalLabel">Size &amp; Quantity of Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!--fill the modal with form inputs-->
                <?php for($i=1; $i <= 6; $i++): ?>
                        <div class="row container-fluid">
                        <!--div for size-->
                        <div class="form-group col-md-3">
                            <label id="labelfont" for="size<?=$i;?>">Size: </label>
                            <input type="text" class="form-control" name="size<?=$i;?>" id="size<?=$i;?>" 
                                   value="<?=((!empty($sArray[$i-1]))? $sArray[$i-1] : ''); ?>"> <!--$i starts with a 0 index so we do -1. we started out loop with i=1 so we do a -1 here to balance it out -->
                        </div>

                        <!--div for Qty-->
                        <div class="form-group col-md-3">
                            <label id="labelfont" for="qty<?=$i;?>">Quantity: </label>
                            <input type="number" class="form-control" name="qty<?=$i;?>" id="qty<?=$i;?>" min="0" max="15" 
                                   value="<?=((!empty($qArray[$i-1]))? $qArray[$i-1] : ''); ?>">
                        </div>

                        <!--div for Theshold - Low inventory Calc-->
                        <div class="form-group col-md-3">
                            <label id="labelfont" for="threshold<?=$i;?>">Threshold: </label>
                            <input type="number" class="form-control" name="threshold<?=$i;?>" id="threshold<?=$i;?>" min="0" max="9" 
                                   value="<?=((!empty($tArray[$i-1]))? $tArray[$i-1] : ''); ?>">
                        </div>
                    </div><!--end modal div Row-->
                <?php endfor; ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <!--function called from admin/includes/footer.php-->
                <button type="button" class="btn btn-success" onclick="updateSizes(); jQuery('#sizesModal').modal('toggle'); return false;">Save changes</button>
            </div>
            </div>
        </div>
        </div>
        <!-- Modal to input Size and Qty of the product : END -->

                          <!--*********** ADD NEW PRODUCT FORM PAGE END ************-->

<?php        
    }else{ //closed at the very end just above footer file
        //we do all the below code like display table. edit and delete product etc 

        //popluate the table with product details. loop through p_results in tbody.
        $sql = "SELECT * FROM products WHERE deleted = 0";
        $p_results = $edb -> query($sql);

        //toggle the product to be featured or not on the website.
        if(isset($_GET['featured'])){
            //button pressed so get id and
            $id = (int)$_GET['id'];
            $featured = (int)$_GET['featured'];
            $featured_sql = "UPDATE products SET featured = '$featured' WHERE id = '$id' ";
            $edb -> query($featured_sql);
            header('location: products.php');
        }//end if - featured toggle
 ?>


        <?php
            //populate dropdown from database table
            include('includes/navigation.php');  
        ?>


<!--******************************************** products table on products page - ADMIN ******************************-->

        <h2 class="brands-title">Products</h2><hr>


        <!--Add a new product Button-->
        <center><a href="products.php?add=1" id="add_product_btn" class="btn btn-success"><b>Add New Product</b></a></center> <hr>


        <!--Products Table-->
        <table class="table table-bordered table-condensed table-striped table-active" style="width:auto; margin:0 auto; margin-bottom:30px;">
            <thead class="table-dark">
                <th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th>
            </thead>

            <tbody>
                <?php while($product = mysqli_fetch_assoc($p_results)): 
                    //get the category name from category table and use it to display product category in FE table
                    $child_id = $product['categories'];
                    $cat_sql = "SELECT * FROM categories WHERE id = '$child_id' ";
                    $result = $edb -> query($cat_sql);
                    $child = mysqli_fetch_assoc($result);
                    $parent_id = $child['parent'];
                    $p_sql = "SELECT * FROM categories WHERE id = '$parent_id' ";
                    $p_result = $edb -> query($p_sql);
                    $parent = mysqli_fetch_assoc($p_result);
                    $category = $parent['category'].' ~ '.$child['category']; //
                ?>
                    <tr>
                        <td>
                            <a href="products.php?edit=<?=$product['id']; ?>" class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="right" delay="0" title="Edit Product"><i class="fas fa-pencil-alt"></i></a>
                            &nbsp;&nbsp;
                            <a href="products.php?delete=<?=$product['id']; ?>" class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="right" delay="0" title="Archive Product" ><i class="far fa-trash-alt"></i></a>
                        </td>
                        <td><?= $product['title']; ?></td>
                        <td><?= money($product['price']); /*money func created in helpers file*/?></td>
                        <td><?=$category; ?></td>
                        <td>
                            <!--ternary if so that we should see plus sign if featured=1 and mius if featured=0.
                            we are trying to create a toggle. And we are also passing the id| <i class="fas fa-minus"></i> & just change minus to plus for plus sign-->
                            <a href="products.php?featured=<?=(($product['featured'] == 0)? '1' : '0');?>&id=<?=$product['id'];?>" 
                                class="btn btn-xs btn-light"><i class="fas fa-<?=(($product['featured'] == 1)?'minus':'plus');?>"></i>
                            </a>&nbsp;
                            <?=(($product['featured'] == 1)?'Featured product' : '');?>
                        </td>
                        <td>0</td>
                    </tr>         
                <?php endwhile; ?>
            </tbody>
        </table>

<!--************************************* Footer Start **********************************************************-->


<?php
    }//end ifelse - ADD buttton

    //php file that contains the page footer
    include('includes/footer.php'); //includes the left side bar filters
?>


<script>
    //code for auto population of child category when edit button is clicked of a product
    //we write the code here becausew e want it to run only on this file and not all files
    jQuery('document').ready(function(){
        //anonymous func to call a custom func from the admin/includes/footer
        //the php var will populate to the func and pass the it in the func
        get_child_options('<?= $category;?>');
    });
</script>