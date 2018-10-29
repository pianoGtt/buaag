<!DOCTYPE HTML>
<!--@author yang-->
<!--v1.2-->
<!--修复按快了以后自杀问题-->
<!--优化移动算法 按键后立刻移动-->
<!--优化了美工 :)-->
<html>
	<head>
		<title>canvas贪吃蛇</title>
		<link rel="stylesheet" type="text/css" href="./snake.css">
	</head>
	<body>
		<canvas id="canvas" width="500" height="500"></canvas>
		<div id="markpad">
			<p>Score:<span id="score">0</span></p>
			<p>Level:<span id="level">1</span></p>
			<p><font size="1">按回车开始游戏 5分一级 逐级加速</font></p>
			<p><font size="1">操作说明：小键盘 ↑↓←→</font></p>
		</div>
		<script src="./snake.js" type="text/javascript"></script>
	</body>
</html>