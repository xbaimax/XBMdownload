<?php
function getClientIp() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ips[0]);
    }
    return $ip;
}

function checkBlacklistAndRespond() {    
// 读取黑名单文件
$blacklistFile = 'data/WAF_IP.txt';
$blacklistIps = file_get_contents($blacklistFile);
$blacklistIps = explode('|', trim($blacklistIps));

// 检查当前IP是否在黑名单中
$visitorIp = getClientIp();
if (in_array($visitorIp, $blacklistIps)) {
        header('Location: blacklist.php');      // 跳转到黑名单页面
        exit;
    }
}
?>