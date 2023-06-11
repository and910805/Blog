<?php
session_start();

// 檢查使用者是否已登入，如果未登入，將跳轉到 login.php
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chatroom</title>
  <style>
    .chatroom-container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
    }

    .chatroom-messages {
      list-style-type: none;
      padding: 0;
    }

    .chatroom-message {
      margin-bottom: 10px;
    }

    .chatroom-message .user {
      font-weight: bold;
    }

    .chatroom-message .content {
      margin-top: 5px;
    }

    .chatroom-input {
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <a class="nav-link" href="index.php" style="font-size: 50px;">首頁 <span class="sr-only">(current)</span></a>

  <div class="container mt-5" style="margin-top: 30px;">

    <div class="chatroom-container">
      <h1>聊天室 你好!</h1>
      <!-- 留言列表 -->
      <ul class="chatrooms-list" id="chatroom-list">
        <!-- 此處將動態插入留言 -->
      </ul>

      <!-- 留言輸入框 -->
      <form method="POST" action="handle_chatroom.php">
        <textarea name="chatroom" placeholder="輸入留言"></textarea>
        <br>
        <input type="submit" value="送出">
      </form>
    </div>
  </div>

  <button onclick="topFunction()" id="movetop" title="回到顶部">
    &#10548;
  </button>

  <!-- JS脚本和库的引入 -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/owl.carousel.js"></script>
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

    // 定時更新聊天室內容
    setInterval(fetchChatroomData, 1000); // 每秒執行一次

    function fetchChatroomData() {
      $.ajax({
        url: "fetch_chatroom.php", // 您需要創建一個名為 fetch_chatroom.php 的後端文件，用於獲取最新的聊天室內容
        type: "GET",
        success: function (response) {
          // 更新留言列表
          $("#chatroom-list").html(response);
        },
        error: function (xhr, status, error) {
          console.log(error);
        }
      });
    }
  </script>
  <!-- /move top -->

  <!-- owlcarousel -->
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
