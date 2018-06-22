<?php
// $mbip="192.168.181.1";
$mbdk=8080;
// $msg="A1 58 01 08 00 DC B9";
include("config.php");
$button1=@$_POST['button1'];
$button2=@$_POST['button2'];
$roadid=@$_POST['lu'];
 if(!empty($button1)){
    $flag=1;
                }
  else{$flag=0;}
  if(!empty($button1)){
    $flag=0;
                }
  else{$flag=1;}




$flag=1;
$roadid='1010101';
$sql="select * from lamp where roadid=$roadid";
$i=0;
$rs=mysqli_query($conn,$sql);
   while ($arr=mysqli_fetch_array($rs)) {
        $road[$i]=$arr["lampip"];
        $i++;
}





function sendcommand($mbip,$mbdk,$msg){
$fp=fsockopen($mbip,$mbdk);     //打开数据流 
if(!$fp)           //如果打开出错 
{ 
  echo "unable to openn";       //输出内容 
} 
else            //如果成功打开 
{ 
  // $msg="A1 58 01 08 00 DC B9";
  $msgArray = str_split(str_replace(' ', '', $msg), 2);  //拆分数组
  $msg1="";
  for ($j = 0; $j < count($msgArray); $j++)   
  {
 	$msg1=$msg1. chr(hexdec($msgArray[$j]));    // 合并16进制
     //socket_write($msgsock, chr(hexdec($msgArray[$j])));  // 逐组数据发送
  }
  fwrite($fp,$msg1);     //向数据流写入内容 
  stream_set_timeout($fp,1);       //进行超时设置 
  $res=fread($fp,2000);        //读取内容 
  $info=stream_get_meta_data($fp);      //获取数据流报头 
  fclose($fp);          //关闭数据流 
  if($info['timed_out'])        //如果超时 
  { 
    echo 'connection timed out!';      //输出内容 
  } 
  else 
  { 
    echo $res;          //输出读取内容 
  } 
}
}

if($flag==1){
$j=0;
for($j=0;$j<count($road);$j++){
$msg="A1 58 01 02 05 01 01 01 01 01 F3 76";
$mbdk=8080;



//$mbip=$road[$j];
sendcommand($road[$j],$mbdk,$msg);
}
}


if($flag==0){
$j=0;
for($j=0;$j<count($road);$j++){
$msg="A1 58 01 02 05 02 02 02 02 02 07 C3";
$mbdk=8080;
sendcommand($road[$j],$mbdk,$msg);
}
}



?>