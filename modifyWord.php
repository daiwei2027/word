<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div id="right">
        <?php
        ini_set('display_errors', 'On');
        $servername = "localhost";
        $username = "root";
        $password = "@Passw0rd";
        $dbname = "word";

        // 创建连接
        $conn = new mysqli($servername, $username, $password, $dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }

        $conn->query("SET NAMES UTF8");

        date_default_timezone_set("Asia/Shanghai");	

        $sql = "UPDATE word SET word='" . $_POST["word"] . "',mean='" . $_POST["mean"] . "' WHERE id=" . $_GET["id"];

        if ($conn->query($sql) === TRUE) {
            echo $id = $conn->insert_id;
            echo "新记录插入成功";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $current = $_GET["current"];

        $conn->close();
        header("Location: http://192.168.1.6/word/view.php?current=" . $current);
        ?>
    </div>
</body>

</html>
