<?php
session_start();

// 檢查使用者是否已登入，如果未登入，將跳轉到 login.php
if(isset($_SESSION['username'])&&$_SESSION['username']!='@') {
}
else{
  header("Location: login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $content = $_POST['chatroom']; // 從表單中獲取留言內容
  $user_id = $_SESSION['user_id']; // 從會話中獲取使用者ID

  // 建立與資料庫的連線
  $db = mysqli_connect("localhost", "root", "nttucsie", "blog");
  
  // 檢查連線是否成功
  if ($db->connect_error) {
    die("連線失敗： " . $db->connect_error);
  }

  // 將留言插入到資料庫
  $sql = "INSERT INTO chatroom (user_id, content) VALUES ('$user_id', '$content')";
  if ($db->query($sql) === TRUE) {
    echo "留言已插入到資料庫";
  } else {
    echo "插入留言時發生錯誤： " . $db->error;
  }

  // 關閉資料庫連線
  $db->close();

  // 跳轉回聊天室頁面
  header("Location: chat.php");
  exit();
}

?>
