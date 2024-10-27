<?php 
/* 
    - 用途：(前端) 登出帳戶
    - 狀態：已完成。
    - 上次完成編輯：2024/04/28
    - 作者：銓chuan (https://chuan0418.me)
*/

session_start();
session_destroy();
header("Location: https://notify.yphs907.com/manage/login.php");
exit();

?>