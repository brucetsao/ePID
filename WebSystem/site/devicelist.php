
<?php
 
   	include("../comlib.php");		//使用資料庫的呼叫程式
   	include("../Connections/iotcnn.php");		//使用資料庫的呼叫程式
		//	Connection() ;
  	$link=Connection();		//產生mySQL連線物件

	$sid=$_GET["sid"];		//取得POST參數 : field1
	$mac=$_GET["MAC"];		//取得POST參數 : field1

	$qrystr=sprintf("select a.* , b.sname , b.ename from nukiot.sitelist as a,nukiot.sensortype as b  where a.id = %d and a.sensortype = b.sid order by Did asc ",$sid) ;		//將dhtdata的資料找出來

	$d01 = array();	// declare blank array of d01
	$d02 = array();	// declare blank array of d02
	$d03 = array();	// declare blank array of d03
	$d04 = array();	// declare blank array of d04
	$d05 = array();	// declare blank array of d05
	
	$result=mysql_query($qrystr,$link);		//將dhtdata的資料找出來(只找最後5

  if($result!==FALSE){
	 while($row = mysql_fetch_array($result)) 
	 {
			array_push($d01, $row["Did"]);	// array_push(某個陣列名稱,加入的陣列的內容
			array_push($d02, $row["model"]);
			array_push($d03, $row["sensortype"]);
			array_push($d04, $row["sname"]);
			array_push($d05, $row["ename"]);
			array_push($d06, $row["ps"]);
		}// 會跳下一列資料

  }
			
	
	 mysql_free_result($result);	// 關閉資料集
 
	 mysql_close($link);		// 關閉連線





?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Temperature and Humidity Device (Home Use) List</title>
<link href="webcss.css" rel="stylesheet" type="text/css" />

</head>
<body>
<?php
include '../title.php';
?>
<input type ="button" onclick="history.back()" value="BACK(回到上一頁)">
</input>
  <div align="center">
   <table border="1" align = center cellspacing="1" cellpadding="1">		
		<tr>
			<td>SubDevice ID(子機編號)</td>
			<td>Model Name & Type & Model(控制器名稱/種類/型號)</td>
			<td>Sensor ID(感測器代碼)</td>
			<td>Sensor Name(感測器名稱)</td>
			<td>Sensor Englisg Name(感測英文器名稱)</td>
			<td>PS(備註)</td>
			<td><a href='<?php echo sprintf("subdeviceadd.php?sid=%d&MAC=%s",$sid,$mac); ?>'>Management</a></td>
		</tr>

      <?php 
		  if(count($d00) >0)
		  {
				for($i=count($d00)-1;$i >=0  ;$i=$i-1)
					{
						echo sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href='subdevicelistadd.php'>Device Belong/</a><a href='ShowChartlist.php?mac=%s'>Curve Chart</a>/<a href='ShowSingleGuage.php?mac=%s'>Guage Chart</a></td></tr>", $d01[$i], $d02[$i], $d03[$i], $d04[$i], $d05[$i], $d06[$i]);
					 }
		 }
      ?>

   </table>

</div>

</form>
<?php
include '../footer.php';
?>

</body>
</html>
