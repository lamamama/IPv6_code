<?php
//农业ipv6 socket联调测试；
//error_reporting( E_ALL );
set_time_limit( 0 );
ob_implicit_flush();
    $address = '2001:1::1863:a02b:202a:c901'; //服务端ip  
    $port = 8888;  


//创建socket：AF_INET=是ipv4 如果用ipv6，则参数为 AF_INET6 ， SOCK_STREAM为socket的tcp类型，如果是UDP则使用SOCK_DGRAM  
$socket = socket_create( AF_INET6, SOCK_DGRAM, SOL_UDP );
if ( $socket === false ) {
    echo "socket_create() failed:reason:" . socket_strerror( socket_last_error() ) . "\n";
}
$ok = socket_bind( $socket, $address, $port );
if ( $ok === false ) {
    echo "socket_bind() failed:reason:" . socket_strerror( socket_last_error( $socket ) );
}
echo "OK\nBinding the socket on $address:$port ...\n";  
    echo "OK\nNow ready to accept connections.\nListening on the socket ...\n";  

do {
    $from = "";
    $port = 0;
    socket_recvfrom( $socket, $buf,1024, 0, $from, $port );
    $showtime=date("Y-m-d H:i:s"); 
    echo "From Client  $from:$port ($showtime)\n"; 
    $receiv = bin2hex($buf);
    echo "Receive : {$receiv}\n"; 
    
   
    $i=0;
	$n=0;
	for($i=0;$i<8;$i++)
	{
	 $a[$i]=substr($receiv,$n,2);
	 $n=$n+2;
	}

	    $id0=$a[2]-30;
	    $id1=$a[3]-30;
        $id=$id0.$id1;
		// $test0=$a[4].$a[5];
		$tes0=$a[4]-30;
		$tes1=$a[5]-30;
        $test1=$tes0.$tes1;
  
        $tes2=$a[6]-30;
        $tes3=$a[7]-30;
        $test3=$tes2.$tes3;
  
		
        include("config.php");
        $insert = "insert into data (lpid,wendu,shidu,tim)VALUES($id,$test1,$test3,now())";

	    mysqli_query($conn,$insert);





        mysqli_close($conn);















   usleep( 1000 );
} while ($buf !== false);
?>