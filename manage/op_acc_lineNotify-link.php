<?php 
/* 
    - 用途：(後端) 帳號管理->管理 LINE Notify Token
    - 狀態：已完成。
    - 上次完成編輯：2024/04/28
    - 作者：銓chuan (https://chuan0418.me)
*/

session_start();
require_once "~/assets/function.php"; # Auto Generate on 2021/12/01
require_once "../function.php";

// https://notify.yphs907.com/manage/op_acc_lineNotify-link.php

if ($_GET["edit-tokens"] && $_GET["operation"] && $userID){
    switch($_GET["operation"]){
        case "rename":
            // ./op_acc_lineNotify-link.php?edit-tokens=true&operation=rename&rename_oldName=MyOldName&rename_newName=BrandNewName&rename_target=ThisIsMyToken123
            $target = $_GET["rename_target"];
            $oldName = $_GET["rename_oldName"];
            $newName = $_GET["rename_newName"];
            執行資料庫("yphs_web_notification", "UPDATE `yphs_web_notification`.`LINEnotify_tokens` SET `name` = '$newName' WHERE `name`='$oldName' AND `token`='$target';");
        break;

        case "delete":
            // ./op_acc_lineNotify-link.php?edit-tokens=true&operation=delete&delete_target=ThisIsMyToken123&delete_targetName=BrandNewName
            $target = $_GET["delete_target"];
            $targetName = $_GET["delete_targetName"];
            執行資料庫("yphs_web_notification", "DELETE FROM `yphs_web_notification`.`LINEnotify_tokens` WHERE `name`='$targetName' AND `token`='$target';");
        break;
    }
    header("Location: https://notify.yphs907.com/manage/account.php");
    exit();
}elseif (查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`clientUsers` WHERE `userID`='$userID';")){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://notify-bot.line.me/oauth/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=".$_GET["code"]."&redirect_uri=".urlencode("【callback_url】")."&client_id=【client_id】&client_secret=【client_secret】");
    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {echo 'Error:' . curl_error($ch);}
    curl_close($ch);

    $result = json_decode($result);
    $access_token = $result->access_token;
    
    if ($access_token && $userID){ // 防止重新載入頁面後的 null 進入資料庫
        $name = "我的新聊天室（".date("Y-m-d_H-i-s", time())."）";
        執行資料庫("yphs_web_notification", "INSERT INTO `yphs_web_notification`.`LINEnotify_tokens` (`name`, `token`, `userID`) VALUES ('$name', '$access_token', '$userID');");
        
        echo "已註冊用戶，連結Token，跳轉管理頁面";
    }

    header("Location: https://notify.yphs907.com/manage/notification.php?newTokenBond=true&token=".$access_token);
    exit();
}else{
    // 註冊頁面未完成
    echo "未註冊用戶，跳轉註冊頁面";
    header("Location: https://notify.yphs907.com/manage/signup.php");
    exit();
}

?>