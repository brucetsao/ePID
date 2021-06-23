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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_iot, $iot);
$query_Recordset1 = "select * from nukiot.site as a , nukiot.area as b where a.areaid = b.areaid  ORDER BY b.areaname DESC , a.siteid ASC ";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $iot) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
//echo $query_Recordset1."<br>" ;
if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<?php include("../Connections/iot.php");		//使用資料庫的呼叫程式式  ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pid Control Center</title>
<link href="../webcss.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function tfm_confirmLink(message) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
}
</script>
</head>

<body>
<?php
include '../title.php';
?>
<input type ="button" onclick="history.back()" value="BACK(回到上一頁)">
</input>
<form id="form1" name="form1" method="post" action="">
  <p>&nbsp;</p>
  <table width="100%" border="1">
    <tr>
      <td><div align="center">Location Area <br /> 管理區域</div></td>
      <td><div align="center">Device ID<br>裝置編號</div></td>
      <td><div align="center">MAC<br>網路卡編號</div></td>
      <td><div align="center">Device Name<br>裝置名稱</div></td>
      <td><div align="center">Address<br>裝置地址</div></td>
      <td><div align="center">Management<br>管理動作</div></td>
    </tr>

      <?php do { ?>
        <tr>
        <td><?php echo $row_Recordset1['areaname']."(".$row_Recordset1['areaid'].")"; ?></td>
        <td><?php echo $row_Recordset1['siteid']; ?></td>
        <td><?php echo $row_Recordset1['MAC']; ?></td>
        <td><?php echo $row_Recordset1['sitename']; ?></td>
        <td><?php echo $row_Recordset1['address']; ?></td>
         <td><a href="<?php echo sprintf("devicelist.php?sid=%d&MAC=%s",$row_Recordset1['id'],$row_Recordset1['MAC']); ?>" target="_self">Query subdevice(查詢子裝置)</a> / <a href="siteadd.php">Add(新增)</a> / <a href="siteedt.php?sid=<?php echo $row_Recordset1['id']; ?>" target="_self">Edit(修改)</a> / <a href="sitedel.php?sid=<?php echo $row_Recordset1['id']; ?>" onclick="tfm_confirmLink('確認要刪除這筆資料嗎????(刪除後無法還原歐)');return document.MM_returnValue">Delete(刪除)</a></td>
        </tr>
        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

  </table>
  <p align="center">&nbsp;<a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">FirstPage(第一頁)</a> / <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous(上一頁)</a> / <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next(下一頁)</a> / <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">LastPage(最後一頁)</a></p>

</form>

<?php
include '../footer.php';
?>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
