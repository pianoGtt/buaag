//设置背景画布
var canvas = document.getElementById('canvas');

//设置画笔
var brush = canvas.getContext('2d');

//初始数据
var P = 10;					//最小像素单位
var score = 0;				//得分
var level = 1;				//级别
var speed = 500;			//速度
var X = 250;				//蛇头X坐标
var Y = 250;				//蛇头Y坐标
var isStart = false;		//是否已经开始游戏
var currentDirection = 38;	//当前方向
var cW = 500;				//画布宽度 需要跟外面canvas统一
var cH = 500;				//画布高度 需要跟外面canvas统一
var loop;					//循环体
var step = 5;				//升级豆数
var headColor = '#F8CD76';	//蛇头颜色
var bodyColor = '#75F94C';	//蛇身颜色
var foodColor = '#FFF';		//食物颜色
var strokeColor = '#000';	//蛇身边框颜色

//方向 37左 38上 39右 40下
var allowDirection = [37, 38, 39, 40];

//初始蛇身
var snakeBody = [[X, Y], [X, Y+P], [X, Y+P*2], [X, Y+P*3], [X, Y+P*4]];

//初始食物
var food = [];
var maxFood = 3;

//初始化
initSnake();

//监听键盘事件
window.onkeyup = function(key)
{
	if(isStart === false)
	{
		if(key.keyCode === 13)
		{
			isStart = true;
			alert('开始游戏');
			createFood();
			loop = setInterval(run, speed);
		}
	}
	else
	{
		if(allowDirection.indexOf(key.keyCode) > -1)
		{
			changeDirection(key.keyCode);
		}
	}
}

//初始蛇的位置
function initSnake()
{
	//绘制初始的蛇身
	for(i=0;i<=snakeBody.length - 1;i++)
	{
		if(i === 0)
		{
			brush.fillStyle = headColor;
			
		}
		else
		{
			brush.fillStyle = bodyColor;	
		}

		brush.strokeStyle = strokeColor;
		brush.fillRect(snakeBody[i][0], snakeBody[i][1], P, P);
		brush.strokeRect(snakeBody[i][0], snakeBody[i][1], P, P);
	}
}

//画蛇
function drawSnake(mX = 0, mY = 0)
{
	//删除原先蛇所在的图层
	for(i=0;i<=snakeBody.length-1;i++)
	{
		brush.clearRect(snakeBody[i][0], snakeBody[i][1], P, P);
	}

	//绘制新的移动后的蛇图层
	for(i=snakeBody.length-1;i>=0;i--)
	{
		if(i === 0)
		{
			snakeBody[i][0] = X += mX;
			snakeBody[i][1] = Y += mY;
			brush.fillStyle = headColor;
		}
		else
		{
			snakeBody[i][0] = snakeBody[i-1][0];
			snakeBody[i][1] = snakeBody[i-1][1];
			brush.fillStyle = bodyColor;
		}

		brush.strokeStyle = strokeColor;
		brush.fillRect(snakeBody[i][0], snakeBody[i][1], P, P);
		brush.strokeRect(snakeBody[i][0], snakeBody[i][1], P, P);
	}

	//判断是否吃豆
	eat(X,Y);

	//判断是否撞墙
	isOutSide(X,Y);

	//判断是否自杀
	isKillSelf(X,Y);

	console.log(speed);
}

//运行
function run()
{
	if(currentDirection === 37)
	{
		drawSnake(-P);
	}
	//上移动
	else if(currentDirection === 38)
	{
		drawSnake(0 , -P);
	}
	//右移动
	else if(currentDirection === 39)
	{
		drawSnake(P);
	}
	//下移动
	else if(currentDirection === 40)
	{
		drawSnake(0 , P);
	}
}

//移动
function changeDirection(direction)
{
	switch(currentDirection)
	{
		case 37:
			switch(direction)
			{
				case 37:
					_move(direction, -P);
				break;
				case 38:
					_move(direction, 0, -P);
				break;
				case 40:
					_move(direction, 0, P);
				break;
			}
		break;
		case 38:
			switch(direction)
			{
				case 38:
					_move(direction, 0, -P);
				break;
				case 37:
					_move(direction, -P);
				break;
				case 39:
					_move(direction, P);
				break;
			}
		break;
		case 39:
			switch(direction)
			{
				case 39:
					_move(direction, P);
				break;
				case 38:
					_move(direction, 0, -P);
				break;
				case 40:
					_move(direction, 0, P);
				break;
			}
		break;
		case 40:
			switch(direction)
			{
				case 40:
					_move(direction, 0, P);
				break;
				case 37:
					_move(direction, -P);
				break;
				case 39:
					_move(direction, P);
				break;
			}
		break;
	}
}

//移动
function _move(direction, mX = 0, mY = 0)
{
	drawSnake(mX, mY);
	currentDirection = direction;
}

//吃豆
function eat(eX, eY)
{
	for(i=0;i<food.length;i++)
	{
		if(eX === food[i][0] && eY === food[i][1])
		{
			//获取蛇尾坐标和次蛇尾坐标
			let sw = snakeBody[snakeBody.length - 1];
			let sw2 = snakeBody[snakeBody.length - 2];

			//计算XY坐标差值获取要添加的蛇身方向
			let aX = sw[0] - sw2[0] + sw[0];
			let aY = sw[1] - sw2[1] + sw[1];

			food.splice(i,1);
			snakeBody.push([aX, aY]);

			score += 1;
			document.getElementById('score').innerHTML = score;

			detectLevel();
			createFood();
		}
	}
}

//是否自杀
function isKillSelf(kX, kY)
{
	for(i=1;i<=snakeBody.length - 1;i++)
	{
		if(kX === snakeBody[i][0] && kY === snakeBody[i][1])
		{
			reset('你啃到自己了,最终得分:' + score);
		}
	}
}

//是否撞墙
function isOutSide(oX, oY)
{
	if(oX < 0 || oY < 0 || oX > (cW - P) || oY > (cH - P))
	{
		reset('你撞墙上了,最终得分:' + score);
	}
}

//随机生成食物
function createFood()
{
	//当前食物数量
	let cFood = food.length;

	if(cFood < maxFood)
	{
		for(i=cFood;i<maxFood;)
		{
			//随机获取XY坐标
			let fX = Math.floor(Math.random() * (cW - P*2 + 1) / P) * P;
			let fY = Math.floor(Math.random() * (cW - P*2 + 1) / P) * P;

			//获取该坐标下RGB颜色
			let c = brush.getImageData(fX, fY, P, P).data;
			let red = c[0];
			let green = c[1];
			let blue = c[2];

			//没有被占用颜色格子的才能生成食物
			if(red === 0 && green === 0 && blue === 0)
			{
				brush.fillStyle = foodColor;
				brush.fillRect(fX, fY, P, P);

				brush.strokeStyle = strokeColor;
				brush.strokeRect(fX, fY, P, P);

				food.push([fX, fY]);
				i++;
			}
		}
	}
}

//重置游戏
function reset(msg)
{
	clearInterval(loop);
	alert(msg);
	return window.location.reload();
}

//检测级别
function detectLevel()
{
	let newLevel = Math.ceil(score/step);
	if(newLevel > level)
	{
		clearInterval(loop);

		level = newLevel;
		speed -= 50;
		document.getElementById('level').innerHTML = level;

		loop = setInterval(run, speed);
	}
}