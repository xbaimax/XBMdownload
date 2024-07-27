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
		<title>关于我们——软麟panel</title>
		<link type="image/x-icon" rel="shortcut icon" href="../img/logo.jpg"><!--标签图片请自行定义——放入href中-->
		<link rel="stylesheet" type="text/css" href="../css/about_us.css">

	</head>
	<body>
		<div id="left_choice_menu">

			<div id="left_choice_menu_logo_contral">
				<img id="left_choice_menu_logo" src="../img/logo.jpg">
			</div>

			<div id="left_choice_menu_option">
				<div class="left_choice_menu_option_alldiv" id="panel_home_page">
					<img class="left_choice_menu_option_allimg" src="../img/ms.svg"><span class="left_choice_menu_option_allspan">面板首页</span>
				</div>
				
				<div class="left_choice_menu_option_alldiv" id="software_list">
					<img class="left_choice_menu_option_allimg" src="../img/sl.svg"><span class="left_choice_menu_option_allspan">软件列表</span>
				</div>
				
				<div class="left_choice_menu_option_alldiv" id="security_policy">
					<img class="left_choice_menu_option_allimg" src="../img/sc.svg"><span class="left_choice_menu_option_allspan">安全策略</span>
				</div>
				
				<div class="click" id="about_us">
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
			<div id="div1_zckf">
				<h1 class="zckf_h1">支持开发</h1>
				<p style="margin-left:40px;color:gray">我们将一直保持开源,向开发者捐赠以表示支持！</p>
				<a href="gift.html"><img src="../img/wx.png" class="zckf_img"></a>
				<a href="https://afdian.com/a/ibaizhan"><img src="../img/aifadian.svg" class="zckf_img"></a>
			</div>
			<div id="div_gzwm">
				<h1 class="zckf_h1">关于我们</h1>
				<div><span class="gywm_span">@小白</span><a href="https://tool.gljlw.com/qq/?qq=3596200633"><img src="../img/qq.svg" class="gywm_img"></a><a href="https://gitee.com/ibaizhan/"><img src="../img/gitee.svg" class="gywm_img"></a><a href="https://space.bilibili.com/3461572311648712"><img src="../img/bilibili.svg" class="gywm_img"></a></div>
				<div><span class="gywm_span">@BEATS</span><a href="https://tool.gljlw.com/qq/?qq=3466473875"><img src="../img/qq.svg" class="gywm_img"></a><a href="https://gitee.com/lcbeats/"><img src="../img/gitee.svg" class="gywm_img"></a></div>
				<div><span class="gywm_span">@游牧中</span><a href="https://tool.gljlw.com/qq/?qq=1204714374"><img src="../img/qq.svg" class="gywm_img"></a></div>
			</div>
		</div>
	</body>
	<script src="../js/menu.js"></script>
</html>