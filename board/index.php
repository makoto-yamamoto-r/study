<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div id="messageForm">
            <form action="post.php" method="post">
                <p>お名前：<input type="text" name="nameForm"></p>
                <p>タイトル：<input type="text" name="titleForm"> <input type="submit" value="投稿する"></p>
                <p>
                    メッセージ<br>
                    <textarea name="messageForm" rows="5" cols="50" wrap="soft"></textarea>
                </p>
            </form>
        </div>
        <div id="boardContent">
            <?php
            
            $mysqli = new mysqli("localhost","root","","test");
            
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
                printf('<div id="content">
                <p>
                <span id="titleDisp">%s</span>　
                <span id="nameDisp">投稿者：%s</span>　
                <span id="timeDisp">投稿日：%s</span>　
                <span id="idDisp">No.%s</span>
                </p>
                <p>
                <span id="messageDisp">%s</span>
                </p>
                </div>',
                $value["title"],$value["name"],$value["time"],$value["id"],$value["message"]);
            }
            
            $mysqli->close();
            
            ?>
        </div>
    </body>
</html>

