<?php

if ( isset($_REQUEST['host']) && isset($_REQUEST['out']) ){
	$host = $_REQUEST['host'];
	$out = $_REQUEST['out'];

	$fp = fsockopen($host, 80, $sock_errno, $sock_errmsg, 30);

	if (!$fp) {
		echo $sock_errmsg . ($sock_errno) . "<br />";
	} 
	else {

		fwrite($fp, $out);
		while (!feof($fp)) {
			echo fgets($fp,128);
		}
		fclose($fp);
	}
}

?>