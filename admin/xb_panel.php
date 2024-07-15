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
		<p class="three-point-font">你说巧不巧，我首页没做！</p>
		<p class="three-point-font">嗯？空着确实不太好，要不我们一点留些彩蛋吧</p>
		<p class="three-point-font">对！“亿”点彩蛋</p>
		<p class="three-point-font">彩蛋1，MD5：e78b96a52d3d5f04</p>
		<p class="three-point-font">彩蛋2，下载链接：https://cccimg.com/down.php/6270d1016382d1c2d85a71ecb293656b.zip</p>
		<p class="three-point-font">彩蛋2的下载密码暗语：小米的初心价</p>
		<div class="three-point-font">彩蛋3，粉蝶花之语</div>
		<div class="three-point-font">不写了，不写了。。。（被林揍.ing）</div>
		<div class="three-point-font">说明：彩蛋内容并不单独归于一人</div>
		</div>
	</body>
	<script src="../js/menu.js"></script>
</html>