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
<script type="text/javascript" src="js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="js/custom/general.js"></script>
<script type="text/javascript" src="js/custom/charts.js"></script>
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
        	<li ><a href="header_index.php"><span class="icon icon-flatscreen"></span>首页</a></li>
            <li><a href="header_control.php"><span class="icon icon-pencil"></span>设备</a></li>
            <li><a href="header_map.php"><span class="icon icon-message"></span>地图</a></li>
            <li class="current"><a href="header_manage.php"><span class="icon icon-chart"></span>配置</a></li>
        </ul>
        
       
        
    </div><!--header-->


    <div class="vernav iconmenu">
        <ul>
            <li><a href="header_manage.php" class="inbox">路灯绑定</a></li>
             <li><a href="manage_led.php" class="inbox">LED绑定</a></li>
              <li class="current"><a href="manage_video.php" class="inbox">监控绑定</a></li>
               <li><a href="manage_user.php" class="inbox">用户管理</a></li>
            
        </ul>
        <?php
       include("left.php");
       ?>
        <br /><br />
    </div><!--leftmenu-->


    <div class="centercontent">
    <div class="pageheader">
        <h1 class="pagetitle">Reports</h1>
        <span class="pagedesc">An example of graphs &amp; charts. A page without left menu.</span>
        
        <ul class="hornav">
            <li class="current"><a href="#charts">Charts</a></li>
            <li><a href="#statistics">Statistics</a></li>
        </ul>
    </div><!--pageheader-->
    
    <div class="contentwrapper">
    
        <div id="charts" class="subcontent">
        
            <div class="one_half">
                <div class="contenttitle2">
                    <h3>Simple Chart</h3>
                </div><!--contenttitle-->
                <br />
                <div id="chartplace" style="height:300px;"></div>
            </div><!--one_half-->
            
            <div class="one_half last">            
                <div class="contenttitle2">
                    <h3>Bar Graph</h3>
                </div><!--contenttitle-->
                <br />
                <div id="bargraph" style="height:300px;"></div>
            </div><!--one_half last-->
            
            <br clear="all" /><br />
            
            <div class="one_half">
                <div class="contenttitle2">
                    <h3>Real Time Chart</h3>
                </div><!--contenttitle-->
                <br />
                <div id="realtime" style="height:300px;"></div>
                <br />
                <small>You can update a chart periodically to get a real-time effect by using a timer to insert the new data in the plot and redraw it.</small>
            </div><!--one_half-->
            
            <div class="one_half last">
                <div class="contenttitle2">
                    <h3>Pie Chart</h3>
                </div><!--contenttitle-->
                <br />
                <div id="piechart" style="height: 300px;"></div>
            </div><!--one_half last-->
        
        <br clear="all" />
        
        </div><!--#charts-->
        
        <div id="statistics" class="subcontent">
            &nbsp;
        </div><!--#statistics-->
        
    </div><!--contentwrapper-->
    
    
</div><!--bodywrapper-->
</div>

</body>
</html>
