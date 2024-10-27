<?php 
require_once "../function.php";

$token = $_GET["token"];
$userToken = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`LINEnotify_tokens` WHERE `token`='$token';", "assoc");

if ($token && $userToken["userID"] != $userID){
    header("Location: https://notify.yphs907.com/manage/notification.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>永平訊息不漏接</title>
    <?php 
    // 樣式();
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Google tag (gtag.js) -->

    <script type="module">
        import Tags from "../_demo_bs5-tag-in-input/tags.js";
        Tags.init();
    </script>
    <script>
        function selectTokenChanged(){
            gtag("event", "notification_changeEditToken");
            if (document.getElementById("Tokens").value == "* 綁定新聊天室 *"){
                window.location.href = "https://notify-bot.line.me/oauth/authorize?response_type=code&client_id=Nsiw1z5rcy4BM98pniLMSd&redirect_uri=<?=urlencode("https://notify.yphs907.com/manage/op_acc_lineNotify-link.php")?>&scope=notify&state=<?=取得隨機數(8)?>&response_mode=get"
            }else{
                window.location.href = "https://notify.yphs907.com/manage/notification.php?token="+document.getElementById("Tokens").value;
            }
        }
    </script>
</head>
<body>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4">永平訊息不漏接</span>
        </a>

        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link">首頁</a></li>
            <li class="nav-item"><a href="/manage/notification.php" class="nav-link active" aria-current="page">通知設定</a></li>
            <li class="nav-item"><a href="/manage/account.php" class="nav-link">帳號管理</a></li>
            <li class="nav-item"><a href="/history.php" class="nav-link">歷史公告</a></li>
            <li class="nav-item"><a href="/manage/op_logout.php" class="nav-link">登出</a></li>
            <li class="nav-item"><a href="/about.php" class="nav-link">關於本系統</a></li>
        </ul>
    </header>
    <div class="container">
        <h1 class="fw-bold">通知設定</h1>
        <hr>
        <div class="container">
            <?php 
            if ($_GET["saved"] == "success"){
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </symbol>
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-success d-flex align-items-center fade show" role="alert" id="success_saved">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                    <div>
                        儲存成功！
                    </div>
                </div>
                <script>
                    var myAlert = new bootstrap.Alert(document.getElementById("success_saved"))
                    window.setTimeout(function(){
                        document.getElementById("success_saved").classList.remove("show");
                    }, 10000);
                </script>
            <?php }
            if (!$_GET["token"]){
                $echo_nonSelected = "disabled";
                ?>
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </symbol>
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-danger d-flex align-items-center fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"><use xlink:href="#info-fill"/></svg>
                    <div>
                        請先透過下方的選單選取您要編輯的聊天室。
                    </div>
                </div>
            <?php } ?>
            <form action="https://notify.yphs907.com/manage/op_notification-setting.php" method="post">
                <input type="submit" value="儲存" class="btn btn-primary mx-2 <?=$echo_nonSelected?>">
                <a href="../system/push_notification/notification_test.php?token=<?=$token?>" class="btn btn-primary mx-2 <?=$echo_nonSelected?>">發送測試通知</a>
                <div class="form-group row my-2">
                    <label for="Tokens" class="col-form-label col-auto">編輯：</label>
                    <div class="col">
                        <select class="form-select" id="Tokens" onchange="selectTokenChanged()">
                            <option value="null" disabled selected>請選擇欲編輯的聊天室</option>
                            <?php
                            $LINEnotify_userTokens = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`LINEnotify_tokens` WHERE `userID`='$userID';", "array");
                            foreach($LINEnotify_userTokens as $key => $value){
                                $echo_selectedToken = "";
                                if ($token == $value["token"]){
                                    $echo_selectedToken = " selected";
                                }
                            ?>
                            <option value="<?=$value["token"]?>"<?=$echo_selectedToken?>><?=$value["name"]?></option>
                            <?php 
                                };
                            ?>
                            <option value="* 綁定新聊天室 *">* 綁定新聊天室 *</option>
                        </select>
                    </div>
                </div>
                <fieldset class="form-group mt-3">
                    <div class="form-check form-switch">
                        <?php 
                        if ($userToken["notification"] == "enable"){
                            $notiShow = "checked";
                        }
                        ?>
                        <input class="form-check-input" type="checkbox" id="notification" name="notification" <?=$notiShow?> <?=$echo_nonSelected?>>
                        <label class="form-check-label" for="notification">通知功能</label>
                    </div>
                </fieldset>
                <div class="form-group row my-2">
                    <label for="token_name" class="col-form-label col-auto">Token 名稱：</label>
                    <div class="col">
                        <input type="text" name="tokenName" class="form-control" value="<?=$userToken["name"]?>" <?=$echo_nonSelected?>>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="token_name" class="col-form-label col-auto">Token 內容：</label>
                    <div class="col">
                        <input type="text" class="form-control" value="<?=$token?>" readonly disabled>
                        <input type="text" name="token" class="visually-hidden" value="<?=$token?>" readonly>
                    </div>
                </div>
                <hr>
                <div class="form-group row my-2">
                    <label for="預設篩選類別" class="col-form-label col-auto">預設篩選類別：</label>
                    <div class="col">
                        <select class="form-select" id="預設篩選類別" name="預設篩選類別[]" multiple 
                            data-allow-clear="true"  <?=$echo_nonSelected?>>
                            <option disabled value="">找幾個選項！來篩選那些沒用的公告吧</option>
                            <?php 
                            foreach (json_decode(file_get_contents("/system/push_notification/category.json")) as $category => $regex){
                                $echo_selectedCat = "";
                                if (in_array($category, (array) json_decode($userToken["category"]))){
                                    $echo_selectedCat = " selected";
                                }
                                ?><option value="<?=$category?>"<?=$echo_selectedCat?>><?=$category?></option>
                            <?php }?>
                        </select>
                        <div class="invalid-feedback">請輸入有效的值</div>

                        <div class="px-2 py-2">
                            說明：<br>
                            為了能讓大家使用的較為得心應手，系統已內建了一些常用的公告類別供使用者選擇。<br>
                            帶星號 * 的選項資料是從校網個別專區擷取的。<br>
                            當然如果你比較厲害，你也可以使用下面的關鍵字搜尋功能。<br>
                        </div>
                    </div>
                </div>
                <hr>
                <h3>進階設定</h3>
                <div class="form-group row my-2">
                    <label for="自訂通知關鍵字" class="col-form-label col-auto">自訂通知關鍵字：</label>
                    <div class="col">
                        <select class="form-select" id="自訂通知關鍵字" name="自訂通知關鍵字[]" multiple 
                            data-allow-new="true" data-allow-clear="true"  <?=$echo_nonSelected?>>
                            <option disabled value="">輸入一點文字！來篩選那些沒用的公告吧</option>
                            <?php 
                            foreach (json_decode($userToken["regexs"]) as $regex){
                                ?><option value="<?=$regex?>" selected><?=$regex?></option>
                            <?php }
                            ?>
                        </select>
                        <div class="invalid-feedback">請輸入有效的值</div>

                        <div class="px-2 py-2">
                            說明：<br>
                            本系統支援 regex 正則表達式匹配文字。（例：「/.*/」）<br>
                            當然您也可以單純使用關鍵字就好。<br>
                            貼心提醒，如果您沒有放任何東西在上面跟這裡，雖然失去了本系統的初衷，不過我們會讓所有通知都來轟炸您的手機。
                        </div>
                    </div>
                </div>
                <div class="visually-hidde1n">

                </div>
                <a class="btn btn-danger mt-2 <?=$echo_nonSelected?>" href="op_acc_lineNotify-link.php?edit-tokens=true&operation=delete&delete_target=<?=$value["token"]?>&delete_targetName=<?=$value["name"]?>">刪除聊天室<i class="fa-solid fa-trash-can"></i></a>
                <input type="submit" value="儲存" class="btn btn-primary mt-2 <?=$echo_nonSelected?>">
            </form>
        </div>
        
        
        
    </div>
<?php 
if ($_GET["newTokenBond"]){
    ?>
    <!-- Modal -->
    <div class="modal fade" id="firstSettingModal" tabindex="-1" aria-labelledby="firstSettingModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="firstSettingModalLabel">聊天室初始化</h1>
                </div>
                <form action="https://notify.yphs907.com/manage/op_notification-setting.php?newTokenBond=true" method="post">
                    <div class="modal-body">
                        <h5>先進行一些簡單的設定</h5>
                        <div class="form-group row my-2">
                            <label for="token_name" class="col-form-label col-auto">聊天室名稱：</label>
                            <div class="col">
                                <input type="text" name="tokenName" class="form-control" value="<?=$userToken["name"]?>">
                            </div>
                        </div>
                        <div class="form-group row my-2">
                            <label for="token_name" class="col-form-label col-auto">Token 內容（您......大概率不應該變更這個設定）：</label>
                            <div class="col">
                                <input type="text" class="form-control" value="<?=$token?>" readonly disabled>
                                <input type="text" name="token" class="visually-hidden" value="<?=$token?>" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row my-2">
                            <label for="token_name" class="col-form-label col-auto">選擇您的身分：</label>
                            <p>個人化您的推播通知，稍後可以刪除或自訂更多關鍵字通知</p>
                            <div class="col">
                                <input type="radio" class="btn-check" name="role" value="role_teacher" id="role_teacher" autocomplete="off" required>
                                <label class="btn btn-primary" for="role_teacher">老師</label>
                                <p>學生相關、考試資訊、課外活動、營隊資訊、教師進修研習資訊</p>

                                <input type="radio" class="btn-check" name="role" value="role_jh-student" id="role_jh-student" autocomplete="off">
                                <label class="btn btn-primary" for="role_jh-student">國中學生</label>
                                <p>學生相關、考試資訊、課外活動、營隊資訊、國中部資訊、校網精選照片*、獎補助學金*</p>

                                <input type="radio" class="btn-check" name="role" value="role_sh-student" id="role_sh-student" autocomplete="off">
                                <label class="btn btn-primary" for="role_sh-student">高中學生</label>
                                <p>學生相關、考試資訊、課外活動、營隊資訊、高中部資訊、校網精選照片*、雙聯學制*、獎補助學金*</p>

                                <input type="radio" class="btn-check" name="role" value="role_jh-parent" id="role_jh-parent" autocomplete="off">
                                <label class="btn btn-primary" for="role_jh-parent">國中家長</label>
                                <p>學生相關、家長、考試資訊、課外活動、營隊資訊、國中部資訊、校網精選照片*、獎補助學金*、學雜費減免*</p>

                                <input type="radio" class="btn-check" name="role" value="role_sh-parent" id="role_sh-parent" autocomplete="off">
                                <label class="btn btn-primary" for="role_sh-parent">高中家長</label>
                                <p>學生相關、家長、考試資訊、課外活動、營隊資訊、高中部資訊、校網精選照片*、獎補助學金*、學雜費減免*</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="儲存變更"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var firstSettingModal = new bootstrap.Modal(document.getElementById("firstSettingModal"), {
            keyboard: false
        })
        firstSettingModal.toggle()
    </script>
    <?php 
}

?>
</body>
<script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.0/firebase-app.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.14.0/firebase-analytics.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
        apiKey: "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
        authDomain: "X.firebaseapp.com",
        projectId: "XXX",
        storageBucket: "XXX.appspot.com",
        messagingSenderId: "XXXXXXXXXXXX",
        appId: "X:XXXXXXXXXXXX:web:XXXXXXXXXXXXXXXXXXXXXX",
        measurementId: "G-XXXXXXXXXX"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
</script>
</html>
