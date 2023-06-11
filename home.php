
<!doctype html>
<html lang="en">
<head>
  <style>
    .btnn {
      display: inline-block;
      padding: 10px 20px;
      border: 2px solid red;
      border-radius: 5px;
      text-decoration: none;
      color: red;
      font-weight: bold;
    }
    .nav-item {
      display: inline-block;
      margin-right: 10px;
    }
  </style>
</head>
<body>
<header id="site-header" class="fixed-top">
  <div class="container">
    <nav class="navbar navbar-expand-lg stroke p-0">
      <h1><a class="navbar-brand" href="index.php">
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
          <li class="nav-item">
            <a class="nav-link" href="contact.html">聯繫</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="chat.php">公共聊天室</a>
          </li>				  
		  <?php
				  session_start();
						if (isset($_SESSION['username'])) { 
							// 在这里使用 $_SESSION['username']
							// ...
						} else {
							// 如果 'username' 键不存在，执行相应的处理
							$_SESSION['username'] = '@'; // 或者设置一个默认值
							// ...
						}

			
						
						if(isset($_SESSION['username'])&&$_SESSION['username']!='@') {
							echo '<li class="nav-item">
									<a class="nav-link" href="logout.php">登出</a>
								  </li>';
						    
						   
							echo '<li class="nav-item">
									<a class="nav-link" href="view_friends.php">好友</a>
								  </li>';
							echo '<li class="nav-item">
									<a class="nav-link" href="home.php">個人小屋</a>
								  </li>';
								  
							echo '<li class="nav-item ">
									<a class="nav-link" href="post.php">發文!!</a>
								  </li>';
							if ($_SESSION['username'] == 'and910805' ) {
								echo '<li class="nav-item">
											<a class="nav-link" href="delete.php">刪除貼文</a>
										  </li>';
							}
							
						} else {
							echo '<li class="nav-item">
									<a class="nav-link" href="login.php">登入</a>
								  </li>';
								  
						}
					?>

				  
				  
				  
              </ul>
			  
			  
          </div>
		  <div class="mobile-position">
              <nav class="navigation">
                  <div class="theme-switch-wrapper">
                      <label class="theme-switch" for="checkbox">
                          <input type="checkbox" id="checkbox">
                          <div class="mode-container">
                              <i class="gg-sun"></i>
                              <i class="gg-moon"></i>
                          </div>
                      </label>
                  </div>
              </nav>
          </div>
      </nav>
  </div>
 
</header>
     <body>
	 
  <div class="container mt-5" style="margin-top: 30px;">

	
    <?php
	
  	echo "<div style=' margin-left: 10px;font-size:20px'><strong>";
	echo $_SESSION['username'] . '你好!' . '<br>這是你自己家<br><br><br>';
	echo "</strong></div>";  
	?>
	<form action="upload.php" method="post" enctype="multipart/form-data">
	  <input type="file" name="avatar" accept="image/*" style="max-width: 200px;">
	  <input type="submit" value="上傳照片">
	</form>
	<?php

  // 檢查是否有登入
  
  
  if (isset($_SESSION['username'])) {
	$name=$_SESSION['username'];
	if (isset($_SESSION['visited_user'])) {
	  // 如果有儲存的要拜訪的使用者名稱，將使用者切換回來
	  $visited_user = $_SESSION['visited_user'];
	  unset($_SESSION['visited_user']); // 刪除暫存的要拜訪的使用者名稱
	  $name=$visited_user;
	  
	  
	}
 
    
    $db = mysqli_connect("localhost", "root", "nttucsie", "blog");
    if (!$db) {
      die("Database connection error: " . mysqli_connect_error());
    }

    // 取得使用者的頭像
    $query = "SELECT avatar_url FROM users WHERE username='$name'";
	$result = mysqli_query($db, $query);
	if ($result && mysqli_num_rows($result) > 0) {
	  $row = mysqli_fetch_assoc($result);
	  $avatar_url = $row['avatar_url'];
	  
	  if ($avatar_url) {
		$avatar = $avatar_url;
	  } else {
		// 如果找不到頭像，使用預設頭像
		$avatar = 'uploads/default_avatar.jpg';
	  }
	} else {
	  // 如果找不到頭像，使用預設頭像
	  $avatar = 'uploads/default_avatar.jpg';
	}


	echo "<div style='max-width: 200px;'>";
	echo "<img src='$avatar' style='max-width: 100%; float: left;'>";
	echo "</div>";

	echo "<form class='form-inline my-lg-0'>";
	if ($_SESSION['username'] != $name) {
		echo "<div style='float: left; margin-left: 10px;font-size:20px'><strong>";
		echo $_SESSION['username'] . '你好!' . '<br>這是' . $name . '家<br><br><br><br><br>';
		echo "</strong></div>";
	} else {
		echo "<div style='float: left; margin-left: 10px;font-size:20px'><strong>";
		echo $_SESSION['username'] . '你好!' . '<br>這是你自己家<br><br><br><br><br>';
		echo "</strong></div>";
	}
	echo '</form>';

    // 取得使用者的日記
    $query = "SELECT * FROM diary WHERE username='$name' ORDER BY created_at DESC LIMIT 1";
    $result = mysqli_query($db, $query);
    
	echo "<a href='write_diary.php' class='btnn'>寫日記</a>";
	echo "<form action='visit_other.php' method='POST'>";
	echo "<label for='username'><br>輸入別人的使用者名稱：</label>";
	echo "<input type='text' id='username' name='username' required><br><br>";
	echo "<input type='submit' name='submit' value='前往別人家'>";
	echo "</form>";


    mysqli_close($db);
  } else {
    echo "<p>請先登入</p>";
  }
  if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='my-5'>";
       
        echo "<h2>" . $row['title'] . "</h2>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<p>發表於 " . $row['created_at'] . "</p>";
        echo "</div>";
      }
    } else {
      echo "<p>尚無日記，你想要撰寫嗎?!</p>";
	
	  
    }
	
  ?>
  </div>


  <button onclick="topFunction()" id="movetop" title="回到顶部">
    &#10548;
  </button>

  <!-- JS脚本和库的引入 -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/owl.carousel.js"></script>

  
  <button onclick="topFunction()" id="movetop" title="Go to top">
    &#10548;
  </button>
  <script>
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
      scrollFunction()
    };

    function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("movetop").style.display = "block";
      } else {
        document.getElementById("movetop").style.display = "none";
      }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    }
  </script>
  <!-- /move top -->

  




  <!-- owlcarousel -->
 
  <!-- script for banner typing text -->
  <script>
    function autoType(elementClass, typingSpeed) {
      var thhis = $(elementClass);
      thhis.css({
        "position": "relative",
        "display": "inline-block"
      });
      thhis.prepend('<div class="cursor" style="right: initial; left:0;"></div>');
      thhis = thhis.find(".text-js");
      var text = thhis.text().trim().split('');
      var amntOfChars = text.length;
      var newString = "";
      thhis.text("|");
      setTimeout(function () {
        thhis.css("opacity", 1);
        thhis.prev().removeAttr("style");
        thhis.text("");
        for (var i = 0; i < amntOfChars; i++) {
          (function (i, char) {
            setTimeout(function () {
              newString += char;
              thhis.text(newString);
            }, i * typingSpeed);
          })(i + 1, text[i]);
        }
      }, 1500);
    }

    $(document).ready(function () {
      // Now to start autoTyping just call the autoType function with the 
      // class of outer div
      // The second paramter is the speed between each letter is typed.   
      autoType(".type-js", 200);
    });
  </script>
  <!----下面是聊天室功能-->
   <script>
   
    });
  </script>
  <!-- //script for banner typing text -->

  <!-- script for carousel slider -->
  <script>
    $(document).ready(function () {
      $("#owl-demo1").owlCarousel({
        loop: true,
        nav: false,
        margin: 30,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
            nav: false
          },
          767: {
            items: 2,
            nav: false
          },
          992: {
            items: 4,
            nav: false
          }
        }
      })
    })
  </script>
  <!-- //script for carousel slider -->

  <!-- disable body scroll which navbar is in active -->
  <script>
    $(function () {
      $('.navbar-toggler').click(function () {
        $('body').toggleClass('noscroll');
      })
    });
  </script>
  <!-- disable body scroll which navbar is in active -->

  <!--/MENU-JS-->
  <script>
    $(window).on("scroll", function () {
      var scroll = $(window).scrollTop();

      if (scroll >= 80) {
        $("#site-header").addClass("nav-fixed");
      } else {
        $("#site-header").removeClass("nav-fixed");
      }
    });

    //Main navigation Active Class Add Remove
    $(".navbar-toggler").on("click", function () {
      $("header").toggleClass("active");
    });
    $(document).on("ready", function () {
      if ($(window).width() > 991) {
        $("header").removeClass("active");
      }
      $(window).on("resize", function () {
        if ($(window).width() > 991) {
          $("header").removeClass("active");
        }
      });
    });
  </script>
  
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/theme-change.js"></script>
  <script src="assets/js/owl.carousel.js"></script>
  <link rel="stylesheet" href="assets/css/style-starter.css">

 

  
</body>

</html>