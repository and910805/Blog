<?php
session_start();

if (isset($_SESSION['username'])) {
  // 檢查是否有選擇檔案
  if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $username = $_SESSION['username'];
    $avatar = $_FILES['avatar'];

    // 檢查上傳的檔案類型
    $allowedTypes = ['image/jpeg', 'image/png'];
    if (in_array($avatar['type'], $allowedTypes)) {
      // 指定照片儲存的路徑和檔名
      $uploadDir = 'uploads/';
      $filename = $username . '_' . time() . '_' . $avatar['name'];
      $uploadPath = $uploadDir . $filename;

      // 將檔案移動到指定路徑
      if (move_uploaded_file($avatar['tmp_name'], $uploadPath)) {
        // 更新使用者的頭像資訊
        $db = mysqli_connect("localhost", "root", "nttucsie", "blog");
        if (!$db) {
          die("Database connection error: " . mysqli_connect_error());
        }

        $query = "UPDATE users SET avatar_url='$uploadPath' WHERE username='$username'";
        mysqli_query($db, $query);
        mysqli_close($db);

        // 重新導向到原始頁面
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
      } else {
        echo "照片上傳失敗";
      }
    } else {
      echo "只允許上傳 JPEG 和 PNG 格式的照片";
    }
  } else {
    echo "未選擇照片";
  }
} else {
  echo "請先登入";
}
?>
