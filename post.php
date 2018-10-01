
<?php

$time = date('Y-m-d H:i:s');
$name = $_POST['nameForm'];
$title = $_POST['titleForm'];
$message = $_POST['messageForm'];

print("名前：".$name."<br>");
print("タイトル：".$title."<br>");
print("メッセージ：".$message."<br>");

$mysqli = new mysqli("localhost","root","","test");

if ($mysqli->connect_error) {
    print($mysqli->connect_error);
    exit();
}

$mysqli->set_charset("utf8");

$sql = "INSERT INTO boardData (
    time,name,title,message
) VALUES (
    '$time','$name','$title','$message'
)";

$response = $mysqli->query($sql);

if($response){
    print("succeed.<br><br>");
    print('<a href="getSql.php" target="_blank">見る</a>');
}else{
    print("failure.");
}

?>