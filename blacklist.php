<?php
// 获取客户端IP地址
function getClientIp() {
    $ip = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');
    } elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
    } elseif (getenv('REMOTE_ADDR')) {
        $ip = getenv('REMOTE_ADDR');
    } else {
        $ip = 'UNKNOWN';
    }
    return $ip;
}

$clientIp = getClientIp();

$blockedIps = file_get_contents('data/WAF_IP.txt');
$blockedIpsArray = explode('|', $blockedIps);

if (!in_array($clientIp, $blockedIpsArray)) {
    header('Location: /');
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>访问受限-小白WAF</title>
    <link type="image/x-icon" rel="shortcut icon" href="../img/logo.jpg">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        h1 {
            color: #ff6961;
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
<body>
<h1>访问受限</h1>
<p>对不起，您的IP地址已被系统识别为存在潜在风险，因此无法继续访问此网站。</p>
<p>如有疑问，请联系网站管理员。</p>
</body>
</html>