<?php
session_start();

// 檢查使用者是否已經登入
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 建立資料庫連線
$db = mysqli_connect("localhost", "root", "nttucsie", "blog");
if (!$db) {
    die("Database connection error: " . mysqli_connect_error());
}

// 查詢好友
$query = "SELECT users.username FROM friends JOIN users ON friends.user_id_2 = users.id WHERE friends.user_id_1 = {$_SESSION['user_id']}";
$result = mysqli_query($db, $query);
if (!$result) {
    die("Database query error: " . mysqli_error($db));
}

// 加為好友的表單提交處理
if (isset($_POST['friend_name'])) {
    $friend_name = mysqli_real_escape_string($db, $_POST['friend_name']);

    // 檢查是否已經是好友
    $check_query = "SELECT * FROM friends JOIN users ON friends.user_id_2 = users.id WHERE friends.user_id_1 = {$_SESSION['user_id']} AND users.username = '$friend_name'";
    $check_result = mysqli_query($db, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('該使用者已經是您的好友。');</script>";
    } else {
        // 取得好友的 ID
        $friend_query = "SELECT id FROM users WHERE username = '$friend_name'";
        $friend_result = mysqli_query($db, $friend_query);
        if (!$friend_result) {
            die("Database query error: " . mysqli_error($db));
        }
        $friend_row = mysqli_fetch_assoc($friend_result);
        $friend_id = $friend_row['id'];

        // 新增好友關係
        $insert_query = "INSERT INTO friends (user_id_1, user_id_2) VALUES ({$_SESSION['user_id']}, '$friend_id')";
        if (mysqli_query($db, $insert_query)) {
            echo "<script>alert('加為好友成功。');</script>";
            header("Location: view_friends.php");
            exit();
        } else {
            echo "<script>alert('加為好友失敗，請稍後再試。');</script>";
        }
    }
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>好友列表:</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 40px;
        }
        
        h2 {
            margin-bottom: 10px;
        }
        .button {
		  background-color: #4CAF50;
		  color: #fff;
		  padding: 10px 20px;
		  border: none;
		  border-radius: 5px;
		  transition: background-color 0.3s ease;
		}

		.button:hover {
		  background-color: #45a049;
		}
        .btn {
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #45a049;
        }
		@keyframes gradient-animation {
		  0% { color: #ff0000; }
		  50% { color: #00ff00; }
		  100% { color: #0000ff; }
		}

		h1 {
		  animation: gradient-animation 5s linear infinite;
		}
    </style>
    <script>
        function validateForm() {
            var friendName = document.forms["addFriendForm"]["friend_name"].value;
            if (friendName == "") {
                alert("請輸入好友的名字。");
                return false;
            }
        }
    </script>
</head>
<body>
    <h2>好友列表</h2>

    
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>" . $row['username'] . "</p>";
    }
    ?>

    <form name="addFriendForm" method="POST" action="view_friends.php" onsubmit="return validateForm()">
        <label>輸入好友名字：</label>
        <input type="text" name="friend_name" required>
        <input type="submit" value="加為好友" class="btn">
    </form>
</body>
</html>
