<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>永平訊息不漏接</title>
    <?php 
    require_once "~/assets/function.php"; # Auto Generate on 2021/12/01
    ?>
    <link rel="manifest" href="/manifest.json">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-XXXXXXXXXX');
    </script>
</head>
<body>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4">永平訊息不漏接</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link active" aria-current="page">首頁</a></li>
            <li class="nav-item"><a href="/manage/notification.php" class="nav-link">通知設定</a></li>
            <li class="nav-item"><a href="/manage/account.php" class="nav-link">帳號管理</a></li>
            <li class="nav-item"><a href="history.php" class="nav-link">歷史公告</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">關於本系統</a></li>
        </ul>
    </header>
    <div class="container">
        <h2>想上一間好大學 但<span class="fw-bold">找不到</span>升學資訊？</h2>
        <h2>想瞭解學校的<span class="fw-bold">活動資訊</span>嗎？</h2>
        <h2>想尋找學校各項活動<span class="fw-bold">花絮影片</span>嗎？</h2>
        <h2>想脫單 但<span class="fw-bold">找不到</span>聯誼活動？</h2>
        <h1>快使用 <span class="fw-bold">永平訊息通知神器</span>！讓你一手掌握訊息、訊息不漏接！</h1>
        <hr>
        <a href="/manage/login.php" class="btn btn-lg fw-bolder" style="color:#fff; background-color: #6f3def">！立即使用！</a>
        <br><br>
        <h5>使用上有任何問題？ <a href="https://chuan0418.me" class="btn btn-lg btn-success" target="_BLANK">聯絡開發者</a></h5>
        <br>
        <h5>協助我們完善系統 <a href="https://notify.yphs907.com/form/?from=5rC45bmz6KiK5oGv5LiN5ryP5o6l57O757Wx6aaW6aCB" class="btn btn-lg btn-secondary" target="_BLANK">填寫使用問卷</a></h5>

    </div>
<?php 
// manage API
?>
</body>
<script>
    if ("serviceWorker" in navigator){
        console.log("嘗試註冊 Service Worker");
        navigator.serviceWorker.register("/assets/serviceWorker.js").then(function(reg){
            console.log("Service Worker 註冊成功。");
        }).catch(function(err){
            console.log("Service Worker 註冊失敗。", err);
        });
    }
</script>
</html>