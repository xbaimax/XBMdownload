<?php
require_once "mysql_xb/mysql.php";

// 判断Safety_lock文件是否存在
if (!file_exists('data/Safety_lock')) {
    header('Location: install/index.php');
    exit();
}

// 访问统计函数
function incrementVisitCount() {
    $filePath = 'data/visit_statistics.txt';
    if (file_exists($filePath)) {
        $count = (int)file_get_contents($filePath);
        $count++;
        file_put_contents($filePath, $count);
    } else {
        file_put_contents($filePath, 1);
    }
}

incrementVisitCount();

// 分页参数
$items_per_page = 5;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $items_per_page;

// 搜索功能
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';

$condition = '';
if (!empty($keyword)) {
    $condition = "WHERE app_title LIKE '%$keyword%' OR app_description LIKE '%$keyword%'";
}

// 总记录数
$sql_total = "SELECT COUNT(*) as total FROM app_cards $condition";
$result_total = mysqli_query($conn, $sql_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_pages = ceil($row_total['total'] / $items_per_page);

// 查询当前页数据
$sql = "SELECT * FROM app_cards $condition LIMIT $start, $items_per_page";
$result = mysqli_query($conn, $sql);

require_once 'api/WAF_IP.php';  //调用IP防火墙检测

checkBlacklistAndRespond();
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://dimg04.tripcdn.com/images/0Z037224x8vb7zwajD168.jpg" type="image/ico">
    <title></title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('../data/WZBT.txt')
                .then(response => response.text())
                .then(data => {
                    document.title = data.trim();
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
    <link rel="stylesheet" type="text/css" href="css/download_xb.css">
    <link rel="stylesheet" type="text/css" href="css/copyright.css">
    <style id="dynamic-background-style">
        body {
            background-color: transparent;
            background-size: cover;
            background-position: center;
        }
    </style>

    <script>
        async function setBackgroundImage() {
            const response = await fetch('api/bj.php');
            const blob = await response.blob();
            const reader = new FileReader();
            reader.onloadend = function () {
                const imageDataUrl = reader.result;
                document.getElementById('dynamic-background-style').innerHTML = `
                    body {
                        background-image: url('${imageDataUrl}');
                        background-size: cover;
                        background-position: center;
                    }
                `;
            };
            reader.readAsDataURL(blob);
        }
        window.onload = setBackgroundImage;
    </script>
</head>
<body>
<!-- 导航栏 -->
<div class="navbar" style="display: flex; justify-content: flex-end; align-items: center; padding: 10px; background-color: #f8f9fa; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
    <form action="" method="get" id="form_contral" style="display: flex; align-items: center;">
        <input style="border: 2px solid #007bff; border-radius: 15px; padding: 10px; margin-right: 10px; width: 200px; outline: none;" type="text" name="keyword" placeholder="搜索..." value="<?php echo htmlspecialchars($keyword); ?>">
        <button style="background-color: #007bff; color: white; border: none; border-radius: 15px; padding: 10px 20px; cursor: pointer; transition: background-color 0.3s ease-in-out;" type="submit">搜索</button>
    </form>
</div>

    <!-- 大字标题 -->
    <h1 id="dynamicTitle" style="text-align: center; margin-bottom: 30px;"></h1>

    <!-- 引入jQuery库 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript代码 -->
    <script>
    $(document).ready(function() {
        $.ajax({
            url: '../api/yy.php',
            type: 'GET',
            success: function(data) {
                $('#dynamicTitle').text(data); // 直接将获取的文本设置为<h1>标签的内容
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    });
    </script>
    <!-- 软件列表 -->
    <div class="container">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="app-card" onclick="toggleCard(this)">
                <div class="app-card-details">
                    <img src="<?php echo $row['app_icon']; ?>" alt="<?php echo $row['app_title']; ?>图标" class="app-icon">
                    <div>
                        <h2 class="app-title"><?php echo $row['app_title']; ?></h2>
                        
                        <div class="app-details">
                            <?php if (!empty($row['app_version'])): ?>
                                <p><span class="bold-label">项目版本：</span><?php echo $row['app_version']; ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($row['app_platform'])): ?>
                                <p><span class="bold-label">项目平台：</span><?php echo $row['app_platform']; ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($row['app_source_url'])): ?>
                                <p><span class="bold-label">相关链接：</span><a href="<?php echo $row['app_source_url']; ?>" class="custom-link"><?php echo "立即前往"; ?></a></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($row['app_description'])): ?>
                                <p><span class="bold-label">软件描述：</span><?php echo $row['app_description']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $row['app_download_url']; ?>" class="download-btn" onclick="event.stopPropagation();">立即下载</a>
            </div>
        <?php endwhile; ?>

        <!-- 分页导航 -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?><?php echo !empty($keyword) ? '&keyword=' . urlencode($keyword) : ''; ?>" class="prev">上一页</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo !empty($keyword) ? '&keyword=' . urlencode($keyword) : ''; ?>" class="<?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?><?php echo !empty($keyword) ? '&keyword=' . urlencode($keyword) : ''; ?>" class="next">下一页</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p style="text-align: center;">未找到相关的内容。</p>
    <?php endif; ?>

    </div>
    <footer style="background-color: transparent;">
        <div class="footer-content">
            <a href="https://gitee.com/ibaizhan/XBMdownload" target="_blank" class="gitee-link">
                <img src="img/Gitee_logo.png" alt="Gitee Logo" class="gitee-logo">
                <span class="gitee-text">开源地址</span>
            </a>
            <p>&copy; 2024-现在 小白. All rights reserved.</p>
        </div>
    </footer>
    <!-- 雪花飘落js引用，觉得不需要或网页加载慢可以注释或直接删掉 -->
    <script src="js/xh_pl.js"></script>

    <script>
    let currentOpenCard = null;

    function toggleCard(card) {
        const details = card.querySelector('.app-details');
        if (currentOpenCard && currentOpenCard !== card) {
            const currentDetails = currentOpenCard.querySelector('.app-details');
            currentDetails.style.maxHeight = null;
        }
        if (details.style.maxHeight) {
            details.style.maxHeight = null;
            currentOpenCard = null;
        } else {
            details.style.maxHeight = details.scrollHeight + "px";
            currentOpenCard = card;
        }
    }
    </script>
</body>
</html>