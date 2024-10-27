<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>永平訊息不漏接</title>
    <?php 
    require_once "~/assets/function.php"; # Auto Generate on 2021/12/01
    require_once "../function.php";
    
    if ($_GET["loginStatus"] != "fail"){
        $echo_loginFail = " visually-hidden";
    }
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Google tag (gtag.js) -->
</head>
<body>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4">永平訊息不漏接</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link">首頁</a></li>
            <li class="nav-item"><a href="/manage/notification.php" class="nav-link">通知設定</a></li>
            <li class="nav-item"><a href="/manage/account.php" class="nav-link active" aria-current="page">帳號管理</a></li>
            <li class="nav-item"><a href="/history.php" class="nav-link">歷史公告</a></li>
            <li class="nav-item"><a href="/about.php" class="nav-link">關於本系統</a></li>
        </ul>
    </header>

    <div class="container">
        <h1 class="fw-bold">登入 系統</h1>
        <hr>
        
        <div class="container">
            <h3>您目前為登出狀態</h3>
            <hr>
            <center>
            <div class="bg-light rounded-3 py-3">
                <p class="text-danger fw-bold mb-3 fs-2">
                    目前僅支援 LINE 連動登入
                </p>
                <div class="mx-6 my-6 py-2" style="max-width:30%">
                    <!-- <form class="" action="https://notify.yphs907.com/manage/op_login.php" method="POST">
                        <p class="text-danger fw-bold mb-3<?=$echo_loginFail?>">
                            您輸入的帳號密碼錯誤！<br>或您還沒有註冊本系統。
                        </p>
                        <div class="vertical-input-group">
                            <div class="form-floating vertical-inside-input-group">
                                <input type="text" class="form-control" id="floatingInput" name="userName" placeholder="使用者名稱" required>
                                <label for="floatingInput">使用者名稱</label>
                            </div>
                            <div class="form-floating vertical-inside-input-group">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="密碼" required>
                                <label for="floatingPassword">密碼</label>
                            </div>
                        </div>
                        <div class="form-check text-start my-3">
                            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">記住我</label>
                        </div>
                        <button class="btn btn-primary w-100 py-2" type="submit">登入</button>
                    </form> -->
                </div>
            </div>
            </center>
            <hr>
            <center>
            <div class="bg-light rounded-3 py-3">
                <h4>或使用</h4>
                <!-- <a href="signup.php" class="btn btn-lg btn-primary my-2">註冊帳號</a><br> -->
                <a href="https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=2001070431&redirect_uri=<?=urlencode("https://notify.yphs907.com/manage/op_acc_line-link.php")?>&state=<?=取得隨機數(8)?>&scope=profile%20openid%20email"
                    class="btn btn-lg btn-success my-2">以 LINE 登入/註冊</a>
            </div>
            </center>
        </div>
    </div>
<?php 
// manage API
?>
</body>
</html>
