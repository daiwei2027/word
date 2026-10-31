<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>首页</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div id="content">
		<?php
		$servername = 'localhost';
		$username = 'root';
		$password = '@Passw0rd';
		$dbname = 'word';
		$id = $_GET["id"];
		$current = $_GET["current"];

		// 创建连接
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die('连接失败: ' . $conn->connect_error);
		}
		$sql = 'SELECT * FROM word WHERE id=' . $id;
		$result = $conn->query($sql);
		$row = $result->fetch_row();
		?>
		<form action="modifyWord.php?id=<?php echo $id; ?>&current=<?php echo $current; ?>" method="post">
			书名：<input type="text" name="word" value="<?php echo $row[1]; ?>"><br>
			章节：<input type="text" name="mean" value="<?php echo $row[2]; ?>"><br>
			<input type="submit"><br>
			<input type="reset">
		</form>
	</div>
</body>

</html>
