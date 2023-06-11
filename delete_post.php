<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 檢查使用者是否已登入
    if (!isset($_SESSION['username'])) {
        echo "您尚未登入，無法刪除文章。";
        exit;
    }

    // 獲取要刪除的文章ID
    $post_id = $_POST['post_id'];

    // 連接資料庫
    $db = mysqli_connect("localhost", "root", "nttucsie", "blog");

    // 檢查文章是否存在
    $query = "SELECT * FROM posts WHERE id = $post_id";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 0) {
        echo "要刪除的文章不存在。";
        exit;
    }

    // 檢查使用者是否有權限刪除文章
    $row = mysqli_fetch_assoc($result);
    if ($_SESSION['username'] != 'and910805') {
        echo "您沒有權限刪除此文章。";
        exit;
    }

    // 刪除文章及相關評論
    $deletePostQuery = "DELETE FROM posts WHERE id = $post_id";
    $deleteCommentsQuery = "DELETE FROM comments WHERE post_id = $post_id";

    // 開始事務
    mysqli_begin_transaction($db);

    try {
        // 執行刪除操作
        mysqli_query($db, $deleteCommentsQuery);
        mysqli_query($db, $deletePostQuery);

        // 提交事務
        mysqli_commit($db);

        // 關閉資料庫連接
        mysqli_close($db);

        // 刪除成功，跳轉回首頁並顯示成功訊息
        header("Location: index.php?message=刪除成功");
        exit;
    } catch (Exception $e) {
        // 回滾事務
        mysqli_rollback($db);

        // 關閉資料庫連接
        mysqli_close($db);

        // 顯示錯誤訊息
        echo "刪除文章失敗：" . $e->getMessage();
        exit;
    }
} else {
    // 非法訪問
    echo "非法訪問。";
    exit;
}
?>



