<?php 
include("../comlib.php");		//使用資料庫的呼叫程式
include('../Connections/iot.php'); 


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
  $insertSQL = sprintf("insert into nukiot.site(MAC ,siteid , sitename, address, longitude, latitude, areaid) VALUES (%s,%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['select1'], "text"),
                       GetSQLValueString($_POST['textfield1'], "text"),
                       GetSQLValueString($_POST['textfield2'], "text"),
                       GetSQLValueString($_POST['textfield3'], "text"),
                       GetSQLValueString($_POST['textfield5'], "double"),
                       GetSQLValueString($_POST['textfield4'], "double"),
                       GetSQLValueString($_POST['select2'], "text"));

	//echo  $insertSQ."<br>" ;
  mysql_select_db($database_iot, $iot);
  $Result1 = mysql_query($insertSQL, $iot) or die(mysql_error());
	 $insertGoTo = "sitelist.php";

  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

}
?>
<?php

	
	$str2 =  "select MAC from nukiot.pidController where MAC not in (select MAC from nukiot.site group by mac) group by MAC" ;
//	$result=mysql_query("SELECT * FROM `ppgtbl` order by `room_name` ",$iot);	
	$result2=mysql_query($str2,$iot);	
	
	$str3 =  "select * from nukiot.area order by  areaname  asc" ;
	$result3=mysql_query($str3,$iot);	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Pid Control Center</title>
<link href="../webcss.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
include '../title.php';
?>
<input type ="button" onclick="history.back()" value="BACK(回到上一頁)">
</input>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="1">
    <tr>
      <td>MAC<br /> 網路卡編號</td>
      <td width="80%"><label for="textfield01">
        <select name="select1" id="select1">
          <?php 
		  if($result2 !==FALSE){
		     while($row = mysql_fetch_array($result2)) {
		        printf(" <option value='%s'>%s</option>", 
		           $row["MAC"], $row["MAC"]);
		     }
 		     mysql_free_result($result2);
		 }
   	   ?>
        </select>
      </label></td>

    </tr>

    <tr>
      <td width="20%">Device ID<br>裝置編號</td>
      <td><label for="textfield1"></label>
      <input name="textfield1" type="text" id="textfield2" size="12" /></td>
    </tr>
    <tr>
      <td>Device Name<br>裝置名稱</td>
      <td><label for="textfield2">
        <input name="textfield2" type="text" id="textfield" size="25" />
      </label></td>
    </tr>
    <tr>
      <td>Address<br>裝置地址</td>
      <td><label for="textfield3">
        <input name="textfield3" type="text" id="address" size="80" />
      </label><input type="button" id="send" value="轉換座標"></td>
    </tr>
    <tr>
      <td>Latitude(緯度)</td>
      <td><label for="textfield4">
        <input name="textfield4" type="text"  id="lat"  size="16" />
      </label></td>
    </tr>
    <tr>
      <td>Longitude(經度)</td>
      <td><label for="textfield5">
        <input name="textfield5" type="text" id="lng"  size="16" />
      </label></td>
    </tr>
    <tr>
      <td>Location Area <br /> 管理區域</td>
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
<p id="msg"></p>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script>
  $('#send').on('click', function(){
    var address = $('#address').val()
    if (address)
      addToLatLng(address)
    else
      alert('Please Input Address')
  });

  function addToLatLng (address) {
    $.ajax({
      url: 'https://api.map8.zone/v2/place/geocode/json?key=<?php echo $map8key; ?>&address=' + address
    }).done(function(response) {
      var msg = ''
      var result = response.results[0]

      if (result.level == 'fuzzy' || result.authoritative == "false")
        msg = 'Please Input Complete and Exact Address for get exact results'
      if (result.formatted_address == '')
        msg = 'Please Input Complete and Exact Address'
        
      $('#lat').val(result.geometry.location.lat)
      $('#lng').val(result.geometry.location.lng)
      $('#msg').html(msg)
    }).fail(function(result) {
      $('#msg').text('Can't Get Address Data，Please Confirm Internet Connection is OK?? and MAP Certificate is valid')
    });
  }
</script>
<?php
include '../footer.php';
?>
</body>
</html>