<?php 
session_start();
require_once "~/assets/function.php"; # Auto Generate on 2021/12/01

// PassworDHasheS
$PDHSforFunction = "【鹽】";
$PDHSforFront = "【鹽】";
$PDHSforEnd = "【鹽】";

$userID = $_SESSION["userID"];
$userData = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`clientUsers` WHERE `userID`='$userID';");

if (!stristr($_SERVER["REQUEST_URI"], "login.php") && 
    !stristr($_SERVER["REQUEST_URI"], "signup.php") && 
    !stristr($_SERVER["REQUEST_URI"], "history.php") && 
    !stristr($_SERVER["REQUEST_URI"], "op_signup.php") && 
    !stristr($_SERVER["REQUEST_URI"], "op_acc_line-link.php") && 
    !stristr($_SERVER["argv"][0], "push_notification.php")
    ){
    
    if (!$userID){ // 未登入跳轉
        include "op_logout.php";
        header("Location: https://notify.yphs907.com/manage/login.php");
        exit();
    }
    }

// LINE Notify - 傳送訊息
function LINENotify_sendToClient($token, $text){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://notify-api.line.me/api/notify');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "message=".$text);
    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    $headers[] = 'Authorization: Bearer '.$token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
}

// LINE官方帳號 - 傳送訊息
function LINEAcc_sendToClient($userId, $text){
    $request = [
        "to" => $userId,
        "messages" => [
            [
                "type" => "text",
                "text" => $text
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/message/push');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: Bearer 【Token】';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
}

// LINE官方帳號 - 回復訊息
function LINEAcc_replyToClient($replyToken, $text){
    $request = [
        "replyToken" => $replyToken,
        "messages" => [
            [
                "type" => "text",
                "text" => $text
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.line.me/v2/bot/message/reply');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: Bearer 【Token】';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
}


?>
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.0/firebase-app.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
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
</script>
<style>
    /* https://stackoverflow.com/questions/39623405/vertically-stack-bootstrap-input-group-controls */
    .vertical-input-group .vertical-inside-input-group:first-child {
        padding-bottom: 0;
    }
    .vertical-input-group .vertical-inside-input-group:first-child * {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;    
    }
    .vertical-input-group .vertical-inside-input-group:last-child {
        padding-top: 0;
    }
    .vertical-input-group .vertical-inside-input-group:last-child * {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .vertical-input-group .vertical-inside-input-group:not(:last-child):not(:first-child) {
        padding-top: 0;
        padding-bottom: 0;
    }
    .vertical-input-group .vertical-inside-input-group:not(:last-child):not(:first-child) * {
        border-radius: 0;
    }  
    .vertical-input-group .vertical-inside-input-group:not(:first-child) * {
        border-top: 0;
    }
</style>