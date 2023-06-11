<!DOCTYPE html>
<html>
<head>
	<title>登入 | 罐頭blog</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="assets/css/login_style.css">
</head>
<body>
	<header>
		<h1>罐頭blog</h1>
	</header>
	<div class="login">
		<h2>會員登入</h2>
		<form action="login.php" method="post">
			<label>使用者名稱 :</label>
			<input type="text" name="username" placeholder="請輸入使用者名稱" required>
			<label>密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;碼 :</label>
			<input type="password" name="password" placeholder="請輸入密碼" required>
			<input type="submit" value=" 登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;入 ">
		</form>
		<p>還不是會員？<a href="register.php">註冊</a></p>
	</div>
</body>
</html>


<?php
session_start();

if(isset($_SESSION['username'])&&$_SESSION['username']!='@') {
	setcookie("username", $_SESSION['username'], time() + 3600, "/");
	
    header('Location: index.php');
    exit();
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mysqli = new mysqli("localhost", "root", "nttucsie", "blog");
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
			$_SESSION['user_id'] = $row['id']; 
            header('Location: index.php');
            exit();
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('Invalid username');</script>";
    }
    $mysqli->close();
}
?>

