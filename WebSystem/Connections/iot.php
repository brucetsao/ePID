<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

$hostname_iot = "localhost";
$database_iot = "nukiot";
$username_iot = "dbuser";
$password_iot = "dbpassword";
$iot = mysql_pconnect($hostname_iot, $username_iot, $password_iot) or trigger_error(mysql_error(),E_USER_ERROR); 
		mysql_query("SET NAMES UTF8");
		session_start();
		mysql_select_db($database_iot, $iot);
?>