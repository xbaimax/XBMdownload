<?php  
// 作者：小白初梦
// QQ:3596200633

$mobileImageLinks = [   // 手机端图片链接
    'https://dimg04.tripcdn.com/images/0Z017224x8vi0h96n4FBD.jpg',
    'https://dimg04.tripcdn.com/images/0Z03w224x8vi03sly81A2.jpg',
    'https://dimg04.tripcdn.com/images/0Z017224x8vi0reqo80E0.jpg',
    'https://dimg04.tripcdn.com/images/0Z02l224x8vi0jou924B3.jpg',
    'https://dimg04.tripcdn.com/images/0Z03b224x8vi0h99p675D.jpg',
    'https://dimg04.tripcdn.com/images/0Z06b224x8vi0yfcb8D8A.jpg',
    'https://dimg04.tripcdn.com/images/0Z072224x8vi0lxprC1E0.jpg',
    'https://dimg04.tripcdn.com/images/0Z003224x8vi0lxpsDE08.jpg',
    'https://dimg04.tripcdn.com/images/0Z015224x8vi0ab647A37.jpg',
    'https://dimg04.tripcdn.com/images/0Z06s224x8vi0suvm5A15.jpg',
    'https://dimg04.tripcdn.com/images/0Z05p224x8vi11e98F2A7.jpg',
    'https://dimg04.tripcdn.com/images/0Z02u224x8vi0x43rA97B.jpg',
    'https://dimg04.tripcdn.com/images/0Z022224x8vi0znx5DA05.jpg',
    'https://dimg04.tripcdn.com/images/0Z052224x8vizgjunFF6B.jpg',
];
$desktopImageLinks = [  // 电脑端图片链接
    'https://dimg04.tripcdn.com/images/0Z00z224x8vhzog8j479E.jpg',
    'https://dimg04.tripcdn.com/images/0Z01i424x8u23hvu46C08.jpg',
    'https://dimg04.tripcdn.com/images/0Z03s224x8vi0ou3x8082.jpg',
    'https://dimg04.tripcdn.com/images/0Z016224x8vi11hk521AB.jpg',
    'https://dimg04.tripcdn.com/images/0Z00w224x8vi0q66y6C08.jpg',
    'https://dimg04.tripcdn.com/images/0Z004224x8vi19wzhF508.jpg',
    'https://dimg04.tripcdn.com/images/0Z03a224x8vi1c2kk937F.jpg',
];

$userAgent = $_SERVER['HTTP_USER_AGENT'];

// 判断是手机还是电脑访问
$isMobile = preg_match('/(android|blackberry|iphone|ipad|ipod|opera mini|iemobile|wpdesktop)/i', $userAgent);

$imageLinks = $isMobile ? $mobileImageLinks : $desktopImageLinks;

if (empty($imageLinks)) {  
    http_response_code(404);  
    echo "没有可用的图片链接";  
    exit;  
}  

$randomLink = $imageLinks[array_rand($imageLinks)];  

$imageInfo = getimagesize($randomLink);
$imageMimeType = $imageInfo['mime'];
header('Content-Type: ' . $imageMimeType);

header('Location: ' . $randomLink);
exit;