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
		<title>面板设置——软麟panel</title>
		<link type="image/x-icon" rel="shortcut icon" href="../img/logo.jpg">
		<link rel="stylesheet" type="text/css" href="../css/panel_setting.css">
		<style>
			/*
			.contral_theelements{
				text-align:right;
			}*/
			.paddingLeft_span{
				margin-left:2%;
			}
			#contral_theQQandTheTage{
			    
			    margin-top:20px;
				margin-left:20px;
				
				display: grid;/*82px 10% 9%;*/
				grid-template-columns: 1fr 1fr 1fr;
				grid-row-gap: 10px;
			}
			.input_fuck_two{
			   border-radius:8px;
			}
			#div_goodmind{
			  	display: grid;/*82px 10% 9%;*/
				grid-template-columns: 380px   1fr;	
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

				<div class="left_choice_menu_option_alldiv" id="security_policy">
					<img class="left_choice_menu_option_allimg" src="../img/sc.svg"><span
						class="left_choice_menu_option_allspan">安全策略</span>
				</div>

				<div class="left_choice_menu_option_alldiv" id="about_us">
					<img class="left_choice_menu_option_allimg" src="../img/au.svg"><span
						class="left_choice_menu_option_allspan">关于我们</span>
				</div>

				<div class="click" id="panel_setting">
					<img class="left_choice_menu_option_allimg" src="../img/sit.svg"><span
						class="left_choice_menu_option_allspan">面板设置</span>
				</div>
				<div style="display:flex;justify-content: center;">
					<div style="position:absolute;bottom:2%;">©小白</div>
				</div>

			</div>
		</div>

		<div id="center_show_choice">
			<div id="zhbb">
				<h1 style="margin-left:20px;padding-top:20px;">账户信息：</h1>
				<div id="zh">
				<?php
				// 打开文件
				$file = fopen('../data/ZZ_QQ.txt', 'r');
				if ($file !== FALSE) {
    				// 读取文件内容
    				$qqNumber = fgets($file);
    				// 关闭文件
    				fclose($file);

    				// 移除可能的换行符
    				$qqNumber = trim($qqNumber);
    
    				// 检查QQ号码是否符合格式
    				if (preg_match('/^\d{5,13}$/', $qqNumber)) {
        			// 如果QQ号码格式正确，则输出图片
        				echo '<img id="head" src="http://q1.qlogo.cn/g?b=qq&nk=' . $qqNumber . '&s=100">';
    				} else {
        			// 如果QQ号码格式不正确，可以输出默认图片
					echo '<img id="head" src="../img/lose.jpg">';
    				}
				} else {
    				echo '获取QQ号信息失败！';
				}
				?>
					<table style="margin-left:40px;font-size:30px">
						<tr>
						<?php
						include "../mysql_xb/mysql.php";
						$sql = "SELECT username FROM admin";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
    						while($row = $result->fetch_assoc()) {
        						echo '<td>账号：</td>';
        						echo '<td>' . htmlspecialchars($row["username"]) . '</td>';
    						}
						} else {
    						echo "查询错误";
						}
						$conn->close();
						?>
						</tr>
						<tr>
							<td>邮箱：</td>
							<td>（编辑与用途未开发，敬请期待）</td>
						</tr>
					</table>
				</div>
				<div style="position: fixed;top:42%;right: 5%;">
				<p id="pppp">修改账户</p>
				</div>
			</div>
			<div id="div_goodmind">
			<div id="contral_theQQandTheTage">
				<span class="paddingLeft_span">站长QQ：</span><div><input type="text" id="manqq" class="input_fuck_two"></div><div style="text-align:right"><span id="keepman" class="blues">保存</span></div>
				<span class="paddingLeft_span">网站标题：</span><div><input type="text" id="webtage" class="input_fuck_two"></div><div style="text-align:right"><span id="keepwebtage" class="blues">保存</span></div>
			</div>
			<div></div>
			</div>
			<script>
        document.addEventListener('DOMContentLoaded', function() {
            var manqq = document.getElementById("manqq");
            var keepman = document.getElementById("keepman");

            if (manqq && keepman) {
                // 读取文件内容并填充到输入框
                fetch('../data/ZZ_QQ.txt')
                    .then(response => response.text())
                    .then(data => {
                        manqq.value = data;
                    })
                    .catch(error => {
                        console.error('读取文件时发生错误:', error);
                    });

        // 为保存按钮添加点击事件
        keepman.addEventListener('click', async function() {
            try {
                // 发送AJAX请求到同一PHP文件
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    body: JSON.stringify({ content: manqq.value }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.status}`);
                }

                const data = await response.text();
                console.log("数据已保存", data);
                window.location.href = "xb_panel_setting.php";
            } catch (error) {
                console.error('写入文件时发生错误:', error);
            }
        });
    } else {
        console.error('元素不存在或未正确获取');
    }
});
        document.addEventListener('DOMContentLoaded', function() {
            var webtageInput = document.getElementById("webtage");
            var keepwebtageButton = document.getElementById("keepwebtage");

            if (webtageInput && keepwebtageButton) {
                // 读取网站标题并填充到输入框
                fetch('../data/WZBT.txt')
                    .then(response => response.text())
                    .then(data => {
                        webtageInput.value = data.trim();
                    })
                    .catch(error => console.error('读取文件时发生错误:', error));

        // 为保存按钮添加点击事件
        keepwebtageButton.addEventListener('click', async function() {
            try {
                // 发送POST请求到PHP处理脚本
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    body: JSON.stringify({ title: webtageInput.value }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.status}`);
                }

                const data = await response.text();
                console.log("标题已保存", data);
                window.location.href = "xb_panel_setting.php";
            } catch (error) {
                console.error('写入文件时发生错误:', error);
            }
        });
    } else {
        console.error('元素不存在或未正确获取');
    }
});
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = json_decode(file_get_contents('php://input'), true);

    // 检查是否有'content'键存在，这取决于前端发送的数据结构
    if (isset($content['content'])) {
        if (file_put_contents('../data/ZZ_QQ.txt', $content['content'])) {
            echo "数据已保存";
        } else {
            http_response_code(500);
            echo "保存数据时出错";
        }
    }

    // 检查是否有'title'键存在
    if (isset($content['title'])) {
        if (file_put_contents('../data/WZBT.txt', $content['title'])) {
            echo "标题已成功保存";
        } else {
            http_response_code(500);
            echo "保存标题时出错";
        }
    }

    exit;
}
?>

		</div>
		
		<div id="shadow" style="display:none">
			<div id="top_left_div">
				<h2 style="margin-left:20px;">修改账户</h1>
				<p style="color:deepskyblue;margin-left:20px;margin-bottom:0px;">基础设置</p>
				<hr  style="border-color:deepskyblue;margin-left:20px;margin-right:20px;margin-bottom:0px;">
				<div class="rjpzcon"><span class="rjpzt">账号：</span><textarea name="username" class="rjpz" rows="1" cols="5"></textarea></div>
				<div class="rjpzcon"><span class="rjpzt">密码：</span><textarea name="xkey" class="rjpz" rows="1" cols="25"></textarea></div>
				<!--<div class="rjpzcon"><span class="rjpzt">邮箱：</span><textarea class="rjpz" rows="1" cols="25"></textarea></div>-->
				<div style="display: flex;justify-content: flex-end;margin:30px">
					<span id="quxiao">取消</span>
					<span id="queren">确认</span>
				</div>
			</div>
		</div>
		
		<!--
		<div id="shadow_keepman" style="display:none">
			<div id="top_left_div_keepman">
				<h2 style="margin-left:20px;">修改账户</h1>
				<p style="color:deepskyblue;margin-left:20px;margin-bottom:0px;">基础设置</p>
				<hr  style="border-color:deepskyblue;margin-left:20px;margin-right:20px;margin-bottom:0px;">
				<div class="rjpzcon"><span class="rjpzt">账号：</span><textarea name="username" class="rjpz" rows="1" cols="5"></textarea></div>
				<div class="rjpzcon"><span class="rjpzt">密码：</span><textarea name="xkey" class="rjpz" rows="1" cols="25"></textarea></div>
				<div style="display: flex;justify-content: flex-end;margin:30px">
					<span id="quxiao_keepman">取消</span>
					<span id="queren_keepman">确认</span>
				</div>
			</div>
		</div>
		-->
		<!--这是给keepman准备的，要用自己修(不要就自己删)-->
	</body>

<script>
var usernameInput = document.querySelector('textarea[name="username"]');
var xkeyInput = document.querySelector('textarea[name="xkey"]');
var pppp=document.getElementById("pppp");
var quxiao=document.getElementById("quxiao");
var queren = document.getElementById("queren");
var shadow=document.getElementById("shadow");

pppp.onclick=function(){
	shadow.style.display="block";
}
quxiao.onclick=function(){
	shadow.style.display="none";
}

queren.onclick = function() {
    // 获取输入值
    var username = usernameInput.value;
    var xkey = xkeyInput.value;

    // 发送Ajax请求
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "Update_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText); // 响应消息
            // 根据服务器响应做进一步处理
        }
    };
    xhr.send("username=" + encodeURIComponent(username) + "&xkey=" + encodeURIComponent(xkey));

    // 关闭弹窗
    shadow.style.display = "none";
};
</script>
	<script src="../js/menu.js"></script>
</html>