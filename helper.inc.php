<?php
function set_default(&$var, $default="", $catchNulls=FALSE) {
	if (!isset($var) || ($catchNulls && $var == "")) {
		$var = $default;
	}
}


?>