<?php

use Phalcon\Mvc\Controller;

class BoardController extends Controller
{
    public function indexAction()
    {
        //ここで登録してViewで$this->assets->outputCss('header') するとうごく
        $this->assets
            ->collection("header")
            ->addCss("css/boardStyle.css");
        $this->assets
            ->collection("header")
            ->addJs("js/boardScript.js");
        $this->assets
            ->collection("header")
            ->addJs("https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js");
    }
    
    //書き換え時にもこれを呼び出します。新規ではid指定なし、書き換えではid指定あり。指定された上でidの投稿がなかった場合にエラーです。
    public function postAction(){
        echo $this->tag->linkTo("board","掲示板へ戻る")."<br>";
        $board_db_phalcon = new Board_db_phalcon();
        $postData = $this->request->getPost();
        
        $postData["time"] = date('Y-m-d H:i:s');
        echo $postData["time"]."<br>";
        
        $postData["message"] = preg_replace("/\r\n|\r|\n/", "<br>", $postData["message"]);
        
        if(array_key_exists("id",$postData)){
            $content = Board_db_phalcon::findFirst($postData["id"]);
            if($content === false){
                return "id:{$id}の投稿がありません。<br>";
            }
            if($content->update($postData,["id","name","title","message","time",])){
                return "編集しました。";
            }
            else{
                return "fairule:<br>".implode("<br>",$content->getMessages());
            }
        }
        else{
            if($board_db_phalcon->save($postData,["name","title","message","time",])){
                return "新規投稿しました。<br>";
            }
            else{
                return "fairule:<br>".implode("<br>",$board_db_phalcon->getMessages());
            }
        }
    }
    //削除するやつです
    public function deleteAction(){
        echo $this->tag->linkTo("board","掲示板へ戻る")."<br>";
        $id = $this->request->getQuery("id");
        echo "id:{$id}<br>";
        //findFirst(hoge) で初めの要素がhogeとマッチする初めの一つが取れる、複数は取らない
        $content = Board_db_phalcon::findFirst($id);
        if($content === false){
            return "id:{$id}の投稿がありません。<br>";
        }
        if($content->delete() === false){
            echo "削除に失敗しました。<br>";
            $messages = $content->getMessages();
            foreach ($messages as $message) {
                echo $message, "<br>";
            }
        }
        return "削除に成功しました。";
    }
    //phtmlの方でなんやかんやしています
    public function editAction(){
        
    }
}