<?php
// 连接到MySQL数据库
$servername = "localhost";  // 数据库地址（本地数据库，一般不用改）
$username = "your_username";    // 数据库用户名
$password = "your_password";    // 数据库密码
$dbname = "your_dbname";    // 数据库名

$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$conn->set_charset("utf8"); // 设置字符集
?>