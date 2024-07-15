<?php
function checkVersion($id, $version) {
    $url = "http://api.2018k.cn/checkVersion?id={$id}&version={$version}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return explode('|', $response);
}

$id = "0CBFF4B1033C473FA9766E4C29C02720";
$version = "1.0";

$result = checkVersion($id, $version);

if ($result[0] == "true") {
    echo "有新版本可用！";
    echo "是否强制更新: " . ($result[1] == "true" ? "是" : "否");
    echo "下载地址: " . $result[3];
    echo "服务器版本号: " . $result[4];
} else {
    echo "当前版本已是最新版本！";
}
?>