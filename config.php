
<?php
//define a constant to get the path of the root directory to this document //name of the const and its localhost path

define('BASEURL', __DIR__.'/');
define('SITE_URL', 'http://localhost/ASP_Project');

//define the var with a garbage string
define('CART_COOKIE', 'SXB38200sHiReEnB');

//we want our shopping cart to stay for 30 days from the day of the cart fill. Create in form of a COOKIE
//so we use the time() func to take todays datetime and there are 86400 sec in a day that times 30
define('CART_COOKIE_EXPIRE', time() + (86400 *30));


//set a Tax constant so we can apply to subtotal to get a grand total on the items in the cart
define('TAXRATE', 0.087); //almost 9% sales tax



//constants for STRIPE - CHECKOUT PROCESS
//1)define currency
define('CURRENCY', 'usd');
//2)define our checkout mode //CHANGE TEST TO LIVE WHEN YOU ARE READY TO GO LIVE
define('CHECKOUTMODE','TEST');


if(CHECKOUTMODE == 'TEST'){
    //3)define the SECRET API KEY FOR STRIPE. WE NEED THIS KEY FOR LOGGABLE TRANSACTION DATA
    define('STRIPE_PRIVATE', 'sk_test_7W3pVpDjmGJHk51Vop9VFRJO');
    //define the stripe publishable key for test
    define('STRIPE_PUBLIC', 'pk_test_GWYM3MhHKRIBSd2GtR7dnH7F');
}//end if for checkoutmode TEST constant


//WE DONT HAVE A LIVE MODE SO WE REEPEAT THE TEST MODE KEYS FOR LIVE AS WELL. WE CAN USE THIS IN FUTURE 
//SO WE JUST NEED TO CHANGE THE DEFINED CONSTANT CHECOUTMODE FROM TEST TO LIVE TO START USING OUR LIVE KEYS
if(CHECKOUTMODE == 'LIVE'){
    //3)define the SECRET API KEY FOR STRIPE. WE NEED THIS KEY FOR LOGGABLE TRANSACTION DATA
    define('STRIPE_PRIVATE', 'sk_test_7W3pVpDjmGJHk51Vop9VFRJO');
    //define the stripe publishable key for test
    define('STRIPE_PUBLIC', 'pk_test_GWYM3MhHKRIBSd2GtR7dnH7F');
}//end if for checkoutmode LIVE constant
