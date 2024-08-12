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

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>软麟panel</title>
		<link type="image/x-icon" rel="shortcut icon" href="../img/logo.jpg">
		<style>
			body {
				background: linear-gradient(to bottom, white 0%, lightblue 100%);
				background-repeat: no-repeat;
				background-attachment: fixed;
				/* 以下是为了兼容不同浏览器 */
				-webkit-background: linear-gradient(to bottom, white 0%, lightblue 100%);
				-moz-background: linear-gradient(to bottom, white 0%, lightblue 100%);
				-o-background: linear-gradient(to bottom, white 0%, lightblue 100%);
			}

			#left_choice_menu {
				position: fixed;
				top: 3%;
				left: 1%;
				width: 250px;
				height: 94%;
				background-color: white;
				border-radius: 10px;
				box-shadow: 3px 3px 8px lightgray;
			}

			#center_show_choice {
				position: fixed;
				top: 3%;
				left: calc(3vw + 240px);
				width: calc(100vw - 240px - 4vw);
				height: 94%;
				background-color: white;
				border-radius: 10px;
				box-shadow: 3px 3px 8px lightgray;
			}

			#left_choice_menu_logo_contral {
				margin-top: 30px;
				margin-bottom: 30px;
				text-align: center;
			}

			#left_choice_menu_logo {
				max-width: 90px;

			}

			#left_choice_menu_option {
				margin-top: 40px;
				text-align: center;
			}

			.left_choice_menu_option_alldiv {
				cursor: pointer;
				margin-top: 30px;
				margin-bottom: 30px;
				margin-left: 50px;
				margin-right: 50px;
				padding-top:10px;
				padding-bottom:10px;
				border-radius: 8px;
			}

			.left_choice_menu_option_allimg {
				max-width: 20px;
			}

			.left_choice_menu_option_allspan {
				margin-left: 10px;
				font-size: 20px;
				font-weight:bold;
			}
			
			.click{
				cursor: pointer;
				margin-top: 30px;
				margin-bottom: 30px;
				margin-left: 50px;
				margin-right: 50px;
				padding-top:10px;
				padding-bottom:10px;
				border-radius: 8px;
				background-color:#f1f0f0;
			}
			.three-point-font {
    			font-size: 16pt;
  			}
		</style><!--不喜欢嵌入式css，请自行转移到css文件！-->

	</head>
	<body>
		<div id="left_choice_menu">

			<div id="left_choice_menu_logo_contral">
				<img id="left_choice_menu_logo" src="../img/logo.jpg">
			</div>

			<div id="left_choice_menu_option">
				<div class="click" id="panel_home_page">
					<img class="left_choice_menu_option_allimg" src="../img/ms.svg"><span class="left_choice_menu_option_allspan">面板首页</span>
				</div>
				
				<div class="left_choice_menu_option_alldiv" id="software_list">
					<img class="left_choice_menu_option_allimg" src="../img/sl.svg"><span class="left_choice_menu_option_allspan">软件列表</span>
				</div>
				
				<div class="left_choice_menu_option_alldiv" id="security_policy">
					<img class="left_choice_menu_option_allimg" src="../img/sc.svg"><span class="left_choice_menu_option_allspan">安全策略</span>
				</div>
				
				<div class="left_choice_menu_option_alldiv" id="about_us">
					<img class="left_choice_menu_option_allimg" src="../img/au.svg"><span class="left_choice_menu_option_allspan">关于我们</span>
				</div>
				
				<div class="left_choice_menu_option_alldiv" id="panel_setting">
					<img class="left_choice_menu_option_allimg" src="../img/sit.svg"><span class="left_choice_menu_option_allspan">面板设置</span>
				</div>
				<div style="display:flex;justify-content: center;">
					<div style="position:absolute;bottom:2%;">©小白</div>
				</div>
			</div>
		</div>

		<div id="center_show_choice">
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
					echo "<p class='three-point-font'>有新版本可用，远程版本号: " . $remote_version . "，本地版本号: " . $local_version . "</p>";
					echo "<a href='https://gitee.com/ibaizhan/XBMdownload' target='_blank' class='three-point-font'>点击这里访问仓库</a>";
				} else {
					echo "<p class='three-point-font'>当前已是最新版本，本地版本号: " . $local_version . "</p>";
				}
			} else {
				echo "<p class='three-point-font'>无法获取版本号。</p>";
			}
			?>
		</div>
	</body>
	<script src="../js/menu.js"></script>
</html>