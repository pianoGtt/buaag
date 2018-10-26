//设置背景画布
var canvas = document.getElementById('canvas');

//设置画笔
var brush = canvas.getContext('2d');

//初始数据
var P = 10;					//最小像素单位
var score = 0;				//得分
var level = 0;				//级别
var speed = 100;			//速度
var X = 250;				//蛇头X坐标
var Y = 250;				//蛇头Y坐标
var isStart = false;		//是否已经开始游戏
var currentDirection = 38;	//当前方向
var cW = 500;				//画布宽度 需要跟外面canvas统一
var cH = 500;				//画布高度 需要跟外面canvas统一
var loop;					//循环体
var headColor = '#F8CD76';	//蛇头颜色
var bodyColor = '#75F94C';	//蛇身颜色
var foodColor = '#FFFFFF';	//食物颜色
var lock = false;			//卡键锁死

//方向 37左 38上 39右 40下
var allowDirection = [37, 38, 39, 40];

//初始蛇身
var snakeBody = [[X, Y], [X, Y+P], [X, Y+P*2], [X, Y+P*3], [X, Y+P*4]];

//初始食物
var food = [];

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
			loop = setInterval(move, speed);
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

//移动
function move()
{
	//左移动
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

	//判断是否吃豆
	if(food.length > 0)
	{
		let fX = food[0][0];
		let fY = food[0][1];
		if(snakeBody[0][0] === fX && snakeBody[0][1] === fY )
		{
			add();
			createFood();
		}
	}

	//判断是否撞墙
	isOutSide();

	//判断是否自杀
	isKillSelf();
}

//初始蛇的位置
function initSnake()
{
	//绘制新的蛇身
	for(i=0;i<=snakeBody.length - 1;i++)
	{
		if(i === 0)
		{
			brush.fillStyle = headColor;
			brush.fillRect(snakeBody[i][0], snakeBody[i][1], P, P);
		}
		else
		{
			brush.fillStyle = bodyColor;
			brush.fillRect(snakeBody[i][0], snakeBody[i][1], P, P);
		}
	}
}

//画蛇
function drawSnake(mX = 0, mY = 0)
{
	//复制一份蛇身体,原身体用于清除原先点位
	let tempShakeBody = JSON.parse(JSON.stringify(snakeBody));

	//删掉蛇尾
	brush.clearRect(snakeBody[snakeBody.length-1][0], snakeBody[snakeBody.length-1][1], P, P);

	//绘制新的蛇身
	for(i=0;i<=snakeBody.length - 1;i++)
	{
		if(i === 0)
		{
			brush.fillStyle = headColor;
			snakeBody[i][0] += mX;
			snakeBody[i][1] += mY;
			brush.fillRect(snakeBody[i][0], snakeBody[i][1], P, P);
		}
		else
		{
			brush.fillStyle = bodyColor;
			snakeBody[i][0] = tempShakeBody[i-1][0];
			snakeBody[i][1] = tempShakeBody[i-1][1];
			brush.fillRect(snakeBody[i][0], snakeBody[i][1], P, P);
		}
	}

	lock = false;
}

//添加蛇身
function add()
{
	let sw = snakeBody[snakeBody.length - 1];
	let sw2 = snakeBody[snakeBody.length - 2];

	let pX = sw[0] - sw2[0] + sw[0];
	let pY = sw[1] - sw2[1] + sw[1];

	snakeBody.push([pX, pY]);
	food.pop();

	score += 1;
	document.getElementById('score').innerHTML = score;

	detectLevel();
	createFood();
}

//移动
function changeDirection(direction)
{
	switch(currentDirection)
	{
		case 37:
			if(direction === 38 || direction === 40)
			{
				if(lock === false)
				{
					currentDirection = direction;
					lock = true;
				}
			}
			break;
		case 38:
			if(direction === 37 || direction === 39)
			{
				if(lock === false)
				{
					currentDirection = direction;
					lock = true;
				}
			}
			break;
		case 39:
			if(direction === 38 || direction === 40)
			{
				if(lock === false)
				{
					currentDirection = direction;
					lock = true;
				}
			}
			break;
		case 40:
			if(direction === 37 || direction === 39)
			{
				if(lock === false)
				{
					currentDirection = direction;
					lock = true;
				}
			}
			break;
	}
}

//是否自杀
function isKillSelf()
{
	for(i=1;i<=snakeBody.length - 1;i++)
	{
		if(snakeBody[0][0] === snakeBody[i][0] && snakeBody[0][1] === snakeBody[i][1])
		{
			clearInterval(loop);
			alert('你啃到自己了,最终得分:' + score);
			reset();
		}
	}
}

//是否撞墙
function isOutSide()
{
	if(snakeBody[0][0] < 0 || snakeBody[0][1] < 0 || snakeBody[0][0] > (cW - P) || snakeBody[0][1] > (cH - P))
	{
		clearInterval(loop);
		alert('你撞墙上了,最终得分:' + score);
		reset();
	}
}

//随机生成食物
function createFood()
{
	if(food.length === 0)
	{
		let fX = Math.floor(Math.random()*(cW-P+1) / P) * P;
		let fY = Math.floor(Math.random()*(cH-P+1) / P) * P;

		let c = brush.getImageData(fX, fY, P, P).data;
		let red = c[0];
		let green = c[1];
		let blue = c[2];

		//没有被占用颜色格子的才能生成食物
		if(red === 0 && green === 0 && blue === 0)
		{
			brush.fillStyle = foodColor;
			brush.fillRect(fX, fY, P, P);

			food.push([fX, fY]);
		}
		else
		{
			createFood();
		}
	}
}

//重置游戏
function reset()
{
	return window.location.reload();
}

//检测级别
function detectLevel()
{
	if(score >= 6 && score <= 10 && level !== 2)
	{
		level = 2;
		document.getElementById('level').innerHTML = level;

		speed -= 20;
		clearInterval(loop);
		loop = setInterval(move, speed);
	}
	else if(score >= 11 && score <= 15 && level !== 3)
	{
		level = 3;
		document.getElementById('level').innerHTML = level;

		speed -= 20;
		clearInterval(loop);
		loop = setInterval(move, speed);
	}
	else if(score >= 16 && score <= 20 && level !== 4)
	{
		level = 4;
		document.getElementById('level').innerHTML = level;

		speed -= 20;
		clearInterval(loop);
		loop = setInterval(move, speed);
	}
	else if(score >= 21 && level !== 5)
	{
		level = 5;
		document.getElementById('level').innerHTML = level;

		speed -= 20;
		clearInterval(loop);
		loop = setInterval(move, speed);
	}
}