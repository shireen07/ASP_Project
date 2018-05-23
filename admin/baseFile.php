

<?php  
    //user-registration db file
    include('../registration/server.php'); 

    //database connection file - initial file
    //we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
    require_once('../core/init.php');

    //Include files that have seperate elements of the page like header, navbar, main content, footer etc
    include('includes/head.php');

    //populate dropdown from database table
    include('includes/navigation.php');

    //include('includes/leftbar.php'); //includes the left side bar filters

    //if the user is empty they cannot access this page
    //START
    if(empty($_SESSION['username'])){
    header('location: ../registration/login.php');
    }
//END
?>
<!--************************************************************************************************************-->

<br><br><br>
TEST FILE!
<br><br><br>

<!--************************************************************************************************************-->
<?php
    //right side bar
    //include('includes/rightbar.php');

    //php file that includes the pop up modal which contains product info
    //include('../includes/detailsModal.php');

    //php file that contains the page footer
    include('includes/footer.php'); //includes the left side bar filters

?>





<!--******************************************************************************************8***********-->

<!--JS function to display the dynamic data into the detailsModal.php-->
<script>
   function detailsModal(id){
       //creating a onject variable with a JSON string
       var data = {"id" : id};
       //creating a AJAX Http request to call the data from the prod thumbs id and displying it dynamically in the modal
       $.ajax ({
           //baseurl is the main proj folder defined in init.php and we are concatinating the php page path to it
           url : <?php echo BASEURL;?> + 'includes/detailsModal.php', // YOU CAN USE '=' instead of typing 'echo' in php syntax. 
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



<!--**********************************************************************************************************-->
