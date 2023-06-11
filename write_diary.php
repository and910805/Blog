<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>寫日記</title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .form-container {
      width: 400px;
      text-align: center;
    }

    .form-container label {
      display: block;
      margin-bottom: 10px;
    }

    .form-container textarea {
      width: 100%;
      resize: vertical;
    }

    .form-container input[type="submit"] {
      padding: 10px 20px;
      border: 2px solid red;
      border-radius: 5px;
      text-decoration: none;
      color: red;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h1>寫日記----><a href='home.php'><button>返回小屋</button></a></h1>

  <?php
  session_start();
  // 檢查是否有登入
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $db = mysqli_connect("localhost", "root", "nttucsie", "blog");
    if (!$db) {
      die("Database connection error: " . mysqli_connect_error());
    }

    if (isset($_POST['submit'])) {
      $title = $_POST['title'];
      $content = $_POST['content'];
      $created_at = date('Y-m-d H:i:s');

      // 將日記資料插入到資料庫
      $query = "INSERT INTO diary (username, title, content, created_at) VALUES ('$username', '$title', '$content', '$created_at')";
      $result = mysqli_query($db, $query);
      if ($result) {
        echo "<span><strong>日記已儲存成功</strong></span>";
      } else {
        echo "<span>日記儲存失敗</span>";
      }
    }

    // 顯示日記撰寫表單
    echo "<form action='write_diary.php' method='POST'>";
    echo "<label for='title'>標題：</label>";
    echo "<input type='text' id='title' name='title' required><br><br>";
    echo "<label for='content'>內容：</label><br>";
    echo "<textarea id='content' name='content' rows='10' cols='30' required></textarea><br><br>";
    echo "<input type='submit' name='submit' value='儲存日記'>";
    echo "</form>";
    

    mysqli_close($db);
  } else {
    echo "<p>請先登入</p>";
  }
  ?>

</body>
</html>
