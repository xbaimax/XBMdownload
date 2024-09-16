<?php
header('Access-Control-Allow-Origin:*');
// 默认UA
$UserAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36';
$url = isset($_GET['url']) ? $_GET['url'] : "";
$pwd = isset($_GET['pwd']) ? $_GET['pwd'] : "";

// 判断传入链接参数是否为空
if (empty($url)) {
    die('请输入URL');
}

// 链接处理
$url='https://www.lanzoup.com/'.explode('.com/',$url)['1'];
$softInfo = MloocCurlGet($url);

// 判断文件链接是否失效
if (strstr($softInfo, "文件取消分享了") != false) {
    die('文件取消分享了');
}

// 带密码的链接的处理
if(strstr($softInfo, "function down_p(){") != false) {
    if(empty($pwd)) {
        die('请输入分享密码');
    }
    preg_match_all("~skdklds = '(.*?)';~", $softInfo, $segment);
    $post_data = array(
        "action" => 'downprocess',
        "sign" => $segment[1][0],
        "p" => $pwd
    );
    $softInfo = MloocCurlPost($post_data, "https://www.lanzoup.com/ajaxm.php", $url);
} else {
    // 不带密码的链接处理
    preg_match("~\n<iframe.*?name=\"[\s\S]*?\"\ssrc=\"\/(.*?)\"~", $softInfo, $link);
    $ifurl = "https://www.lanzoup.com/" . $link[1];
    $softInfo = MloocCurlGet($ifurl);
    preg_match_all("~'sign':'(.*?)'~", $softInfo, $segment);
    $post_data = array(
        "action" => 'downprocess',
        "sign" => $segment[1][0],
    );
    $softInfo = MloocCurlPost($post_data, "https://www.lanzoup.com/ajaxm.php", $ifurl);
}

// 解析最终直链地址
$softInfo = json_decode($softInfo, true);
if ($softInfo['zt'] != 1) {
    die($softInfo['inf']);
}

// 拼接链接
$downUrl1 = $softInfo['dom'] . '/file/' . $softInfo['url'];
$downUrl2 = MloocCurlHead($downUrl1, "https://developer.lanzoug.com", $UserAgent, "down_ip=1; expires=Sat, 16-Nov-2019 11:42:54 GMT; path=/; domain=.baidupan.com");

// 判断最终链接是否获取成功，如未成功则使用原链接
$downUrl = $downUrl2 == "" ? $downUrl1 : $downUrl2;

// 直接重定向到下载链接
header("Location:$downUrl");
die();

// CURL函数
function MloocCurlGet($url = '', $UserAgent = '') {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    if ($UserAgent != "") {
        curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.Rand_IP(), 'CLIENT-IP:'.Rand_IP()));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

// POST函数
function MloocCurlPost($post_data = '', $url = '', $ifurl = '', $UserAgent = '') {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
    if ($ifurl != '') {
        curl_setopt($curl, CURLOPT_REFERER, $ifurl);
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.Rand_IP(), 'CLIENT-IP:'.Rand_IP()));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

// 直链解析函数
function MloocCurlHead($url, $guise, $UserAgent, $cookie) {
    $headers = array(
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
        'Accept-Encoding: gzip, deflate',
        'Accept-Language: zh-CN,zh;q=0.9',
        'Connection: keep-alive',
        'User-Agent: '.$UserAgent
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_REFERER, $guise);
    curl_setopt($curl, CURLOPT_COOKIE , $cookie);
    curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
    curl_setopt($curl, CURLOPT_NOBODY, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    $data = curl_exec($curl);
    $url = curl_getinfo($curl);
    curl_close($curl);
    return $url["redirect_url"];
}

// 随机IP函数
function Rand_IP() {
    $ip2id = round(rand(600000, 2550000) / 10000);
    $ip3id = round(rand(600000, 2550000) / 10000);
    $ip4id = round(rand(600000, 2550000) / 10000);
    $arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211");
    $randarr= mt_rand(0,count($arr_1)-1);
    $ip1id = $arr_1[$randarr];
    return $ip1id.".".$ip2id.".".$ip3id.".".$ip4id;
}
?>