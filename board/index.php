<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/boardStyle.css">
    </head>
    <body>
        <div id="messageForm">
            <form action="post.php" method="post">
                <p>お名前　<input type="text" id="nameForm" name="nameForm"></p>
                <p>タイトル<input type="text" id="titleForm" name="titleForm"><input type="submit" value="投稿する"></p>
                <p>
                    メッセージ<br>
                    <textarea name="messageForm" id="messageForm" cols="100" rows="10" wrap="soft"></textarea>
                </p>
            </form>
        </div>
        <div id="boardContent">
            <?php
            
            $mysqli = new mysqli("localhost","root","","test");
            
            define("DATE_FORMAT","Y/m/d(D) H:i");
            
            if ($mysqli->connect_error) {
                print("failure to load DB.<br>");
                print($mysqli->connect_error);
                exit();
            }

            $mysqli->set_charset("utf8");
            $sql = "SELECT * FROM board_db";
            $response = $mysqli->query($sql);
            if($response==false){
                print("failure to load DB.<br>");
                exit();
            }
            $data = $response->fetch_all(MYSQLI_ASSOC);
        
            foreach($data as $value){
                printf('<div class="content"><div class="content-header"><span class="content-title">%s</span><span class="content-username">投稿者：<span class="username">%s</span></span><span class="content-postdate">投稿日：<span class="postdate">%s</span></span><span class="content-id">No.<span class="id">%s</span></span></div><div class="content-message">%s</div></div>',
                $value["title"],$value["name"],date(DATE_FORMAT,strtotime($value["time"])),$value["id"],$value["message"]);
            }
            
            $mysqli->close();
            
            ?>
        </div>
    </body>
</html>

