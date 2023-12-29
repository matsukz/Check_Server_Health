<?php
    //ポートをチェックする関数
    function PortCheck($ip,$port){
        $Flask="http://192.168.0.102:5500";
        $URL = $Flask."/port?ip=".$ip."&port=".$port;
        $json = file_get_contents($URL);
        $data = json_decode($json,true);
        if ($data == true){
            if ($data["Result"] == true){
                //OK
                return "<div class='text-center text-success'>ONLINE</div>";
            }else{
                //NG
                return "<div class='text-center text-danger'>OFFLINE</div>";
            }
        }else{
            //Flaskへのリクエスト失敗
            return "<div class='text-center text-danger'>API ERROR</div>";
        }
    }
?>

<div class="d-flex justify-content-center">
    <div class="Container col-md-8">

        <div class="accordion" id="accordion_main">
            <?php
                $json = json_decode(file_get_contents("Client.json"),true);
                foreach($json as $key=>$value){
                    //クライアントの数だけ継続
                    //ボタン生成
                    echo '<div class="accordion-item">';
                    echo '<h2 class="accordion-header" id="accordion_'.$json[$key]["id"].'_h">';
                    echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_'.$json[$key]["id"].'_main" aria-expanded="true" aria-controls="accordion_'.$json[$key]["id"].'_main">';
                    echo $key;
                    echo '</button>';
                    echo '</h2>';

                    //中身生成
                    echo '<div id="accordion_'.$json[$key]["id"].'_main" class="accordion-collapse collapse show" aria-labelledby="accordion_'.$json[$key]["id"].'_h"';
                    
                    //中身の各行を生成
                    echo '<div class="accordion-body">';

                    // IPアドレスを取得する
                    echo '<div class="row">';
                    echo '<div class="col-6"><div class="text-center">IPアドレス</div></div>';
                    echo '<div class="col-6"><div class="text-center">'.$json[$key]["IP"].'</div></div>';
                    echo '</div>';

                    //サービスとポートを取得しPortCheckに投げる
                    echo '<div class="row">';
                        foreach($json[$key]["Port"] as $service=>$port){
                            echo '<div class="col-6"><div class="text-center">'.$service.'</div></div>';
                            echo '<div class="col-6">';
                            echo PortCheck($json[$key]["IP"],$port);
                            echo '</div>';
                        }
                    echo '</div>';
                    
                    //divタグを閉じる
                    echo '</div></div>';
                
                }
            ?>
        </div>
    </div>
</div>