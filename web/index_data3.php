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
 include("top.php");
?>
    
<?php
include("config.php");
$sql="select * from lamp";
$resu=mysqli_query($conn,$sql);


while(@$arr=mysqli_fetch_array($resu)){

    $lampid[]=$arr['lampid'];//查询小船id形成数组
}
?>




<script language="javascript">
    var obj =eval('<?php echo json_encode($lampid);?>');
    counts=obj.length;
    function Myselect(){
        var i;
        for (i=0;i < counts; i++) {
            document.form1.sel.options[i] = new Option(obj[i]);
        }
    }//select调用PHP内的数组函数
</script>
    
   


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
            <li class="current"><a href="index_data.php" class="elements">实时数据</a></li>
            <li><a href="index_query.php" class="widgets">信息查询</a></li>
        </ul>
        <?php
       include("left.php");
       ?>
        <br /><br />
    </div><!--leftmenu-->

 <div class="centercontent">
    <div class="pageheader">
        <h1 class="pagetitle">数据曲线图</h1>
       
        
        <ul class="hornav">
            <li ><a href="#charts">实时曲线</a></li>
            <li class="current"><a href="#statistics">历史曲线</a></li>
        </ul>
    </div><!--pageheader-->
    <div>
        <form name="form1" action="index_data3.php" method="GET" id="chanxun">
        大棚id<select type='text' name="lampid" id="sel"  onFocus="Myselect()"></select>
        从时间<input type='datetime-local' name='shijian1'/>
        到时间<input type='datetime-local' name='shijian2'/>
        <input type='submit' name='button' value='提交'/>



    </div>
    <?php

            $button=@$_GET['button'];
            if(!empty($button)){
                if(empty($_GET['lampid'])){
                    echo "<script> alert('error:请输入路灯ID!');</script>";

                };
                $lampid=@$_GET['lampid'];
                $time1=$_GET['shijian1'];
                $time2=$_GET['shijian2'];
                $shijian1=str_replace('T',' ',$time1);
                $shijian2=str_replace('T',' ',$time2);

                $sql = "select * from data where (tim between '$shijian1' and '$shijian2') and lampid=$lampid order by tim desc ;";
                $res=mysqli_query($conn,$sql);

               $temparr=array();

               while(@$result=mysqli_fetch_array($res)){

                   $atmosarr[]=array($result['tim'],$result['atmos']);
                   $wenduarr[]=array($result['tim'],$result['temperature']);
                   $lightarr[]=array($result['tim'],$result['light']);
                   $pmarr[]=array($result['tim'],$result['pm']);
                   $windsparr[]=array($result['tim'],$result['windsp']);
                   $windsuarr[]=array($result['tim'],$result['windsu']);
                 
               }


               $atmos='[';
               $length=
               count($atmosarr);
               for($i=0;$i<$length;$i++){
                   $time=strtotime($atmosarr[$i][0])*1000;
                   if($i<$length-1){
                       //拼接气压
                       $str1="[".$time.",".$atmosarr[$i][1]."],";
                       $atmos.=$str1;
                   }elseif($i==$length-1){
                       $str1="[".$time.",".$atmosarr[$i][1]."]]";
                       $atmos.=$str1;
                   }
               }


               $wendu='[';
               $length=
               count($wenduarr);
               for($i=0;$i<$length;$i++){
                   $time=strtotime($wenduarr[$i][0])*1000;
                   if($i<$length-1){
                       //拼接温度
                       $str1="[".$time.",".$wenduarr[$i][1]."],";
                       $wendu.=$str1;
                   }elseif($i==$length-1){
                       $str1="[".$time.",".$wenduarr[$i][1]."]]";
                       $wendu.=$str1;
                   }
               }


               $light='[';
               $length=
               count($lightarr);
               for($i=0;$i<$length;$i++){
                   $time=strtotime($lightarr[$i][0])*1000;
                   if($i<$length-1){
                       //拼接光照
                       $str1="[".$time.",".$lightarr[$i][1]."],";
                       $light.=$str1;
                   }elseif($i==$length-1){
                       $str1="[".$time.",".$lightarr[$i][1]."]]";
                       $light.=$str1;
                   }
               }


               $pm='[';
               $length=
               count($pmarr);
               for($i=0;$i<$length;$i++){
                   $time=strtotime($pmarr[$i][0])*1000;
                   if($i<$length-1){
                       //拼接pm
                       $str1="[".$time.",".$pmarr[$i][1]."],";
                       $pm.=$str1;
                   }elseif($i==$length-1){
                       $str1="[".$time.",".$pmarr[$i][1]."]]";
                       $pm.=$str1;
                   }
               }



               $windsp='[';
               $length=
               count($windsparr);
               for($i=0;$i<$length;$i++){
                   $time=strtotime($windsparr[$i][0])*1000;
                   if($i<$length-1){
                       //拼接风湿度
                       $str1="[".$time.",".$windsparr[$i][1]."],";
                       $windsp.=$str1;
                   }elseif($i==$length-1){
                       $str1="[".$time.",".$windsparr[$i][1]."]]";
                       $windsp.=$str1;
                   }
               }



               $windsu='[';
               $length=
               count($windsuarr);
               for($i=0;$i<$length;$i++){
                   $time=strtotime($windsuarr[$i][0])*1000;
                   if($i<$length-1){
                       //拼接风速
                       $str1="[".$time.",".$windsuarr[$i][1]."],";
                       $windsu.=$str1;
                   }elseif($i==$length-1){
                       $str1="[".$time.",".$windsuarr[$i][1]."]]";
                       $windsu.=$str1;
                   }
               }
          
















           }
           else{
               exit;
            }
           ?>
    <div class="contentwrapper">
    
        <div id="charts" class="subcontent">
        
            <div class="one_half">
                <div class="contenttitle2">
                    <h3>大气压力</h3>
                </div><!--contenttitle-->
                <br />
                <div id="container1" style="height:300px;"></div>
            </div><!--one_half-->
            
            <div class="one_half last">            
                <div class="contenttitle2">
                    <h3>温度</h3>
                </div><!--contenttitle-->
                <br />
                <div id="container2" style="height:300px;"></div>
            </div><!--one_half last-->
            
            <br clear="all" /><br />
            
            <div class="one_half">
                <div class="contenttitle2">
                    <h3>湿度</h3>
                </div><!--contenttitle-->
                <br />
                <div id="container3" style="height:300px;"></div>
                <br />
                
            </div><!--one_half-->
            
            <div class="one_half last">
                <div class="contenttitle2">
                    <h3>光照</h3>
                </div><!--contenttitle-->
                <br />
                <div id="container4" style="height: 300px;"></div>
            </div><!--one_half last-->

            <div class="one_half">
                <div class="contenttitle2">
                    <h3>PM2.5</h3>
                </div><!--contenttitle-->
                <br />
                <div id="container5" style="height:300px;"></div>
                <br />
                
            </div><!--one_half-->
            
            <div class="one_half last">
                <div class="contenttitle2">
                    <h3>风速值</h3>
                </div><!--contenttitle-->
                <br />
                <div id="container6" style="height: 300px;"></div>
            </div><!--one_half last-->
        
        <br clear="all" />
        
        </div><!--#charts-->

        

       









        </div>
        
        <div id="statistics" class="subcontent">
            &nbsp;
        </div><!--#statistics-->
        
    </div><!--contentwrapper-->
    
    
</div><!--bodywrapper-->
</div>

</body>
</html>



<script src="https://cdn.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>

<script src="https://cdn.hcharts.cn/highcharts/highcharts.js"></script>
 <script>
            




            $(function() {

                var atmos = eval(<?php echo $atmos; ?>);
                var wendu = eval(<?php echo $wendu; ?>);
                var light = eval(<?php echo $light; ?>);
                var pm = eval(<?php echo $pm; ?>);
                var windsp = eval(<?php echo $windsp; ?>);
                var windsu = eval(<?php echo $windsu; ?>);



                Highcharts.setOptions({
                    global: {
                        useUTC: false  //表示是使用本地时间而不是utc的标准时间。
                    }
                });
                  
                  chart1 = new Highcharts.Chart({  
                        chart: {  
                            renderTo: 'container1',
                            defaultSeriesType: 'spline',  
                            
                        },  
                        title:{  
                            text: '大气压力信息',  
                            x:-20  
                        },  
                        xAxis: {  
                            type: 'datetime',  
                            tickPixelInterval: 150,  
                            maxZoom: 20 * 1000  
      
                        },  
                        yAxis: {  
                            minPadding: 0.2,  
                            maxPadding: 0.2,  
                            
                        },  
                        tooltip: {  
                            formatter: function(){  
      
                                return Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '数值是：' + this.y;  
                            }  
                        },  
                        //本来下面是版权信息，我将它改成下载浏览器了，因为这个在XP下IE7，8无法运行  
                      
                        series: [{  
                            name: '压力值',  
                            data: atmos 
                        }]  
                    });  

                   chart2 = new Highcharts.Chart({  
                        chart: {  
                            renderTo: 'container2',
                            defaultSeriesType: 'spline',  
                              
                        },  
                        title:{  
                            text: '温度值信息',  
                            x:-20  
                        },  
                        xAxis: {  
                            type: 'datetime',  
                            tickPixelInterval: 150,  
                            maxZoom: 20 * 1000  
      
                        },  
                        yAxis: {  
                            minPadding: 0.2,  
                            maxPadding: 0.2,  
                            
                        },  
                        tooltip: {  
                            formatter: function(){  
      
                                return Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '数值是：' + this.y;  
                            }  
                        },  
                        //本来下面是版权信息，我将它改成下载浏览器了，因为这个在XP下IE7，8无法运行  
                      
                        series: [{  
                            name: '温度值',  
                            data: wendu 
                        }]  
                    });  
                   
                   chart3 = new Highcharts.Chart({  
                        chart: {  
                            renderTo: 'container3',
                            defaultSeriesType: 'spline',  
                            
                        },  
                        title:{  
                            text: '湿度值信息',  
                            x:-20  
                        },  
                        xAxis: {  
                            type: 'datetime',  
                            tickPixelInterval: 150,  
                            maxZoom: 20 * 1000  
      
                        },  
                        yAxis: {  
                            minPadding: 0.2,  
                            maxPadding: 0.2,  
                            
                        },  
                        tooltip: {  
                            formatter: function(){  
      
                                return Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '数值是：' + this.y;  
                            }  
                        },  
                        //本来下面是版权信息，我将它改成下载浏览器了，因为这个在XP下IE7，8无法运行  
                      
                        series: [{  
                            name: '湿度值',  
                            data: windsp 
                        }]  
                    });  

                   chart4 = new Highcharts.Chart({  
                        chart: {  
                            renderTo: 'container4',
                            defaultSeriesType: 'spline',  
                              
                        },  
                        title:{  
                            text: '光照强度信息',  
                            x:-20  
                        },  
                        xAxis: {  
                            type: 'datetime',  
                            tickPixelInterval: 150,  
                            maxZoom: 20 * 1000  
      
                        },  
                        yAxis: {  
                            minPadding: 0.2,  
                            maxPadding: 0.2,  
                            
                        },  
                        tooltip: {  
                            formatter: function(){  
      
                                return Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '数值是：' + this.y;  
                            }  
                        },  
                        //本来下面是版权信息，我将它改成下载浏览器了，因为这个在XP下IE7，8无法运行  
                      
                        series: [{  
                            name: '光照强度',  
                            data: light
                        }]  
                    });  
                        

                        chart5 = new Highcharts.Chart({  
                        chart: {  
                            renderTo: 'container5',
                            defaultSeriesType: 'spline',  
                             
                        },  
                        title:{  
                            text: 'PM2.5信息',  
                            x:-20  
                        },  
                        xAxis: {  
                            type: 'datetime',  
                            tickPixelInterval: 150,  
                            maxZoom: 20 * 1000  
      
                        },  
                        yAxis: {  
                            minPadding: 0.2,  
                            maxPadding: 0.2,  
                            
                        },  
                        tooltip: {  
                            formatter: function(){  
      
                                return Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '数值是：' + this.y;  
                            }  
                        },  
                        //本来下面是版权信息，我将它改成下载浏览器了，因为这个在XP下IE7，8无法运行  
                      
                        series: [{  
                            name: 'PM2.5值',  
                            data: pm
                        }]  
                    });  
                        chart6 = new Highcharts.Chart({  
                        chart: {  
                            renderTo: 'container6',
                            defaultSeriesType: 'spline',  
                            
                        },  
                        title:{  
                            text: '风速值信息',  
                            x:-20  
                        },  
                        xAxis: {  
                            type: 'datetime',  
                            tickPixelInterval: 150,  
                            maxZoom: 20 * 1000  
      
                        },  
                        yAxis: {  
                            minPadding: 0.2,  
                            maxPadding: 0.2,  
                            
                        },  
                        tooltip: {  
                            formatter: function(){  
      
                                return Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '数值是：' + this.y;  
                            }  
                        },  
                        //本来下面是版权信息，我将它改成下载浏览器了，因为这个在XP下IE7，8无法运行  
                      
                        series: [{  
                            name: '风值',  
                            data: windsu 
                        }]  
                    });  
                });  









            </script>




            <script>
                
            $(function() {

                var atmos = eval(<?php echo $atmos; ?>);



                Highcharts.setOptions({
                    global: {
                        useUTC: false  //表示是使用本地时间而不是utc的标准时间。
                    }
                });


                //温度图表代码

                chart1 = new Highcharts.Chart({
                    chart: {
                        zoomType: 'x',
                        renderTo: 'container1',
                        defaultSeriesType: 'spline',  //表示是一条曲线，表示点与点之间是通过曲线连在一起的。
                        marginRight: 10
                    },
                    credits: {
                        enabled: false // 去掉右下角的版权信息显示
                    },

                    title: {
                        text: '气压信息'
                    },
                    xAxis: {
                        title: {
                            text: '时间'
                        },
                        labels: {
                            formatter: function () {
                                return Highcharts.dateFormat('%m-%d日 %H时', this.value);
                            }
                        },

                        type: 'datetime'                 //设置y轴是时间类型

                    },

                    yAxis: {
                        title: {
                            text: '大气压'
                        },
                        labels: {
                            formatter: function () {
                                return this.value;
                            }
                        },
                        //指定y=3直线的样式,设置警戒线

                    },

                    //鼠标放在某个点上时的提示信息
                    //dateFormat,numberFormat是highCharts的工具类
                    tooltip: {
                        formatter: function () {
                            return "时间" +
                                Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' + "气压" +
                                Highcharts.numberFormat(this.y, 2);
                        }
                    },
                    //曲线的示例说明，像地图上得图标说明一样,即图例
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },
                    //把曲线图导出成图片等格式
                    exporting: {
                        enabled: true
                    },
                    //放入数据
                    series: [
                        {
                            name: '气压',
                            data: atmos         //这里是通过数组的形式，即（x,y)的形式描点赋值的。x为时间戳（单位毫秒）[[1,2],[1,2]]

                        }
                    ]
                });

            





            });




            </script>
           