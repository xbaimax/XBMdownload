<?php
include "../mysql_xb/mysql.php";

if (isset($_COOKIE['xb_xkey'])) {
    $sql = "select * from admin";
    $nahida = $conn->query($sql);
    $my_sj = $nahida->fetch_all()[0];
    if ($_COOKIE['xb_xkey'] != $my_sj[1]) {
    die("<script>alert('请登录！'); window.location.replace('index.html');</script>");
    }

} else {
    die("<script>alert('请登录！'); window.location.replace('index.html');</script>");
}
?>

<?php
// 连接数据库
include "../mysql_xb/mysql.php";

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 接收POST数据
$username = $_POST['username'];
$xkey = $_POST['xkey'];

// 更新数据库
$sql = "UPDATE admin SET username='$username', xkey='$xkey' WHERE id=1";

if ($conn->query($sql) === TRUE) {
    echo "账号密码更新成功，请重新登录";
} else {
    echo "更新出错: " . $conn->error;
}

$conn->close();
?>