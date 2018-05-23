
<!--Expert Advice Page hosts Static Videos and Text-->

<?php
//database connection file - initial file
//we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
require_once('../core/init.php');

//Include files that have seperate elements of the page like header, navbar, main content, footer etc
include('../includes/head.php');

//populate dropdown from database table
include('../includes/navigation.php');
?>

<!--********************   mAIN cONTENT   *******************************-->
<br><br>
<!--News Letter-->
<div class="row">
    <div class="col-md-1"></div>
    
    <div class="col-md-2">
        <h3 id="filter_subs" style="color:blueviolet; font-size:22px">News Letter</h3>
        <form class="form" role="form">
            <div id="result"></div>
            <div class="form-group">
                <label class="sr-only" for="email">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email">
            </div>
            <button type="button" id="submit" class="btn btn-primary btn-block">Subscribe</button>
       </form>
    </div>
    
    <div class="col-md-8"></div>
    
    <iframe class="col-md-12" id="NewsFeed_1" src="https://blog.stitchfix.com/fashion-tips/" align="center" ></iframe>

</div>
<br><br><br>
<!--***********************   FOOTER   ****************************-->
<?php
//php file that contains the page footer
include('../includes/footer.php'); //includes the left side bar filters
?>

<!--JQ for News LEtter -->
<script>
    $(document).ready(function(){
        $('#email').focus();

        //if user presses enter btn after writing the email
        $('#email').keypress(function(event){
            var email = $('#email').val();
            var keyCode = event.keyCode; //keyboard btns press
            if(keyCode == 13){  //13 is for enter
                //fire ajax func
                jQuery.ajax({
                    url: '/ASP_Project/subscribe/newsAction.php',
                    type: 'POST',
                    data: {email : email},
                    success: function(data){
                        $('#result').hide();
                        $('#result').html(data);
                        $('#result').fadeIn();
                    }//end success
                });//end ajax call
            }//end if
        });//end keypress


        //submit btn
        $('#submit').click(function(){
            var email = $('#email').val();
            //fire ajax func
            jQuery.ajax({
                url: '/ASP_Project/subscribe/newsAction.php',
                type: 'POST',
                data: {email : email},
                success: function(data){
                    $('#result').hide();
                    $('#result').html(data);
                    $('#result').fadeIn();
                }//end success
            });//end ajax call
        });//end clicked func


    });//end doc ready func
</script>