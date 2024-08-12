<?php
// 获取远程版本号
function getRemoteVersion($file_url) {
    // 初始化cURL会话
    $ch = curl_init();

    // 设置cURL选项
    curl_setopt($ch, CURLOPT_URL, $file_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // 执行cURL请求
    $file_content = curl_exec($ch);

    // 检查cURL请求是否成功
    if ($file_content === FALSE) {
        return false;
    } else {
        // 解析JSON响应
        $file_info = json_decode($file_content, true);

        // 检查是否成功解析JSON
        if (json_last_error() === JSON_ERROR_NONE && isset($file_info['content'])) {
            // 解码Base64编码的内容
            $decoded_content = base64_decode($file_info['content']);
            return $decoded_content;
        } else {
            return false;
        }
    }

    // 关闭cURL会话
    curl_close($ch);
}

// 对比版本号
function compareVersions($remote_version, $local_version) {
    return version_compare($remote_version, $local_version, '>');
}

// Gitee仓库的API URL
$file_url = 'https://gitee.com/api/v5/repos/ibaizhan/XBMdownload/contents/%E7%89%88%E6%9C%AC%E5%8F%B7.txt';

// 本地版本号
$local_version = '1.2.0';

// 获取远程版本号
$remote_version = getRemoteVersion($file_url);

// 检查是否成功获取版本号
if ($remote_version !== false) {
    // 对比版本号
    if (compareVersions($remote_version, $local_version)) {
        echo "有新版本可用，远程版本号: " . $remote_version . "，本地版本号: " . $local_version . "<br>";
        echo "<a href='https://gitee.com/ibaizhan/XBMdownload' target='_blank'>点击这里访问仓库</a>";
    } else {
        echo "当前已是最新版本，本地版本号: " . $local_version;
    }
} else {
    echo "无法获取版本号。";
}
?>