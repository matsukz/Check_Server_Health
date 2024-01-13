<?php
    error_reporting(0);

    function PortCheck($ip,$port){
        $URL = "http://Health_flask:5000/port?ip=".$ip."&port=".$port; //URL指定
        $ch = curl_init(); //curl接続初期化
        $options = [
            //curlオプション指定
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => true, //返信を有効に
            CURLOPT_FRESH_CONNECT => true, //キャッシュを利用しない
            CURLOPT_CONNECTTIMEOUT => 5 //5sでタイムアウト
        ];
        curl_setopt_array($ch,$options);
        $response = curl_exec($ch); //curl実行
        $code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch); //curl終了

        if ($code == 200){
            $json = json_decode($response,true); //配列化
            if ($json["Result"] == true){
                return '<div class="text-success">ONLINE</div>';
            }else{
                return '<div class="text-danger">OFFLINE</div>';
            }
        }else{
            return '<div class="text-danger">API ERROR</div>';
        }
    }

    function WARPCheck($ip){
        $ch = curl_init();
        $options = [
            CURLOPT_URL => "http://".$ip."/check_warp",
            CURLOPT_USERAGENT => "PHPServiceChecker",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_CONNECTTIMEOUT => 5
        ];
        curl_setopt_array($ch,$options);
        curl_exec($ch);
        $response = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response == 200){
            return '<div class="text-success">ONLINE</div>';
        }else{
            return '<div class="text-danger">OFFLINE</div>';
        }
    }

    function HttpResponse($ip,$port,$path){
        $URL = "http://".$ip.":".$port.$path;
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $URL,
            CURLOPT_USERAGENT => "PHPServiceChecker",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_CONNECTTIMEOUT => 5
        ];
        curl_setopt_array($ch,$options);
        curl_exec($ch);
        $code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($code == 200){
            return '<div class="text-success">ONLINE</div>';
        }else{
            return '<div class="text-danger">OFFLINE</div>';
        }
    }

    function PingCheck($ip){
        $URL = "http://Health_flask:5000/ping?ip=".$ip;
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_CONNECTTIMEOUT => 5
        ];
        curl_setopt_array($ch,$options);
        $response = curl_exec($ch);
        $code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code == 200){
            $json = json_decode($response,true);
            if ($json["Result"] >= 0){
                return '<div class="text-success">OK</div>';
            }else{
                '<div class="text-danger">NG</div>';
            }
        }else{
            return '<div class="text-danger">API ERROR</div>';
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
                    //HTTPの場合はcURLでステータスコードを取得する
                    echo '<div class="row">';
                        foreach($json[$key]["Port"] as $service=>$port){
                            echo '<div class="col-6"><div class="text-center">'.$service.'</div></div>';
                            echo '<div class="col-6">';
                            if ($port == 80 || $port == 8080){
                                echo '<div class="text-center">'.HttpResponse($json[$key]["IP"],$port,$json[$key]["URLPath"]).'</div>';
                            }else{
                                echo '<div class="text-center">'.PortCheck($json[$key]["IP"],$port).'</div>';
                            }
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