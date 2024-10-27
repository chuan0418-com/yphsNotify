<?php 
require_once "~/assets/function.php"; # Auto Generate on 2021/12/01
require_once "/function.php";

ini_set('display_errors','1');
error_reporting(E_ALL);
function exception_handler($exception){
    echo "Uncaught exception: " , $exception->getMessage(), "\n";
    if (time() < intval(file_get_contents("./exception_handler_record"))){
        LINEAcc_sendToClient("【開發者手機】", "⚠️❗嚴重錯誤❗⚠️\n【Uncaught Exception】\n".$exception->getMessage());
        file_put_contents("./exception_handler_record", time());
    }
    // 重啟錯誤警報：exception_handler_record 改成 「99999999999999999」
};
set_exception_handler('exception_handler');

function getRSSfeed($url){
    // 讀取 rss
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo $error = 'Error:' . curl_error($ch);
        LINEAcc_sendToClient("【開發者手機】", "⚠️❗嚴重錯誤❗⚠️\n【Curl Error】\n".$error);
    };
    curl_close($ch);

    // 刪除特殊字元+文字處理
    $result=preg_replace("//", "", $result); // 特殊字元紀錄_20231011_line31
    $result=preg_replace("//", "", $result); // 特殊字元紀錄_20231201_line31

    $result=str_replace(array("<content:encoded>", "</content:encoded>"), array("<content>", "</content>"), $result); // 含冒號的節點
    $result=str_replace(array("<dc:creator>", "</dc:creator>"), array("<creator>", "</creator>"), $result); // 含冒號的節點
    $result=str_replace("<![CDATA[]]>", "<![CDATA[nothing]]>", $result); // <![CDATA[]]> 無法轉換為文字

    preg_match_all("/href=\"#([A-Za-z0-9]+)\"/", $result, $matches); // 文件嵌入按鈕為動態id，造成資料庫比對內容會出現更新
    // $i = 1;
    foreach ($matches[1] as $match) {
        $result=str_replace($match, "embed", $result);
        // $i++;
    }

    $result=iconv(mb_detect_encoding($result, mb_detect_order(), true), "UTF-8", $result); // Big5 轉 UTF-8？

    // 分析 xml 物件
    $xml = new SimpleXMLElement($result, LIBXML_NOCDATA);
    $feeds = json_decode(json_encode($xml));
    $feeds = $feeds->channel->item;
    
    return $feeds;
}

function getUserRegexlist_enableNoti(){
    // 合併所有使用者的 regex
    $regexList = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`LINEnotify_tokens` WHERE `notification`='enable';", "array");
    $regexs = [];
    foreach ($regexList as $value){
        if (json_decode($value["regexs"])){
            foreach (json_decode($value["regexs"]) as $regex){
                array_push($regexs, $regex);
            }
        }
    }
    $regexs = array_unique($regexs); // 去重

    return $regexs;
}


$urls = [
    "全部公告" => "https://www.yphs.ntpc.edu.tw/category/news/feed/", 
    "行政公告" => "https://www.yphs.ntpc.edu.tw/category/news/news_1/feed/", 
    "榮譽榜" => "https://www.yphs.ntpc.edu.tw/category/news/news_3/feed/", 
    "學生活動專區" => "https://www.yphs.ntpc.edu.tw/category/news/news_7/feed/", 
    "教師進修研習資訊" => "https://www.yphs.ntpc.edu.tw/category/news/news_2/feed/", 
    "獎補助學金" => "https://www.yphs.ntpc.edu.tw/category/news/news_4/feed/", 
    "人事公告" => "https://www.yphs.ntpc.edu.tw/category/news/news_5/feed/", 
    "學雜減免" => "https://www.yphs.ntpc.edu.tw/category/news/news_6/feed/",
    "雙聯學制" => "https://www.yphs.ntpc.edu.tw/category/news/news_8/feed/", 

    "每月菜單" => "https://www.yphs.ntpc.edu.tw/category/office/div_220/section_223/healthy/monthy_menu_list/feed/", 
    "高中職五專升學資訊" => "https://www.yphs.ntpc.edu.tw/category/progression/progression_02_line/feed/", 
    "大學升學資訊" => "https://www.yphs.ntpc.edu.tw/category/progression/progression_01_line/feed/", 
    "國中部七年級新生入學資訊" => "https://www.yphs.ntpc.edu.tw/category/freshman/freshman_01_line/feed/", 
    "高中部招生入學資訊" => "https://www.yphs.ntpc.edu.tw/category/freshman/freshman_02_line/feed/", 
    "活動花絮" => "https://www.yphs.ntpc.edu.tw/category/main_gallery/feed/"
];


$regexsList = getUserRegexlist_enableNoti();
$categoriesList = json_decode(file_get_contents("/system/push_notification/category.json"));

$notiedFeeds = [];
foreach ($urls as $url){
    $feeds = getRSSfeed($url);
    foreach ($feeds as $feed){ // 遍歷 rss 各項目
        $userList = [];
        $channel =""; $channel_text = "";
        if (!查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`newsRecord` WHERE `guid` = '$feed->guid';")){
            // 當有新公告時，繼續執行
            $channel_text = "【新公告】";
            $channel = "new";
        }else{
            $inDatabaseNews = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`newsRecord` WHERE `guid` = '$feed->guid';");
            if ($inDatabaseNews["title"] != $feed->title){
                // 當公告內容有變時，繼續執行
                $channel_text = "【標題更新】";
                $channel = "update_title";
            }elseif ($inDatabaseNews["content"] != $feed->content){
                $channel_text = "【內容更新】";
                $channel = "update_content";
            }else{
                continue;
            }
        }
        // 若公告未發布過

        // Regex 配對
        // 若 regex 符合，則列入待尋找用戶名單中
        $notiedRegex = [];
        foreach ($regexsList as $regex){ 
            if (preg_match("/\/.*\//", $regex)){ // 判斷為 regex 表達式 或 一般字串
                if (preg_match($regex, $feed->title)){ 
                    array_push($notiedRegex, $regex); 
                }
            }elseif (stripos($feed->title, "*")){
                    array_push($notiedRegex, $regex); 
            }else{
                if (stripos($feed->title, $regex)){
                    array_push($notiedRegex, $regex); 
                }
            }
        }
        $notiedRegex = array_unique($notiedRegex); // 去重

        // 將 regex 符合的用戶列出
        foreach ($notiedRegex as $regex){ 
            $queryUserList = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`LINEnotify_tokens` WHERE `regexs` LIKE '%$regex%' AND `notification` = 'enable';", "array");
            foreach ($queryUserList as $user){
                array_push($userList, $user["token"]);
            };
        }
        $userList = array_unique($userList); // 去重



        // 類別配對
        // 若 regex 符合，則列入待尋找用戶名單中
        $notiedCats = [];
        foreach ($categoriesList as $cat => $catsData){
            if ($catsData->res == "regexs"){
                foreach ($catsData->regexs as $regex){ 
                    if (preg_match("/\/.*\//", $regex)){ // 判斷為 regex 表達式 或 一般字串
                        if (preg_match($regex, $feed->title)){ 
                            array_push($notiedCats, $catsData->name); 
                        }
                    }else{
                        if (stripos($feed->title, $regex)){
                            array_push($notiedCats, $catsData->name); 
                        }
                    }
                }
            }elseif ($catsData->res == "feed"){ // 網頁rss分類
                if (is_array($feed->category)){
                    if (in_array($catsData->name, $feed->category)){
                        array_push($notiedCats, $catsData->name); 
                    }
                }else{
                    if ($catsData->name == $feed->category){
                        array_push($notiedCats, $catsData->name); 
                    }
                }

            }
        }

        $notiedCats = array_unique($notiedCats); // 去重

        // 將 類別 符合的用戶列出
        foreach ($notiedCats as $cat){ 
            $queryUserList = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`LINEnotify_tokens` WHERE `category` LIKE '%$cat%' AND `notification` = 'enable';", "array");
            foreach ($queryUserList as $user){
                array_push($userList, $user["token"]);
            };
        }
        $userList = array_unique($userList); // 去重

        // 發布通知
        foreach ($userList as $client){ 
            $text = $channel_text."\n".$feed->title."：\n".$feed->guid;
            LINENotify_sendToClient($client, $text);
            sleep(0.1);
        }
        unset($client);

        // 添加發布紀錄
        $userList = json_encode($userList);
        $feed->category = json_encode($feed->category, JSON_UNESCAPED_UNICODE);
        switch ($channel){
            case "update_title":
                $feedDatabase = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`newsRecord` WHERE `guid` = '$feed->guid';");
                $updateRecord = json_decode($feedDatabase["updateRecord"]);
                $updateRecord[] = [
                    "updateTime" => time(), 
                    "updateColumn" => "title", 
                    "newTitle" => $feed->title, 
                    "original" => [
                        "title" => $feedDatabase["title"], 
                        "content" => base64_encode($feedDatabase["content"]), 
                        "category" => $feedDatabase["category"], 
                        "scanedTime" => $feedDatabase["scanedTime"], 
                        "notiedToken" => $feedDatabase["notiedToken"]
                    ]
                ];
                執行資料庫("yphs_web_notification", "UPDATE `yphs_web_notification`.`newsRecord` SET `title`='$feed->title', `link`='$feed->link', `creator`='$feed->creator', `pubDate`='".strtotime($feed->pubDate)."', `category`='$feed->category', `guid`='$feed->guid', `content`='$feed->content', `scanedTime`='".time()."', `notiedToken`='$userList', `updateRecord`='".json_encode($updateRecord, JSON_UNESCAPED_UNICODE)."' WHERE `guid`='$feed->guid';");
            break;
            
            case "update_content":
                $feedDatabase = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`newsRecord` WHERE `guid` = '$feed->guid';");
                $updateRecord = json_decode($feedDatabase["updateRecord"]);
                $updateRecord[] = [
                    "updateTime" => time(), 
                    "updateColumn" => "content", 
                    "newContent" => base64_encode($feed->content), 
                    "original" => [
                        "title" => $feedDatabase["title"], 
                        "content" => base64_encode($feedDatabase["content"]), 
                        "category" => $feedDatabase["category"], 
                        "scanedTime" => $feedDatabase["scanedTime"], 
                        "notiedToken" => $feedDatabase["notiedToken"]
                    ]
                ];
                // 執行資料庫("yphs_web_notification", "INSERT INTO `yphs_web_notification`.`newsRecord` (`title`, `link`, `creator`, `pubDate`, `category`, `guid`, `content`, `scanedTime`, `notiedToken`, `updateRecord`) VALUES ('$feed->title', '$feed->link', '$feed->creator', '".strtotime($feed->pubDate)."', '$feed->category', '$feed->guid', '$feed->content', '".time()."', '$userList', '".json_encode($updateRecord, JSON_UNESCAPED_UNICODE)."');");
                執行資料庫("yphs_web_notification", "UPDATE `yphs_web_notification`.`newsRecord` SET `title`='$feed->title', `link`='$feed->link', `creator`='$feed->creator', `pubDate`='".strtotime($feed->pubDate)."', `category`='$feed->category', `guid`='$feed->guid', `content`='$feed->content', `scanedTime`='".time()."', `notiedToken`='$userList', `updateRecord`='".json_encode($updateRecord, JSON_UNESCAPED_UNICODE)."' WHERE `guid`='$feed->guid';");
            break;

            default:
                執行資料庫("yphs_web_notification", "INSERT INTO `yphs_web_notification`.`newsRecord` (`title`, `link`, `creator`, `pubDate`, `category`, `guid`, `content`, `scanedTime`, `notiedToken`) VALUES ('$feed->title', '$feed->link', '$feed->creator', '".strtotime($feed->pubDate)."', '$feed->category', '$feed->guid', '$feed->content', '".time()."', '$userList');");
            break;
        }
        
        
        array_push($notiedFeeds, $feed->guid);
        unset($userList);
        continue;
    }
}



echo time();
file_put_contents("/system/push_notification/last_update", strtotime($feeds[0]->pubDate));
?>
