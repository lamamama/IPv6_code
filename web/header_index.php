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
<script type="text/javascript" src="js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.slimscroll.js"></script>
<script type="text/javascript" src="js/custom/general.js"></script>
<script type="text/javascript" src="js/custom/dashboard.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/plugins/excanvas.min.js"></script><![endif]-->
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
        	<li class="current"><a href="header_index.php"><span class="icon icon-flatscreen"></span>首页</a></li>
            <li><a href="header_control.php"><span class="icon icon-pencil"></span>设备</a></li>
            <li><a href="header_map.php"><span class="icon icon-message"></span>地图</a></li>
            <li><a href="header_manage.php"><span class="icon icon-chart"></span>配置</a></li>
        </ul>
    </div><!--header-->
    




     <div class="vernav2 iconmenu">
        <ul>
            <li><a href="index_state.php" class="editor">实时状态</a></li>
            <!--<li><a href="filemanager.html" class="gallery">文件管理</a></li>-->
            <li><a href="index_data.php" class="elements">实时数据</a></li>
            <li><a href="index_query.php" class="widgets">信息查询</a></li>
        </ul>
        <?php
       include("left.php");
       ?>
        <br /><br />
    </div><!--leftmenu-->
        
    






    <div class="centercontent">
    
        <div class="pageheader">
            <h1 class="pagetitle">控制台</h1>
           
            
           
        </div><!--pageheader-->
        
    
    
</div><!--bodywrapper-->

</body>
</html>
