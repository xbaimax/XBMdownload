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

  // 分页参数
  $itemsPerPage = 10;
  $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
  $start = ($page - 1) * $itemsPerPage;

  // 获取总记录数
  $totalQuery = "SELECT COUNT(*) AS total FROM app_cards";
  $resultTotal = $conn->query($totalQuery);
  $rowTotal = $resultTotal->fetch_assoc();
  $totalItems = $rowTotal['total'];
  $totalPages = ceil($totalItems / $itemsPerPage);

  // 执行分页查询
  $query = "SELECT * FROM app_cards LIMIT $start, $itemsPerPage";
  $result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>项目列表——软麟panel</title>
		<link type="image/x-icon" rel="shortcut icon" href="../img/logo.jpg">
		<link rel="stylesheet" type="text/css" href="../css/software_list.css">
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

				<div class="click" id="software_list">
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

				<div class="left_choice_menu_option_alldiv" id="panel_setting">
					<img class="left_choice_menu_option_allimg" src="../img/sit.svg"><span
						class="left_choice_menu_option_allspan">面板设置</span>
				</div>
				<div style="display:flex;justify-content: center;">
					<div style="position:absolute;bottom:2%;">©小白</div>
				</div>
			</div>
		</div>
		
		    <div id="center_show_choice">
			    <div id="top">
				    <span id="top_left">添加实例</span>
				    <a href="https://qm.qq.com/q/vRmp5iRTaw" class=“tda”><span id="top_right">官方Q群</span></a>
		    </div>
	
			<div id="center">
				<table>
					<tr style="background-color:#fbfbfb;">
						<th class="xiangmu">软件列表</th>
						<th class="xiangmu">平台</th>
						<th class="xiangmu">版本号</th>
						<th class="xiangmu">内容</th>
						<th class="xiangmu">操作</th>
					</tr>
					<?php while ($row = $result->fetch_assoc()): ?>
						<tr>
							<td><?php echo htmlspecialchars($row['app_title']); ?></td>
							<td><?php echo htmlspecialchars($row['app_platform']); ?></td>
							<td><?php echo htmlspecialchars($row['app_version']); ?></td>
							<td><?php echo htmlspecialchars($row['app_description']); ?></td>
							<td>
                            <!-- 编辑链接 -->
                            <a class="tda" href="xb_panel_edit.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                                <span class="aandd">编辑</span>
                            </a>
    
                            <!-- 删除链接，添加JavaScript确认 -->
                            <a class="tda" href="javascript:void(0);" onclick="return confirmDelete(<?php echo $row['id']; ?>);">
                                <span class="aandd">删除</span>
                            </a>
                        </td>
						</tr>
					<?php endwhile; ?>
				</table>
			</div>
			<div id="trnext">
				<span id="up" class="trnext_s" onclick="changePage(<?php echo max(1, $page - 1); ?>)">上一页</span>
				<input id="number" type="text" value="<?php echo $page; ?>" oninput="trcheck()">
				<span id="down" class="trnext_s" onclick="changePage(<?php echo min($totalPages, $page + 1); ?>)">下一页</span>
				<script>
					function changePage(pageNum) {
						if (pageNum >= 1 && pageNum <= <?php echo $totalPages; ?>) {
							window.location.href = "?page=" + pageNum;
						}
					}
					function trcheck() {
						var pageNumber = document.getElementById("number").value;
						if (pageNumber >= 1 && pageNumber <= <?php echo $totalPages; ?>) {
							window.location.href = "?page=" + pageNumber;
						}
					}
				</script>
			</div>
		</div>

	<div id="shadow">
		<div id="top_left_div">
			<h2 style="margin-left:20px;">软件配置</h1>
			<p style="color:deepskyblue;margin-left:20px;margin-bottom:0px;">基础设置</p>
			<hr  style="border-color:deepskyblue;margin-left:20px;margin-right:20px;margin-bottom:0px;">
			<div class="rjpzcon"><span class="rjpzt">软件图标：</span><textarea name="app_icon" class="rjpz" rows="1" cols="25"></textarea></div>
			<div class="rjpzcon"><span class="rjpzt">软件名称：</span><textarea name="app_title" class="rjpz" rows="1" cols="10"></textarea></div>
			<div class="rjpzcon"><span class="rjpzt">软件版本：</span><textarea name="app_version" class="rjpz" rows="1" cols="8"></textarea></div>
			<div class="rjpzcon"><span class="rjpzt">软件平台：</span><textarea name="app_platform" class="rjpz" rows="1" cols="25"></textarea></div>
			<div class="rjpzcon"><span class="rjpzt">相关链接：</span><textarea name="app_source_url" class="rjpz" rows="1" cols="25"></textarea></div>
			<div class="rjpzcon"><span class="rjpzt">软件描述：</span><textarea name="app_description" class="rjpz" rows="2" cols="44"></textarea></div>
			<div class="rjpzcon"><span class="rjpzt">下载链接：</span><textarea name="app_download_url" class="rjpz" rows="2" cols="44"></textarea></div>
			<div style="display: flex;justify-content: flex-end;margin:30px">
    			<span id="quxiao">取消</span>
    			<span id="queren">确认</span>
			</div>
		</div>
	</div>
	<script>
			$(document).ready(function(){
				// 添加实例按钮点击事件
				$("#top_left").click(function(){
					$("#shadow").show(); // 显示配置界面
				});

    $("#queren").click(function(){
        var data = {
            app_icon: $("textarea[name='app_icon']").val(),
            app_title: $("textarea[name='app_title']").val(),
            app_version: $("textarea[name='app_version']").val(),
            app_platform: $("textarea[name='app_platform']").val(),
            app_source_url: $("textarea[name='app_source_url']").val(),
            app_description: $("textarea[name='app_description']").val(),
            app_download_url: $("textarea[name='app_download_url']").val()
        };

        $.ajax({
            type: "POST",
            url: "Add_software.php",
            data: data,
            success: function(response){
                console.log("软件添加成功:", response);
                $("#shadow").hide();
				window.location.href = "xb_panel_list.php";
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.error("软件添加失败:", textStatus, errorThrown);
            }
        });
    });

    $("#quxiao").click(function(){
        $("#shadow").hide();
    });
});

function confirmDelete(id) {
    if (confirm('确定要删除此条目吗？')) {
        window.location.href = 'Delete_software.php?id=' + id;
    }
    return false;
}
</script>
		<script src="../js/menu.js"></script>
		<script src="../js/trnext.js"></script>
	</body>
</html>