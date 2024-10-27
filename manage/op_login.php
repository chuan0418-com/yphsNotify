<?php
require_once "~/assets/function.php"; # Auto Generate on 2021/12/01
require_once "../function.php";
$queryUser = 執行資料庫("yphs_web_notification", "SELECT * FORM `clientsUsers` WHERE `userID` = '$userID'");

$queryHashPassword = $queryUser["userPassword"];
if ($queryHashPassword == $GET_HashPassword){
    $_SESSION["userID"] = $queryUser["userID"];
    header("Location: https://notify.yphs907.com/account.php");
}else{
    header("Location: https://notify.yphs907.com/login.php?loginStatus=fail");
    exit();
}

// JDJ5JDEwJHp4eUpyaC9HeGRtYW13elRRQWNneWVsYng4T1RYSlFWcWx2aWEzRER1V1k4VlFhQ29qREdL
// JDJ5JDEwJExhTk9heUovVTF3cFVyblhkbVY3ZU9Vc0NBNEQ2RVR0WXBOT3k2MFI3aC5WSHZwanFCSEMu
?>