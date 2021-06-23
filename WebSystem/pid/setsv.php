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
<title>Set PID Controller SV Value</title>
<link href="../webcss.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
include '../title.php';
?>
<input type ="button" onclick="history.back()" value="回到上一頁">
</input>
<form id="form1" name="form1" method="POST" action="savesv.php">
  <table width="100%" border="1">
    <tr>
      <td>PID Controller Device MAC Address
      <input name="textfield1" type="hidden" id="textfield1" value="<?php echo $mac; ?>" /></td>
      <td><? echo $mac ; ?></td>
   </tr>
       <tr>
      <td>Modbus Channel(通訊埠號碼)
        <input type="hidden" name="textfield2" id="textfield2" value="<?php echo $sid; ?>" /></td>
      <td><? echo $sid ; ?></td>
   </tr>    
    


    <tr>
      <td>SV Value(目標數值)</td>
      <td width="80%"><label for="textfield3"></label>
      <input name="textfield3" type="text" id="textfield3" size="8" maxlength="10" /></td>
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