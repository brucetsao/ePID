<?php 
require_once('../Connections/iot.php'); 


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
  $insertSQL = sprintf("INSERT INTO mosdevice (mac, deviceid, devicename, deviceaddr, longitude, latitude, areaid) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['select'], "text"),
                       GetSQLValueString($_POST['textfield1'], "text"),
                       GetSQLValueString($_POST['textfield2'], "text"),
                       GetSQLValueString($_POST['textfield3'], "text"),
                       GetSQLValueString($_POST['textfield4'], "double"),
                       GetSQLValueString($_POST['textfield5'], "double"),
                       GetSQLValueString($_POST['select2'], "text"));

  mysql_select_db($database_iot, $iot);
  $Result1 = mysql_query($insertSQL, $iot) or die(mysql_error());

  $insertGoTo = "mosdevicelist.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php
  mysql_select_db($database_iot, $iot);
	
	$str2 =  "SELECT * FROM `mosdata` WHERE mac not in (select mac from mosdevice where 1)  group by mac" ;
	$str3 =  "select * from mosarea order by  areaname  desc" ;
//	$result=mysql_query("SELECT * FROM `ppgtbl` order by `room_name` ",$link);	
	$result2=mysql_query($str2,$iot);	
	$result3=mysql_query($str3,$iot);		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新增補蚊機資料</title>
<link href="../webcss.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
include '../systitle.php';
?>
<input type ="button" onclick="history.back()" value="Back(回到上一頁)"></input>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="1">
    <tr>
      <td width="20%">蚊子機網路機號位址(MAC)</td>
      <td width="80%"><label for="textfield">
        <select name="select" id="select">
          <?php 
		  if($result2 !==FALSE){
		     while($row = mysql_fetch_array($result2)) {
		        printf(" <option value='%s'>%s</option>", 
		           $row["mac"], $row["mac"]);
		     }
 		     mysql_free_result($result2);
		 }
   	   ?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>MosquitoTrap Code(蚊子機代碼)</td>
      <td><label for="textfield1"></label>
      <input name="textfield1" type="text" id="textfield2" size="12" /></td>
    </tr>
    <tr>
      <td>MosquitoTrap Name(蚊子機名稱)</td>
      <td><label for="textfield2">
        <input name="textfield2" type="text" id="textfield" size="25" />
      </label></td>
    </tr>
    <tr>
      <td>Address(蚊子機裝機地址)</td>
      <td><label for="textfield3">
        <input name="textfield3" type="text" id="textfield" size="80" />
      </label></td>
    </tr>
    <tr>
      <td>Latitud(蚊子機裝機地緯度)</td>
      <td><label for="textfield4">
        <input name="textfield4" type="text" id="textfield" size="16" />
      </label></td>
    </tr>
    <tr>
      <td>Longitude(蚊子機裝機地經度)</td>
      <td><label for="textfield5">
        <input name="textfield5" type="text" id="textfield" size="16" />
      </label></td>
    </tr>
    <tr>
      <td>Area(監管區域)</td>
      <td width="80%"><label for="textfield6">
        <select name="select2" id="select2">
          <?php 
		  if($result3 !==FALSE){
		     while($row = mysql_fetch_array($result3)) {
		        printf(" <option value='%s'>%s</option>", 
		           $row["areaid"], $row["areaname"]);
		     }
 		     mysql_free_result($result3);
		 }
   	   ?>
        </select>
      </label></td>

    </tr>
    <tr>
      <td><input type="reset" name="button2" id="button2" value="Reset(重設)" /></td>
      <td><input type="submit" name="button" id="button" value="Submit(送出)" /></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
</p>
</form>

<?php
include '../footer.php';
?>
</body>
</html>