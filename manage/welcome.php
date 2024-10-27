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
            <li class="nav-item"><a href="/manage/account.php" class="nav-link">帳號管理</a></li>
            <li class="nav-item"><a href="/history.php" class="nav-link">歷史公告</a></li>
            <li class="nav-item"><a href="/manage/op_logout.php" class="nav-link">登出</a></li>
            <li class="nav-item"><a href="/about.php" class="nav-link">關於本系統</a></li>
        </ul>
    </header>
    <div class="container">
        <h1 class="fw-bold">嗨！新朋友</h1>
        <h5>讓我們透過幾個步驟簡單設定一下吧！</h5>
        <hr>
        <div class="container mb-3">
            <form action="https://notify.yphs907.com/manage/op_account-setting.php" method="post">
                <div>
                    <h3 class="fw-bold">設定都在哪裡？</h3>
                    <h5>您可以在上方的導覽列找到各項設定。</h5>
                    <ul>
                        <li><h5>帳號管理：變更使用者名稱、綁定帳號、刪除帳號、新增通知管道（LINE 聊天室）...</h5></li>
                        <li><h5>通知設定：管理多個通知管道的設定和篩選分類</h5></li>
                        <li><h5>歷史公告：儲存近期學校曾發布過的公告</h5></li>
                    </ul>
                </div>


                <hr>
                <div>
                    <h3 class="fw-bold">已連結的 LINE Notify 聊天室</h3>
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
                    <h5>這裡還沒有任何聊天室，您可以現在
                        <a href="https://notify-bot.line.me/oauth/authorize?response_type=code&client_id=【client_id】&redirect_uri=<?=urlencode("【callback_url】")?>&scope=notify&state=<?=取得隨機數(8)?>&response_mode=get"
                        class="btn btn-success">綁定聊天室</a> 以接收訊息。
                    </h5>
                    <br><br>
                </div>
            </form>
        </div>

    </div>
<?php 
// manage API
?>
</body>
</html>