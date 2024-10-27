<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>永平訊息不漏接</title>
    <?php 
    require_once "~/assets/function.php"; # Auto Generate on 2021/12/01
    require_once "../function.php";
    // 樣式();
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
        <h1 class="fw-bold">註冊 系統</h1>
        <hr>
        
        <div class="container">
            <h3>您目前為登出狀態</h3>
            <hr>
            <center>
            <div class="bg-light rounded-3 py-3">
                <p class="text-danger fw-bold mb-3 fs-2">
                    目前僅支援 LINE 連動登入
                </p>
                <div class="mx-6 my-6 py-2" style="max-width:80%">
                    <!-- <form class="" action="#" method="post">
                        <div class="row">
                            <div class="col">
                                <div class="vertical-input-group">
                                    <div class="form-floating vertical-inside-input-group">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="使用者名稱" required>
                                        <label for="floatingInput">使用者名稱</label>
                                    </div>
                                    <div class="form-floating vertical-inside-input-group">
                                        <input type="password" class="form-control" id="floatingPassword" placeholder="密碼" required>
                                        <label for="floatingPassword">密碼</label>
                                    </div>
                                    <div class="form-floating vertical-inside-input-group">
                                        <input type="password" class="form-control" id="floatingPasswordConfirm" placeholder="確認密碼" required>
                                        <label for="floatingPasswordConfirm">確認密碼</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating my-2">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="姓名/暱稱" required>
                                    <label for="floatingInput">姓名/暱稱</label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100 py-2 my-4" type="submit" style="max-width: 30%">註冊</button>
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
