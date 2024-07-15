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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $update_id = intval(@$_POST['id']);  // 获取要更新的软件ID
    $app_icon = @$_POST['app_icon'];    // 获取图标URL
    $app_title = @$_POST['app_title'];  // 获取软件标题
    $app_version = @$_POST['app_version'];  // 获取软件版本
    $app_platform = @$_POST['app_platform'];    // 获取软件平台
    $app_source_url = @$_POST['app_source_url'];    // 获取相关链接
    $app_description = @$_POST['app_description'];  // 获取软件描述
    $app_download_url = @$_POST['app_download_url'];    // 获取软件下载链接

    // 使用预处理语句防止SQL注入
    $stmt = $conn->prepare("UPDATE app_cards SET app_icon=?, app_title=?, app_version=?, app_platform=?, app_source_url=?, app_description=?, app_download_url=? WHERE id=?");
    $stmt->bind_param("sssssssi", $app_icon, $app_title, $app_version, $app_platform, $app_source_url, $app_description, $app_download_url, $update_id);

    if ($stmt->execute()) {
        echo "软件信息更新成功";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "请求方法必须为POST";
}

$conn->close();
?>