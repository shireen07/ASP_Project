
<!--2nd widget in the RHS filter area of the categories page-->
<h3 class="text-center" id="widget_title">Polular Items</h3>

<?php
    //look at our tansactions: 
    //WE WANT THE LAST 5 PAID TRANSACTIONS IN CART TABLE IN DESCENDING ORDER SO WE GET LATEST FIRST
    $transQ = $edb->query("SELECT * FROM cart WHERE paid = 1 ORDER BY id DESC LIMIT 5");
    $results = array();

    while($row = mysqli_fetch_assoc($transQ)){
        //add each row to the $results array
        $results[] = $row;        
    }//end while
    
    $row_count = $transQ->num_rows; //gives us number of results
    
    //keep track of items so we dont repeat the same items if same items purchased my diff customers
    $used_ids = array();
    for($i=0; $i < $row_count; $i++){
        $json_items = $results[$i]['items']; //passing the item string of each item passed thru the for loop
        $items = json_decode($json_items, true); //decode the json string of each transaction
        foreach($items as $item){
            if(!in_array($item['id'] , $used_ids)){
                /* !in_array() checks if the item id is not in the used_ids array then we add it so for the next item 
                it checks this list and if the new item id is in the list we skip mentioning this new item */
                $used_ids[] = $item['id'];  
            }//end nested if
        }//end nested foreach
    }//end for
?>

    <!--Now we have our Latest purchased items list ready so we display them-->
    <div id="recent_widget">
        <table class="table table-condensed">
            <?php foreach($used_ids as $id): 
                $productQ = $edb->query("SELECT id, title FROM products WHERE id = '{$id}' ");
                $product = mysqli_fetch_assoc($productQ);
            ?>
                <!--for each product display a row-->
                <tr>
                    <td> <?= substr($product['title'],0,15); ?> </td>
                    <td>
                        <a class="text-info" onclick="detailsModal('<?=$id;?>')">View</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </table>
    </div>