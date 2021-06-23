<?php 
   	include("../Connections/iotcnn.php");		//使用資料庫的呼叫程式
	
	$link=Connection();		//產生mySQL連線物件
	
	mysql_select_db($db,$link) ;
	//$link=Connection();		//產生mySQL連線物件
	
?>
<?php

if (isset($_GET['sid'])) {
  $temp0 = $_GET['sid'];
}
mysql_select_db($db, $link);
$str1 = sprintf("SELECT a.* ,b.* FROM mosdevice as a , mosarea as b WHERE a.id = %d and  a.areaid = b.areaid ",$temp0);
//echo $str1."<br>" ;
//SELECT a.* ,b.* FROM mosdevice as a , mosarea as b WHERE a.id = 15 and  a.areaid = b.areaid

$Recordset1 = mysql_query($str1, $link) or die(mysql_error());
$row1 = mysql_fetch_assoc($Recordset1);
$str2 = sprintf("select * from iot.mosdata where fid = %d order by datatime desc",$row1['id']) ;
//echo $str2."<br>" ;
	mysql_select_db($db, $link);
$Recordset2 = mysql_query($str2, $link) or die(mysql_error());
//echo "(".$Recordset2."/".mysql_num_rows($Recordset2).")<br>"
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>補蚊機捕獲蚊子資料</title>
<link href="../webcss.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
include '../title.php';
?>
<input type ="button" onclick="history.back()" value="回到上一頁"></input>
<form id="form1" name="form1" method="POST">
  <table width="100%" border="1">
  
      <tr>
      <td width="200">Primary ID(主鍵)</td>
      <td width="800"><?php echo $row1['id']; ?></td>
    </tr>
  
    <tr>
      <td width="200">MAC(機器網路碼)</td>
      <td width="800"><?php echo $row1['mac']; ?></td>
    </tr>
    <tr>
      <td width="200">Device ID(機器代碼)</td>
      <td width="800"><?php echo $row1['deviceid']; ?></td>
    </tr>
    <tr>
      <td width="200">Device name(機器名稱)</td>
      <td width="800"><?php echo $row1['devicename']; ?></td>
    </tr>
    <tr>
      <td width="200">Address(裝機地址)</td>
      <td width="800"><?php echo $row1['deviceaddr']; ?></td>
    </tr>
    <tr>
      <td width="200">Latitude(緯度)</td>
      <td width="800"><?php echo $row1['latitude']; ?></td>
    </tr>
    <tr>
      <td width="200">Longitude(經度)</td>
      <td width="800"><?php echo $row1['longitude']; ?></td>
    </tr>
    <tr>
      <td width="200">Ares(區域)</td>
      <td width="800"><?php echo $row1['areaname']; ?>/<?php echo $row1['areaid']; ?></td>

    </tr>
    <tr>
      <td width="200"><a href="mosdevicelist.php" target="_self">Back(回上頁)</a></td>
      <td>&nbsp;</td>
    </tr>
  </table>
    <p></p>
    <table width="100%" border="1">
  <tr>
    <td><div align="center">Datetime<br>時間</div></td>
    <td><div align="center">Mac<br>網卡編號</div></td>
    <td><div align="center">Type<br>種類</div></td>
    <td><div align="center">Temperature<br>溫度</div></td>
    <td><div align="center">Humidity濕度</div></td>
    <td><div align="center">Carbon dioxide<br>二氧化碳</div></td>
  </tr>

	<?php 
		//  if($Recordset2 !==FALSE){
		     while($row2 = mysql_fetch_assoc($Recordset2)) 
			 {
				 if (trim($row2["type"]) =="AEDES")
				 {
					$str3 = sprintf("<tr BGColor='#FFCCFF'><td>%s</td><td>%s</td><td>%s</td><td>%f</td><td>%f</td><td>%f</td></tr>",$row2["datatime"],$row2["mac"],$row2["type"],$row2["temp"],$row2["humid"],$row2["co2"]) ;
					 
				 }
				 else
				 {
					$str3 = sprintf("<tr BGColor='#99CCFF'><td>%s</td><td>%s</td><td>%s</td><td>%f</td><td>%f</td><td>%f</td></tr>",$row2["datatime"],$row2["mac"],$row2["type"],$row2["temp"],$row2["humid"],$row2["co2"]) ;
					 
				 }
				 


				echo $str3 ;
		     }
		// }
      ?>
 
   </table>   
</form>

<?php
include '../footer.php';
?>
</body>
</html>
<?php
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
?>
