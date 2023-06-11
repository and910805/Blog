<?php
// 在这里添加数据库连接代码
$db = mysqli_connect("localhost", "root", "nttucsie", "database_name");
if (!$db) {
  die("数据库连接错误：" . mysqli_connect_error());
}

// 获取要发送的消息
$message = $_POST['message'];

// 在这里添加发送消息的逻辑
// 根据需求编写代码来发送消息

// 示例代码，插入新的消息记录到数据库
$query = "INSERT INTO chat_messages (sender_id, receiver_id, message_content) VALUES ('{$_SESSION['user_id']}', '$receiverId', '$message')";
$result = mysqli_query($db, $query);
if (!$result) {
  die("发送消息错误：" . mysqli_error($db));
}

// 返回成功响应给客户端
echo "消息发送成功";
?>
