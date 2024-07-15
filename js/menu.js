var elements = document.getElementsByClassName('left_choice_menu_option_alldiv');
for (var i = 0; i < elements.length; i++) {
	elements[i].addEventListener('mouseover', function() {
		if (!this.classList.contains('click')) {
			this.style.backgroundColor = 'lightblue';
		}
	});

	elements[i].addEventListener('mouseout', function() {
		if (!this.classList.contains('click')) {
			this.style.backgroundColor = 'white';
		}
	});
}
//判定是否有点击过这个按钮，没点击过就按照悬停时为lightblue色，离开时为white色




var panel_home_page = document.getElementById("panel_home_page");
panel_home_page.onclick = function() {
	window.open("xb_panel.php",'_self');
}


var software_list = document.getElementById("software_list");
software_list.onclick = function() {
	window.open("xb_panel_list.php",'_self');
}

var security_policy = document.getElementById("security_policy");
security_policy.onclick = function() {
	window.open("xb_panel_waf.php",'_self');
}

var about_us = document.getElementById("about_us");
about_us.onclick = function() {
	window.open("xb_panel_about.php",'_self');
}

var panel_setting = document.getElementById("panel_setting");
panel_setting.onclick = function() {
	window.open("xb_panel_setting.php",'_self');
}