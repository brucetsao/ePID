<?php 
	$devicemac= "CC50E3B6B808" ;
	
	$deviceid = 1 ;
	$pvvalue = 0.0 ;
	$svvalue= 0.0 ;
	$alarm = 0 ;
	$alarmH = 0.0 ;
	$alarmL = 0.0 ;		
?>
<?php
   	include("comlib.php");		//使用資料庫的呼叫程式
   	include("./Connections/iotcnn.php");		//使用資料庫的呼叫程式
		//使用資料庫的呼叫程式
		
	$link=Connection();		//產生mySQL連線物件
?>

<?php

	//	echo $devicemac."<br> 111" ;
	//	echo $deviceid."<br> 112" ;
	//	echo $pvvalue."<br> 113" ;	
	//	echo $svvalue."<br> 114" ;			link


?>

<?php

	//	echo $devicemac."<br> 111" ;
	//	echo $deviceid."<br> 112" ;
	//	echo $pvvalue."<br> 113" ;	
	//	echo $svvalue."<br> 114" ;			

	function GetAlarm($mm,$dd,$para,$ln)
	{
		$tmp = 0.0 ;
	
		$qrystr = sprintf("select * from nukiot.pidController where Mac = '%s' and did = %d", $mm,$dd) ;
		$result=mysql_query($qrystr,$ln);		//將dhtdata的資料找出來(只找最後5
		  if($result!==FALSE)
		  {
			 while($row = mysql_fetch_array($result)) 
			 {
				switch ($para)
				{
					case 0:	 
						$tmp = $row["AL1Flag"] ;
						break;
					case 1:	 
						$tmp = $row["AL1L"] ;
						break;
					case 2:	 
						$tmp = $row["ALT1H"] ;
						break;
					default:
						$tmp = 0;
						break;					
				}
				//echo $row["PV"]."<br> GET" ;
			//	$svvalue = $row["SV"] ;
				 mysql_free_result($result);	// 關閉資料集
				 return $tmp ;
			 }
		 }
				 mysql_free_result($result);	// 關閉資料集		 
		return $tmp ;
	}

	function GetPV($mm,$dd,$ln)
	{
		$tmp = 0.0 ;
	
		$qrystr = sprintf("select * from nukiot.pidController where Mac = '%s' and did = %d", $mm,$dd) ;
				echo "(".$qrystr.")"."<br>" ;
		$result=mysql_query($qrystr,$ln);		//將dhtdata的資料找出來(只找最後5
		  if($result!==FALSE)
		  {
			 while($row = mysql_fetch_array($result)) 
			 {
				$tmp = $row["PV"] ;
				//echo $row["PV"]."<br> GET" ;
			//	$svvalue = $row["SV"] ;
				 mysql_free_result($result);	// 關閉資料集
				 return $tmp ;
			 }
		 }
				 mysql_free_result($result);	// 關閉資料集		 
		return $tmp ;
	}
	
	
	function GetSV($mm,$dd,$ln)
	{
		$tmp = 0.0 ;
	
		$qrystr = sprintf("select * from nukiot.pidController where Mac = '%s' and did = %d", $mm,$dd) ;
		echo "(".$qrystr.")"."<br>" ;
		$result=mysql_query($qrystr,$ln);		//將dhtdata的資料找出來(只找最後5
		  if($result!==FALSE)
		  {
			 while($row = mysql_fetch_array($result)) 
			 {
				$tmp = $row["SV"] ;
				//echo $row["PV"]."<br> GET" ;
			//	$svvalue = $row["SV"] ;
				 mysql_free_result($result);	// 關閉資料集
				 return $tmp ;
			 }
		 }
				 mysql_free_result($result);	// 關閉資料集		 
		return $tmp ;
	}
	

	function PVShow($pvalue, $pos)
	{
		$nu = 0 ;
		if ($pos == 0) 
			{
				$nu = (int)($pvalue *10) % 10 ;
			}
			else if ($pos == 1) 
			{
				$nu = (int)$pvalue % 10 ;
			}
			else if ($pos == 2) 
			{
				$nu = (int)($pvalue/10)  % 10 ;
			}
			else if ($pos == 3) 
			{
				$nu = (int)($pvalue/100)  % 10 ;
			}

	if ($pos == 1)
		{
			return sprintf("<img src='images/p%1dd.jpg' />",$nu) ;
		}
		else
		{
			return sprintf("<img src='images/p%1d.jpg' />",$nu) ;
		}
		
	}


	function SVShow($pvalue, $pos)
	{
		$nu = 0 ;
		if ($pos == 0) 
			{
				$nu = (int)($pvalue *10) % 10 ;
			}
			else if ($pos == 1) 
			{
				$nu = (int)$pvalue % 10 ;
			}
			else if ($pos == 2) 
			{
				$nu = (int)($pvalue/10)  % 10 ;
			}
			else if ($pos == 3) 
			{
				$nu = (int)($pvalue/100)  % 10 ;
			}

	if ($pos == 1)
		{
			return sprintf("<img src='images/s%1dd.jpg' />",$nu) ;
		}
		else
		{
			return sprintf("<img src='images/s%1d.jpg' />",$nu) ;
		}
		
	}	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="refresh" content="10">

<title>1111111111111111運用工業互聯網技術整合工廠既有控制器之系統開發</title>
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


<?php

include 'title.php';
	echo "aaaaaaaaaaaaaaaaa"."<br>"  ; ;
?>


<?php

		echo "ddddddddddddddddd"."<br>"  ;
//	$pvvalue = 589.4 ;
//	$svvalue = 927.5 ;	

	$pvvalue = GetPV($devicemac,$deviceid,$link) ;
		echo "22222222222222"."<br>"  ; 
	$svvalue = GetSV($devicemac,$deviceid,$link) ;
			echo "3333333333333333333333" ;
//	$alarm = GetAlarm($devicemac,$deviceid,0,$link) ;
//	$alarmH = GetAlarm($devicemac,$deviceid,2,$link) ;
//	$alarmL = GetAlarm($devicemac,$deviceid,1,$link) ;
	
	$alarm = 1 ;
	$alarmH = 1 ;
	$alarmL = 1 ;	
	echo $pvvalue."<br>"  ; 
	echo $svvalue."<br>"  ; 
//	echo $pvvalue."<br> aaaa" ;

?>

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

</body>
</html>




