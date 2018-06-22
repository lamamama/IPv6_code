<?php
header("Content-Type: text/html; charset=utf-8");
//    $conn->Open($connstr); //建立数据库连接
include ("config.php");
//$sqlstr = "select name from Province"; //设置查询字符串
//$rs=mysqli_query($conn,$sqlstr);
//while ($arr=mysqli_fetch_array($rs)) {
//    echo $Province=$arr["name"].",";
//}
//
//
//$rs = null;
//$arr=null;



//
//$sqlstr = "select name from County where cid=101"; //设置查询字符串
//$rs = mysqli_query($conn,$sqlstr);
//while ($arr=mysqli_fetch_array($rs)) {
//    echo $County=$arr["name"].",";
//}
//$arr=null;
$sqlstr = "select lampid from lamp where cid=1010101"; //设置查询字符串
$rs = mysqli_query($conn,$sqlstr);
while ($arr=mysqli_fetch_array($rs)) {
    echo $County=$arr["lampid"].",";
}
$arr=null;

?>