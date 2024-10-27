<?php 
require_once "~/assets/function.php"; # Auto Generate on 2021/12/01
require_once "../../function.php";

$GET_token = $_GET["token"];
$tokenData = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`LINEnotify_tokens` WHERE `token`='$GET_token';");
$token_userID = $tokenData["userID"];
$userData = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`clientUsers` WHERE `userID`='$token_userID';");
LINENotify_sendToClient($GET_token, "【測試通知】\n這是由使用者「".$userData["userName"]."」透過「".$tokenData["name"]."」傳送的測試通知。\n當你看得到這則通知時，代表一切都運作的好好的！");
header("Location: ".getenv("HTTP_REFERER"));
exit();
?>