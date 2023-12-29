<?php
    $Flask="http://192.168.0.102:5500"; //FlaskのURL
    $IP_CFNX2="192.168.0.20";
    $IP_Mate="192.168.0.30";
    $IP_LXC1000="192.168.0.105";
    $IP_LXC1010="192.168.11.5";
    $IP_NextCloud="192.168.11.3";

    //ポートをチェックする関数
    function PortCheck($ip,$port){
        global $Flask;
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

<div class="accordion" id="accordion_main">
    <!-- メイト-->
    <div class="accordion-item">
        <h2 class="accordion-header" id="accordion_mate_h">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_mate_main" aria-expanded="true" aria-controls="accordion_mate_main">
                NEC-Mate001
            </button>
        </h2>
        <div id="accordion_mate_main" class="accordion-collapse collapse show" aria-labelledby="accordion_mate_h">
            <div class="accordion-body">

                <div class="row">
                    <div class="col-6">IPアドレス</div>
                    <div class="col-6"><div class="text-center"><?php echo $IP_Mate;?></div></div>
                </div>

                <div class="row">
                    <div class="col-6">SSH</div>
                    <div class="col-6">
                        <?php echo PortCheck($IP_Mate,"22");?>
                    </div>

                    <div class="col-6">DNS</div>
                    <div class="col-6">
                        <?php echo PortCheck($IP_Mate,"53");?>
                    </div>

                    <div class="col-6">Lighttpd</div>
                    <div class="col-6">
                        <?php echo PortCheck($IP_Mate,"80");?>
                    </div>
                    
                    <div class="col-6">OpenVPN</div>
                    <div class="col-6">
                        <?php echo PortCheck($IP_Mate,"443");?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LXC1010 -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="accordion_lxc1010_h">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_lxc1010_main" aria-expanded="true" aria-controls="accordion_lxc1010_main">
                Proxmox LXC1010
            </button>
        </h2>
        <div id="accordion_lxc1010_main" class="accordion-collapse collapse show" aria-labelledby="accordion_lxc1010_h">
            <div class="accordion-body">

                <div class="row">
                    <div class="col-6">IPアドレス</div>
                    <div class="col-6"><div class="text-center"><?php echo $IP_LXC1010;?></div></div>
                </div>

                <div class="row">
                    <div class="col-6">SSH</div>
                    <div class="col-6">
                        <?php echo PortCheck($IP_LXC1010,"22");?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">DNS</div>
                    <div class="col-6">
                        <?php echo PortCheck($IP_LXC1010,"53");?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">HTTP</div>
                    <div class="col-6">
                        <?php echo PortCheck($IP_LXC1010,"80");?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">Minecraft</div>
                    <div class="col-6">
                        <?php echo PortCheck($IP_LXC1010,"25565");?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- accordionを追加するならここから下  -->
    
</div>