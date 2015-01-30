<?php

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'  || $_SERVER['SERVER_PORT'] == 443) {

    $secure_connection = true;
}else{

	$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	echo "<h3>ERROR</h3>
			<br>
			<BLOCKQUOTE><BLOCKQUOTE><P ALIGN=JUSTIFY>
			<FONT CLASS=content>Your connection is not encrypted. 
			Please make sure that this address always starts with 'https'.  An easy way to remember is that the 's' stands for secure</FONT></P>
			<a href=\"{$redirect}\">{$redirect}</a>
			</BLOCKQUOTE></BLOCKQUOTE>
			<br>
			
			<br>";
	
	exit();
}



?>