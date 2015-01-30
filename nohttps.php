<?php
include('header.inc.php');
?>
<style>
#mainNav li {
	display: inline;
	list-style: none;
	font-size:1.0em;
	margin: 0pt 1.1em 0pt 0pt;
	padding: 0;
	}
</style>




<h3>ERROR</h3>

<br>
<BLOCKQUOTE><BLOCKQUOTE><P ALIGN=JUSTIFY>
<FONT CLASS="content">Your connection is not encrypted. 
Please make sure that this address always starts with 'https'.  An easy way to remember is that the 's' stands for secure</FONT></P>
</BLOCKQUOTE></BLOCKQUOTE>
<br>
<br>

<h3><cfoutput>
<a href="<?php echo  "https://".$_SERVER['HTTP_HOST'] . '/concordia/login.php'> </a>
</cfoutput>
</h3>
<br>
<br>
<?php
include('footer.inc.php');
?>