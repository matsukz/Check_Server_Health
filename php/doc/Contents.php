<?php
    error_reporting(0);

    $Agent = "PHPServiceChecker";
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: $Agent\r\n"
        ]
    ];
    $context = stream_context_create($options);

    //ポートをチェックする関数
    function PortCheck($ip,$port){
        $Flask = "http://192.168.0.102:5500";
        $URL = $Flask."/port?ip=".$ip."&port=".$port;
        global $context;
        $json = file_get_contents($URL,false,$context);
        $data = json_decode($json,true);
        if ($data == true){
            if ($data["Result"] == true){
                //OK
                return '<div class="text-success">ONLINE</div>';
            }else{
                //NG
                return '<div class="text-danger">OFFLINE</div>';
            }
        }else{
            //Flaskへのリクエスト失敗
            return '<div class="text-danger">API ERROR</div>';
        }
    }

    //PINGをチェックする関数
    function PingCheck($ip){
        global $context;
        $Flask = "http://192.168.0.102:5500";
        $URL = $Flask."/ping?ip=".$ip;
        $json = file_get_contents($URL,false,$context);
        $data = json_decode($json,true);
        if ($data == true){
            if ($data["Result"] >= 0){
                //OK
                return '<div class="text-success">OK</div>';
            }elseif ($data["Result"] == null){
                //NG
                return '<div class="text-danger">NG</div>';
            }else{
                return '<div class="text-danger">API ERROR</div>';
            }
        }
    }

    function WARPCheck($ip){
        global $context;
        $URL = "http://".$ip."/check_warp";
        $json = file_get_contents($URL,false,$context);
        $data = json_decode($json,true);
        if ($data == true){
            return '<div class="text-success">ONLINE</div>';
        }else{
            return '<div class="text-danger">OFFLINE</div>';
        }
    }
?>

<div class="d-flex justify-content-center">
    <div class="Container col-md-8">
        <div class="float-end"><?php echo date("Y年n月j日 H時i分s秒"); ?></div>
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
                            echo '<div class="text-center">'.PortCheck($json[$key]["IP"],$port).'</div>';
                            echo '</div>';
                        }
                    echo '</div>';

                    // WARPの稼働を調べる
                    if (array_key_exists("WARP",$json[$key])){
                        echo '<div class="row">';
                        echo '<div class="col-6"><div class="text-center">WARP</div></div>';
                        echo '<div class="col-6"><div class="text-center">'.$json[$key]["WARP"].'</div></div>';
                        echo '</div>';

                        echo '<div class="row">';
                        echo '<div class="col-6"><div class="text-center">Nginx Service</div></div>';
                        echo '<div class="col-6"><div class="text-center">'.WARPCheck($json[$key]["WARP"]).'</div></div>';
                        echo '</div>';
                    }else{
                        // WARPの設定がないのでなにもしない
                    }                    
                    
                    //divタグを閉じる
                    echo '</div></div>';
                
                }
            ?>
        </div>
    </div>
</div>