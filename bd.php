<?php
	//
$mysqli = new mysqli("localhost", "root", "nopass", "iteh2lb1var2");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}else{
//echo "OK";
}

$mysqli->query("set names utf8");
//echo "connected";
    ?>
