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
<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/custom/general.js"></script>
<script type="text/javascript" src="js/custom/tables.js"></script>
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
 include("top.php");
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
            <li ><a href="index_data.php" class="elements">实时数据</a></li>
            <li class="current"><a href="index_query.php" class="widgets">信息查询</a></li>
        </ul>
        <?php
       include("left.php");
       ?>
        <br /><br />
    </div><!--leftmenu-->

 <div class="centercontent tables">
    
        <div class="pageheader notab">
            <h1 class="pagetitle">综合信息查询</h1>
        </div><!--pageheader-->


        <div id="contentwrapper" class="contentwrapper">
                        
              
              
                
                
                
          <div class="contenttitle2">
                    <h3>大棚综合信息采集表</h3>
                </div><!--contenttitle-->
                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable2">
                    <colgroup>
                        <col class="con0" style="width: 4%" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr>
                          <th class="head0 nosort"><input type="checkbox" /></th>
                            <th class="head0">省</th>
                            <th class="head1">市</th>
                            <th class="head0">区</th>
                            <th class="head1">街道</th>
                            <th class="head0">大气压</th>
                            <th class="head1">温度</th>
                            <th class="head0">湿度</th>
                            <th class="head1">光照</th>
                            <th class="head0">风速</th>
                            <th class="head1">风向</th>
                            <th class="head0">PM2.5</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                          <th class="head0"><span class="center">
                            <input type="checkbox" />
                          </span></th>
                          <th class="head0">省</th>
                            <th class="head1">市</th>
                            <th class="head0">区</th>
                            <th class="head1">街道</th>
                            <th class="head0">大气压</th>
                            <th class="head1">温度</th>
                            <th class="head0">湿度</th>
                            <th class="head1">光照</th>
                            <th class="head0">风速</th>
                            <th class="head1">风向</th>
                            <th class="head0">PM2.5</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        
                        <tr class="gradeA">
                          <td align="center"><span class="center">
                            <input type="checkbox" />
                          </span></td>
                            <td class="center">江苏省</td>
                            <td class="center">南通市</td>
                            <td class="center">崇川区</td>
                            <td class="center">啬园路</td>
                            <td class="center">4</td>
                            <td class="center">45</td>
                            <td class="center">75</td>
                            <td class="center">15</td>
                            <td class="center">东北</td>
                            <td class="center">4</td>
                            <td class="center">153</td>
                            
                           
                        </tr>
                         <tr class="gradeA">
                          <td align="center"><span class="center">
                            <input type="checkbox" />
                          </span></td>
                            <td class="center">江苏省</td>
                            <td class="center">南通市</td>
                            <td class="center">崇川区</td>
                            <td class="center">啬园路</td>
                            <td class="center">4</td>
                            <td class="center">45</td>
                            <td class="center">75</td>
                            <td class="center">15</td>
                            <td class="center">东北</td>
                            <td class="center">4</td>
                            <td class="center">153</td>
                            
                           
                        </tr>
                         <tr class="gradeA">
                          <td align="center"><span class="center">
                            <input type="checkbox" />
                          </span></td>
                            <td class="center">江苏省</td>
                            <td class="center">南通市</td>
                            <td class="center">崇川区</td>
                            <td class="center">啬园路</td>
                            <td class="center">4</td>
                            <td class="center">45</td>
                            <td class="center">75</td>
                            <td class="center">15</td>
                            <td class="center">东北</td>
                            <td class="center">4</td>
                            <td class="center">153</td>
                            
                           
                        </tr>
                         <tr class="gradeA">
                          <td align="center"><span class="center">
                            <input type="checkbox" />
                          </span></td>
                            <td class="center">江苏省</td>
                            <td class="center">南通市</td>
                            <td class="center">崇川区</td>
                            <td class="center">啬园路</td>
                            <td class="center">4</td>
                            <td class="center">45</td>
                            <td class="center">75</td>
                            <td class="center">15</td>
                            <td class="center">东北</td>
                            <td class="center">4</td>
                            <td class="center">153</td>
                            
                           
                        </tr>
                         <tr class="gradeA">
                          <td align="center"><span class="center">
                            <input type="checkbox" />
                          </span></td>
                            <td class="center">江苏省</td>
                            <td class="center">南通市</td>
                            <td class="center">崇川区</td>
                            <td class="center">啬园路</td>
                            <td class="center">4</td>
                            <td class="center">45</td>
                            <td class="center">75</td>
                            <td class="center">15</td>
                            <td class="center">东北</td>
                            <td class="center">4</td>
                            <td class="center">153</td>
                            
                           
                        </tr>
                         <tr class="gradeA">
                          <td align="center"><span class="center">
                            <input type="checkbox" />
                          </span></td>
                            <td class="center">江苏省</td>
                            <td class="center">南通市</td>
                            <td class="center">崇川区</td>
                            <td class="center">啬园路</td>
                            <td class="center">4</td>
                            <td class="center">45</td>
                            <td class="center">75</td>
                            <td class="center">15</td>
                            <td class="center">东北</td>
                            <td class="center">4</td>
                            <td class="center">153</td>
                            
                           
                        </tr>
                         <tr class="gradeA">
                          <td align="center"><span class="center">
                            <input type="checkbox" />
                          </span></td>
                            <td class="center">江苏省</td>
                            <td class="center">南通市</td>
                            <td class="center">崇川区</td>
                            <td class="center">啬园路</td>
                            <td class="center">4</td>
                            <td class="center">45</td>
                            <td class="center">75</td>
                            <td class="center">15</td>
                            <td class="center">东北</td>
                            <td class="center">4</td>
                            <td class="center">153</td>
                            
                           
                        </tr>
                         <tr class="gradeA">
                          <td align="center"><span class="center">
                            <input type="checkbox" />
                          </span></td>
                            <td class="center">江苏省</td>
                            <td class="center">南通市</td>
                            <td class="center">崇川区</td>
                            <td class="center">啬园路</td>
                            <td class="center">4</td>
                            <td class="center">45</td>
                            <td class="center">75</td>
                            <td class="center">15</td>
                            <td class="center">东北</td>
                            <td class="center">4</td>
                            <td class="center">153</td>
                            
                           
                        </tr>
                    </tbody>
                </table>
        
        </div><!--contentwrapper-->
        
    </div><!-- centercontent -->
    
    
</div><!--bodywrapper-->

</body>
</html>
