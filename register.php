<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Register | Can Blog</title>
	<link rel="stylesheet" href="login_style.css">
	<style>
		form {
			max-width: 500px;
			margin: 20px auto;
			padding: 20px;
			background-color: #fff;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
		}

		input[type="text"], input[type="email"], input[type="password"] {
			display: block;
			width: 100%;
			padding: 10px;
			margin-bottom: 10px;
			font-size: 16px;
			border: none;
			border-radius: 5px;
			background-color: #f2f2f2;
			color: #666;
		}

		input[type="submit"] {
			display: block;
			width: 100%;
			padding: 10px;
			margin-top: 20px;
			border: none;
			border-radius: 5px;
			background-color: #2980b9;
			color: #fff;
			font-size: 18px;
			cursor: pointer;
		}

		label {
			display: block;
			margin-bottom: 10px;
			font-weight: bold;
			color: #666;
		}

		.error {
			color: red;
			font-size: 14px;
			margin-top: 5px;
		}
	</style>
</head>
<body>
	<div class="login-page">
		<div class="form">
			<form class="login-form" method="post">
				<h2>註冊</h2>
				<label>用戶名</label>
				<input type="text" placeholder="請輸入用戶名" name="username" required>
				<label>電子郵件</label>
				<input type="email" placeholder="請輸入電子郵件" name="email" required>
				<label>密碼</label>
				<input type="password" placeholder="請輸入密碼" name="password" required>
				<label>確認密碼</label>
				<input type="password" placeholder="請再次輸入密碼" name="confirm_password" required>
				<input type="submit" name="register" value="註冊">
				<p class="message">已經有帳號了？<a href="login.php">點此登入</a></p>
				<?php if(!empty($error_message)) { ?>
					<p class="error"><?php echo $error_message; ?></p>
				<?php } ?>
			</form>
		</div>
	</div>
</body>
</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $email = $_POST["email"];

  // 建立 MySQL 連線
  $mysqli = new mysqli("localhost", "root", "nttucsie", "blog");

  // 檢查連線是否成功
  if ($mysqli->connect_errno) {
    die("連線失敗：" . $mysqli->connect_error);
  }

  // 檢查帳號是否已存在
  $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    die("帳號已存在！");
  }

  // 建立帳號
  $hashed_password = password_hash($password, PASSWORD_DEFAULT); // 將密碼進行哈希加密
  $stmt = $mysqli->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $hashed_password, $email);
  $stmt->execute();

  // 關閉連線
  $stmt->close();
  $mysqli->close();

  // 跳轉到登入頁面
  header("Location: login.php");
  exit();
}

?>
