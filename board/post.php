<?php
//POSTデータ受信
$time = date('Y-m-d H:i:s');
$name = $_POST['nameForm'];
$title = $_POST['titleForm'];
$message = $_POST['messageForm'];
if(is_string($message)){
    $message = preg_replace("/\r\n|\r|\n/", "<br>", $_POST['messageForm']);    
}
//POSTデータ受信ここまで

//入力制限チェック
function checkLengthError($fieldStr,$fieldName,$fieldLimit){
    $isError = false;
    if(!is_string($fieldStr)||mb_strlen($fieldStr)==0){
        $isError = true;
        print($fieldName."を入力してください。<br>");
    }
    if(mb_strlen($fieldStr)>$fieldLimit){
        $isError = true;
        print($fieldName."は".(string)$fieldLimit."文字以内で入力してください。<br>");
    }
    return $isError;
}
$exitFlag = false;
if(checkLengthError($name,"名前",20)){
    $exitFlag = true;
}
if(checkLengthError($title,"タイトル",40)){
    $exitFlag = true;
}
if(checkLengthError($message,"メッセージ",140)){
    $exitFlag = true;
}
if($exitFlag){
    exit();
}
//入力制限チェックここまで

print("名前：".$name."<br>");
print("タイトル：".$title."<br>");
print("メッセージ：".$message."<br>");

//MySQL INSERT
$mysqli = new mysqli("localhost","root","","test");

if ($mysqli->connect_error) {
    print($mysqli->connect_error);
    exit();
}

$mysqli->set_charset("utf8");

$sql = "INSERT INTO board_db (
    time,name,title,message
) VALUES (
    '$time','$name','$title','$message'
)";

$response = $mysqli->query($sql);

if($response){
    print("succeed.");
}else{
    print("failure.");
}

$mysqli->close();
//MySQL INSERTここまで

?>