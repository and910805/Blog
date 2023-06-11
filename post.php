


<!doctype html>
<html lang="en">
<header id="site-header" class="fixed-top">
  <link href="//fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style-starter.css">
  <div class="container">
      <nav class="navbar navbar-expand-lg stroke p-0">
          <h1> <a class="navbar-brand" href="index.html">
                  <span class="fa fa-bell-o"></span> 罐頭Blog
              </a></h1>
        
          <button class="navbar-toggler  collapsed bg-gradient" type="button" data-toggle="collapse"
              data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="navbar-toggler-icon fa icon-expand fa-bars"></span>
              <span class="navbar-toggler-icon fa icon-close fa-times"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
              <ul class="navbar-nav ml-lg-5 mr-lg-auto">
                  <li class="nav-item active">
                      <a class="nav-link" href="index.php">首頁 <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="about.html">關於</a>
                  </li>
                  <li class="nav-item ">
                      <a class="nav-link" href="contact.html">聯繫</a>
                  </li>
				  
				   <?php
						session_start();
						if(isset($_SESSION['username'])) {
							echo '<li class="nav-item">
									<a class="nav-link" href="logout.php">登出</a>
								  </li>';
						} else {
							echo '<li class="nav-item">
									<a class="nav-link" href="login.php">登入</a>
								  </li>';
						}
					?>

				  
				  <li class="nav-item ">
                      <a class="nav-link" href="post.php">發文!!</a>
                  </li>
				  
              </ul>

          </div>
      </nav>
  </div>
 
</header>
     <body>
  <div class="container mt-5" style="margin-top: 500px;">
   <div class="container">
        <h1>發表文章</h1>
		
		<?php
		
			if(isset($_SESSION['username'])&&$_SESSION['username']!='@') {
			}
			else{
			  header("Location: login.php");
			  exit();
			}echo "<div style=' margin-left: 10px;font-size:20px'><strong>";
	echo $_SESSION['username'] . '你好!' . '這是你自己家<br><br>';
	echo "</strong></div>"; 

			echo "<span style='color: pink; font-weight: bold'>" . $_SESSION['username'] . "</span><span>你好!!要寫甚麼文章?</span>";
			


		?>
        <form action="post.php" method="post">
            <div class="form-group">
                <label for="title">標題：</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">內容：</label>
                <textarea id="content" name="content" rows="10" required></textarea>
            </div>
            <button type="submit">發表</button>
        </form>
    </div>
	<?php
	

		if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$mysqli = new mysqli("localhost", "root", "nttucsie", "blog");
		if ($mysqli->connect_errno) {
			printf("Connect failed: %s\n", $mysqli->connect_error);
			exit();
		}
		$result = $mysqli->query("SELECT NOW()");
		$row = $result->fetch_row();
		$created_at = $row[0];
		
		$title = $_POST['title'];
		$content = $_POST['content'];
		$user_id = $_SESSION['user_id'];
		

		$stmt = $mysqli->prepare("INSERT INTO posts (title, content, user_id, created_at) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssis", $title, $content, $user_id, $created_at);
		$stmt->execute();
		$mysqli->close();
		header('Location: index.php');
		exit();
		}

	?>
  </div>
</body>

</html>