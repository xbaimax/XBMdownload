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

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>编辑实例-软麟panel</title>
		<link type="image/x-icon" rel="shortcut icon" href="../img/logo.jpg">
		<link rel="stylesheet" type="text/css" href="../css/software_list.css">
		<style>
			#shadow2 {
				/*display:none;*/
				position: absolute;
				width: 100%;
				height: 100%;
				background-color:none;
			}
		</style>
	</head>
	<body>
    <?php
        include "../mysql_xb/mysql.php"; // 包含数据库连接脚本

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT app_icon, app_title, app_version, app_platform, app_source_url, app_description, app_download_url, id AS update_id FROM app_cards WHERE id = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('i', $id); // 'i' 表示参数类型为整数
                $stmt->execute(); // 执行预处理语句
                $stmt->store_result(); // 存储结果集元数据

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($app_icon, $app_title, $app_version, $app_platform, $app_source_url, $app_description, $app_download_url, $update_id);
                    $stmt->fetch(); // 获取结果集中的第一行数据

                    // 在HTML中预填充数据
                    echo '<div id="shadow2">';
                    echo '<div id="top_left_div">';
                    echo '<h2 style="margin-left:20px;">软件配置</h2>';
                    echo '<p style="color:deepskyblue;margin-left:20px;margin-bottom:0px;">基础设置</p>';
                    echo '<hr  style="border-color:deepskyblue;margin-left:20px;margin-right:20px;margin-bottom:0px;">';
                    echo '<div class="rjpzcon"><span class="rjpzt">软件图标：</span><textarea name="app_icon" class="rjpz" rows="1" cols="25">' . htmlspecialchars($app_icon) . '</textarea></div>';
                    echo '<div class="rjpzcon"><span class="rjpzt">软件名称：</span><textarea name="app_title" class="rjpz" rows="1" cols="10">' . htmlspecialchars($app_title) . '</textarea></div>';
                    echo '<div class="rjpzcon"><span class="rjpzt">软件版本：</span><textarea name="app_version" class="rjpz" rows="1" cols="8">' . htmlspecialchars($app_version) . '</textarea></div>';
                    echo '<div class="rjpzcon"><span class="rjpzt">软件平台：</span><textarea name="app_platform" class="rjpz" rows="1" cols="25">' . htmlspecialchars($app_platform) . '</textarea></div>';
                    echo '<div class="rjpzcon"><span class="rjpzt">相关链接：</span><textarea name="app_source_url" class="rjpz" rows="1" cols="25">' . htmlspecialchars($app_source_url) . '</textarea></div>';
                    echo '<div class="rjpzcon"><span class="rjpzt">软件描述：</span><textarea name="app_description" class="rjpz" rows="2" cols="44">' . htmlspecialchars($app_description) . '</textarea></div>';
                    echo '<div class="rjpzcon"><span class="rjpzt">下载链接：</span><textarea name="app_download_url" class="rjpz" rows="2" cols="44">' . htmlspecialchars($app_download_url) . '</textarea></div>';
                    echo '<!--<div class="rjpzcon"><span style="margin-left:20px;font-weight:bold;vertical-align: top;">内容：</span><textarea class="rjpz" rows="5" cols="50"></textarea></div>-->';
                    echo '<div style="display: flex;justify-content: flex-end;margin:30px">';
                    echo '<span id="quxiao">取消</span>';
                    echo '<span id="queren">确认</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                } else {
                    // 处理没有找到记录的情况
                    echo "没有找到ID为 $id 的记录。";
                }
                $stmt->close(); // 关闭连接
            } else {
                // 处理预处理语句失败的情况
                echo "预处理语句失败: " . $conn->error;
            }

            $conn->close(); // 关闭连接
        }
    ?>
<script>
var quxiao = document.getElementById("quxiao");
var queren = document.getElementById("queren");

quxiao.onclick = function() {
    window.location.href = "xb_panel_list.php";
}

queren.onclick = function() {
    var formData = new FormData();
    formData.append('id', <?php echo $update_id; ?>);
    formData.append('app_icon', document.querySelector('textarea[name="app_icon"]').value);
    formData.append('app_title', document.querySelector('textarea[name="app_title"]').value);
    formData.append('app_version', document.querySelector('textarea[name="app_version"]').value);
    formData.append('app_platform', document.querySelector('textarea[name="app_platform"]').value);
    formData.append('app_source_url', document.querySelector('textarea[name="app_source_url"]').value);
    formData.append('app_description', document.querySelector('textarea[name="app_description"]').value);
    formData.append('app_download_url', document.querySelector('textarea[name="app_download_url"]').value);

    fetch('Update_software.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('Success:', data);
        alert('软件信息更新成功');
        window.location.href = "xb_panel_list.php";
    })
    .catch((error) => {
        console.error('Error:', error);
        // 错误处理
    });
};
</script>
	</body>
</html>