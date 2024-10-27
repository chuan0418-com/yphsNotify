<?php 
/* 
    - 用途：(後端) 帳號管理->刪除帳號
    - 狀態：-
    - 上次完成編輯：2024/04/28
    - 作者：銓chuan (https://chuan0418.me)
*/

session_start();
require_once "~/assets/function.php"; # Auto Generate on 2021/12/01
require_once "../function.php";
查詢資料庫("yphs_web_notification", "DELETE FROM `yphs_web_notification`.`clientUsers` WHERE `userID`='$userID';");
session_destroy();
header("Location: https://notify.yphs907.com/manage/login.php");
exit();
?>