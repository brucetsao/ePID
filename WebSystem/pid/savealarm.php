<?php 
   	include("../Connections/iotcnn.php");		//使用資料庫的呼叫程式
		//	Connection() ;
   	
  	$link=Connection();		//產生mySQL連線物件


?>
<?php
if (!function_exists("GetSQLValueString")) 
{
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
		  if (PHP_VERSION < 6) 
		  {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		  }
	
	  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
	
		  switch ($theType) 
			  {
				case "text":
				  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				  break;    
				case "checkbox":
				case "long":
				case "int":
				  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
				  break;
				case "double":
				  $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
				  break;
				case "date":
				  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				  break;
				case "defined":
				  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				  break;
			  }
		  return $theValue;
		}
}
/*
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) 
	{
	  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}

*/
//if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) 
	{
	  $updateSQL = sprintf("update nukiot.pidController SET AL1Flag=%d, ALT1H=%f, AL1L=%f   WHERE MAC=%s and did = %d",
						   GetSQLValueString($_POST['select'], "int"),
						   GetSQLValueString($_POST['textfield3'], "double"),
						   GetSQLValueString($_POST['textfield4'], "double"),
						   GetSQLValueString($_POST['textfield1'], "text"),
						   GetSQLValueString($_POST['textfield2'], "int")
								);
		echo $updateSQL."<br>" ;
	//  mysql_select_db($db, $iot);
     $result=mysql_query($updateSQL,$link);		//將dhtdata的資料找出來(只找最後5
	  
	 // $Result1 = mysql_query($updateSQL, $link) or linkie(mysql_error());
	}
	$updateGoTo = "http://nuk.arduino.org.tw:8888/iot.php";
	 header(sprintf("Location: %s", $updateGoTo), true, 301);
    exit();
?>
