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
<script type="text/javascript" src="js/custom/blog.js"></script>
<script src="js/thumbnails.js" type="text/javascript"></script>
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
            <li class="current"><a href="header_control.php"><span class="icon icon-pencil"></span>设备</a></li>
            <li><a href="header_map.php"><span class="icon icon-message"></span>地图</a></li>
            <li><a href="header_manage.php"><span class="icon icon-chart"></span>配置</a></li>
        </ul>
    </div><!--header-->


    
    <div class="vernav">
    	<ul>
        	<li class="current"><a href="control_lamp.php" class="editor">路灯控制</a></li>
            <li><a href="control_led.php">LED控制</a></li>
            <li><a href="control_video.php">视频监控</a></li>
           
        </ul>

       <?php
       include("left.php");
       ?>
   
    </div><!--leftmenu-->
    
   





    <div class="centercontent">
    
        <div class="pageheader">
            <h1 class="pagetitle">路灯控制</h1>
            
            
           
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper">

    
<form method="post" action="12.php">
        <div id="description">
            <p>
        <select style="width:100px; " onchange="sech(this.id)" id="sheng" name="sheng">
           <option value="province">请选择省份</option>
        </select>
    </p>
    <p>
        <select onchange="sech(this.id)" id="shi" name="shi">
        <option value="city">请选择市区</option>
        </select>
    </p>
    <p>


        <select onchange="sech(this.id)" id="xian" name="xian">
        <option value="county">请选择县乡</option>
        </select>
    </p>
    <p>

        <select onchange="sech(this.id)" id="lu" name="lu">
            <option value="road">请选择街道</option>
        </select>
    </p>
   


    
         <p class="stdformbutton">
        <input type="submit" value='开' name='button1' class="stdbtn btn_blue" />
         <input type="submit" value='关' name='button2' class="stdbtn btn_red" />
        </p>

        

        </div>
        
    </form>


   
             
        </div><!--contentwrapper-->
    
    </div><!--centercontent-->
    
    
</div><!--bodywrapper-->

</body>
</html>
