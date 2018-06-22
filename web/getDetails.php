<?php
header("Content-Type: text/html; charset=utf-8");
include ("config.php");
if($_GET['ID']==0){//获得省列表

    $sqlstr = "select name from Province"; //设置查询字符串
    $rs=mysqli_query($conn,$sqlstr);
    while ($arr=mysqli_fetch_array($rs)) {
        echo $Province=$arr["name"].",";

    }
    $arr=null;
}

if($_GET['ID']>0&&$_GET['ID']<35){//获得省对应的市列表

    $sqlstr = "select name from City where provinceid =".$_GET['ID']; //设置查询字符串
    $rs = mysqli_query($conn,$sqlstr);
    while ($arr=mysqli_fetch_array($rs)) {
        echo $City=$arr["name"].",";
    }
    $arr=null;
}

if($_GET['ID']>100&&$_GET['ID']<4000){//获得省市对应的县列表

    $sqlstr = "select name from County where cityid=".$_GET['ID']; //设置查询字符串
    $rs = mysqli_query($conn,$sqlstr);
    while ($arr=mysqli_fetch_array($rs)) {
        echo $County=$arr["name"].",";
    }
    $arr=null;
}

if($_GET['ID']>10100&&$_GET['ID']<1010100){//县对应路

    $sqlstr = "select name from road where countyid=".$_GET['ID']; //设置查询字符串
    $rs = mysqli_query($conn,$sqlstr);
    while ($arr=mysqli_fetch_array($rs)) {
        echo $Road=$arr["name"].",";
    }
    $arr=null;
}


if($_GET['ID']>1010100){//路对应灯
//    $sqlstr = "select lampid from lamp where cid=1010101";
$sqlstr = "select lampid from lamp where roadid=".$_GET['ID']; //设置查询字符串
$rs = mysqli_query($conn,$sqlstr);
while ($arr=mysqli_fetch_array($rs)) {
echo $County=$arr["lampid"].",";
}
$arr=null;
}
?>