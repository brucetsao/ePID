

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="refresh" content="10">

<title>運用工業互聯網技術整合工廠既有控制器之系統開發</title>
<link href="./webcss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#PV {
	position: absolute;
	width: 201px;
	height: 70px;
	z-index: 1;
	left: 761px;
	top: 482px;
}
#SV {
	position: absolute;
	width: 165px;
	height: 52px;
	z-index: 1;
	left: 793px;
	top: 565px;
}
body {
	background-color: #FFF;
}
#myProgress {
  width: 100%;
  background-color: grey;
}

#myBar {
  width: 60%;
  height: 60px;
  background-color: green;
  text-align: center;
  line-height: 60px;
  color: white;
}
</style>
</head>

<body>
<?php
include 'title.php';
?>


<?php
   	include("comlib.php");		//使用資料庫的呼叫程式
   	include("./Connections/iotcnn.php");		//使用資料庫的呼叫程式
   	include("sysinit.php");		//使用資料庫的呼叫程式
		
	$link=Connection();		//產生mySQL連線物件
	
//	$pvvalue = 589.4 ;
//	$svvalue = 927.5 ;	

	$pvvalue = GetPV($devicemac,$deviceid,$link) ;
	$svvalue = GetSV($devicemac,$deviceid,$link) ;
//	$alarm = GetAlarm($devicemac,$deviceid,0,$link) ;
//	$alarmH = GetAlarm($devicemac,$deviceid,2,$link) ;
//	$alarmL = GetAlarm($devicemac,$deviceid,1,$link) ;
	
	$alarm = GetAlarm($devicemac,$deviceid,0,$link)  ;
	$alarmH = GetAlarm($devicemac,$deviceid,2,$link)  ;
	$alarmL = GetAlarm($devicemac,$deviceid,1,$link)  ;	
	
//	echo $pvvalue."<br> aaaa" ;

?>


<p>&nbsp;</p>
    <div  align="center">
      <table width="600" border="0" cellpadding="0" cellspacing="0" class="device">
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="128"><div align="right">PV</div></td>
          <td width="334"><div align="center"><?php echo PVShow($pvvalue,3).PVShow($pvvalue,2).PVShow($pvvalue,1).PVShow($pvvalue,0); ?></div></td>
          <td width="138">&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right">SV</div></td>
          <td><div align="center"><?php echo SVShow($svvalue,3).SVShow($svvalue,2).SVShow($svvalue,1).SVShow($svvalue,0); ?></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td rowspan="2"><div align="right">Alarm Value</div>            <div align="right"></div></td>
          <td><div align="center"><?php echo SVShow($alarmH,3).SVShow($alarmH,2).SVShow($alarmH,1).SVShow($alarmH,0); ?></div></td>
          <td rowspan="2"><img src='images/<?php echo(($alarm==1)?"alarnon.jpg":"alarnoff.jpg");?>' width="134" height="100" /></td>
        </tr>
        <tr>
          <td><div align="center"><?php  echo SVShow($alarmL,3).SVShow($alarmL,2).SVShow($alarmL,1).SVShow($alarmL,0); ?></div></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="128"><div align="left">PID</div></td>
          <td width="334"><div align="center"></div></td>
          <td width="138"><div align="right">FY900</div></td>
        </tr>
      </table>
</div>

<?php
include 'footer.php';
?>

</body>
</html>

