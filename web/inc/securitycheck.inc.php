<?php
require_once("./inc/mysql.inc.php");

$ip = addslashes(substr($_SERVER['REMOTE_ADDR'], 0, 15));

$IPv4_loopback_address = "127.0.0.1";
$IPv6_loopback_address = "::1";

if (($ip != $IPv4_loopback_address) && ($ip != $IPv6_loopback_address)) {
	$dbsec = new CMySQL;
	if (!$dbsec->Open()) $dbsec->Kill();
	$q = "SELECT COUNT(*) AS num
		  FROM ipaddress
		  WHERE IP = '$ip';
		 ";
	if (!$dbsec->Query($q)) $dbsec->Kill();
	$r = $dbsec->Row();
	if ($r->num < 1)
		die('
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Clocking</title>
  </head>
  <body>
    <br><p style="font-size: 18px; text-align: center">Please use MGE stationary office or shop computers to access clocking page.</p>
  </body>
</html>
');
}
?>