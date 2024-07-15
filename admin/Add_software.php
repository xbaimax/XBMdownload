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
include "../mysql_xb/mysql.php";

if (!file_exists("../mysql_xb/mysql.php")) {
    die("<script>alert('错误：不存在mysql.php');</script>");
}

// 检查数据库连接
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app_icon = @$_POST['app_icon'];
    $app_title = @$_POST['app_title'];
    $app_version = @$_POST['app_version'];
    $app_platform = @$_POST['app_platform'];
    $app_source_url = @$_POST['app_source_url'];
    $app_description = @$_POST['app_description'];
    $app_download_url = @$_POST['app_download_url'];

    // 使用预处理语句插入数据
    $stmt = $conn->prepare("INSERT INTO app_cards(app_title,app_icon,app_version,app_platform,app_source_url,app_description,app_download_url) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $app_title, $app_icon, $app_version, $app_platform, $app_source_url, $app_description, $app_download_url);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo '成功';
    } else {
        echo '失败';
    }
    $stmt->close();
} else {
    echo "未通过POST方法提交数据。";
}

$conn->close();
?>