<?php 
require_once "../function.php";
$headerUrl = "Location: https://notify.yphs907.com/manage/account.php";
if ($_POST["userName"]){
    執行資料庫("yphs_web_notification","UPDATE `yphs_web_notification`.`clientUsers` SET `userName`='".$_POST["userName"]."' WHERE  `userID`='".$userData['userID']."';");
}

if ($_POST["userID"] != $userID){
    if (查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`clientUsers` WHERE `userID` = '".$_POST["userID"]."';"))
        $headerUrl = "Location: https://notify.yphs907.com/manage/account.php?acc-setting-status=idUsed";
    else{
        執行資料庫("yphs_web_notification","UPDATE `yphs_web_notification`.`clientUsers` SET `userID`='".$_POST["userID"]."' WHERE  `userID`='".$userData['userID']."';");
        $_SESSION["userID"] = $_POST["userID"];
    }
}

header($headerUrl);
exit();
?>