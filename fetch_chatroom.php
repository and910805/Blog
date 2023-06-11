<?php
session_start();

// 連接到數據庫
$db = mysqli_connect("localhost", "root", "nttucsie", "blog");
if (!$db) {
    die("Database connection error: " . mysqli_connect_error());
}

// 從數據庫檢索最新的留言
$sql = "SELECT * FROM chatroom ORDER BY created_at DESC LIMIT 10";
$result = mysqli_query($db, $sql);
$chatrooms = mysqli_fetch_all($result, MYSQLI_ASSOC);

// 生成 HTML 聊天室列表
$html = '';
foreach ($chatrooms as $chatroom) {
    $html .= '<li>';
    $html .= '<h4>匿名：</h4>';
    $html .= '<p>' . $chatroom["content"] . '</p>';
    $html .= '<p>發表於：' . $chatroom["created_at"] . '</p>';
    $html .= '</li>';
}

echo $html;
?>
