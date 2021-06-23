<?php 
   	include("../sysinit.php");		//使用系統初始化的呼叫程式
   	include("../comlib.php");		//使用共用函式庫程式
   	include("../Connections/iotcnn.php");		//使用資料庫的呼叫程式
		//	Connection() ;
   	
  	$link=Connection();		//產生mySQL連線物件


	$temp1=$_GET["MAC"];		//取得POST參數 : field1
	$temp1a=$_GET["id"];		//取得POST參數 : field1
	$temp2=$_GET["pv"];		//取得POST參數 : field2
	$temp3=$_GET["sv"];		//取得POST參數 : field3
	$dt =  getdataorder() ;	//取得POST參數 : field3
	
//INSERT INTO `pidController` (`id`, `MAC`, `did`, `crtdatetime`, `systime`, `PV`, `SV`) VALUES ('', 'AABBCCDDEEFF', '1', CURRENT_TIMESTAMP, '20200630203600', '22.4', '34.2');
//UPDATE `pidController` SET `PV` = '12' WHERE `pidController`.`id` = 1;
	$query = sprintf("select * from nukiot.pidController where MAC = '%s' and did = %d",$temp1,$temp1a)  ;
	echo $query ;
	echo "<br>" ;
    $result=mysql_query($query,$link);		//將dhtdata的資料找出來(只找最後5

	$num_rows = mysql_num_rows($result);
		echo "Count for select * from nukiot.pidController (".$num_rows.") <br>" ;
		
	if ( $num_rows == 0) 
	{
			$query1 = sprintf("insert into nukiot.pidController (MAC,did,systime,PV,PV) VALUES ('%s',%d,'%s',%f,%f )",$temp1,$temp1a,$dt,$temp2,$temp3 ); 
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		{
			$query1 = sprintf("update nukiot.pidController set PV = %f,  SV = %f  where id = %d ",$temp2,$temp3,$row['id'] ); 
		}
	}
	//組成新增到dhtdata資料表的SQL語法
//http://163.22.24.51:9999/dht/dataadd.php?MAC=AABBCCDDEEFF&t=23&h=98.6
// host is  ==>163.22.24.51:9999
//  app program is ==> /dht/dataadd.php
//  App parameters ==> ?MAC=aabbccddeeff&t=23&h=88


	echo $query1 ;
	echo "<br>" ;
    $result=mysql_query($query1,$link);		//將dhtdata的資料找出來(只找最後5

	if ($result)
		{
				echo "Successful <br>" ;
		}
		else
		{
				echo "Fail <br>" ;
		}
		
			;			//執行SQL語法
	echo "<br>" ;
	mysqli_close($link);		//關閉Query
 
	?> 
 
 
