<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>智慧农业后台管理</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<script type="text/javascript" src="js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="js/plugins/jquery.alerts.js"></script>
<script type="text/javascript" src="js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/custom/general.js"></script>
<script type="text/javascript" src="js/custom/messages.js"></script>


<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Nrv6Aexz3oDZvGGiGass5OVu"></script>
<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
	<script src="js/plugins/css3-mediaqueries.js"></script>
<![endif]-->
</head>
<body class="withvernav">
<div class="bodywrapper">
    
<?php
include("top.php")
?>
    
    
    <div class="header">
    	<ul class="headermenu">
        	<li ><a href="header_index.php"><span class="icon icon-flatscreen"></span>首页</a></li>
            <li><a href="header_control.php"><span class="icon icon-pencil"></span>设备</a></li>
            <li class="current"><a href="header_map.php"><span class="icon icon-message"></span>地图</a></li>
            <li><a href="header_manage.php"><span class="icon icon-chart"></span>配置</a></li>
        </ul>
        
        
        
    </div><!--header-->
    
    <div class="vernav iconmenu">
    	<ul>
        	<li class="current"><a href="header_map.php" class="inbox">路灯位置信息</a></li>
            
        </ul>
        <?php
       include("left.php");
       ?>
        <br /><br />
    </div><!--leftmenu-->
    
    <div class="centercontent">
    
        <div class="pageheader">
            <h1 class="pagetitle">路灯位置</h1>
           
            
            
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper">
             
          <div id="allmap1" style="width:100%;height:500px;"></div>
    
       </div><!--centercontent-->
    
    
</div><!--bodywrapper-->

</body>
</html>


 <script type="text/javascript">
     //  var map = new BMap.Map("allmap1",{mapType:BMAP_SATELLITE_MAP});
     //   map.enableScrollWheelZoom();//启动鼠标滚轮缩放地图
     // var point = new BMap.Point(120.915, 31.979);
     //  map.centerAndZoom(point, 15);
     //  var pathinfo=<?php // echo $pathinfo; ?>;
     //  var pathinfo=eval(pathinfo);
     //    var shipid=pathinfo[0]['shipid'];
     //    var temp=pathinfo[0]['temp'];
     //    var ph=pathinfo[0]['ph'];
     //    var oxy=pathinfo[0]['oxy'];
     //    var ggPoint = new BMap.Point(pathinfo[0]['lat'], pathinfo[0]['lon']);
     //    map.enableScrollWheelZoom();//启动鼠标滚轮缩放地图


    // 百度地图API功能120.915315,31.979608
    var map = new BMap.Map("allmap1",{mapType:BMAP_SATELLITE_MAP});
    map.enableScrollWheelZoom();//启动鼠标滚轮缩放地图
    var point = new BMap.Point(120.915, 31.979);
    map.centerAndZoom(point, 15);








    </script>
