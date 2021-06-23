<?php 
include('../Connections/iot.php'); 

	$sid=$_GET["sid"];		//取得POST參數 : field1
	$mac=$_GET["MAC"];		//取得POST參數 : field1

	
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("insert into nukiot.sitelist (subid, Did, sensortype, model , ps) VALUES (%d, %d,  %s, %s, %s)",
  						$sid ,
                       GetSQLValueString($_POST['select'], "int"),
                       GetSQLValueString($_POST['select2'], "text"),
                       GetSQLValueString($_POST['textfield3'], "text"),
                       GetSQLValueString($_POST['textfield4'], "text"));
//echo $insertSQL."<br>";
  mysql_select_db($database_iot, $iot);
  $Result1 = mysql_query($insertSQL, $iot) or die(mysql_error());
echo $insertSQL."<br>" ;
/*
  		
  $insertGoTo = "devicelist.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  */
}
?>
<?php

	//select Did from nukiot.sitelist where subid = 3 group by DID not in (select Did from nukiot.pidController where MAC ='CC50E3B6B808') order by Did asc
	//select Did from nukiot.pidController where MAC ='CC50E3B6B808' NOT IN (select Did from nukiot.sitelist where subid = 3 group by DID)  order by Did asc 
	
	$str2 =  sprintf("select Did from nukiot.pidController where MAC ='%s' in (select Did from nukiot.sitelist where subid = %d group by DID) order by Did asc",$mac,$sid) ;
	//echo $str2."<br>" ;
	$str3 =  "select * from nukiot.sensortype order by  sid  asc" ;
//	$result=mysql_query("SELECT * FROM `ppgtbl` order by `room_name` ",$iot);	
	$result2=mysql_query($str2,$iot);	
	$result3=mysql_query($str3,$iot);		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Temperature and Humidity Device(Home Use) into Site belonged</title>
<link href="../webcss.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
include '../title.php';
?>
<input type ="button" onclick="history.back()" value="回到上一頁">
</input>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="1">
    <tr>
      <td>PID Center ID</td>
      <td><? echo $sid ; ?></td>
   </tr>    
    <tr>
      <td>PID Controller Device MAC Address</td>
      <td><? echo $mac ; ?></td>
   </tr>    
      <tr>
      <td width="20%">Modbus Channel(通訊埠號碼)</td>
      <td width="80%"><label for="textfield">
        <select name="select" id="select">
          <?php 
		  if($result2 !==FALSE){
		     while($row = mysql_fetch_array($result2)) {
		        printf(" <option value='%s'>%s</option>", 
		           $row["Did"], $row["Did"]);
		     }
 		     mysql_free_result($result2);
		 }
   	   ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Sensor Type(感測器類別)</td>
      <td width="80%"><label for="textfields2">
        <select name="select2" id="select2">
          <?php 
		  if($result3 !==FALSE){
		     while($row = mysql_fetch_array($result3)) {
		        printf("<option value='%s'>%s(%s)</option>", 
		           $row["sid"], $row["ename"],$row["sname"]);
		     }
 		     mysql_free_result($result3);
		 }
		?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Model Name & Type & Model(控制器名稱/種類/型號)</td>
      <td width="80%"><label for="textfield3"></label>
      <input name="textfield3" type="text" id="textfield3" size="120" maxlength="300" /></td>
    </tr>
    <tr>
      <td>PS(備註)</td>
      <td width="80%"><label for="textfield4"></label>
      <input name="textfield4" type="text" id="textfield4" size="120" maxlength="300" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Submit(送出)" /></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
</p>
</form>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<?php
include '../footer.php';
?>
</body>
</html>