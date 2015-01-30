<?php

include('config.inc.php');
include('header.inc.php');
?>


You have successfully registered for free Edmonton Public Library access. 
Your account will expire on	
<?php if ( isset($_SESSION['eplgo']) ) { 
	echo $_SESSION['eplgo']->getUserExpirationDate() ; 
} ?><br><br>

An e-mail message confirming your account will be sent to you shortly. You may now use the <u>barcode</u> on your MacEwan card<br>
to borrow materials and access services at any Edmonton Public Library location.
<br>
<img src="https://library.macewan.ca/files/images/macewan_card.jpg">




<br>


<?php

session_destroy();
include('footer.inc.php');

?>