<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    setcookie("xb_xkey", "小白", time() - 21600, '/');
    $xusername = @$_POST['username'];
    $xkey = @$_POST['xkey'];
    include "../mysql_xb/mysql.php";
    $xusername = mysqli_real_escape_string($conn, $xusername);
    $xkey = mysqli_real_escape_string($conn, $xkey);

    $sql = "SELECT * FROM admin";
    $xbadmin = $conn->query($sql);
    $my_sj = $xbadmin->fetch_assoc();

    if ($my_sj['username'] === $xusername && $my_sj['xkey'] === $xkey) {
        setcookie("xb_xkey", $xkey, time() + 21600, '/');
        echo "<script>window.location.replace('xb_panel.php');</script>";
    } else {
        die("<script>alert('账号或密码错误！'); window.location.replace('index.html');</script>");
    }
} else {
    echo "未通过POST方法提交数据。";
}
$conn->close();
?>