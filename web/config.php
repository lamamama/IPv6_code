<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2017/7/13
 * Time: 19:48
 */
/*数据库连接文件*/
$servername='localhost';
$db_username='root';
$db_password='root';
$db_name='agriculture';
$conn = new mysqli($servername, $db_username, $db_password, $db_name);
mysqli_set_charset($conn,'utf8');
if ($conn->connect_error) {
    die("0 " . $conn->connect_error);
};

?>