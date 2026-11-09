<?php session_start(); ?>
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
        $servername = 'localhost';
        $username = 'root';
        $password = '@Passw0rd';
        $dbname = 'word';

        // 创建连接
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die('连接失败: ' . $conn->connect_error);
        }

        $current = 1;
        $start = 0;

        if ($_GET["current"]) {
            $current = $_GET["current"];
            $start = ($_GET["current"] - 1) * 10;
        }

        if ($_POST["word"]) {
            $sql = "SELECT * FROM word WHERE word='" . $_POST["word"] . "'";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            echo $row[0] . $row[1] . $row[2] . $row[3];
            echo "<table style='border:1px solid black;'><tr><th>id</th><th>单词</th><th>含义</th><th>日期</th><th></th><th></th></tr>";
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td class='green'>" . $row[2] . "</td><td>" . $row[3] . "</td><td><a href='beforeModify.php?id=" . $row[0] . "&current=" . $current . "'>修改单词</a><td></td></td></tr>";
            echo "</table>";
            $sql = 'SELECT count(*) FROM word WHERE id < ' . $row[0] . ' ORDER BY id DESC';
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            $items = $row[0];
            $current = (int)($items / 10 + 1);
        } else {

            $sql = 'SELECT * FROM word LIMIT ' . $start . ', 10';
            $result = $conn->query($sql);
            echo "<table style='border:1px solid black;'><tr><th>id</th><th>单词</th><th>含义</th><th>日期</th><th></th><th></th></tr>";
            if ($result->num_rows > 0) {
                // 输出数据
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["word"] . "</td><td class='green'>" . $row["mean"] . "</td><td>" . $row["date"] . "</td><td><a href='beforeModify.php?id=" . $row["id"] . "&current=" . $current . "'>修改单词</a><td></td></td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 结果";
            }
        }
        echo "<a href='newWord.php'>新建单词</a>";

        ?>
        <form action="view.php" method="post">
            word：<input type="text" name="word"><br>
            <input type="submit"><br>
            <input type="reset">
        </form>
    </div>
    <div id="nav">
        <?php
        // 创建连接
        // Check connection
        $sql = 'SELECT count(*) FROM word';
        $result = $conn->query($sql);
        $row = $result->fetch_row();
        $pages = 0;
        echo $current;

        if ($row[0] == 0) {
            $pages = 0;
        } else if ($row[0] % 10 == 0) {
            $pages = $row[0] / 10;
        } else {
            $pages = (int) ($row[0] / 10 + 1);
        }
        if ($current > 1) {
            echo "<a class='nav' href='view.php?current=" . $current - 1 . "'>&lt;previous</a>";
        }
        for ($i = 1; $i <= $pages; $i++) {
            if ($i == $current) {
                echo "<a class='nav' href='javascript:void(0);' style='color:gray;'>" . $i . "</a>";
            } else {
                echo "<a class='nav' href='view.php?current=" . $i . "'>" . $i . "</a>";
            }
        }
        if ($current < $pages) {
            echo "<a class='nav' href='view.php?current=" . $current + 1 . "'>next&gt;</a>";
        }
        ?>
    </div>
</body>

</html>