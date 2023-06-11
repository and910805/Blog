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

// 檢查是否有指定要加為好友的使用者 ID
if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($db, $_GET['user_id']);
    
    // 檢查是否已經是好友關係
    $query = "SELECT * FROM friends WHERE (user_id_1 = {$_SESSION['user_id']} AND user_id_2 = $user_id) OR (user_id_1 = $user_id AND user_id_2 = {$_SESSION['user_id']})";
    $result = mysqli_query($db, $query);
    if (!$result) {
        die("Database query error: " . mysqli_error($db));
    }
    
    if (mysqli_num_rows($result) > 0) {
        // 已經是好友，顯示錯誤訊息
        echo "您已經是該使用者的好友。";
    } else {
        // 還不是好友，執行加好友動作
        $query = "INSERT INTO friends (user_id_1, user_id_2) VALUES ({$_SESSION['user_id']}, $user_id)";
        if (mysqli_query($db, $query)) {
            echo "已成功加為好友。";
        } else {
            die("Database query error: " . mysqli_error($db));
        }
    }
}

mysqli_close($db);
?>
