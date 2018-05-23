
<?php
    /*we use ob_start()to start the session because we were getting 'Cannot Modify Header Information' warning 
    when we tried adding a new category. the issue was the new category was added in the FE table as well as BckEnd table
    but it was also displaying a error because headers were being printed first before the session was being set*/ 
     ob_start();

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


<!--We include the files above and then did the php code because we want to display our errros in teh form col-md-5 area.
in brands page we included the files after the php code because we wanted to display the errors at the very top of the screen,
even before the navbar-->


<?php
    //access to the init.php file
    //require_once $_SERVER['DOCUMENT_ROOT'] . '/ASP_Project/core/init.php'; 
    require_once('../core/init.php');

   //retrive all categories and their parents to display dynamically in the FORM below
   $sql = "SELECT * FROM categories WHERE parent = 0";
   $result = $edb -> query($sql);

   //declare a var to store errors in an array
   $errorsEDB = array();

   //var
   $category = '';
   $post_parent = '';


   //EDIT BUTTON - FRONT END TABLE as well as update the item from BACKEND table
   if(isset($_GET['edit']) && !empty($_GET['edit'])){
       //edit btn set and not empty so edit category
       $edit_id = (int)$_GET['edit'];
       $edit_id = sanitize($edit_id); //var is cast and validated as a clean value
       $edit_sql = "SELECT * FROM categories WHERE id = '$edit_id' ";
       $edit_result = $edb -> query($edit_sql);
       $edit_category = mysqli_fetch_assoc($edit_result); //access to assoc array of category with the id of the categry chicked by user
   }//end if edit btn



   //DELETE BUTTON - FRONT END TABLE as well as delete the item from BACKEND table
   if(isset($_GET['delete']) && !empty($_GET['delete'])){
       //checks the get array to see if the delete was clicked and set. if set do the following
       $delete_id = (int)$_GET['delete'];// pulls the delete=id value of the cattegory clicked and submits here
       $delete_id = sanitize($delete_id);
       //creating delete query
       /*handle the recursive delete by deleteing id which has delete_id as well as parent which has delete_id - 
       that means when you click on delete btn in of a parent in FE it should internally handle deleting its child records
       as well. if you delete a parent category, its child records are invisible in the FE but the orphaned records remian 
       in the categories table.*/
       $delete_sql = "DELETE FROM categories WHERE id = '$delete_id' OR parent = '$delete_id' ";
       $edb -> query($delete_sql); //exec query
       header('location: categories.php');//redirect page
   }//end DELETE BTN



   //PROCESS FORM to add categories to edb and table on screen
   if(isset($_POST) && !empty($_POST)){
        //sanitize var
        $post_parent = sanitize($_POST['parent']);
        $category = sanitize($_POST['category']);


        //query to get all the rows for certain category with a certain parent so we can check if they already exist before adding
        $sql_form = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' ";
        //if edit is set then redefine the sql_form query above to chck if id of item = edit id in the URL. chck imp so we can update that id
        if(isset($_GET['edit'])){
            $id = $edit_category['id'];
            $sql_form = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' 
                         AND id != '$id' ";
        }//end if for id check
        $form_result = $edb ->query($sql_form);
        $count = mysqli_num_rows($form_result); //how many rows in table have that exact match


        //check if category is blank
        if($category == ''){
            //blank input so display error msg
            $errorsEDB[] .= 'The Category CANNOT be blank! Please enter a valid input..';
        }//end if for blank check


        //check if category already exixts in edb
        if($count > 0){
            //one row exixts that matches the sql query. Then show as error
            $errorsEDB[] .= $category . ' already exists! Please choose a new Category!!';
        }//end if for exixts check


        //Display errors or UPDATE input to Categories table
            if(!empty($errorsEDB)){
                $display = display_errors($errorsEDB);?>
                <script>
                //display errors in the div with id=errors in the FORM section 
                jQuery('document').ready(function(){
                    //anonymous func
                    jQuery('#errors').html('<?= $display; ?>');
                });
                </script>
    <?php  }else{
                //update edb and add the new category
                $update_sql = "INSERT INTO categories (category, parent) VALUES ('$category','$post_parent')";
                //if edit is set then insert query should be replaced with update query
                if(isset($_GET['edit'])){
                    $update_sql = "UPDATE categories SET category = '$category', parent = '$post_parent'
                                   WHERE id = '$edit_id' ";
                }//end if -update
                $edb ->query($update_sql);
                header('location: categories.php');//redirect page
            }//end ifelse for display error or update table

   }//end main if

   
   
    //check for $category_value - When edit btn is clicked the category i/p in the form populated with the cat clicked
    //also, check is included to change the parent dropdown when a child is clicked to edit
    $category_value = '';
    $parent_value = 0; //selects parent in categories table by default
    if(isset($_GET['edit'])){
        //if edit is set the put category name into the blank var declared above
        $category_value = $edit_category['category'];
        //parent dropdown changes to display parent of the child selected to edit
        $parent_value = $edit_category['parent'];
    }else{
        //if get edit isnt set then check if post is set ie form is submitted
        if(isset($_POST)){
            $category_value = $category; //so we get the post value in process from section where $category is set 
            $parent_value = $post_parent;
        }//end if for post check

   }//end ifelse - check on $category_value


?>


<!--******************************************* main content START ******************************************************-->

<h2 class="brands-title">Categories</h2><hr>

<div class="row">
    <!--blank div for asthetics-->
    <div class="col-md-1"></div>

    <!--Add/Edit Form-->
    <div class="col-md-5">
        <!--action includes a ternary if that says if edit is set to GET variable our page will redirect us to edit=$edit_id-->
        <form action="categories.php<?=((isset($_GET['edit']))? '?edit='.$edit_id :''); ?>" method="post" class="form">
            <legend id="legend_title"><?=((isset($_GET['edit']))? 'Edit': 'Add a'); ?> Category..</legend>

            <div id="errors"></div>

            <div class="form-group">
                <label id="labelfont" for="parent">Parent</label>
                <select class="form-control" name="parent" id="parent">
                    <option value="0"<?=(($parent_value == 0)? ' selected="selected"' : ''); ?> >Parent</option>
                    <?php while($parent = mysqli_fetch_assoc($result)): ?>
                        <!--if category is a parent then Dropdown no change, if category is child then display parent category name in DD-->
                        <option value="<?=$parent['id']; ?>" <?=(($parent_value == $parent['id'])? ' selected="selected"' : ''); ?> > 
                            <?=$parent['category']; ?> 
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label id="labelfont" for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?= $category_value; ?>">
            </div>

            <div class="form-group">
                <input type="submit" value="<?=((isset($_GET['edit']))? 'Edit': 'Add'); ?> Category" class="btn btn-success">
            </div>
        </form>
    </div>

     <!--blank div for asthetics-->
     <div class="col-md-1"></div>

    <!--Categories Table-->
    <div class="col-md-5">
        <table class="table table-striped table-bordered table-condensed" style="width:auto;">
            <thead class="table-dark">
                <th>Category</th>
                <th>Category Level</th>
                <th></th>
            </thead>
            <tbody>
                <?php 
                    //retrive all categories and their parents to display dynamically. declared twice coz we use the same code for form as well as table.
                    $sql = "SELECT * FROM categories WHERE parent = 0";
                    $result = $edb -> query($sql);
                    //loop to dynamically display parent
                    while($parent = mysqli_fetch_assoc($result)): 
                    //code for generating children
                    $parent_id = (int)$parent['id'];
                    $sql_2 = "SELECT * FROM categories WHERE parent = '$parent_id' ";
                    $child_result = $edb -> query($sql_2);
                ?>

                    <tr class="table-active">
                        <td><b><?= $parent['category']; ?></b></td>
                        <td><b>Parent</b></td>
                        <td>
                            <a href="categories.php?edit=<?=$parent['id']; ?>" class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="left" delay="0" title="Edit Category"><i class="fas fa-pencil-alt"></i></a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="categories.php?delete=<?=$parent['id']; ?>" class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="right" delay="0" title="Delete Category"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                

                 <?php  while($child = mysqli_fetch_assoc($child_result)): //nested while loop to get child before we close parent ?>
                    <tr class="table-secondary">
                        <td><?= $child['category']; ?></td>
                        <td><?= $parent['category']; ?></td>
                        <td>
                            <a href="categories.php?edit=<?=$child['id']; ?>" class="btn btn-xs btn-light"><i class="fas fa-pencil-alt"></i></a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="categories.php?delete=<?=$child['id']; ?>" class="btn btn-xs btn-light"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                 <?php endwhile; /*end for nested loop displaying child category before closing parent loop*/ ?>

                <?php endwhile; /*end for loop displaying parent category*/ ?>

            </tbody>
        </table>
    </div>
</div>


<!--******************************************** footer START ************************************************************-->

<?php
    //php file that contains the page footer
    include('includes/footer.php'); //includes the left side bar filters
?>