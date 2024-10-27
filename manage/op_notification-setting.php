<?php 
require_once "../function.php";

$token = $_POST["token"];
$post_name = $_POST["tokenName"];
if ($token == "null"){
    header("Location: https://notify.yphs907.com/manage/notification.php");
    exit();
}

if ($_GET["newTokenBond"]){
    $_POST["notification"] = "on";

    switch ($_POST["role"]){
        case "role_teacher":
            $_POST["預設篩選類別"] = ["學生相關","考試資訊","課外活動、營隊資訊","校網精選照片 *","教師進修研習資訊 *","系統推播","系統重要公告"];
        break;
    
        case "role_jh-student":
            $_POST["預設篩選類別"] = ["學生相關","考試資訊","課外活動、營隊資訊","國中部資訊 J","校網精選照片 *","獎補助學金 *"];
        break;

        case "role_sh-student":
            $_POST["預設篩選類別"] = ["學生相關","考試資訊","課外活動、營隊資訊","高中部資訊 S","校網精選照片 *","雙聯學制*","獎補助學金 *"];
        break;
        
        case "role_jh-teacher":
            $_POST["預設篩選類別"] = ["學生相關","家長","考試資訊","課外活動、營隊資訊","國中部資訊 J","校網精選照片 *","獎補助學金 *","學雜費減免 *"];
        break;
        
        case "role_sh-teacher":
            $_POST["預設篩選類別"] = ["學生相關","家長","考試資訊","課外活動、營隊資訊","高中部資訊 S","校網精選照片 *","獎補助學金 *","學雜費減免 *"];
        break;
    }
}
if ($_POST["notification"] == "on"){
    $notification = "enable";
}else{
    $notification = "disable";
}

if ($_POST["自訂通知關鍵字"]){
    if (is_array($_POST["自訂通知關鍵字"])){
        $subs = json_encode($_POST["自訂通知關鍵字"], JSON_UNESCAPED_UNICODE);
    }else{
        $subs[] = $_POST["自訂通知關鍵字"];
    }
}else{
    $subs = null;
}

if ($_POST["預設篩選類別"]){
    if (is_array($_POST["預設篩選類別"])){
        $cats = json_encode($_POST["預設篩選類別"], JSON_UNESCAPED_UNICODE);
    }else{
        $cats[] = $_POST["預設篩選類別"];
    }
}else{
    $cats = null;
}

執行資料庫("yphs_web_notification",
    "UPDATE `yphs_web_notification`.`LINEnotify_tokens` SET `name`='$post_name', `notification`='$notification', `regexs`='$subs', `category`='$cats' WHERE  `token` = '$token';");
header("Location: https://notify.yphs907.com/manage/notification.php?token=$token&saved=success");
exit();
?>