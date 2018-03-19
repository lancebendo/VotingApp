<?php

$conn = mysql_connect("localhost", "root", "tmackulet") or die ("Error connection.".mysql_error());
mysql_select_db("votingsystem", $conn) or die("Error selecting db. ".mysql_error());


?>