<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Bootstrap5.3/css/bootstrap.min.css" rel="stylesheet">
        <title>サーバー稼働状況</title>
    </head>
    <body>
        <script src="Bootstrap5.3/js/bootstrap.min.js"></script>
        <?php
            
            $Flask="http://192.168.0.102:5500"; //FlaskのURL

            //ポートをチェックする関数
            function PortCheck($ip,$port){
                global $Flask;
                $URL = $Flask."/port?ip=".$ip."&port=".$port;
                $json = file_get_contents($URL);
                $data = json_decode($json,true);
                if ($data == true){
                    if ($data["Result"] == true){
                        //OK
                        return "Connection";
                    }else{
                        //NG
                        return "Connection Filed.";
                    }
                }else{
                    //Flaskへのリクエスト失敗
                    return "Request ERROR";
                }
            }
        ?>
        <h1 class="text-center">サーバー稼働状況</h1>

        <div class="accordion" id="accordion_main">
            <div class="accordion-item">
                <h2 class="accordion-header" id="accordion_0_h">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_0_main" aria-expanded="true" aria-controls="accordion_0_main">
                        Mateサーバー
                    </button>
                </h2>
                <div id="accordion_0_main" class="accordion-collapse collapse show" aria-labelledby="accordion_0_h">
                    <div class="accordion-body">
                        IPアドレス -> 192.168.0.30<br>
                        SSH -> <?php echo PortCheck("192.168.0.30","22");?><br>
                        DNS -> <?php echo PortCheck("192.168.0.30","53");?><br>
                        HTTP -> <?php echo PortCheck("192.168.0.30","80");?>
                    </div>
                </div>
            </div>
            <!-- accordionを追加するならここから下  -->

        </div>

    </body>
</html>
