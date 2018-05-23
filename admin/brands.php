
<?php
    /*we are doing the brands form check first and then including the headers, navigation, registration .php files due
    to the reason that if we put this code after including files we get 'Warning: Cannot modify header information-headers already sent by'
    error messages and page does not refresh as it should. but database is updated fine*/

    //database connection file - initial file included first as we are suing edb here
    //we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
    require_once('../core/init.php');

    //get brands from edb database for displaying in table
    $sql = "SELECT * FROM brand ORDER BY brand";
    $results = $edb -> query($sql);

    //manage the add brands form
    //declare a var to collect errors in array format
    $errorsEDB = array();


    //EDIT Brand button
    //check if the $_GET for btn edit=1 is set or empty. if true then edit:id avail and can be edited
    if(isset($_GET['edit']) && !empty($_GET['edit'])){
    //grab the edit btn id for the brand name you want to edit
    $edit_id = (int)$_GET['edit']; //cast it as an int
    $edit_id = sanitize($edit_id);//use func to remove submission of garbage val
    //select query to get the brand we want to edit
    $sql_edit = "SELECT * FROM brand WHERE id = '$edit_id'";
    //pass it into the query method using edb object and set it as $edit_result
    $edit_result = $edb -> query($sql_edit);
    $edit_brand = mysqli_fetch_assoc($edit_result); //we have access to the row we want to edit
    // header('location: brands.php');//redirect to the page so that updated table is displayed
    }//end if for EDIT Button



    //Delete Brrand Button
    //check if the $_GET for btn delete=1 is set or !empty. if true then delete:id is avail and can be deleted
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
        //grab the delete btn id for the brand name you want to delete
        $delete_id = (int)$_GET['delete'];  //cast it as an int
        $delete_id = sanitize($delete_id); //use func to remove submission of garbage val
        $sql_delete = "DELETE FROM brand WHERE id = '$delete_id' ";
        $edb -> query($sql_delete);
        header('location: brands.php');//redirect to the page so that updated table is displayed
    }//end if for delete btn



    //ADD BRAND TO TABLE using FORM   //if add form is submitted then do the following
    //validate form for blank info and brand does not exit in db. if true then print error.else it submits and updates edb
    if(isset($_POST['add_submit'])){
        //create a var for input
        $brandname = sanitize($_POST['brand']); //func from helper.php to clean up garbage input
        
        //first check for blank input// works for both add and edit
        if ($_POST['brand'] == '') {
            $errorsEDB[] .= 'Entered an Empty Brand Name! Please Enter a Valid Brand name.';
        }//end if for blank check
    

    
        //check if brand exists in edb
        $sql_2 = "SELECT * FROM brand WHERE brand = '$brandname'"; //checks if input exists in edb
        //check if it already exists in edb coz if we try to edit a brand and save the same value it should not give us an error that brand exixts coz we editted the brand and saved the exact same thing
        if(isset($_GET['edit'])){
            // edit is set so override $sql_2 and run the following statement
            $sql_2 = "SELECT * FROM brand WHERE brand = '$brandname' AND id != '$edit_id' "; //this gives us an error that brand exists but else it will go ahead and save
        }//end if
        $result_2 = $edb -> query($sql_2);
        $count = mysqli_num_rows($result_2);//counts how many rows in edb was result true for. returns 1 if its in edb
        if($count > 0){
            //brand exixts so display error
            $errorsEDB[] .= $brandname.' already Exists! Please select another Brand name..'; 
        }//end if to check if iput brand name exists in edb
    


        //display errors
        if(!empty($errorsEDB)){
            //errrors are there so call the function from helpers.php
            echo display_errors($errorsEDB);
        }else{
            //errors array empty- ADD brand FORM TO DATABASE
            $sql_3 = "INSERT INTO brand (brand) VALUES ('$brandname')";
            //UPDATE database
            if(isset($_GET['edit'])){
                // edit is set so override $sql_3 and run the following statement
                $sql_3 = " UPDATE brand SET brand = '$brandname' WHERE id = '$edit_id' ";
            }//end if

            $edb -> query($sql_3);
            header('location: brands.php', true, 303); //reloading this page
        }//end ifelse for error display

    }//end main if
?>


<?php  
    //user-registration db file
    include('../registration/server.php'); 

    //Include files that have seperate elements of the page like header, navbar, main content, footer etc
    include('includes/head.php');

    //populate dropdown from database table
    include('includes/navigation.php');

    //if the user is empty they cannot access this page
    //START
    if(empty($_SESSION['username'])){
    header('location: ../registration/login.php');
    }
    //END
?>


<!--******************************************* main content START *******************************************************-->

<h2 class="brands-title">Brands</h2><hr>

<!--Brand Form to add a new brand to the edb from FE-->
<div id="addDiv">
    <!--ternary if skeleton is (()?'':'');// checks if the edit id is passed & null for false so nothing written-->
    <form action="brands.php<?=((isset($_GET['edit']))? '?edit='.$edit_id : '');?>" method="post" class="form-inline"> 

        <div class="form-group">
            
          <?php 
             //set $brand_value even if nothing else is set to remove the undefined variable error you get when input is blank
             $brand_value = '';

             if(isset($_GET['edit'])){
                 //edit is set
                 $brand_value = $edit_brand['brand'];
             }else{
                 //nested if - 
                 if(isset($_POST['brand'])){
                     //brand is set then set brand_value to the brand and sanitize the data
                     $brand_value = sanitize($_POST['brand']);
                 }//end nested if
             }//end ifelse
          ?>

            <!--ternary if to change the label to 'add a brand' or 'edit brand' depending on action performed-->
           <label id="labelfont" for="brand"><?=((isset($_GET['edit']))?'Edit' : 'Add a');?> Brand: </label>&nbsp;

            <!--when we hit edit the brand that we want to update must be populated in the input to change
                we are echoing a new var brand_value-->
            
           <input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value;?>"> 
           
           <!--if edit is set then give a link for cancel button|when you hit cancel it takes us back to add brand screen -->
           <?php if(isset($_GET['edit'])): ?>
              &nbsp;&nbsp; <a href="brands.php" class="btn btn-danger">Cancel</a>
           <?php endif; ?>

           <!--ternary if change the button label as per the action. if edit button on table is clicked
           then button changes to 'edit' else it remains 'add'-->
           &nbsp;&nbsp; 
           <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit' : 'Add');?>" class="btn btn-success">

        </div> 

    </form>
</div><hr>


<!--Brand Table-->
<table class="table table-active table-striped table-bordered table-condensed tableSize" style="width:auto;">
    <thead class="table-dark">
       <th></th><th>Brands We Host</th><th></th>
    </thead>

    <tbody>
        <!--dynamically display brands from database-->
        <?php while($brand = mysqli_fetch_assoc($results)): ?>
           <tr>
              <td>
                  <!--Edit Button will edit the brand in database-->
                 <a href="brands.php?edit=<?php echo $brand['id']; ?>" class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="left" delay="0" title="Edit Brand"><i class="fas fa-pencil-alt"></i></a>
              </td> 
              <td><?php echo $brand['brand']; ?></td>
              <td>
                  <!--Delete Button will delete the brand from edb-->
                 <a href="brands.php?delete=<?php echo $brand['id']; ?>" class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="right" delay="0" title="Delete Brand"><i class="far fa-trash-alt"></i></a>
              </td>
           </tr>
        <?php endwhile;?>
    </tbody>
</table>


<!--******************************************** footer START ************************************************************-->

<?php
    //php file that contains the page footer
    include('includes/footer.php'); //includes the left side bar filters
?>