
<?php

//function to print form errors from brands.php to screen. creates a UL for all errors and prints each error in a li tag
function display_errors($errorsEDB){
   $display = '<ul class="bg-warning">';

   foreach($errorsEDB as $error){
      $display .= '<li class="text-danger font-weight-bold text-center">'.$error.'</li>';
   }//end foreach

   $display .= '</ul>';
   return $display;
}//end func display_errors


//function to print form success message for admin to screen. creates a UL for all errors and prints each error in a li tag
function display_success($successEDB){
    $display = '<ul class="bg-success">';
 
    foreach($successEDB as $success){
       $display .= '<li class="text-white font-weight-bold text-center z-index:1111">'.$success.'</li>';
    }//end foreach
 
    $display .= '</ul>';
    return $display;
 }//end func display_success



//func to take care of the security of brand form. because without this function we are able to add html tags as input and its being accepted by db
function sanitize($dirty){
    /*prebuilt php func which will turn the tags into html entities and they will print to the screen 
    rather than actually be enacted eg: <strong>HELLO</strong> will be printed as '<strong>HELLO</strong>'
    rather than 'HELLO' text becoming bold in font-weight.*/
    /*ENT_QUOTES takes care of single and double quotes & UTF-8 defines our character set*/
    return htmlentities($dirty,ENT_QUOTES,"UTF-8");
}//end sanitize



//function takes any number and returns it in the format of dollars with $ signa and .00
function money($number){
    return '$'.number_format($number, 2);
}//end func money



function is_logged_in(){
    if(isset($_SESSION['username']) && $_SESSION['username'] > 0){
        return true;
    }else{return false;}//end if
}//end func


//for admin users page - format the date from the $db users table into an asthetic format and display
function pretty_date($date){
    return date("M d, Y ~ h:i A", strtotime($date)); //takes 2 param - 1st is the format u want for the date and 2nd
}//end func



//FUNCTION TO - JOIN commoand TO GET THE PARENT AND CHILD CATEGORIES LIST
//this is how we get parent name and id as well as child category name and id using inner join
function get_category($child_id){
    global $edb;
    $id = sanitize($child_id); 
    $sql = "SELECT p.id AS 'p_id' , p.category AS 'parent' , c.id AS 'c_id' , c.category AS 'child'
            FROM categories c
            INNER JOIN categories p
            ON c.parent = p.id 
            WHERE c.id = '$id' ";
    $query = $edb -> query($sql);
    $category = mysqli_fetch_assoc($query);

    return $category;
}//end func


//FUNCTION TO HELP WITH THE SIZES ARRAY IN PRODUCTS TABLE. AND WITH ADJUSTING THE INVENTORY
function sizesToArray($string){
    $sizesArray = explode(',' , $string); //{size1:qty; size2:qty;} explode removed all the ; from json string and made the elements into an array
    $returnArray = array();
    foreach($sizesArray as $size){
        $s = explode(':' , $size); //individual size1:qty, size2:qty,.. array explde removed : and made array[0] = size 1, array[1] = qty1 and so on
        $returnArray[] = array('size' => $s[0] , 'quantity' => $s[1] , 'threshold' =>$s[2]);
    }//end foreach
    return $returnArray;
}//end func sizesToArray


//when we put the adjusted inventory sizes to database we want them to be encoded in a particular format.
function sizesToString($sizes){
    $sizeString = '';
    foreach($sizes as $size){
        $sizeString .= $size['size'] .':'. $size['quantity'] .':'. $size['threshold'] .',' ; 
    }//end foreach
    $trimmed = rtrim($sizeString, ',');
    return $trimmed;
}//end func sizesToString

  
