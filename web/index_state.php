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
<script type="text/javascript" src="js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="js/plugins/charCount.js"></script>
<script type="text/javascript" src="js/plugins/ui.spinner.min.js"></script>
<script type="text/javascript" src="js/plugins/chosen.jquery.min.js"></script>

<script type="text/javascript" src="js/custom/forms.js"></script>

<script src="js/thumbnails.js" type="text/javascript"></script>
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
            <li class="current"><a href="index_state.php" class="editor">实时状态</a></li>
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
    
        <div class="pageheader notab">
            <h1 class="pagetitle">农业实时状态显示</h1>
            <span class="pagedesc">查询当前状态</span>
            
        </div><!--pageheader-->

     
      <div id="contentwrapper" class="contentwrapper">
        <div class="contenttitle2">
                    <h3>筛选条件</h3>
        </div><!--contenttitle-->
       
      <form method="post" action="index_state.php">
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
    <p>
    <select id="deng" name="deng">
    <option value="lamp">大棚编号</option>
   </select>
    </p>


    
         <p class="stdformbutton">
        <input type="submit" value='提交' name='button' class="submit radius2" />
        </p>

        

        </div>
        
    </form>
       
             


             
        
        </div><!--contentwrapper-->

      <div id="contentwrapper" class="contentwrapper">
        <div class="contenttitle2">
                    <h3>实时状态信息</h3>
        </div><!--contenttitle-->
             


             
                <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable2">
                    <colgroup>
                        <col class="con0" style="width: 4%" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr>
                          <th class="head0 nosort"><input type="checkbox" /></th>
                            <th class="head0">路灯ID</th>
                            <th class="head1">气压</th>
                            <th class="head0">温度</th>
                            <th class="head1">亮度</th>
                            <th class="head0">湿度</th>
                             <th class="head1">风向</th>
                            
                        </tr>
                    </thead>
                   
                    <tbody>
                       
                      <?php
                      include('config.php');
            $button=@$_POST['button'];
            if(!empty($button)){
                if(empty($_POST['sheng'])){
                    echo "<script> alert('error:请输入省!');</script>";

                };
                
                $deng=$_POST['deng'];
                
                

                $sql = "select lampid,atmos,temperature,light,windsp,winddr from data where lampid=$deng ;";
                $res1=mysqli_query($conn,$sql);

                
                while(@$result=mysqli_fetch_array($res1)){
                    ?>
                      <tr>
                        <td align="center"><input type="checkbox" /></td>
                       <td ><?=$result['lampid']?></td>
                       <td ><?=$result['atmos']?></td>
                       <td "><?=$result['temperature']?></td>
                       <td "><?=$result['light']?></td>
                          <td "><?=$result['windsp']?></td>
                          <td "><?=$result['winddr']?></td>
                          
                      </tr>
               <?php


                }
            }
?>
                        
                        
                      
                    </tbody>
                </table>
        
        </div><!--contentwrapper-->
        
    </div><!-- centercontent -->
    
    
</div><!--bodywrapper-->

</body>
</html>


