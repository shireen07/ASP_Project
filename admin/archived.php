

<?php  
    ob_start();
    //user-registration db file
    include('../registration/server.php'); 

    //database connection file - initial file
    //we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
    require_once('../core/init.php');

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


<?php
   //DELETE products from archive and add it to the categories again
   if(isset($_GET['delete']) && !empty($_GET['delete']) ){
       $delete_id = (int)$_GET['delete'];
       $delete_id = sanitize($delete_id); 
       $edb -> query("DELETE FROM products WHERE `id` = '$delete_id'"); 
       header('Location: archived.php');
   }//end if - delete

   $sql = "SELECT * FROM products WHERE deleted = 1"; 
   $result = $edb -> query($sql);

   //ARVIVED PRODUCT PROCESS
   if(isset($_GET['archive'])){
    $id = sanitize($_GET['archive']); 
    $reset = "UPDATE products SET `deleted` = 0 AND `featured` = 1 WHERE `id` = '$id' "; 
    $result = $edb -> query($reset); 
    header('Location: archived.php');
   }//end if - archived
?>


<!--******************************************* main content *******************************************************-->

   <h2 class="brands-title">Archived Products..</h2><hr>

   <!--Archived Table-->
    <table class="table table-active table-striped table-bordered table-condensed tableSize" style="width:auto;">
        <thead class="table-dark">
            <td></td> 
            <td>Title</td>
            <td>Price</td>
            <td>Category</td>
            <td>Sold</td>
        </thead>
        <tbody>
            <!--dynamically display ARCHIVED PRODUCTS from database-->
            <?php while ($product = mysqli_fetch_assoc($result)): $childId = $product['categories']; 
                  $catsql = "select * from categories where id ='$childId'"; 
                  $cresult = $edb -> query($catsql); 
                  $child = mysqli_fetch_assoc($cresult); 
                  $parentId = $child['parent']; 
                  $psql = "SELECT * FROM categories WHERE `id` = '$parentId' "; 
                  $presult = $edb -> query($psql); 
                  $parent = mysqli_fetch_assoc($presult); 
                  $category = $parent['category'].'-'.$child['category']; 
            ?>

                <tr>
                    <td>
                        <!--Restore Button will edit the ARCHIVED (deleted column) in PRODUCTS TABLE in database-->
                        <a href="archived.php?archive=<?=$product['id'];?>" class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="right" delay="0" title="Restore to Products"><i class="fas fa-sync"></i></a> &nbsp;
                        <!--Remove Product from Database and archived products as well-->
                        <a href="archived.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="right" delay="0" title="Permanently delete"><i class="fas fa-trash-alt"></i></a>
                    </td>
                    <td><?=$product['title'];?></td> 
                    <td><?= money($product['price']);?></td> 
                    <td><?=$category;?></td> 
                    <td>0</td>
                </tr>
            <?php endwhile;?>
        </tbody>
    </table>


<!--******************************************** footer *************************************************************-->

<?php
    //php file that contains the page footer
    include('includes/footer.php'); //includes the left side bar filters
    ob_end_flush();
?>