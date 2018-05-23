
<?php
    //Search Filter | created a new Search Page in php/search.php
    //Step1: we want to know if we are already in a category. because if we filter/search something and we are in a category then we want to stay in that category
    $cat_id = ((isset($_REQUEST['cat']))? sanitize($_REQUEST['cat']) : '');

    //filter settings for price L to H and H to L
    //if not posted or get var then data posted as null else sorted data is shown on page
    $price_sort = ((isset($_REQUEST['price_sort']))? sanitize($_REQUEST['price_sort']) : '' );
    $min_price = ((isset($_REQUEST['min_price']))? sanitize($_REQUEST['min_price']) : '' );
    $max_price = ((isset($_REQUEST['max_price']))? sanitize($_REQUEST['max_price']) : '' );


    //filter for brands
    $b = ((isset($_REQUEST['brand']))? sanitize($_REQUEST['brand']) : '');
        //loop through all the brands in the $edb
    $brandQ = $edb->query("SELECT * FROM brand ORDER BY brand");

?>


<h3 class="text-center" id="widget_title">Search By..</h3>

<!--Search by Price-->
<h4 class="text-center" id="filter_subs">Price : </h4>
<form action="search.php" method="post">
    <!--hidden input to pass along the cat_id we want if seacrh button is clicked-->
    <input type="hidden" name="cat" value="<?=$cat_id;?>">
    <input type="hidden" name="price_sort" value="0"> <!--if they dont check H or L in price filter then we want 0 to pass-->

    <!--Radio btn for H and L price-->
    <input type="radio" name="price_sort" value="low" <?=(($price_sort == 'low')? ' checked' : '');?> > Low to High <br><br>
    <input type="radio" name="price_sort" value="high" <?=(($price_sort == 'high')? ' checked' : '');?> > High to Low <br><br>
    <!--Display the min and mx price limit of items on the page-->
    <input type="text" name="min_price" class="price-range" placeholder=" Min $" value="<?=$min_price; ?>"> 
    &nbsp;To&nbsp;
    <input type="text" name="max_price" class="price-range" placeholder=" Max $" value="<?=$max_price; ?>">


    <br><br><br>
    <!--Search by Brand-->
    <h4 class="text-center" id="filter_subs">Brand : </h4>
    <input type="radio" id="brandRadio" name="brand" value="" <?=(($b == '')? ' checked' : '');?>>All <br>
    <!--Loop through the query brandQ and display all the barnds in the database using while loop-->
    <?php while($brand = mysqli_fetch_assoc($brandQ)): ?>
        <!--value equals id and give checked attribute to see if isset and for label we are echoing out $brands brand-->
        <input type="radio" id="brandRadio" name="brand" value="<?=$brand['id'];?>" <?=(($b == $brand['id'])?' checked' : '');?>> <?=$brand['brand'];?> <br>
    <?php endwhile;?>
    <br><input type="submit" value="Search" class="btn btn-outline-dark" style="margin-left:70px;">

</form>
