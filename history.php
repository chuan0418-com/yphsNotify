<?php 
require_once "function.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>永平訊息不漏接</title>
    <?php 
    if ($_GET["acc-setting-status"] != "idUsed"){
        $echo_idUsed = " visually-hidden";
    }
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-XXXXXXXXXX');
    </script>
    <script>
        function gtagEvent_viewArchiveBox(title, guid){
            gtag("event", "view_ArchiveBox", {
                "title": title, 
                "guid": guid
            }
            );
        }

        (function(document) {
            'use strict';

            // 建立 LightTableFilter
            var LightTableFilter = (function(Arr) {
                var _input;

                // 資料輸入事件處理函數
                function _onInputEvent(e) {
                    _input = e.target;
                    var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
                    Arr.forEach.call(tables, function(table) {
                        Arr.forEach.call(table.tBodies, function(tbody) {
                            Arr.forEach.call(tbody.rows, _filter);
                        });
                    });
                }

                // 資料篩選函數，顯示包含關鍵字的列，其餘隱藏
                function _filter(row) {
                    var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
                    row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
                }

                return {
                // 初始化函數
                init: function() {
                    var inputs = document.getElementsByClassName('light-table-filter');
                    Arr.forEach.call(inputs, function(input) {
                    input.oninput = _onInputEvent;
                    });
                }
                };
            })(Array.prototype);

            // 網頁載入完成後，啟動 LightTableFilter
            document.addEventListener('readystatechange', function() {
                if (document.readyState === 'complete') {
                    LightTableFilter.init();
                }
            });
        })(document);
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
            <li class="nav-item"><a href="/manage/notification.php" class="nav-link">通知設定</a></li>
            <li class="nav-item"><a href="/manage/account.php" class="nav-link">帳號管理</a></li>
            <li class="nav-item"><a href="history.php" class="nav-link active" aria-current="page">歷史公告</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">關於本系統</a></li>
        </ul>
    </header>
    <div class="container">
        <h1 class="fw-bold">歷史公告</h1>
        <hr>
        <div class="input-group my-2">
            <span class="input-group-text" id="query">搜尋</span>
            <input type="search" class="form-control light-table-filter" placeholder="標題" aria-label="query" name="query" data-table="order-table">
        </div>
        <div>
            <style>
                .table td.fit, 
                .table th.fit,
                .fit {
                white-space: nowrap;
                width: 1%;
                }
            </style>
            <div class="table-responsive">
                <table class="table table-light table-hover table-bordered order-table">
                    <thead>
                        <tr>
                            <th class="fit">編號</th>
                            <th>標題</th>
                            <th class="fit">發布者</th>
                            <th>公告日期</th>
                            <th>分類</th>
                            <!-- <th>擷取時間</th> -->
                            <th class="fit">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $search_start = $_GET["p"]>0 ? intval($_GET["p"])*100-1 : "0";

                            $pubs = 查詢資料庫("yphs_web_notification", "SELECT * FROM `yphs_web_notification`.`newsRecord` ORDER BY `pubDate` DESC LIMIT 0, 100 ;", "array");
                            foreach ($pubs as $key => $value){
                        ?>
                            <tr>
                                <td class="fit"><?=$key+1?></td>
                                <td><a href="<?=$value["link"]?>" class="d-inline-block text-truncate" style="min-width: 1px; max-width: 300px;" title="<?=$value["title"]?>" target="_BLANK"><?=$value["title"]?></a></td>
                                <td class="fit"><?=$value["creator"]?></td>
                                <td><?=date("Y/m/d (D) H:i:s", $value["pubDate"])?></td>
                                <td>
                                    <?php 
                                    foreach (json_decode($value["category"]) as $key){
                                    ?> 
                                    <span class="badge bg-primary"><?=$key?></span>
                                    <?php }?>
                                <!-- <td><?=date("Y/m/d H:i", $value["scanedTime"])?></td> -->
                                <td class="fit">
                                    <hr class="d-lg-none d-print-inline">
                                    <!-- <a class="btn btn-secondary btn-sm" href="#">檢視內容 <i class="fa-solid fa-eye"></i></a> -->
                                    <!-- <a class="btn btn-warning btn-sm" href="/op_toArchiveBox.php?<?=base64_encode($value["guid"])?>" target="_BLANK" onclick="gtagEvent_viewArchiveBox('<?=$value['title']?>', '<?=$value['guid']?>')">歷史頁面 <i class="fa-solid fa-clock-rotate-left"></i></a> -->
                                    <a class="btn btn-primary btn-sm" href="<?=$value["link"]?>" target="_BLANK">前往 <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                </td>
                            </tr>
                        <?php 
                            };
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>