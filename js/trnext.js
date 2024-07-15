var up = document.getElementById("up");
var down = document.getElementById("down"); // 修正拼写错误
var number = document.getElementById("number");

up.onclick = function() {
	var a = parseInt(number.value); // 每次点击时获取最新的值
	if (a > 1) {
		number.value = a - 1; // 直接修改输入框的值
	}
	trcheck()
}

down.onclick = function() {
	var a = parseInt(number.value); // 每次点击时获取最新的值
	if (a < 2) { // 假设 2 是上限，可根据实际情况修改
		number.value = a + 1; // 直接修改输入框的值
	}
	trcheck()
}

function trcheck() {
	for (let i = 1; i <= 2; i++) { // 假设处理到 tr2，可根据实际情况修改
		var element = document.getElementById(`tr${i}`);
		if (element) {
			// 提取 tr 后面的数字
			let num = parseInt(element.id.slice(2));
			// 与输入框的值比较
			if (num === parseInt(number.value)) {
				element.style.display = 'table-row';
			} else {
				element.style.display = 'none';
			}
		}
	}
}
trcheck();

//////////////////////////////////////////////////////

// 点击事件处理函数
number.addEventListener('click', function() {
this.style.border = '3px solid skyblue';
});

// 全局点击事件处理函数
document.addEventListener('click', function(event) {
if (event.target!== number) {
number.style.border = '3px solid #dddddd';
}
});
/////////////////////////////////////////////////////
