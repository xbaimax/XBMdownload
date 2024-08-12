<?php
// 判断Safety_lock文件是否存在(防止重复安装)
if (file_exists('../data/Safety_lock')) {
    header('Location: /');
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link type="image/x-icon" rel="shortcut icon" href="../img/logo.jpg">
    <style>
        body {
            background-image: linear-gradient(to right, #ff96c2, #6fb9ff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        .install-container {
            width: 300px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.5);
            box-shadow: 3px 3px 10px #000;
            border-radius: 10px;
        }
        
        .install-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .install-container input {
            margin-bottom: 10px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.8);
            width: 100%;
        }
        
        .install-container span {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 20px;
        }
        
        .install-container .install-btn {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
        }
        
        .install-container .install-btn:hover {
            background-color: #0056b3;
        }
        
        .install-container .message {
            text-align: center;
            color: #fff;
            margin-top: 20px;
        }
        
        .install-container .success-message {
            color: #006400; /* 墨绿色 */
        }
        
        .install-container .error-message {
            color: #ff0000; /* 红色 */
        }
    </style>
    <title>XBM下载站安装向导</title>
</head>
<body>
    <div class="install-container">
        <form method="post" action="">
            <span class="install-title">XBM安装向导</span>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $db_host = $_POST['db_host'];
                $db_name = $_POST['db_name'];
                $db_user = $_POST['db_user'];
                $db_pass = $_POST['db_pass'];

                // 尝试连接数据库（测试连接）
                $db = new mysqli($db_host, $db_user, $db_pass, $db_name);

                if ($db->connect_error) {
                    echo "<p class='message error-message'>连接数据库失败: " . $db->connect_error . "</p>";
                } else {
                    // 设置字符集为UTF-8
                    $db->set_charset("utf8");

                    // 检查数据库是否有数据
                    $check_sql = "SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = '$db_name'";
                    $result = $db->query($check_sql);
                    $row = $result->fetch_assoc();
                    $table_count = $row['count'];

                    if ($table_count > 0 && !isset($_POST['confirm_overwrite'])) {
                        // 数据库有数据，提示用户是否覆盖
                        echo "<p class='message error-message'>数据库中已存在数据，是否覆盖？</p>";
                        echo "<input type='hidden' name='db_host' value='$db_host'>";
                        echo "<input type='hidden' name='db_name' value='$db_name'>";
                        echo "<input type='hidden' name='db_user' value='$db_user'>";
                        echo "<input type='hidden' name='db_pass' value='$db_pass'>";
                        echo "<input class='install-btn' value='确认覆盖' type='submit' name='confirm_overwrite'>";
                    } else {
                        // 数据库没有数据或用户确认覆盖，直接继续安装
                        // 读取并执行SQL文件
                        $sql_file = 'install.sql';
                        if (file_exists($sql_file)) {
                            $sql = file_get_contents($sql_file);
                            if ($db->multi_query($sql)) {
                                do {
                                    // 等待执行下一个查询
                                    if ($result = $db->store_result()) {
                                        $result->free();
                                    }
                                } while ($db->more_results() && $db->next_result());
                            }
                        } else {
                            echo "<p class='message error-message'>SQL文件不存在</p>";
                        }

                        // 保存配置连接文件
                        $config_content = "<?php\n";
                        $config_content .= "// 连接到MySQL数据库\n";
                        $config_content .= "\$servername = \"$db_host\";  // 数据库地址（本地数据库，一般不用改）\n";
                        $config_content .= "\$username = \"$db_user\";    // 数据库用户名\n";
                        $config_content .= "\$password = \"$db_pass\";    // 数据库密码\n";
                        $config_content .= "\$dbname = \"$db_name\";    // 数据库名\n\n";
                        $config_content .= "\$conn = new mysqli(\$servername, \$username, \$password, \$dbname);\n\n";
                        $config_content .= "// 检查连接\n";
                        $config_content .= "if (\$conn->connect_error) {\n";
                        $config_content .= "    die(\"连接失败: \" . \$conn->connect_error);\n";
                        $config_content .= "}\n";
                        $config_content .= "\$conn->set_charset(\"utf8\"); // 设置字符集\n";
                        $config_content .= "?>\n";

                        file_put_contents('../mysql_xb/mysql.php', $config_content);

                        // 创建Safety_lock文件
                        $lock_content = "这是一个安全效验文件，用于防止重复安装和恶意覆盖安装。请勿随意删除。";
                        if (!is_dir('../data')) {
                            echo "严重安全警告，发现data目录不存在，请检查！";
                        }
                        file_put_contents('../data/Safety_lock', $lock_content);

                        echo "<p class='message success-message'>安装成功！</p>";
                        echo "<input class='install-btn' value='前往首页' type='button' onclick='window.location.href=\"/\"'>";
                    }
                }
            } else {
            ?>
            <input class="db_host" placeholder="数据库主机" name="db_host" type="text" value="localhost" required><br><br>
            <input class="db_name" placeholder="数据库名称" name="db_name" type="text" required><br><br>
            <input class="db_user" placeholder="数据库用户" name="db_user" type="text" required><br><br>
            <input class="db_pass" placeholder="数据库密码" name="db_pass" type="password"><br><br>
            <input class="install-btn" value="安装" type="submit">
            <?php
            }
            ?>
        </form>
    </div>
</body>
</html>