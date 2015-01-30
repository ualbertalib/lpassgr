<?php 
include('config.inc.php');
include_once('./includes/checkhttps.inc.php');
include('header.inc.php'); 




if (!empty($_POST)){

	
	include('./includes/validate.inc.php');
}




?>




<h2>L-Pass (Library Pass) Registration</h2> 
	
	
<?php 

if (isset($messaging) && $messaging->getErrorCount() >0){

	echo $messaging->getErrorString();

}
 ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="left" valign="top">

    <td class="tablewidth24"></td>
    <td  align="left">
	<br />



 <div align="center"><table width="60%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="Black">


<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#EEEEEE">
<tr>
	<td valign="top">

			<table width="100%" bgcolor="#EEEEEE">
			<tr><td>Please login using this link:
			<a target="_blank" href="https://library.macewan.ca/lpass">L-Pass registration page</a>.
			</td></tr>
			</table>
		</td>
		</tr>
		</table>
		</td>
		</td>
		</tr>
</table>
</div>

 </td>

</table>



<?php include('footer.inc.php'); ?>