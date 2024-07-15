<?php 
  include "../mysql_xb/mysql.php";
if(isset($_COOKIE['xb_xkey'])){
  $sql = "select * from admin";
  $nahida = $conn->query($sql);
  $my_sj= $nahida->fetch_all()[0];
  if($_COOKIE['xb_xkey']!=$my_sj[1]){
    die("<script>alert('请登录！'); window.location.replace('index.html');</script>");
  }

}else{
  die("<script>alert('请登录！'); window.location.replace('index.html');</script>");
}
?>

<?php
/*
by:小白&游牧中
*/
// 文件路径
$file_path = '../data/WAF_IP.txt';

/**
 * 创建文件，如果文件不存在
 *
 * @param string $file_path 文件路径
 */
function create_file($file_path) {
    if (!file_exists($file_path)) {
        if (file_put_contents($file_path, '') === false) {
            die("无法创建文件 $file_path");
        }
        echo "文件 $file_path 已创建。\\n";
    }
}

/**
 * 读取文件中的IP地址
 *
 * @param string $file_path 文件路径
 * @return array IP地址数组
 */
function read_ips($file_path) {
    if (!file_exists($file_path)) {
        create_file($file_path);
    }
    $content = file_get_contents($file_path);
    if ($content !== false) {
        $content = trim($content);
        if (empty($content)) {
            return [];
        }
        return array_filter(explode('|', $content), function($value) { return $value !== ''; });
    } else {
        return [];
    }
}

/**
 * 将IP地址写入文件
 *
 * @param string $file_path 文件路径
 * @param array $ips IP地址数组
 */
function write_ips($file_path, $ips) {
    if (file_put_contents($file_path, implode('|', $ips)) === false) {
        die("无法写入文件 $file_path");
    }
}

/**
 * 添加IP地址
 *
 * @param string $file_path 文件路径
 * @param string $ip IP地址
 */
function add_ip($file_path, $ip) {
    $ips = read_ips($file_path);
    if (!in_array($ip, $ips)) {
        $ips[] = $ip;
        write_ips($file_path, $ips);
        echo "IP地址 $ip 已添加。\\n";
    } else {
        echo "IP地址 $ip 已存在。\\n";
    }
}

/**
 * 删除IP地址
 *
 * @param string $file_path 文件路径
 * @param string $ip IP地址
 */
function delete_ip($file_path, $ip) {
    $ips = read_ips($file_path);
    if (in_array($ip, $ips)) {
        $ips = array_diff($ips, [$ip]);
        write_ips($file_path, array_values($ips));
        echo "IP地址 $ip 已删除。\\n";
    } else {
        echo "IP地址 $ip 不存在。\\n";
    }
}

/**
 * 生成IP列表的HTML
 *
 * @param string $file_path 文件路径
 * @return string IP列表的HTML
 */
function generate_ip_list_html($file_path) {
    $ips = read_ips($file_path);
    $html = '';
    if (!empty($ips)) {
        foreach ($ips as $ip) {
            // 修改onclick属性以正确闭合并确保参数为字符串
            $html .= '<tr><td class="xiangmu">' . htmlspecialchars($ip) . '</td><td class="xiangmu">屏蔽</td><td class="xiangmu"><button class="input_delete" onclick="deleteIp(\'' . htmlspecialchars($ip) . '\')">删除</button></td></tr>';
        }
    } else {
        $html .= '<tr><td colspan="3" class="xiangmu">IP地址列表为空</td></tr>';
    }
    return $html;
}

// 处理AJAX请求
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $ip = filter_var($_POST['ip'], FILTER_VALIDATE_IP);
    if ($ip === false) {
        die("Invalid IP address");
    }
    if ($action === 'add') {
        add_ip($file_path, $ip);
    } elseif ($action === 'delete') {
        delete_ip($file_path, $ip);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<title>安全策略&mdash;&mdash;软麟panel</title>
		<link type="image/x-icon" rel="shortcut icon" href="../img/logo.jpg">
		<link rel="stylesheet" type="text/css" href="../css/security_policy.css">
		<style>
			.xiangmu {
				text-align: center;
				padding: 8px;
			}

			table {
				width: 100%;
				border-collapse: collapse;
			}

			th,
			td {
				border: 1px solid #ddd;
			}

			th {
				background-color: #fbfbfb;
			}
			
			.input_delete {
				cursor: pointer;
				color: deepskyblue;
				margin-left: 5px;
				margin-right: 5px;
			}
			
			.input_delete:hover {
				color: skyblue;
			}
		</style>
	</head>
	<body>
		<div id="left_choice_menu">
			<div id="left_choice_menu_logo_contral">
				<img id="left_choice_menu_logo" src="../img/logo.jpg">
			</div>
			<div id="left_choice_menu_option">
				<div class="left_choice_menu_option_alldiv" id="panel_home_page">
					<img class="left_choice_menu_option_allimg" src="../img/ms.svg"><span
						class="left_choice_menu_option_allspan">面板首页</span>
				</div>
				<div class="left_choice_menu_option_alldiv" id="software_list">
					<img class="left_choice_menu_option_allimg" src="../img/sl.svg"><span
						class="left_choice_menu_option_allspan">软件列表</span>
				</div>
				<div class="click" id="security_policy">
					<img class="left_choice_menu_option_allimg" src="../img/sc.svg"><span
						class="left_choice_menu_option_allspan">安全策略</span>
				</div>
				<div class="left_choice_menu_option_alldiv" id="about_us">
					<img class="left_choice_menu_option_allimg" src="../img/au.svg"><span
						class="left_choice_menu_option_allspan">关于我们</span>
				</div>
				<div class="left_choice_menu_option_alldiv" id="panel_setting">
					<img class="left_choice_menu_option_allimg" src="../img/sit.svg"><span
						class="left_choice_menu_option_allspan">面板设置</span>
				</div>
				<div style="display:flex;justify-content: center;">
					<div style="position:absolute;bottom:2%;">&copy;小白</div>
				</div>
			</div>
		</div>
		<div id="center_show_choice">
			<div id="top">
				<span id="top_left">添加IP规则</span>
			</div>
			<div id="center">
				<table>
					<tr style="background-color:#fbfbfb;">
						<th class="xiangmu" style="width:60%">域名/IP地址</th>
						<th class="xiangmu" style="width:10%">策略</th>
						<th class="xiangmu" style="width:10%">操作</th>
					</tr>
					<?php echo generate_ip_list_html($file_path); ?>
				</table>
			</div>
		</div>
		<div id="shadow" style="display:none">
			<div id="top_left_div">
				<h2 style="margin-left:20px;">修改信息</h1>
					<p style="color:deepskyblue;margin-left:20px;margin-bottom:0px;">基础设置</p>
					<hr style="border-color:deepskyblue;margin-left:20px;margin-right:20px;margin-bottom:0px;">
					<div class="rjpzcon"><span class="rjpzt">地址：</span><textarea id="ip_address" class="rjpz" rows="1"
							cols="30"></textarea></div>
					<div class="rjpzcon">
						<span class="rjpzt">策略：</span>
						<select id="ip_policy"
							style="border-radius:8px;margin-left: 14px;box-shadow: 2px 2px 1px lightgray;font-size: 20px;text-align:center;">
							<option value="block" selected>屏蔽</option>
						</select>
					</div>
					<div style="display: flex;justify-content: flex-end;margin:30px">
						<span id="quxiao">取消</span>
						<span id="queren">确认</span>
					</div>
			</div>
		</div>

		<script>
			var top_left = document.getElementById("top_left");
			var quxiao = document.getElementById("quxiao");
			var queren = document.getElementById("queren");
			var shadow = document.getElementById("shadow");
			var ip_address = document.getElementById("ip_address");
			var ip_policy = document.getElementById("ip_policy");

			top_left.onclick = function() {
				shadow.style.display = "block";
			}
			quxiao.onclick = function() {
				shadow.style.display = "none";
			}
			queren.onclick = function() {
				shadow.style.display = "none";
				var ip = ip_address.value.trim();
				var policy = ip_policy.value;
				if (policy === 'block') {
					addIp(ip);
				} else if (policy === 'allow') {
					deleteIp(ip);
				}
			}

			function addIp(ip) {
				var xhr = new XMLHttpRequest();
				xhr.open('POST', window.location.href, true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onreadystatechange = function() {
					if (xhr.readyState === 4 && xhr.status === 200) {
						location.reload();
					}
				};
				xhr.send('action=add&ip=' + encodeURIComponent(ip));
			}

			function deleteIp(ip) {
				var xhr = new XMLHttpRequest();
				xhr.open('POST', window.location.href, true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onreadystatechange = function() {
					if (xhr.readyState === 4 && xhr.status === 200) {
						location.reload();
					}
				};
				xhr.send('action=delete&ip=' + encodeURIComponent(ip));
			}
		</script>
	</body>
	<script src="../js/menu.js"></script>
</html>