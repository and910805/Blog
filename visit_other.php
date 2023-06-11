<?php
session_start();
if (isset($_POST['submit'])) {
  $other_username = $_POST['username'];
  
  // 檢查是否有登入
  if (isset($_SESSION['username'])) {
    $current_username = $_SESSION['username'];
    
    // 檢查使用者是否存在
    $db = mysqli_connect("localhost", "root", "nttucsie", "blog");
    if (!$db) {
      die("Database connection error: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM users WHERE username='$other_username'";
    $result = mysqli_query($db, $query);
    if ($result && mysqli_num_rows($result) > 0) {
      // 使用者存在，導向該使用者的小屋
      $_SESSION['visited_user'] = $other_username; // 儲存要拜訪的使用者名稱
      header("Location: home.php");
      exit();
    } else {
      // 使用者不存在，顯示錯誤訊息
      echo "找不到該使用者";
    }
    
    mysqli_close($db);
  } else {
    echo "請先登入";
  }
} elseif (isset($_SESSION['visited_user'])) {
  // 如果有儲存的要拜訪的使用者名稱，將使用者切換回來
  $visited_user = $_SESSION['visited_user'];
  unset($_SESSION['visited_user']); // 刪除暫存的要拜訪的使用者名稱
  $_SESSION['username'] = $visited_user;
}
?>
