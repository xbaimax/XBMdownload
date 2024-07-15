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
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $delete_id = intval(@$_GET['id']);  // 获取要删除的软件ID

    include "../mysql_xb/mysql.php";

    // 使用预处理语句防止SQL注入
    $stmt = $conn->prepare("DELETE FROM app_cards WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "软件删除成功";
        header("Location: xb_panel_list.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "请求方法必须为GET";
}

$conn->close();
?>