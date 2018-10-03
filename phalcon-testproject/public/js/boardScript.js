
function postConfirm(){
    makeConfirmWindow("本当に投稿しますか？",function(){
        $("#postForm").submit();
    },"投稿","閉じる");
}

function deleteConfirm(id){
    makeConfirmWindow("削除しますか？",function(){
        console.log("delete done.");
        location.href = "board/delete?id="+id;
    },"削除","閉じる");
}

/*
生成失敗でfalse（既に開いていた場合など）、成功でtrueを返す。
*/
function makeConfirmWindow(message,okFunction,okLabel,cancelLabel){
    
    if(okLabel==undefined)okLabel="OK";
    if(cancelLabel==undefined)cancelLabel="キャンセル";
    
    //多重起動チェック
    if($(".modalwindow-background").length!=0){
        console.log("modalwindow多重起動");
        return false;
    }
    //多重起動チェックここまで
    
    //バックグラウンド生成・設定
    $("body").append('<div class="modalwindow-background"></div>');
    var background = $(".modalwindow-background");
    if(!background){
        console.log("modalwindow-background生成失敗");
        closeWindow();
        return false;
    }
    
    //クリック設定
    background.unbind().click(function(){
        closeWindow();
    });
    //クリック設定ここまで
    background.fadeIn("slow");
    //バックグラウンド生成・設定ここまで
    
    //window生成・設定ここから
    //中心出し（リサイズ時に呼ぶべきか）
    var centeringWindow = function(){
        if(modalWindow){
            var top = (window.innerHeight - modalWindow.innerHeight())/2;
            var left = (window.innerWidth - modalWindow.innerWidth())/2;
            
            modalWindow.css({"top": top + "px"});
            modalWindow.css({"left": left + "px"});
        }
    }
    //中心出しここまで

    $("body").append('<div class="modalwindow-window"></div>');
    var modalWindow = $(".modalwindow-window");
    if(!modalWindow){
        console.log("modalwindow-window生成失敗");
        closeWindow();
        return false;
    }
    modalWindow.append('<p class="modalwindow-message">' + message + '</p>');
    modalWindow.append('<p class="modalwindow-buttonArea"><span id="modalwindow-okButton">' + okLabel + '</span><span id="modalwindow-cancelButton">' + cancelLabel + '</span></p>');
    centeringWindow();
    
    modalWindow.fadeIn("slow");
    
    //クリック設定
    $("#modalwindow-okButton").unbind().click(function(){
        okFunction();
    });
    $("#modalwindow-cancelButton").unbind().click(function(){
        closeWindow();
    });
    //クリック設定ここまで
    
    //window生成・設定ここまで
    
    var closeWindow = function(){
        if(background){
            background.fadeOut("slow",function(){
                background.remove(); 
            });
        }
        if(modalWindow){
            modalWindow.fadeOut("slow",function(){
                modalWindow.remove(); 
            });
        }
    }
    
    return true;
}