<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2017/11/30
 * Time: 19:39
 */

include("config.php");
//每次只需要读出一个最新的数据


$sql = "select tim,pm from data where lampid=1010101001 order by tim desc limit 1";
$res=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($res);

$tim = strtotime($row['tim']);

$rzH = strftime('%H',$tim);
//echo $rzH."\n";
$rzM = strftime('%M',$tim);
// echo $rzM."\n";
$rzS = strftime('%S',$tim);
// echo $rzS."\n";
$rzmonth = strftime('%m',$tim);
// echo $rzmonth."\n";
$rzD = strftime('%d',$tim);
// echo $rzD."\n";
$rzY = strftime('%Y',$tim);
// echo $rzY."\n";
//将时间转换为时间戳
$jsonArray = array(mktime($rzH,$rzM,$rzS,$rzmonth,$rzD,$rzY)*1000,round($row['pm'],3));



//文件输出为设置为 JSON
header('Content-type: text/json');
echo json_encode($jsonArray);
?>