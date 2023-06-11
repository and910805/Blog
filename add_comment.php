<?php
session_start(); // 开始会话

if(isset($_SESSION['username'])&&$_SESSION['username']!='@') {
}
else{
    header("Location: login.php"); // 重定向到登录页面
    exit();
}

// 如果已登录，则继续插入评论的代码
$db = mysqli_connect("localhost", "root", "nttucsie", "blog");
if (!$db) {
    die("Database connection error: " . mysqli_connect_error());
}

if (isset($_POST['post_id']) && isset($_POST['comment']) && isset($_POST['user_id'])) {
    $post_id = mysqli_real_escape_string($db, $_POST['post_id']);
    $comment = mysqli_real_escape_string($db, $_POST['comment']);
    $user_id = mysqli_real_escape_string($db, $_POST['user_id']);

    $query = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES ('$post_id', '$user_id', '$comment', NOW())";

    if (mysqli_query($db, $query)) {
        mysqli_close($db);
        header("Location: index.php?id=$post_id");
        exit();
    } else {
        die("Database query error: " . mysqli_error($db));
    }
} else {
    die("Missing required parameters.");
}
mysqli_close($db);

?>
