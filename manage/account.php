<?php 
require_once "../function.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>永平訊息不漏接</title>
    <?php 
    if ($_GET["acc-setting-status"] != "idUsed"){
        $echo_idUsed = " visually-hidden";
    }
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <li class="nav-item"><a href="/manage/op_logout.php" class="nav-link">登出</a></li>
            <li class="nav-item"><a href="/about.php" class="nav-link">關於本系統</a></li>
        </ul>
    </header>
    <div class="container">
        <h1 class="fw-bold">帳號管理</h1>
        <input type="submit" value="儲存" class="btn btn-primary">
        <hr>
        <div class="container mb-3">
            <form action="https://notify.yphs907.com/manage/op_account-setting.php" method="post">
                <div>
                    <h3>個人資料</h3>
                    <div class="form-group row my-2">
                        <label for="userID" class="col-form-label col-auto">使用者名稱：</label>
                        <div class="col">
                            <input type="text" class="form-control" value="<?=$userData["userID"]?>" id="userID" name="userID">
                        </div>
                    </div>
                    <p class="fw-bold text-danger<?=$echo_idUsed?>">變更失敗！此使用者名稱已被使用過</p>
                    <div class="form-group row my-2">
                        <label for="userName" class="col-form-label col-auto">暱稱：</label>
                        <div class="col">
                            <input type="text" class="form-control" value="<?=$userData["userName"]?>" id="userName" name="userName">
                        </div>
                    </div>
                </div>

                <hr>
                <div>
                    <h3>帳號連結</h3>
                    <div class="form-group row mb-2">
                        <label for="line_userName" class="col-form-label col-auto">LINE 帳號綁定：</label>
                        <div class="input-group mb-3 col">
                            <input type="text" class="form-control" disabled value="<?=$userData["LINE_userName"]?>" id="line_userName" name="line_userName">
                        </div>
                    </div>
                </div>

                <hr>
                <div>
                    <h3>已連結的 LINE Notify 聊天室</h3>
                    <a href="https://notify-bot.line.me/oauth/authorize?response_type=code&client_id=【client_id】&redirect_uri=<?=urlencode("【callback_url】")?>&scope=notify&state=<?=取得隨機數(8)?>&response_mode=get"
                        class="btn btn-success">綁定聊天室</a><br><br>
                    <table class="table table-light table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>索引</th>
                                <th>名稱</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $LINEnotify_userTokens = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`LINEnotify_tokens` WHERE `userID`='$userID';", "array");
                                foreach($LINEnotify_userTokens as $key => $value){
                            ?>
                                <tr>
                                    <td><?=$key+1?></td>
                                    <td><?=$value["name"]?></td>
                                    <td>
                                        <hr class="d-lg-none d-print-inline">
                                        <a class="btn btn-danger btn-sm" href="op_acc_lineNotify-link.php?edit-tokens=true&operation=delete&delete_target=<?=$value["token"]?>&delete_targetName=<?=$value["name"]?>">刪除 <i class="fa-solid fa-trash-can"></i></a>
                                        <a class="btn btn-primary btn-sm" href="notification.php?token=<?=$value["token"]?>&tokenName=<?=$value["name"]?>">編輯 <i class="fa-solid fa-pen"></i></a>
                                    </td>
                                </tr>
                            <?php 
                                };
                            ?>
                        </tbody>
                    </table>
                </div>
                <hr>
                <a href="./op_delete-account.php" class="btn btn-danger disabled"><i class="fa-solid fa-trash-can"></i> 刪除帳號</a>
                <input type="submit" value="儲存" class="btn btn-primary">
            </form>
        </div>

    </div>
<?php 
// manage API
?>
</body>
</html>