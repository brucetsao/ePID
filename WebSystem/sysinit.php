


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