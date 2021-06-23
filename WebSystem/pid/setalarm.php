<?php 

	$sid=$_GET["SID"];		//取得POST參數 : field1
	$mac=$_GET["MAC"];		//取得POST參數 : field1

	   	include("../comlib.php");		//使用資料庫的呼叫程式
   	include("../Connections/iotcnn.php");		//使用資料庫的呼叫程式
   	include("../sysinit.php");		//使用資料庫的呼叫程式
		
	$link=Connection();		//產生mySQL連線物件
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Set PID Controller Alarm Value</title>
<link href="../webcss.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
include '../title.php';
?>
<?php
   	include("comlib.php");		//使用資料庫的呼叫程式
   	include("./Connections/iotcnn.php");		//使用資料庫的呼叫程式
   	include("sysinit.php");		//使用資料庫的呼叫程式
		
	$link=Connection();		//產生mySQL連線物件
	
//	$pvvalue = 589.4 ;
//	$svvalue = 927.5 ;	


	$alarm = GetAlarm($devicemac,$deviceid,0,$link)  ;
	$alarmH = GetAlarm($devicemac,$deviceid,2,$link)  ;
	$alarmL = GetAlarm($devicemac,$deviceid,1,$link)  ;	
	
//	echo $pvvalue."<br> aaaa" ;

?>
<input type ="button" onclick="history.back()" value="回到上一頁">
</input>
<form id="form1" name="form1" method="POST" action="savealarm.php">
  <table width="100%" border="1">
    <tr>
      <td>PID Controller Device MAC Address
      <input name="textfield1" type="hidden" id="textfield1" value="<?php echo $mac; ?>" /></td>
      <td width="80%"><? echo $mac ; ?></td>
   </tr>
       <tr>
      <td>Modbus Channel(通訊埠號碼)
        <input type="hidden" name="textfield2" id="textfield2" value="<?php echo $sid; ?>" /></td>
      <td><? echo $sid ; ?></td>
   </tr>    
    


    <tr>
         <td>Ser Alarm On(啟動警示)</td>
      <td><label for="select"></label>
        <select name="select" size="1" id="select">
          <option value="1">Active On</option>
          <option value="0">Active Off</option>
      </select>
        Status[<?php echo(($alarm==1)?"On(啟動中)":"Off(關閉中)");?>]</td>
    </tr>
    <tr>
         <td>Ser Alarm UpperBound Value(警示上界值)</td>
      <td><label for="textfield3"></label>
        <input name="textfield3" type="text" id="textfield3" value="<?php echo $alarmH; ?>" size="10" maxlength="16" /></td>
    </tr>
    <tr>
         <td>Ser Alarm LowerBound Value(警示下界值)</td>
      <td><label for="textfield4"></label>
        <input name="textfield4" type="text" id="textfield4" value="<?php echo $alarmL; ?>"  size="10" maxlength="12" /></td>
    </tr>

    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Submit(送出)" /></td>
    </tr>
  </table>
  <p>
  <input type="hidden" name="MM_update" value="form1" />
</p>
</form>

<?php
include '../footer.php';
?>
</body>
</html>