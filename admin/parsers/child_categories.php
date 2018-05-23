<?php 
    //database connection file - initial file
    //we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
    //require_once('../core/init.php');
    require_once $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/core/init.php' ;

    //user-registration db file
   // include('../registration/server.php'); 

    //if the user is empty they cannot access this page
    /*
    if(empty($_SESSION['username'])){
    header('location: ../registration/login.php');
    }
    */
?>


<?php
    /* Uses an ajax request from admin/inclues/footer
    make a listener in the footer of products.php that says that when a parent category is selected while adding a new item,
    we will fire an ajax request to this file and retrun the options for the child category of the parent selected.
    */

    //cast the var parentID as an int and use the parentID value from the JQ in admin/includes/footer.php
    $parent_id = (int)$_POST['parent_id']; 
    //we call the child category to be printed- JQ from products.php bottom and admin footer.php funct get_child_options
    $selected = sanitize($_POST['selected']);

    $child_query = $edb->query("SELECT * FROM categories WHERE parent = '$parent_id' ORDER BY category ");

    //prebuilt php func to start buffering and echo some html and then release the buffer by cusing clean func
    ob_start();
?>
    <option value=""></option>
    <?php while($child = mysqli_fetch_assoc($child_query)): ?>
        <option value="<?=$child['id'];?>" <?=(($selected == $child['id'])? ' selected' : ''); ?>> <!--ternary if to make the option "selected" only if selected = child id-->
            <?=$child['category']; ?> 
        </option>
    <?php endwhile; ?>

<?php echo ob_get_clean(); ?>