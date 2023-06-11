
<!doctype html>
<html lang="en">
<header id="site-header" class="fixed-top">
  
  

  

  <div class="container">
      <nav class="navbar navbar-expand-lg stroke p-0">
          <h1> <a class="navbar-brand" href="index.php">
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
				  <li class="nav-item ">
                      <a class="nav-link" href="chat.php">公共聊天室</a>
                  </li
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
	
	
	if (isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
	} else {
		$user_id = null;
	}

	$db = mysqli_connect("localhost", "root", "nttucsie", "blog");
	if (!$db) {
		die("Database connection error: " . mysqli_connect_error());
	}
	$query = "SELECT posts.*, users.username FROM posts LEFT JOIN users ON posts.user_id = users.id ORDER BY created_at DESC LIMIT 10";
	$result = mysqli_query($db, $query);
	if (!$result) {
		die("Database query error: " . mysqli_error($db));
	}
	
	while ($row = mysqli_fetch_assoc($result)) {
		echo "<div class='my-5' style='margin-top: 50px;'>";
		echo "<h2>";
		// 添加删除按钮
		if ($_SESSION['username'] == 'and910805') {
			echo "<form method='POST' action='delete_post.php'>";
			echo "<input type='hidden' name='post_id' value='" . $row['id'] . "' />";
			echo "<input type='submit' value='刪除' style='background-color: pink;' />";
			echo "</form>";
		}

		echo $row['title'] . "</h2><br>";
		echo "<p>" . $row['content'] . "</p>";
		echo "<p>By <span style='color: pink; font-weight: bold'>" . $row['username'] . "</span> at " . $row['created_at'] . "</p>";
		echo "</div>";
		$query = "SELECT comments.*, users.username FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE post_id = " . $row['id'] . " ORDER BY created_at ASC";
		$comment_result = mysqli_query($db, $query);
		if (!$comment_result) {
			die("Database query error: " . mysqli_error($db));
		}
		while ($comment_row = mysqli_fetch_assoc($comment_result)) {
			echo "<div style='border: 1px solid black; padding: 10px; margin-top: 20px;'>";
			echo "<p>" . $comment_row['content'] . "</p>";
			echo "<p>By <span style='color: pink; font-weight: bold'>" . $comment_row['username'] . "</span> at " . $comment_row['created_at'] . "</p>";
			echo "</div>";
		}
	

		?>
		
		<form method='POST' action='add_comment.php'>
	  <input type='hidden' name='post_id' value='<?php echo $row['id']; ?>' />
	  <input type='hidden' name='user_id' value='<?php echo $user_id; ?>' />
	  <label>留言：</label>
	  <textarea name='comment'></textarea>
	  <br />
	  <input type='submit' value='送出' />
		</form>

	<?php
      }
      #mysqli_close($db);
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